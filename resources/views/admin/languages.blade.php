@extends('admin.layouts.master')

@section('content')
@if(Request::segment(2) === 'edit-language' || Request::segment(2) === 'add-language')
    @php
        $id = '';
        $name = '';
        $value = '';
        $status = '';

        if(Request::segment(2) === 'edit-language' && isset($language)) {
            $id = $language->id;
            $name = $language->name;
            $value = $language->value;
            $status = $language->status;
        }
    @endphp

    <form action="{{ route('language-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" class="form-control">

        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Request::segment(2) === 'add-language' ? 'Add' : 'Edit' }} Language
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Value -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="value" class="form-label">Value</label>
                                    <input type="text" name="value" id="value" value="{{ old('value', $value) }}" class="form-control @error('value') is-invalid @enderror" placeholder="Value" autocomplete="off" required>
                                    @error('value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ $status == '2' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
                    <h3 class="card-title">Language Management</h3>
                    <div class="card-options">
                        <!-- <a class="btn btn-sm btn-outline-primary" href="{{ route('language-create') }}"> 
                            <i class="fa fa-plus"></i> Create New Language
                        </a> -->
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('language-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Status</th>
                                        <!-- <th scope="col" width="10%">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                    <tr>
                                        <td>
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
                                                <span class="custom-control-label"></span>
                                            </label>
                                        </td>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $rows->name }}</td>
                                        <td>{{ $rows->value }}</td>
                                        <td class="text-center">
                                            <span class="{{ $rows->status == '2' ? 'text-danger' : 'text-success' }}">
                                                {{ $rows->status == '2' ? 'Inactive' : 'Active' }}
                                            </span>
                                        </td>
                                        <!-- <td>
                                            <div class="btn-group btn-group-xs">
                                                <a class="btn btn-sm btn-info" href="{{ route('language-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger" href="{{ route('language-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td> -->
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
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
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
@endsection
