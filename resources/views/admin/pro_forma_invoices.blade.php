@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-pro-forma-invoice' || Request::segment(2) === 'add-pro-forma-invoice')
<?php
$id               = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->id;
$language_id      = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->language_id;
$currency_id      = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->currency_id;
$name             = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->name;
$mobile           = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->mobile;
$email            = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->email;
$address          = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->address;
$remarks          = Request::segment(2) === 'add-pro-forma-invoice' ? $appSetting->pro_forma_invoice_remarks : $proFormaInvoice->remarks;

$billing_address  = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->billing_address;
$bank_detail      = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->bank_detail;
$invoice_number   = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->invoice_number;
$date             = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->date;
$total            = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->total;
$tax_amount            = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->tax_amount;
$grand_total      = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->grand_total;
$advance          = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->advance;
$due              = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->due;
$remarks_enabled              = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->remarks_enabled;
$gst_enabled              = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->gst_enabled;
$show_system_gen              = Request::segment(2) === 'add-pro-forma-invoice' ? '' : $proFormaInvoice->show_system_gen;
?>


<form action="{{ route('pro-forma-invoice-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ Request::segment(2) === 'add-pro-forma-invoice' ? 'Add' : 'Edit' }} Pro Forma Invoice
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Primary Table Fields -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $mobile) }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" required>
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address" required>{{ old('address', $address) }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_number" class="form-label">Invoice Number</label>
                                <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $invoice_number) }}" class="form-control @error('invoice_number') is-invalid @enderror" placeholder="Invoice Number" required>
                                @error('invoice_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $date) }}" class="form-control @error('date') is-invalid @enderror" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bank_detail" class="form-label">Bank Account</label>
                                <select name="bank_detail" id="bank_detail" class="form-control" required>
                                    <option value="">Select Bank Detail</option>
                                    @foreach(App\Models\BankDetail::all() as $bank)
                                    <option value="{{ $bank->id }}" {{ $bank->id == $bank_detail ? 'selected' : '' }}>{{ $bank->account_name }}</option>
                                    @endforeach
                                </select>
                                @error('bank_detail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="billing_address" class="form-label">Billing Address</label>
                                <select name="billing_address" id="billing_address" class="form-control" required>
                                    <option value="">Select Address</option>
                                    @foreach(App\Models\Address::all() as $bill_address)
                                    <option value="{{ $bill_address->id }}" {{ $bill_address->id == $billing_address ? 'selected' : '' }}>{{ $bill_address->title }}</option>
                                    @endforeach
                                </select>
                                @error('billing_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-control">
                                    <option value="">Select Language</option>
                                    @foreach(App\Models\Language::all() as $lang)
                                    <option value="{{ $lang->id }}" {{ $lang->id == $language_id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Currency -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="currency_id" class="form-label">Currency</label>
                                <select name="currency_id" id="currency_id" class="form-control">
                                    <option value="">Select Currency</option>
                                    @foreach(App\Models\Currency::all() as $curr)
                                    <option value="{{ $curr->id }}" {{ $curr->id == $currency_id ? 'selected' : '' }}>{{ $curr->name }}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <hr>

                    <!-- Dynamic Invoice Items -->
                    <div class="form-group">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4>Pro Forma Invoice Items </h4>
                            </div>
                            <div class="col-md-6 text-right"> 
                                <button type="button" class="btn btn-outline-primary" id="add-item">Add Detail Input Field</button>
                            </div>
                        </div>
                        <table class="table table-bordered" id="invoice-proFormaInvoiceDetails-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Pax</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(old('proFormaInvoiceDetails'))
                                @foreach(old('proFormaInvoiceDetails') as $index => $item)
                                <tr>
                                    <td><input type="text" name="proFormaInvoiceDetails[{{ $index }}][description]" class="form-control" value="{{ $item['description'] }}" required></td>
                                    <td><input type="text" name="proFormaInvoiceDetails[{{ $index }}][pax]" class="form-control" value="{{ $item['pax'] }}" required></td>
                                    <td><input type="number" step="0.01" name="proFormaInvoiceDetails[{{ $index }}][price]" class="form-control" value="{{ $item['price'] }}" required></td>
                                    <td><input type="number" step="0.01" name="proFormaInvoiceDetails[{{ $index }}][total]" class="form-control" value="{{ $item['total'] }}" required></td>
                                    <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa fa-times remove-item"></i></button></td>
                                </tr>
                                @endforeach
                                @elseif(isset($proFormaInvoice))
                                @foreach($proFormaInvoice->proFormaInvoiceDetails as $index => $item)
                                <tr>
                                    <td><input type="text" name="proFormaInvoiceDetails[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" required></td>
                                    <td><input type="text" name="proFormaInvoiceDetails[{{ $index }}][pax]" class="form-control" value="{{ $item->pax }}" required></td>
                                    <td><input type="number" step="0.01" name="proFormaInvoiceDetails[{{ $index }}][price]" class="form-control" value="{{ $item->price }}" required></td>
                                    <td><input type="number" step="0.01" name="proFormaInvoiceDetails[{{ $index }}][total]" class="form-control" value="{{ $item->total }}" required></td>
                                    <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa fa-times remove-item"></i></button></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>




                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" name="total" id="total" value="{{ old('total', $total) }}" class="form-control @error('total') is-invalid @enderror" placeholder="Total" required>
                            @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tax_amount" class="form-label">Tax Amount</label>
                            <input type="number" step="0.01" name="tax_amount" id="tax_amount" value="{{ old('tax_amount', $tax_amount) }}" class="form-control @error('tax_amount') is-invalid @enderror" placeholder="Tax Amount" required>
                            @error('tax_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="grand_total" class="form-label">Grand Total</label>
                            <input type="number" step="0.01" name="grand_total" id="grand_total" value="{{ old('grand_total', $grand_total) }}" class="form-control @error('grand_total') is-invalid @enderror" placeholder="Grand Total" required>
                            @error('grand_total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="advance" class="form-label">Advance</label>
                            <input type="number" name="advance" id="advance" value="{{ old('advance', $advance) }}" class="form-control @error('advance') is-invalid @enderror" placeholder="Advance">
                            @error('advance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="due" class="form-label">Due</label>
                            <input type="number" name="due" id="due" value="{{ old('due', $due) }}" class="form-control @error('due') is-invalid @enderror" placeholder="Due">
                            @error('due')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        

                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" placeholder="Remarks">{{ old('remarks', $remarks) }}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="remarks_enabled" class="form-label">Remarks Enabled</label>
                            <input type="checkbox" name="remarks_enabled" value="1" {{ $remarks_enabled == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="gst_enabled" class="form-label">Show GST</label>
                            <input type="checkbox" name="gst_enabled" value="1" {{ $gst_enabled == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="show_system_gen" class="form-label">Show System Generated Line</label>
                            <input type="checkbox" name="show_system_gen" value="1" {{ $show_system_gen == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success">{{ Request::segment(2) === 'add-pro-forma-invoice' ? 'Save' : 'Update' }}</button>
                </div>
            </div>
        </div>
    </div>
</form>



@elseif(Request::segment(2) === 'view-pro-forma-invoice')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pro Forma Invoice Details</h3>
                <div class="card-options">
                    @can('pro-forma-invoice-edit')
                    <a href="{{ route('pro-forma-invoice-edit',$proFormaInvoice->id) }}" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="right" data-original-title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    @can('pro-forma-invoice-delete')
                    <a href="{{ route('pro-forma-invoice-delete',$proFormaInvoice->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this pro-forma-invoice?');" data-toggle="tooltip" data-placement="right" data-original-title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    @can('pro-forma-invoice-browse')
                    <a href="{{ route('pro-forma-invoice-pdf',$proFormaInvoice->id) }}" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="right" data-original-title="Generate Pdf"><i class="fa fa-file-pdf-o"></i></a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Name:</strong> {{ $proFormaInvoice->name }}</p>
                        <p><strong>Email:</strong> {{ $proFormaInvoice->email }}</p>
                        <p><strong>Mobile Number:</strong> {{ $proFormaInvoice->mobile }}</p>
                        <p><strong>Address:</strong> {!! nl2br($proFormaInvoice->address) !!}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Invoice Number:</strong> {{ $proFormaInvoice->invoice_number }}</p>
                        <p><strong>date:</strong> {{ $proFormaInvoice->date }}</p>
                        <p><strong>Total:</strong> {{ $proFormaInvoice->total }}</p>
                        <p><strong>Grand Total:</strong> {{ $proFormaInvoice->grand_total }}</p>
                        <p><strong>Advance:</strong> {{ $proFormaInvoice->advance }}</p>
                        <p><strong>Due:</strong> {{ $proFormaInvoice->due }}</p>
                        <p><strong>GST NO.:</strong> {{ $proFormaInvoice->due }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>{{ env('APP_NAME') }}</strong><br>
                        <p><strong>Address:</strong> {!! nl2br($proFormaInvoice->billingAddress->address) !!}</p>

                        <p><strong>Email:</strong> {{ $proFormaInvoice->billingAddress->email }}</p>

                        <p><strong>Contact:</strong> {{ $proFormaInvoice->billingAddress->mobilenum }}</p>
                        
                        @if($proFormaInvoice->gst_enabled==1)
                        <p><strong>GST NO.:</strong> {{ $proFormaInvoice->billingAddress->gst }}</p>
                        @endif
                    </div>
                </div>

                <h5>Invoice Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th>PAX</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proFormaInvoice->proFormaInvoiceDetails as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->pax }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Pro Forma Invoice Management</h3>
                <div class="card-options">
                    @can('pro-forma-invoice-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('pro-forma-invoice-create') }}"> 
                        <i class="fa fa-plus"></i> Create New Pro Forma Invoice
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <form action="{{ route('pro-forma-invoice-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Invoice Number</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">Advance</th>
                                    <th scope="col">Due</th>
                                    <th scope="col" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0 @endphp
                                @foreach($data as $index=>$invoice)
                                <tr>
                                    <td><label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="boxchecked[]" value="{{ $invoice->id }}" class="colorinput-input custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label></td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $invoice->name }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->date }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>{{ $invoice->grand_total }}</td>
                                    <td>{{ $invoice->advance }}</td>
                                    <td>{{ $invoice->due }}</td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            @can('pro-forma-invoice-read')
                                            <a href="{{ route('pro-forma-invoice-pdf',$invoice->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" data-original-title="Generate Pdf"><i class="fa fa-file-pdf-o"></i></a>
                                            @endcan
                                            @can('pro-forma-invoice-read')
                                            <a class="btn btn-sm btn-info" href="{{ route('pro-forma-invoice-view',$invoice->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('pro-forma-invoice-edit')
                                            <a class="btn btn-sm btn-warning" href="{{ route('pro-forma-invoice-edit',$invoice->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('pro-forma-invoice-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('pro-forma-invoice-delete',$invoice->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row div-margin">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-hand-o-right"></i>
                                </span>
                                <select name="cmbaction" class="form-control" id="cmbaction">
                                    <option value="">Action</option>
                                    <option value="Delete">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-6 col-xs-6">
                            <div class="input-group">
                                <button type="submit" class="btn btn-danger pull-right" name="Action" onClick="return delrec(document.getElementById('cmbaction').value);">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let itemIndex = {{ count(old('proFormaInvoiceDetails', isset($proFormaInvoice) ? $proFormaInvoice->proFormaInvoiceDetails : [])) }};
        const tableBody = document.querySelector('#invoice-proFormaInvoiceDetails-table tbody');

        // Add default row if no proFormaInvoiceDetails exist
        if (itemIndex === 0) {
            addItemRow(itemIndex++);
        }

        // Function to calculate totals
        function calculateInvoice() {
            let total = 0;

            // Loop through each row to calculate totals
            document.querySelectorAll('#invoice-proFormaInvoiceDetails-table tbody tr').forEach(function (row) {
                const price = parseFloat(row.querySelector('[name*="[price]"]').value) || 0;
                const pax = parseInt(row.querySelector('[name*="[pax]"]').value) || 0;
                const itemTotal = price * pax;

                // Update row total and add to the overall total
                row.querySelector('[name*="[total]"]').value = itemTotal.toFixed(2);
                total += itemTotal;
            });

            // Update totals in form
            document.getElementById('total').value = total.toFixed(2);
            const advance = parseFloat(document.getElementById('advance').value) || 0;
            const taxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;

            // Calculate grand total including tax
            const grandTotal = total + taxAmount;

            document.getElementById('grand_total').value = grandTotal.toFixed(2);
            document.getElementById('due').value = (grandTotal - advance).toFixed(2);
        }

        // Function to add a new row
        function addItemRow(index) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td><input type="text" name="proFormaInvoiceDetails[${index}][description]" class="form-control" required></td>
            <td><input type="number" name="proFormaInvoiceDetails[${index}][pax]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="proFormaInvoiceDetails[${index}][price]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="proFormaInvoiceDetails[${index}][total]" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa fa-times"></i></button></td>
            `;
            tableBody.appendChild(newRow);

            // Add event listeners for new row inputs and remove button
            newRow.querySelectorAll('input').forEach(input => input.addEventListener('input', calculateInvoice));
            newRow.querySelector('.remove-item').addEventListener('click', function () {
                removeItemRow(newRow);
            });
        }

        // Function to remove a row, ensuring at least one row remains
        function removeItemRow(row) {
            if (tableBody.rows.length > 1) {
                row.remove();
                calculateInvoice();
            }
        }

        // Add new row on button click
        document.getElementById('add-item').addEventListener('click', function () {
            addItemRow(itemIndex++);
        });

        // Handle removing items with restriction
        document.getElementById('invoice-proFormaInvoiceDetails-table').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                const row = e.target.closest('tr');
                removeItemRow(row);
            }
        });

        // Initialize total calculation on page load
        calculateInvoice();

        // Add event listeners to the existing inputs for calculating totals
        document.querySelectorAll('#invoice-proFormaInvoiceDetails-table input, #advance, #tax_amount').forEach(input => {
            input.addEventListener('input', calculateInvoice);
        });
    });
</script>




@endsection
