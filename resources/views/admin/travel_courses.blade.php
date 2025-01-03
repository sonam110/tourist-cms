@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-travel-course' || Request::segment(2) === 'add-travel-course')
@if(Request::segment(2) === 'add-travel-course')
<?php
$id           = '';
$language_id           = '';
$title        = '';
$slug         = '';
$content      = '';
$image_path   = 'assets/img/noimage.jpg';
$video_link = '';
$status       = '';
$seo_keyword       = '';
?>
@else
<?php
$id           = $travelCourse->id;
$language_id           = $travelCourse->language_id;
$title        = $travelCourse->title;
$slug         = $travelCourse->slug;
$content      = $travelCourse->content;
$image_path   = $travelCourse->image_path;
$video_link = $travelCourse->video_link;
$status       = $travelCourse->status;
$seo_keyword       = $travelCourse->seo_keyword;
?>
@endif

<form action="{{ route('travel-course-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2) === 'add-travel-course')
                        Add
                        @else
                        Edit
                        @endif
                        Travel Course
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" value="{{ $title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title" autocomplete="off" required>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        
                        <!-- Language -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-control" required>
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
                        <!-- Video Link -->
                            <div class="form-group col-md-12">
                                <label for="video_link" class="form-label">Video Link</label>
                                <input type="text" name="video_link" id="video_link" value="{{ $video_link }}" class="form-control @error('video_link') is-invalid @enderror" placeholder="Video Link" autocomplete="off">
                                @error('video_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        <!-- Content -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="content" class="form-control ckeditor @error('content') is-invalid @enderror" rows="2" placeholder="Content" >{!! $content !!}</textarea>
                                @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        

                        <!-- Image Path -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image_path" class="form-label">Image (W:350 H:200 (in PX))</label>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100%; height: 150px;">
                                        <img id="imageThumb" src="{{ url('/') }}/{!! $image_path !!}"> 
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 150px; line-height: 20px;"></div>
                                </div>
                                <div>
                                    <span class="btn btn-outline-primary btn-file" style="width: 100%">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                        <input type="file" name="image_path" id="image_path" accept="image/*" onchange="readURL(this,'imageThumb')">
                                         <!-- @if(Request::segment(2) === 'add-travel-course') required @endif -->
                                    </span> 
                                </div>
                                @if ($errors->has('image_path'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image_path') }}</strong>
                                </span>
                                @endif
                            </div>
                        

                        </div>
                         <!-- SEO Key -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="seo_keyword" class="form-label">SEO KeyWord</label>
                                <input type="text" name="seo_keyword" id="seo_keyword" value="{{ $seo_keyword }}" class="form-control @error('seo_keyword') is-invalid @enderror" placeholder="SEO Key" autocomplete="off">
                                @error('seo_keyword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="status" value="1">
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

@elseif(Request::segment(2) === 'view-travel-course')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Travel Courses</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Video Link</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="text-muted">{{ $travelCourse->id }}</span></td>
                            <td>{{ $travelCourse->title }}</td>
                            <td>{{ $travelCourse->slug }}</td>
                            <td>{{ $travelCourse->video_link }}</td>
                            <td>{{ $travelCourse->status }}</td>
                            <td>
                                <a href="{{ route('travel-course-edit',$travelCourse->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('travel-course-delete',$travelCourse->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this travelCourse?');">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Travel Course Management</h3>
                <div class="card-options">
                    @can('travel-course-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('travel-course-create') }}"> 
                        <i class="fa fa-plus"></i> Create New Travel Course
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <form action="{{ route('travel-course-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Slug</th>
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
                                    <td>{!! $rows->title !!}</td>
                                    <td>{!! $rows->slug !!}</td>
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
                                            <!-- <a class="btn btn-sm btn-secondary" href="{{ route('travel-course-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a> -->
                                            @can('travel-course-edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('travel-course-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('travel-course-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('travel-course-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
@section('extrajs')
<script type="text/javascript">
    document.querySelectorAll('.ckeditor').forEach(function(textarea) {
        CKEDITOR.replace(textarea);
    });
</script>

@endsection
