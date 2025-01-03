<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetail;
use App\Models\Appsetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BankDetailController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:bank-detail-browse',['only' => ['index']]);
        $this->middleware('permission:bank-detail-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:bank-detail-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:bank-detail-delete', ['only' => ['destroy','action']]);
    }

    public function index()
    {
        try 
        {
            $data = BankDetail::get();
            return view('admin.bank_details')->with('data', $data);
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function show($id)
    {
        try 
        {
            $bankDetail = BankDetail::find($id);
            if(!$bankDetail)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.bank_details', compact('bankDetail'));
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('admin.bank_details');
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
        // Validate the request inputs
            $this->validate($request, [
                'account_name' => 'required|string',
                'account_number' => 'required|string',
                'bank_name' => 'required|string',
                'ifsc_code' => 'required|string',
            ]);

        // Prepare the data for insertion/updation
            $data = [
                'account_name' => $request->account_name,
                'ifsc_code' => $request->ifsc_code,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'upi_number' => $request->upi_number,
                'branch_address' => $request->branch_address
            ];
        // Check if the request is for updating an existing record
            if (!empty($request->id)) {
                $bankDetail = BankDetail::find($request->id);
                $bankDetail->update($data);
                return redirect()->route('bank-details-list')->with('success', 'Bank detail successfully updated.');
            } else {
            // Create a new record
                BankDetail::create($data);
                return redirect()->route('bank-details-list')->with('success', 'Bank detail successfully created.');
            }
        } catch (Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function edit($id)
    {
        try 
        {
            $bankDetail = BankDetail::find($id);
            if(!$bankDetail)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.bank_details', compact('bankDetail'));
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function destroy($id)
    {

        try 
        {
            $bankDetail = BankDetail::find($id);
            if(!$bankDetail)
            {

                return redirect()->back()->with('error','Record Not Found!');
            }
            $bankDetail->delete();
            
            return redirect()->back()->with('delete', 'Dynamic Page successfully deleted.');
        }
        catch(\Exception $exception) {

            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {

        try {
            $action = $request->input('cmbaction');
            $ids = $request->input('boxchecked');

            if ($action && $ids) {
                foreach($ids as $id) {
                    $bankDetail = BankDetail::find($id);
                    if ($bankDetail) {
                        if ($action == 'Delete') {
                            $bankDetail->delete();
                        } elseif ($action == 'Active') {
                            $bankDetail->update(['status' => 1]);
                        } elseif ($action == 'Inactive') {
                            $bankDetail->update(['status' => 2]);
                        }
                    }
                }
                
                return redirect()->back()->with('success', 'Action successfully completed.');
            }
            
            return redirect()->back()->with('error', 'No action or items selected.');
        } catch (\Exception $exception) {

            \Log::error($exception);
            return $exception->getMessage();
        }
    }
}
