<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
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

class InquiryController extends Controller
{
    protected $intime;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $data = Inquiry::orderBy('id', 'DESC')->get();
            return view('admin.inquiries',compact('data'));
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
            $reviewAndRating = Inquiry::find($id);
            if($reviewAndRating)
            {
                $reviewAndRating->delete();
                return redirect()->back()->with('delete','Inquiry Deleted Successfully');
            }
            return redirect()->back()->with('error','Record Not Found!');
            
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }
}