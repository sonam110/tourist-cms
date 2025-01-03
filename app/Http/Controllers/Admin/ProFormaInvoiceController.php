<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProFormaInvoice;
use App\Models\ProFormaInvoiceItem;
use App\Models\Appsetting;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;

class ProFormaInvoiceController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:pro-forma-invoice-browse',['only' => ['index']]);
        $this->middleware('permission:pro-forma-invoice-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:pro-forma-invoice-edit', ['only' => ['edit','update','action']]);
        $this->middleware('permission:pro-forma-invoice-delete', ['only' => ['destroy','action']]);
    }

    /**
     * Display a listing of the Pro Forma Invoices.
     */
    public function index()
    {
        try 
        {
            $data = ProFormaInvoice::with('proFormaInvoiceDetails','billingAddress','bankDetail')->get();
            return view('admin.pro_forma_invoices', compact('data'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return redirect()->back()->with('error', 'An error occurred while fetching the invoices.');
        }
    }

    /**
     * Show the form for creating a new Pro Forma Invoice.
     */
    public function create()
    {
        try{
            return view('admin.pro_forma_invoices'); // Ensure this view exists and matches your form
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
            return redirect()->back()->with('error', 'An error occurred while loading the form.');
        }
    }

    /**
     * Store a newly created or updated Pro Forma Invoice in storage.
     */
    public function store(Request $request)
    {
    	// dd($request->all());
    // Validate the request inputs
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'invoice_number' => 'required|string|max:50|unique:pro_forma_invoices,invoice_number,' . $request->id,
            'date' => 'required|date',
            'billing_address' => 'required|exists:addresses,id',
            'bank_detail' => 'required|exists:bank_details,id',
            'total' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'proFormaInvoiceDetails' => 'required|array|min:1',
            'proFormaInvoiceDetails.*.description' => 'required|string|max:255',
            'proFormaInvoiceDetails.*.pax' => 'required',
            'proFormaInvoiceDetails.*.price' => 'required|numeric|min:0',
            'proFormaInvoiceDetails.*.total' => 'required|numeric|min:0',
        ]);

        // Start a database transaction to ensure data integrity
        DB::beginTransaction();

        try {
        // Prepare the data for insertion/updating
            $data = [
                'language_id' => $request->language_id ?? $this->appSetting->default_language,
                'currency_id' => $request->currency_id ?? $this->appSetting->default_currency,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'invoice_number' => $request->invoice_number,
                'date' => $request->date,
                'billing_address' => $request->billing_address,
                'bank_detail' => $request->bank_detail,
                'total' => $request->total,
                'tax_amount' => $request->tax_amount,
                'grand_total' => $request->grand_total,
                'advance' => $request->advance ?? 0,
                'due' => $request->due ?? 0,
                'status' => $request->status ?? 1,
                'remarks' => $request->remarks,
                'remarks_enabled' => $request->remarks_enabled ? $request->remarks_enabled : 0,
                'gst_enabled' => $request->gst_enabled ? $request->gst_enabled : 0,
                'show_system_gen' => $request->show_system_gen ? $request->show_system_gen : 0,
            ];

            if (!empty($request->id)) {
                $proFormaInvoice = ProFormaInvoice::find($request->id);
                if (!$proFormaInvoice) {
                    return redirect()->back()->with('error', 'Record not found.');
                }
                $proFormaInvoice->update($data);

                // Delete any remaining old details
                $proFormaInvoice->proFormaInvoiceDetails()->delete();

                // Update or create invoice proFormaInvoiceDetails
                foreach ($request->proFormaInvoiceDetails as $itemData) {
                    $proFormaInvoice->proFormaInvoiceDetails()->create($itemData);
                }

                DB::commit();
                return redirect()->route('pro-forma-invoices-list')->with('success', 'Pro Forma Invoice successfully updated.');
            } else {
                $proFormaInvoice = ProFormaInvoice::create($data);

                
                foreach ($request->proFormaInvoiceDetails as $itemData) {
                    $proFormaInvoice->proFormaInvoiceDetails()->create($itemData);
                }

                DB::commit();
                return redirect()->route('pro-forma-invoices-list')->with('success', 'Pro Forma Invoice successfully created.');
            }
        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception);
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Display the specified Pro Forma Invoice.
     */
    public function show($id)
    {
        try 
        {
            $proFormaInvoice = ProFormaInvoice::with('proFormaInvoiceDetails','billingAddress','bankDetail')->find($id);
            if(!$proFormaInvoice)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.pro_forma_invoices', compact('proFormaInvoice'));
        }
        catch(Exception $exception) {
            \Log::error($exception);

            return $exception->getMessage();
            return redirect()->back()->with('error', 'An error occurred while fetching the invoice.');
        }
    }

    /**
     * Show the form for editing the specified Pro Forma Invoice.
     */
    public function edit($id)
    {
        try 
        {
            $proFormaInvoice = ProFormaInvoice::with('proFormaInvoiceDetails')->find($id);
            if(!$proFormaInvoice)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.pro_forma_invoices', compact('proFormaInvoice')); // Ensure this view can handle editing
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
            return redirect()->back()->with('error', 'An error occurred while loading the form.');
        }
    }

    /**
     * Remove the specified Pro Forma Invoice from storage.
     */
    public function destroy($id)
    {
        try 
        {
            $proFormaInvoice = ProFormaInvoice::find($id);
            if(!$proFormaInvoice)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            $proFormaInvoice->delete();
            return redirect()->back()->with('delete', 'Pro Forma Invoice successfully deleted.');
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return redirect()->back()->with('error', 'An error occurred while deleting the invoice.');
        }
    }

    /**
     * Handle bulk actions on Pro Forma Invoices.
     */
    public function action(Request $request)
    {
        try {
            $request->validate([
                'boxchecked' => 'required|array',
                'cmbaction' => 'required|string',
            ]);

            $action = $request->input('cmbaction');
            foreach($request->input('boxchecked') as $id)
            {
                $invoice = ProFormaInvoice::find($id);
                if(!$invoice){
                    continue; // Optionally, collect failed IDs to notify the user
                }

                if($action == 'Delete')
                {
                    $invoice->delete();
                }
                elseif($action == 'Active')
                {
                    $invoice->update(['status' => '1']);
                }
                elseif($action == 'Inactive')
                {
                    $invoice->update(['status' => '2']);
                }
                // Add more actions as needed
            }

            return redirect()->back()->with('success', 'Action successfully completed.');
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return redirect()->back()->with('error', 'An error occurred while performing the action.');
        }
    }

    /**
     * Display the specified Pro Forma Invoice.
     */
    public function pdf($id)
    {
        try 
        {
            $proFormaInvoice = ProFormaInvoice::with('proFormaInvoiceDetails','billingAddress','bankDetail','currency')->find($id);
            if($proFormaInvoice)
            {
                $pdf = PDF::loadView('admin.invoice_pdf_template', compact('proFormaInvoice'));
                return $pdf->download($proFormaInvoice->invoice_number.'.pdf');
            }
            return redirect()->back()->with('error', 'An error occurred while fetching the invoice.');
        }
        catch(Exception $exception) {
            \Log::error($exception);

            return $exception->getMessage();
            return redirect()->back()->with('error', 'An error occurred while fetching the invoice.');
        }
    }
}
