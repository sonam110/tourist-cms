@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-ads-management' || Request::segment(2) === 'add-ads-management')
@if(Request::segment(2) === 'add-ads-management')
<?php
$id           = '';
$url_link        = '';
$page_name        = '';
$image_path   = 'assets/img/noimage.jpg';
?>
@else
<?php
$id           = $adsManagement->id;
$url_link        = $adsManagement->url_link;
$image_path   = $adsManagement->image_path;
$page_name   = $adsManagement->page_name;
?>
@endif

<form action="{{ route('ads-management-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2) === 'add-ads-management')
                        Add
                        @else
                        Edit
                        @endif
                        Ads  Management
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Url Link -->
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="url_link" class="form-label">Url Link</label>
                                <input type="text" name="url_link" id="url_link" value="{{ $url_link }}" class="form-control @error('url_link') is-invalid @enderror" placeholder="Url Link" autocomplete="off" required>
                                @error('url_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>  

                        <!-- Page Name -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="page_name" class="form-label">Page Name</label>
                                <select name="page_name" id="page_name" class="form-control">
                                    <option value="">Select Page Name</option>
                                   	<option value="home" {{ $page_name == 'home' ? 'selected' : '' }}>Home</option>
                                   	<option value="packages" {{ $page_name == 'packages' ? 'selected' : '' }}>Packages</option>
                                    <option value="service-ramta-yogi" {{ $page_name == 'service-ramta-yogi' ? 'selected' : '' }}>Ramta Yogi</option>
                                    <option value="service-domestic" {{ $page_name == 'service-domestic' ? 'selected' : '' }}>Domestic</option>
                                    <option value="service-international" {{ $page_name == 'service-international' ? 'selected' : '' }}>International</option>
                                   	<option value="destinations" {{ $page_name == 'destinations' ? 'selected' : '' }}>Destination</option>
                                    <option value="travel-courses" {{ $page_name == 'travel-courses' ? 'selected' : '' }}>Touriversity</option>
                                    <option value="blogs" {{ $page_name == 'blogs' ? 'selected' : '' }}>Blogs</option>
                                    <option value="vlogs" {{ $page_name == 'vlogs' ? 'selected' : '' }}>Vlogs</option>
                                    <option value="vlogs" {{ $page_name == 'vlogs' ? 'selected' : '' }}>Vlogs</option>
                                    <option value="visa-inquiry" {{ $page_name == 'visa-inquiry' ? 'selected' : '' }}>Visa</option>
                                    <option value="career" {{ $page_name == 'career' ? 'selected' : '' }}>Career</option>
                                    @forelse(App\Models\DynamicPage::where('status',1)->get() as $page)

                                    <option value="{{$page->slug}}" {{ $page_name == $page->slug ? 'selected' : '' }}>{{$page->title}} (Dynamic)</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('page_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>                   

                        <!-- Image Path -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image_path" class="form-label">Image (W:1115 H:300 in PX) or use same size image according to your need</label>
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
                <h3 class="card-title">Ads  Management</h3>
                <div class="card-options">
                    @can('ads-management-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('ads-management-create') }}"> 
                        <i class="fa fa-plus"></i> Create New Ads Management                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" url_link="" data-original-url_link="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <form action="{{ route('ads-management-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Page NAme</th>
                                    <th scope="col">Url Link</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" width="10%">Action</th>
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
                                    <td>{!! ++$i !!}</td>
                                    <td>{!! $rows->page_name !!}</td>
                                    <td>{!! $rows->url_link !!}</td>
                                    <td><img src="{{asset($rows->image_path)}}" style="width: 150px;"></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            @if($rows->status == '2') 
                                            <span class="text-danger">Inactive</span>
                                            @else 
                                            <span class="text-success">Active</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            @can('ads-management-edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('ads-management-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" url_link="" data-original-url_link="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('ads-management-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('ads-management-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" url_link="" data-original-url_link="Delete">
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
@endsection
