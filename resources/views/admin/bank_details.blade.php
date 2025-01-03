@extends('admin.layouts.master')

@section('content')
    @php
        $isEdit = Request::segment(2) === 'edit-bank-detail';
        $isAdd = Request::segment(2) === 'add-bank-detail';
    @endphp

    @if($isAdd || $isEdit)
        @php
            $id = $isEdit ? $bankDetail->id : '';
            $bank_name = $isEdit ? $bankDetail->bank_name : '';
            $branch_address = $isEdit ? $bankDetail->branch_address : '';
            $account_number = $isEdit ? $bankDetail->account_number : '';
            $account_name = $isEdit ? $bankDetail->account_name : '';
            $upi_number = $isEdit ? $bankDetail->upi_number : '';
            $ifsc_code = $isEdit ? $bankDetail->ifsc_code : '';
        @endphp

        <form action="{{ route('bank-detail-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" class="form-control">

            <div class="row row-deck">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $isAdd ? 'Add' : 'Edit' }} Bank Detail
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Account Name -->
                                <div class="form-group col-sm-6">
                                    <label for="account_name" class="form-label">Account Name</label>
                                    <input type="text" id="account_name" name="account_name" class="{{ $errors->has('account_name') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Account Name" autocomplete="off" required value="{{ old('account_name', $account_name) }}">
                                    @if ($errors->has('account_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Bank Name -->
                                <div class="form-group col-sm-6">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" id="bank_name" name="bank_name" class="{{ $errors->has('bank_name') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Bank Name" autocomplete="off" required value="{{ old('bank_name', $bank_name) }}">
                                    @if ($errors->has('bank_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bank_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Account Number -->
                                <div class="form-group col-sm-4">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" id="account_number" name="account_number" class="{{ $errors->has('account_number') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Account Number" autocomplete="off" required value="{{ old('account_number', $account_number) }}">
                                    @if ($errors->has('account_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account_number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                 <!-- IFSC Code -->
                                <div class="form-group col-sm-4">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" id="ifsc_code" name="ifsc_code" class="{{ $errors->has('ifsc_code') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="IFSC Code" autocomplete="off" required value="{{ old('ifsc_code', $ifsc_code) }}">
                                    @if ($errors->has('ifsc_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ifsc_code') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                 <!-- UPI Number -->
                                <div class="form-group col-sm-4">
                                    <label for="upi_number" class="form-label">UPI Number</label>
                                    <input type="text" id="upi_number" name="upi_number" class="{{ $errors->has('upi_number') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="UPI Number" autocomplete="off" required value="{{ old('upi_number', $upi_number) }}">
                                    @if ($errors->has('upi_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('upi_number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Branch Address -->
                                <div class="form-group col-md-12">
                                    <label for="branch_address" class="form-label">Branch Address</label>
                                    <textarea name="branch_address" id="branch_address" class="form-control @error('branch_address') is-invalid @enderror" rows="2" placeholder="Branch Address" required>{{ old('branch_address', $branch_address) }}</textarea>
                                    @error('branch_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-footer text-center">
                                <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bank detail Management</h3>
                        <div class="card-options">
                            @can('bank-detail-add')
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('bank-detail-create') }}">
                                <i class="fa fa-plus"></i> Create New Address
                            </a>
                            &nbsp;&nbsp;&nbsp;
                            @endcan
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go To Back">
                                <i class="fa fa-mail-reply"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Account name</th>
                                        <th scope="col">Bank Name</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">IFSC Code</th>
                                        <th scope="col">UPI Number</th>
                                        <th scope="col">Address</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $rows->account_name }}</td>
                                            <td>{{ $rows->bank_name }}</td>
                                            <td>{{ $rows->account_number }}</td>
                                            <td>{{ $rows->ifsc_code }}</td>
                                            <td>{{ $rows->upi_number }}</td>
                                            <td>{!! $rows->branch_address !!}</td>
                                            <td>
                                                <div class="btn-group btn-group-xs">
                                                    @can('bank-detail-edit')
                                                    <a class="btn btn-sm btn-info" href="{{ route('bank-detail-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('bank-detail-delete')
                                                    <a class="btn btn-sm btn-danger" href="{{ route('bank-detail-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
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
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
