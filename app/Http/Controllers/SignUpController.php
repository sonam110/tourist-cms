<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Str;
use Mail;
use DB;
use App\Mail\CommonMail;
use App\Mail\WelcomeMail;
use App\Mail\UserMail;
use App\Models\Otp;
use Illuminate\Support\Facades\Notification;
use App\Models\EmailTemplate;
use App\Notifications\UserNotification;
class SignUpController extends Controller
{
    public function signUp()
    { 
        $countries = Country::pluck('name','id')->all();
        return View('auth.register',compact('countries'));
    }

    public function signUpSave(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name'        		=> 'required',
            'email'             => 'required|email|unique:users,email',
            // 'password'          => 'required|same:confirm-password',
            'mobile'     		=> 'required',
            // 'address'   		=> 'required'
        ]);

        $input 					    = $request->all();
        $input['password']          = bcrypt(12345678);
        $input['userType']          = 'user';
        $input['role_id']          = NULL;
        $input['email_verified_token'] = Str::random(25);
        $user = User::create($input);
        

        // Find or create an OTP entry
        $otp = Otp::where('email', $request->email)->orderBy('id', 'DESC')->first();
        if (!$otp || $otp->resent_count >= env('OTP_ATTEMPT_LIMIT', 3)) {
            $otp = new Otp;
            $generateOtp = env('IS_MAIL_SEND_ENABLE', false) ? rand(1000, 9999) : 1234;
            $otp->resent_count = 0;
        } else {
            $generateOtp = $otp->otp;
        }


        $otp->email = $request->email;
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
                $variable_data = ['{{otp}}' => $generateOtp];
                $mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);
                $mail_subject = $email_template->mail_subject;

                $mailObj = [
                    'mail_subject' => $mail_subject,
                    'mail_body'    => $mail_body,
                ];

                Mail::to(strtolower($user->email))->send(new CommonMail($mailObj));
            }
        }


        session(['email' => $request->email]);
        return \Redirect()->route('login')->with('success','Account successfully created. Verify Your Account and Login.');
    }
}
