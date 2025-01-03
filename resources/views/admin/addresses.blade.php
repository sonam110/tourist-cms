@extends('admin.layouts.master')

@section('content')
    @php
        $isEdit = Request::segment(2) === 'edit-address';
        $isAdd = Request::segment(2) === 'add-address';
    @endphp

    @if($isAdd || $isEdit)
        @php
            $id = $isEdit ? $address->id : '';
            $email = $isEdit ? $address->email : '';
            $addressText = $isEdit ? $address->address : '';
            $mobilenum = $isEdit ? $address->mobilenum : '';
            $language_id = $isEdit ? $address->language_id : '';
            $title = $isEdit ? $address->title : '';
            $uuid = $isEdit ? $address->uuid : '';
            $website = $isEdit ? $address->website : '';
            $gst = $isEdit ? $address->gst : '';
        @endphp

        <form action="{{ route('address-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" class="form-control">

            <div class="row row-deck">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $isAdd ? 'Add' : 'Edit' }} Address
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Title -->
                                <div class="form-group col-sm-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title" class="{{ $errors->has('title') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Title" autocomplete="off" required value="{{ old('title', $title) }}">
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="form-group col-sm-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="{{ $errors->has('email') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Email" autocomplete="off" required value="{{ old('email', $email) }}">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Mobile -->
                                <div class="form-group col-sm-6">
                                    <label for="mobilenum" class="form-label">Mobile / Contact Number</label>
                                    <input type="text" id="mobilenum" name="mobilenum" class="{{ $errors->has('mobilenum') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Mobile / Contact Number" autocomplete="off" required value="{{ old('mobilenum', $mobilenum) }}">
                                    @if ($errors->has('mobilenum'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobilenum') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Language -->
                                <div class="col-md-6">
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
                                <!-- Website -->
                                <div class="form-group col-sm-6">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="text" id="website" name="website" class="{{ $errors->has('website') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Website" autocomplete="off" required value="{{ old('website', $website) }}">
                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Gst Number -->
                                <div class="form-group col-sm-6">
                                    <label for="gst" class="form-label">Gst Number</label>
                                    <input type="text" id="gst" name="gst" class="{{ $errors->has('gst') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Gst Number" autocomplete="off" required value="{{ old('gst', $gst) }}">
                                    @if ($errors->has('gst'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gst') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Address -->
                                <div class="form-group col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="6" placeholder="Address" required>{!! old('address', $addressText) !!}</textarea>
                                    @error('address')
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
                        <h3 class="card-title">Address Management</h3>
                        <div class="card-options">
                            @can('address-add')
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('address-create') }}">
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Website</th>
                                        <th scope="col">GST</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $rows->title }}</td>
                                            <td>{{ $rows->email }}</td>
                                            <td>{{ $rows->mobilenum }}</td>
                                            <td>{!! $rows->address !!}</td>
                                            <td>{{ $rows->website }}</td>
                                            <td>{!! $rows->GST !!}</td>
                                            <td>
                                                <div class="btn-group btn-group-xs">
                                                    @can('address-edit')
                                                    <a class="btn btn-sm btn-info" href="{{ route('address-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('address-delete')
                                                    <a class="btn btn-sm btn-danger" href="{{ route('address-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
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
