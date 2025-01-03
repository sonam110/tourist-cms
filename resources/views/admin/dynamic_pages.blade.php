@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-dynamic-page' || Request::segment(2) === 'add-dynamic-page')
    @php
        $id = $dynamicPage->id ?? '';
        $language_id = $dynamicPage->language_id ?? '';
        $title = $dynamicPage->title ?? '';
        $sub_title = $dynamicPage->sub_title ?? '';
        $order_number = $dynamicPage->order_number ?? '';
        $content = $dynamicPage->content ?? '';
        $banner_image_path = $dynamicPage->banner_image_path ?? 'assets/img/noimage.jpg';
        $status = $dynamicPage->status ?? '';
        $seo_keyword = $dynamicPage->seo_keyword ?? '';
        $placed_in = $dynamicPage->placed_in ?? '';
    @endphp

    <form action="{{ route('dynamic-page-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" class="form-control">

        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Request::segment(2) === 'add-dynamic-page' ? 'Add' : 'Edit' }} Dynamic Page
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title" autocomplete="off" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Sub Title -->
                                    <div class="form-group">
                                        <label for="sub_title" class="form-label">Sub Title</label>
                                        <input type="text" name="sub_title" id="sub_title" value="{{ old('sub_title', $sub_title) }}" class="form-control @error('sub_title') is-invalid @enderror" placeholder="Sub Title" autocomplete="off" required>
                                        @error('sub_title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                         <div class="form-group col-md-3">
                                            <label for="order_number" class="form-label">Order Number</label>
                                            <input type="number" name="order_number" id="order_number" value="{{ old('order_number', $order_number) }}" class="form-control @error('order_number') is-invalid @enderror" placeholder="Order Number" autocomplete="off">
                                            @error('order_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Place In -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="placed_in" class="form-label">Place In</label>
                                                <select name="placed_in" id="placed_in" class="form-control @error('placed_in') is-invalid @enderror" required>
                                                    <option value="header_menu" {{ old('placed_in', $placed_in) == 'header_menu' ? 'selected' : '' }}>Header Menu</option>
                                                    <option value="footer_menu" {{ old('placed_in', $placed_in) == 'footer_menu' ? 'selected' : '' }}>Footer Menu</option>
                                                    <option value="call_by_link" {{ old('placed_in', $placed_in) == 'call_by_link' ? 'selected' : '' }}>Call By Link</option>
                                                </select>
                                                @error('placed_in')
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
                                                <select name="language_id" id="language_id" class="form-control @error('language_id') is-invalid @enderror" required>
                                                    <option value="">Select Language</option>
                                                    @foreach(App\Models\Language::all() as $lang)
                                                        <option value="{{ $lang->id }}" {{ old('language_id', $language_id) == $lang->id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('language_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                    <option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="2" {{ old('status', $status) == 2 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- Background Image -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="banner_image_path" class="form-label">Background Image</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 100%; height: 157px;">
                                            <img id="imageThumb" src="{{ $banner_image_path ? url($banner_image_path) : '' }}" alt="Background Image">
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 157px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-outline-primary btn-file" style="width: 100%;">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                                <input type="file" name="banner_image_path" id="banner_image_path" accept="image/*" onchange="readURL(this,'imageThumb')" class="@error('banner_image_path') is-invalid @enderror">
                                            </span>
                                        </div>
                                        @error('banner_image_path')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea name="content" id="content" class="form-control content @error('content') is-invalid @enderror" placeholder="Content" rows="10" required>{{ old('content', $content) }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                            

                            <!-- Submit -->
                            <div class="col-md-12">
                                <div class="form-footer text-center">
                                    <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@elseif(Request::segment(2) === 'view-dynamic-page')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Dynamic Page Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><strong>Title:</strong></h5>
                            <p>{{ $dynamicPage->title }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5><strong>Content:</strong></h5>
                            <p>{!! $dynamicPage->content !!}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><strong>Status:</strong></h5>
                            <span class="badge {{ $dynamicPage->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $dynamicPage->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h5><strong>Background Image:</strong></h5>
                            @if($dynamicPage->banner_image_path)
                                <img src="{{ asset($dynamicPage->banner_image_path) }}" alt="Background Image" class="img-fluid rounded shadow-sm">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title">Dynamic Page Management</h3>
                    <div class="card-options">
                        @can('dynamic-page-add')
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('dynamic-page-create') }}">
                            <i class="fa fa-plus"></i> Create New Dynamic Page
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('dynamic-page-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Sub Title</th>
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
                                    <td>{!! $rows->sub_title !!}</td>
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
                                            <!-- <a class="btn btn-sm btn-secondary" href="{{ route('dynamic-page-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a> -->
                                            @can('dynamic-page-edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('dynamic-page-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('dynamic-page-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('dynamic-page-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
