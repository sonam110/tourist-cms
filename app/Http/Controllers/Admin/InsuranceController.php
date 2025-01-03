<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;
use App\Models\Label;

class InsuranceController extends Controller
{
    protected $intime;
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();
        $this->middleware('permission:insurance-browse',['only' => ['index']]);
        $this->middleware('permission:insurance-delete', ['only' => ['destroy','action']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $data = Insurance::orderBy('id', 'DESC')->get();
            return view('admin.insurances',compact('data'));
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
            $insurance = Insurance::find($id);
            if($insurance)
            {
                $insurance->delete();
                return redirect()->back()->with('delete','Insurance Deleted Successfully');
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
            if($request->input('cmbaction') == 'Delete')
            {
                Insurance::where('id', $action)->delete();
            }
            elseif($request->input('cmbaction') == 'Verify')
            {
                Insurance::where('id', $action)->update(['status' => '1']);
            }
            elseif($request->input('cmbaction') == 'Process')
            {
                Insurance::where('id', $action)->update(['status' => '2']);
            }
            elseif($request->input('cmbaction') == 'Reject')
            {
                Insurance::where('id', $action)->update(['status' => '3']);
            }
            else
            {
                return redirect()->back()->with('error', 'Action Invalid.');
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }
}