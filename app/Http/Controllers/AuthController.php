<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AppSetting;
use App\Models\Language;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use Exception;
use Mail;
use App\Models\EmailTemplate;
use App\Models\Otp;
use App\Mail\CommonMail;

class AuthController extends Controller
{

	public function login(Request $request)
	{
		session(['redirect_url' => url()->previous()]);
		$validation = \Validator::make($request->all(), [
			'email' => 'required|email',
			'gRecaptcha'  => 'required|captcha'
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'errors' => $validation->errors()
			], 422);
		}

		try {
			$email = $request->email;

        	// Find the user by email
			$user = User::where('email', $email)->first();
			if (!$user) {
				return response()->json([
					'success' => false,
					'message' => 'User does not exist with the entered email address.'
				], 404);
			}

        	// Check if the user is inactive
			if (in_array($user->status, [0, 2, 3])) {
				return response()->json([
					'success' => false,
					'message' => 'User is not active. Contact the admin.',
				], 403);
			}

        	// Find or create an OTP entry
			$otp = Otp::where('email', $email)->orderBy('id', 'DESC')->first();
			if (!$otp || $otp->resent_count >= env('OTP_ATTEMPT_LIMIT', 3)) {
				$otp = new Otp;
				$generateOtp = env('IS_MAIL_SEND_ENABLE', false) ? rand(1000, 9999) : 1234;
				$otp->resent_count = 0;
			} else {
				$generateOtp = $otp->otp;
			}


			$otp->email = $email;
			$otp->otp = $generateOtp;
			$otp->otp_expired = now()->addMinutes(5);
			$otp->resent_count += 1;
			if ($otp->resent_count >= env('OTP_ATTEMPT_LIMIT', 3)) {
				$otp->lock_till = now()->addMinutes(10);
			}
			$otp->save();

        	// Send OTP email if enabled
			if (env('IS_MAIL_SEND_ENABLE', false)) {
				$email_template = EmailTemplate::where('template_for', 'send-otp')->first();
				if ($email_template) {
					$variable_data = [
							'{{otp}}' => $generateOtp,
							'{{user_name}}' => $user->name
					];
					$mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
					$mail_subject = $email_template->mail_subject;

					$mailObj = [
						'mail_subject' => $mail_subject,
						'mail_body'    => $mail_body,
					];

					Mail::to(strtolower($user->email))->send(new CommonMail($mailObj));
				}
			}

        	// Return success response with the OTP field visibility flag
			return response()->json([
				'success' => true,
				'message' => 'OTP has been sent to your email address.',
				'showOtp' => true,
				'email'   => $email
			], 200);

		} catch (\Exception $exception) {
			\Log::error($exception->getMessage());
			return response()->json([
				'success' => false,
				'message' => 'Oops! Something went wrong.'
			], 500);
		}
	}
	

	public function verifyOtp(Request $request)
	{
		$validation = \Validator::make($request->all(),[ 
			'email' => 'required|email',
			'otp' => 'required|numeric|digits:4',
		]);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'message' => $validation->errors()->first(),
			]);
		}

		try {
			$email = strtolower($request->email);
			$user = User::where('email', $email)->first();
			if (!$user) {
				return response()->json([
					'success' => false,
					'message' => 'User does not exist with the entered email address.',
				]);
			}

			if (in_array($user->status, [0, 2, 3])) {
				return response()->json([
					'success' => false,
					'message' => 'User is not active. Contact the admin.',
				]);
			}

			$otp = Otp::where('email', $email)->orderBy('id', 'DESC')->first();
			if (!$otp) {
				return response()->json([
					'success' => false,
					'message' => 'OTP not found.',
				]);
			}

			if (time() > strtotime($otp->otp_expired)) {
				$otp->delete();
				return response()->json([
					'success' => false,
					'message' => 'OTP expired.',
				]);
			}

			if ($otp->otp == $request->otp) {
				if ($otp->remember_me != 1) {
					$otp->delete();
				}
				Auth::login($user, true);
				return response()->json([
					'success' => true,
					// 'redirectUrl' => route('user.dashboard'),
					'redirectUrl' => session()->pull('redirect_url', route('user.dashboard')),
				]);
			}

			return response()->json([
				'success' => false,
				'message' => 'Wrong OTP.',
			]);
		} catch (Exception $exception) {
			\Log::error($exception);
			return response()->json([
				'success' => false,
				'message' => 'Oops! Something went wrong.',
			]);
		}
	}
}
