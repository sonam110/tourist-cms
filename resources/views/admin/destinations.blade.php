@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-destination' || Request::segment(2)==='add-destination')
@if(Request::segment(2)==='add-destination')
<?php
$id             = '';
$name           = '';
$destination_type  = '';
$status         = '';
$image_path   = 'assets/img/noimage.jpg';
?>
@else
<?php
$id             = $destination->id;
$name           = $destination->name;
$destination_type        = $destination->destination_type;
$status           = $destination->status;
$image_path   = $destination->image_path;
?>
@endif

<form action="{{ route('destination-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2)==='add-destination')
                        Add
                        @else
                        Edit
                        @endif
                        Destination
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Destination Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="destination_type" class="form-label">Destination Type</label>
                                <select name="destination_type" id="destination_type" class="form-control">
                                    <option value="1" @if($destination_type == 1) selected @endif>Domestic</option>
                                    <option value="2" @if($destination_type == 2) selected @endif>International</option>
                                </select>
                                @error('destination_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                         <!-- Image Path -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image_path" class="form-label">Image (Width:750 px Height: 350 px)</label>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100%; height: 148px;">
                                        <img id="imageThumb" src="{{ url('/') }}/{!! $image_path !!}"> 
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 148px; line-height: 20px;"></div>
                                </div>
                                <div>
                                    <span class="btn btn-outline-primary btn-file" style="width:100%">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                        <input type="file" name="image_path" id="image_path" accept="image/*" onchange="readURL(this,'imageThumb')" >
                                    </span> 
                                </div>
                                @if ($errors->has('image_path'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image_path') }}</strong>
                                </span>
                                @endif
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
        <div class="card-header ">
            <h3 class="card-title">Destination Management</h3>
            <div class="card-options">
                @can('destination-add')
                <a class="btn btn-sm btn-outline-primary" href="{{ route('destination-create') }}"> 
                    <i class="fa fa-plus"></i> Create New Destination
                </a>
                &nbsp;&nbsp;&nbsp;
                @endcan
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                    <i class="fa fa-mail-reply"></i>
                </a>
            </div>
        </div>
        <form action="{{ route('destination-action') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Destination Type</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($data as $destination)
                            <tr>
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="boxchecked[]" value="{{ $destination->id }}" class="colorinput-input custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                </td>
                                <td>{!! ++$i !!}</td>
                                <td><img src="{{asset($destination->image_path)}}" width="100px" alt="{{asset('assets/img/noimage.jpg')}}"></td>
                                <td>{!! $destination->name !!}</td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @if($destination->destination_type=='1') 
                                        <span class="text-Info">Domestic</span>
                                        @else 
                                        <span class="text-Primary">International</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        @if($destination->status=='2') 
                                        <span class="text-danger">Inactive</span>
                                        @else 
                                        <span class="text-success">Active</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @can('destination-edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('destination-edit',$destination->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('destination-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('destination-delete',$destination->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option> 
                                <option value="Add To Home">Add To Home</option>
                                <option value="Remove From Home">Remove From Home</option>
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