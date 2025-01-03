<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;
use App\Mail\CommonMail;
use Mail;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return redirect()->route('user.dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // Check if a user exists by provider_id and provider_name
        
        $user = User::where('provider_id', $socialUser->getId())
        ->where('provider_name', $provider)
        ->first();
        if (!$user) {
            $password = rand(10000000, 99999999);
            $existingUser = User::where('email', $socialUser->getEmail())->first();
            if ($existingUser) {
                $user = User::where('email',$socialUser->getEmail())->update([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }
            else
            {
                
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt($password),
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);

                // Send registration email if enabled
                if (env('IS_MAIL_SEND_ENABLE', false) == true) {
                    $email_template = EmailTemplate::where('template_for', 'registration')->first();

                    if ($email_template) {
                        $variable_data = [
                            '{{name}}' => $user->name,
                            '{{email}}' => $user->email,
                            '{{password}}' => $password
                        ];

                        $mail_subject = strReplaceAssoc($variable_data, $email_template->mail_subject);
                        $mail_body = strReplaceAssoc($variable_data, $email_template->mail_body);

                        $mailObj = [
                            'mail_subject' => $mail_subject,
                            'mail_body' => $mail_body
                        ];

                        Mail::to(strtolower($user->email))->send(new CommonMail($mailObj));
                    }
                }
            }
        }

        return $user;
    }

}
