<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;
use App\Models\Appsetting;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        EmailTemplate::truncate();
        $appSetting = Appsetting::first();
        $logo_path = asset('/'.$appSetting->app_logo);
        $mobilenum = $appSetting->mobilenum;
        $app_name = $appSetting->app_name;
        $address = $appSetting->address;
        $logo = '<img src="'.$logo_path.'" height="20">';
        // $footer = '<br><br>
        
        // Kind Regards,<br>
        // Team '.$app_name.'

        // <br><br>
        // <div style="border-bottom: 1px solid #632ca6;"></div>
        // <br>

        // '.$logo.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Skip this line and pay as you go.<br><br>

        // '.$app_name.',<br>
        // '.$address.',<br>
        // '.$mobilenum;

        $footer = '<br><br>
        
        Kind Regards,<br>
        The TURISTICO MUNDO - Ramta Yogi Team<br>';
        
        //$logo = '';

        $templates = [
            [
                'template_for' => 'password-changed',
                'mail_subject' => 'Your Password Has Been Successfully Changed',
                'mail_body' => 'Dear {{name}},
                <br>
                We are writing to inform you that your account password has been successfully changed. If you initiated this change, no further action is required.
                <br>
                If you did not request a password change, please contact our support team immediately at <strong>'.$appSetting->email.'</strong> to secure your account.
                <br><br>
                Thank you for your attention to this matter and for choosing our services.
                <br><br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'forgot-password',
                'mail_subject' => 'Forgot Password',
                'mail_body' => 'Dear {{name}},<br>
                Please click below link to reset password.<br>
                <br>
                <a href="{{link}}" style="background: #632ca6; padding: 5px; text-decoration: none; color:#fff">Click here</a>
                '.$footer,
                'custom_attributes' => '{{name}},{{link}}',
                'status' => 1,
            ],
            [
                'template_for' => 'send-otp',
                'mail_subject' => 'Your One-Time Password',
                'mail_body' => 'Dear {{user_name}},
                <br><br>
                Thank you for choosing TI-MUNDO - Ramta Yogi. Below is your one-time password (OTP) to log in:<br><br>

                <strong> OTP: {{otp}} </strong> <br><br>

                Please note that this OTP expires in 5 minutes and can only be used once.<br><br>

                If you did not request this, please disregard this message. 
                '.$footer,
                'custom_attributes' => '{{otp}},{{user_name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'registration',
                'mail_subject' => 'Registered Successfully',
                'mail_body' => 'Dear {{name}} ,<br> you have been registered successfully. Following are your login credentials : <br> 
                Email - <strong>{{email}}</strong> <br>
                '.$footer,
                'custom_attributes' => '{{name}},{{email}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-sent',
                'mail_subject' => 'Booking Request Sent',
                'mail_body' => 'Dear {{name}} ,<br> your booking request has been sent. you can check status of your booking in your dashboard and you will be notified by mail of any status updates. <br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-recieved',
                'mail_subject' => 'Booking Request Recieved',
                'mail_body' => 'There is booking request from user <strong> {{email}} </strong> for {{destination}} from {{start_date}} to {{end_date}} <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{email}},{{start_date}},{{end_date}}',
                'status' => 1,
            ],
            [
                'template_for' => 'inquiry-request-sent',
                'mail_subject' => 'Inquiry Request Sent',
                'mail_body' => 'Dear {{name}} ,<br> your inquiry request has been sent. you can check status of your inquiry in your dashboard and you will be notified by mail of any status updates. <br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'inquiry-request-recieved',
                'mail_subject' => 'Inquiry Request Recieved',
                'mail_body' => 'There is inquiry request from user <strong> {{email}} </strong> for travel date {{travel_date}} and for {{traveller_count}} persons. <br>
                '.$footer,
                'custom_attributes' => '{{email}},{{travel_date}},{{traveller_count}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-verified-admin',
                'mail_subject' => 'Booking Request Verified',
                'mail_body' => 'Booking request from user <strong> {{email}} </strong> for {{destination}} from {{start_date}} to {{end_date}} has been verified by {{auth_user}}. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{email}},{{start_date}},{{end_date}},{{auth_user}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-verified-user',
                'mail_subject' => 'Booking Request Verified',
                'mail_body' => 'Your Booking request for {{destination}} from {{start_date}} to {{end_date}} has been verified by Admin. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{start_date}},{{end_date}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-rejected-admin',
                'mail_subject' => 'Booking Request Rejected',
                'mail_body' => 'Booking request from user <strong> {{email}} </strong> for {{destination}} from {{start_date}} to {{end_date}} has been rejected by {{auth_user}}. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{email}},{{start_date}},{{end_date}},{{auth_user}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-rejected-user',
                'mail_subject' => 'Booking Request Rejected',
                'mail_body' => 'Your Booking request for {{destination}} from {{start_date}} to {{end_date}} has been rejected by Admin. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{start_date}},{{end_date}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-processed-admin',
                'mail_subject' => 'Booking Request Processed',
                'mail_body' => 'Booking request from user <strong> {{email}} </strong> for {{destination}} from {{start_date}} to {{end_date}} has been processed by {{auth_user}}. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{email}},{{start_date}},{{end_date}},{{auth_user}}',
                'status' => 1,
            ],
            [
                'template_for' => 'booking-request-processed-user',
                'mail_subject' => 'Booking Request Processed',
                'mail_body' => 'Your Booking request for {{destination}} from {{start_date}} to {{end_date}} has been processed by Admin. <br>
                '.$footer,
                'custom_attributes' => '{{destination}},{{start_date}},{{end_date}}',
                'status' => 1,
            ],
            [
                'template_for' => 'contact-request-sent',
                'mail_subject' => 'Contact Request Sent',
                'mail_body' => 'Dear {{name}} ,<br> your contact request has been sent. Admin will contact you soon. <br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'contact-request-recieved',
                'mail_subject' => 'Contact Request Recieved',
                'mail_body' => 'There is contact request from user <strong> {{name}} </strong> with email {{email}} and mobile number {{mobilenum}}. <br>
                '.$footer,
                'custom_attributes' => '{{name}},{{email}},{{mobilenum}}',
                'status' => 1,
            ],
            [
                'template_for' => 'visa-request-sent',
                'mail_subject' => 'Visa Request Sent',
                'mail_body' => 'Dear {{name}} ,<br> your visa request has been sent. Admin will contact you soon. <br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'visa-request-recieved',
                'mail_subject' => 'Visa Request Recieved',
                'mail_body' => 'There is visa request from user <strong> {{name}} </strong> with email {{email}} and mobile number {{mobilenum}}. <br>
                '.$footer,
                'custom_attributes' => '{{name}},{{email}},{{mobilenum}}',
                'status' => 1,
            ],
            [
                'template_for' => 'insurance-request-sent',
                'mail_subject' => 'Insurance Request Sent',
                'mail_body' => 'Dear {{name}} ,<br> your insurance request has been sent. Admin will contact you soon. <br>
                '.$footer,
                'custom_attributes' => '{{name}}',
                'status' => 1,
            ],
            [
                'template_for' => 'insurance-request-recieved',
                'mail_subject' => 'Insurance Request Recieved',
                'mail_body' => 'There is insurance request from user <strong> {{name}} </strong> with email {{email}} and mobile number {{mobilenum}}. <br>
                '.$footer,
                'custom_attributes' => '{{name}},{{email}},{{mobilenum}}',
                'status' => 1,
            ],

        ];

        foreach ($templates as $key => $template) {
            $data = new EmailTemplate;
            $data->language_id = $appSetting->default_language;
            $data->template_for = $template['template_for'];
            $data->mail_subject = $template['mail_subject'];
            $data->mail_body = $template['mail_body'];
            $data->custom_attributes = $template['custom_attributes'];
            $data->status = $template['status'];
            $data->save();
        }
    }
}
