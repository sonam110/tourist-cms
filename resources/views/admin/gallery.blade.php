@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-gallery' || Request::segment(2)==='add-gallery')
@if(Request::segment(2)==='add-gallery')
<?php
$id             = '';
$name           = '';
$status         = '';
$image_path   = 'assets/img/noimage.jpg';
?>
@else
<?php
$id             = $gallery->id;
$name        = $gallery->name;
$status           = $gallery->status;
$image_path   = $gallery->image_path;
?>
@endif

<form action="{{ route('gallery-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2)==='add-gallery')
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-label">Destination Name</label>
                                <input type="text" name="name" id="name" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                         <!-- Image Path -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image_path" class="form-label">Gallery Image ( W:300 H:300 in PX)</label>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100%; height: 148px;">
                                        <img id="imageThumb" src="{{ url('/') }}/{!! $image_path !!}"> 
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 148px; line-height: 20px;"></div>
                                </div>
                                <div>
                                    <span class="btn btn-outline-primary btn-file" style="width:100%">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                        <input type="file" name="image_path" id="image_path" accept="image/*" onchange="readURL(this,'imageThumb')">
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
            <h3 class="card-title">Gallery Management</h3>
            <div class="card-options">
                @can('gallery-add')
                <a class="btn btn-sm btn-outline-primary" href="{{ route('gallery-create') }}"> 
                    <i class="fa fa-plus"></i> Create New Gallery
                </a>
                &nbsp;&nbsp;&nbsp;
                @endcan
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                    <i class="fa fa-mail-reply"></i>
                </a>
            </div>
        </div>
        <form action="{{ route('gallery-action') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Gallery Image</th>
                                <th scope="col">Destination Name</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($data as $gallery)
                            <tr>
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="boxchecked[]" value="{{ $gallery->id }}" class="colorinput-input custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                </td>
                                <td>{!! ++$i !!}</td>
                                <td><img src="{{asset($gallery->image_path)}}" width="100px" alt="{{asset('assets/img/noimage.jpg')}}"></td>
                                <td>{!! $gallery->name !!}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        @if($gallery->status=='2') 
                                        <span class="text-danger">Inactive</span>
                                        @else 
                                        <span class="text-success">Active</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @can('gallery-edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('gallery-edit',$gallery->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('gallery-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('gallery-delete',$gallery->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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