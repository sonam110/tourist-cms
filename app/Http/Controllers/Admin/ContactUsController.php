<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;
use App\Models\Label;

class ContactUsController extends Controller
{
    protected $intime;
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();
        $this->middleware('permission:contact-us-browse',['only' => ['index']]);
        $this->middleware('permission:contact-us-delete', ['only' => ['destroy','action']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $data = ContactUs::orderBy('id', 'DESC')->get();
            return view('admin.contact_us',compact('data'));
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
            $contactUs = ContactUs::find($id);
            if($contactUs)
            {
                $contactUs->delete();
                return redirect()->back()->with('delete','Contact Us Deleted Successfully');
            }
            return redirect()->back()->with('error','Record Not Found!');
            
        } catch (\Throwable $exception) {
            \Log::error($exception);
            DB::rollback();
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction') == 'Delete')
            {
                ContactUs::where('id', $action)->delete();
            }
            else
            {
                return redirect()->back()->with('error', 'Action Invalid.');
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }
}