@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-vlog' || Request::segment(2) === 'add-vlog')
@if(Request::segment(2) === 'add-vlog')
<?php
$id           = '';
$language_id           = '';
$title        = '';
$slug         = '';
$categories   = [];
$content      = '';
$video_path   = '';
$image_path   = 'assets/img/noimage.jpg';
$order_number = '';
$posted_by    = '';
$post_date    = '';
$seo_key      = '';
$views        = '';
$status       = '';
?>
@else
<?php
$id           = $vlog->id;
$language_id           = $vlog->language_id;
$title        = $vlog->title;
$slug         = $vlog->slug;
$categories   = json_decode($vlog->categories);
$content      = $vlog->content;
$video_path   = $vlog->video_path;
$image_path   = $vlog->image_path;
$order_number = $vlog->order_number;
$posted_by    = $vlog->posted_by;
$post_date    = $vlog->post_date;
$seo_key      = $vlog->seo_key;
$views        = $vlog->views;
$status       = $vlog->status;
?>
@endif

<form action="{{ route('vlog-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2) === 'add-vlog')
                        Add
                        @else
                        Edit
                        @endif
                        Vlog
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6">
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
                        <!-- Video Path -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="video_path" class="form-label">Video Path</label>
                                <input type="text" name="video_path" id="video_path" value="{{ $video_path }}" class="form-control @error('video_path') is-invalid @enderror" placeholder="Video Path" autocomplete="off" required>
                                @error('video_path')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                        </div>

                        <!-- Categories -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="categories" class="form-label">Categories</label>
                                <select name="categories[]" id="categories" class="form-control select2" multiple data-placeholder="Select Categories" required>
                                    <option value="">Select Category</option>
                                    @foreach(App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ in_array($cat->id, $categories) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('categories')
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
                        <!-- Order Number -->
                        <div class="form-group col-md-3">
                            <label for="order_number" class="form-label">Order Number</label>
                            <input type="text" name="order_number" id="order_number" value="{{ $order_number }}" class="form-control @error('order_number') is-invalid @enderror" placeholder="Order Number" autocomplete="off">
                            @error('order_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Vloged By -->
                        <div class="form-group col-md-3">
                            <label for="posted_by" class="form-label">Posted By</label>
                            <select name="posted_by" id="posted_by" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach(App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $posted_by ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('posted_by')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Post Date -->
                        <div class="form-group col-md-3">
                            <label for="post_date" class="form-label">Post Date</label>
                            <input type="date" name="post_date" id="post_date" value="{{ $post_date }}" class="form-control @error('post_date') is-invalid @enderror">
                            @error('post_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        

                        <!-- Image Path -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image_path" class="form-label">Image</label>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100%; height: 148px;">
                                        <img id="imageThumb" src="{{ url('/') }}/{!! $image_path !!}"> 
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 148px; line-height: 20px;"></div>
                                </div>
                                <div>
                                    <span class="btn btn-outline-primary btn-file" style="width:100%">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                        <input type="file" name="image_path" id="image_path" accept="image/*" onchange="readURL(this,'imageThumb')" required>
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
                                <label for="seo_key" class="form-label">SEO Key</label>
                                <input type="text" name="seo_key" id="seo_key" value="{{ $seo_key }}" class="form-control @error('seo_key') is-invalid @enderror" placeholder="SEO Key" autocomplete="off">
                                @error('seo_key')
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

@elseif(Request::segment(2) === 'view-vlog')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Vlogs</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Categories</th>
                            <th>Order Number</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="text-muted">{{ $vlog->id }}</span></td>
                            <td>{{ $vlog->title }}</td>
                            <td>{{ $vlog->slug }}</td>
                            <td>{{ $vlog->categories }}</td>
                            <td>{{ $vlog->order_number }}</td>
                            <td>{{ $vlog->views }}</td>
                            <td>{{ $vlog->status }}</td>
                            <td>
                                <a href="{{ url('edit-vlog/'.$vlog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ url('delete-vlog/'.$vlog->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this vlog?');">Delete</a>
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
                <h3 class="card-title">Vlog Management</h3>
                <div class="card-options">
                    @can('vlog-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('vlog-create') }}"> 
                        <i class="fa fa-plus"></i> Create New Vlog
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <form action="{{ route('vlog-action') }}" method="POST" class="form-horizontal" autocomplete="off">
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
                                    <th scope="col">Home</th>
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
                                    <td>{{ $rows->view_on_home == 1 ? 'True':'False' }}</td>
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
                                            <!-- <a class="btn btn-sm btn-secondary" href="{{ route('vlog-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a> -->
                                            @can('vlog-edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('vlog-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('vlog-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('vlog-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
</div>
@endif
<script>
    function readVideoURL(input, thumbId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var video = document.getElementById(thumbId);
                video.src = e.target.result;
                video.load();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection