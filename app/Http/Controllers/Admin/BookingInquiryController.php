<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;
use App\Models\Label;
use Mail;
use App\Mail\CommonMail;

class BookingInquiryController extends Controller
{
    protected $intime;
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();
        $this->middleware('permission:booking-inquiry-browse',['only' => ['index']]);
        $this->middleware('permission:booking-inquiry-delete', ['only' => ['destroy','action']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $data = Booking::orderBy('id', 'DESC')->get();
            return view('admin.bookings',compact('data'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function destroy($id)
    {
        try 
        {
            $reviewAndRating = Booking::find($id);
            if($reviewAndRating)
            {
                $reviewAndRating->delete();
                return redirect()->back()->with('delete','Booking Deleted Successfully');
            }
            return redirect()->back()->with('error','Record Not Found!');
            
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            $booking = Booking::find($action);
            if (empty($booking)) {
                return redirect()->back()->with('message','Record Not Found');
            }

            $variable_data = [
                '{{email}}' => $booking->email,
                '{{destination}}' => $booking->destination_name,
                '{{start_date}}' => $booking->start_date,
                '{{end_date}}' => $booking->end_date,
                '{{auth_user}}' => auth()->user()->name,
            ];

            $variable_data1 = [
                '{{destination}}' => $booking->destination_name,
                '{{start_date}}' => $booking->start_date,
                '{{end_date}}' => $booking->end_date,
            ];

            if($request->input('cmbaction') == 'Delete')
            {
                $booking->delete();
                $email_template = '';
                $email_template1 = '';

            }
            elseif($request->input('cmbaction') == 'Verify')
            {
                $email_template = EmailTemplate::where('template_for', 'booking-request-verified-admin')->first();
                $email_template1 = EmailTemplate::where('template_for', 'booking-request-verified-user')->first();

                $booking->update(['status' => '1']);
            }
            elseif($request->input('cmbaction') == 'Process')
            {
                $email_template = EmailTemplate::where('template_for', 'booking-request-processed-admin')->first();
                $email_template1 = EmailTemplate::where('template_for', 'booking-request-processed-user')->first();
                $booking->update(['status' => '2']);
            }
            elseif($request->input('cmbaction') == 'Reject')
            {
                $email_template = EmailTemplate::where('template_for', 'booking-request-rejected-admin')->first();
                $email_template1 = EmailTemplate::where('template_for', 'booking-request-rejected-user')->first();
                $booking->update(['status' => '3']);
            }
            else
            {
                return redirect()->back()->with('error', 'Action Invalid.');
            }

            // Notify  if  mail send enabled
            if (env('IS_MAIL_SEND_ENABLE', false)) {

                // To Admin
                if ($email_template) {
                    $mailObj = [
                        'mail_subject' => $email_template->mail_subject,
                        'mail_body'    => strReplaceAssoc($variable_data, $email_template->mail_body),
                    ];
                    Mail::to(strtolower(User::first()->email))->send(new CommonMail($mailObj));
                }

                // To User
                if ($email_template1) {
                    $mailObj = [
                        'mail_subject' => $email_template1->mail_subject,
                        'mail_body'    => strReplaceAssoc($variable_data1, $email_template1->mail_body),
                    ];
                    Mail::to(strtolower(User::first()->email))->send(new CommonMail($mailObj));
                }
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }
}