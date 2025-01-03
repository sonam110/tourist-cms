<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visa;
use App\Models\VisaDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;
use App\Models\Label;

class VisaController extends Controller
{
    protected $intime;
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();
        $this->middleware('permission:visa-browse',['only' => ['index']]);
        $this->middleware('permission:visa-delete', ['only' => ['destroy','action']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try{
            $data = Visa::orderBy('id', 'DESC')->get();
            return view('admin.visas',compact('data'));
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
            $visa = Visa::find($id);
            if($visa)
            {
                $visa->delete();
                return redirect()->back()->with('delete','Visa Deleted Successfully');
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
                Visa::where('id', $action)->delete();
            }
            elseif($request->input('cmbaction') == 'Verify')
            {
                Visa::where('id', $action)->update(['status' => '1']);
            }
            elseif($request->input('cmbaction') == 'Process')
            {
                Visa::where('id', $action)->update(['status' => '2']);
            }
            elseif($request->input('cmbaction') == 'Reject')
            {
                Visa::where('id', $action)->update(['status' => '3']);
            }
            else
            {
                return redirect()->back()->with('error', 'Action Invalid.');
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }

    public function visaDestinations()
    {
        $data = VisaDestination::get();
        return view('admin.visas')->with('data', $data);
    }

    public function visaDestinationStore(Request $request)
    {
        $this->validate($request, [
            'destination_name' => 'required'
        ]);
        $input = $request->all();
        VisaDestination::create($input);
        return redirect()->route('visa-destinations')->with('success', 'VisaDestination successfully created.');
    }


    public function visaDestinationDestroy($id)
    {
        if (VisaDestination::where('id', $id)->count() < 1) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        VisaDestination::where('id', $id)->delete();
        return redirect()->back()->with('success', 'VisaDestination successfully deleted.');
    }
}