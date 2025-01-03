@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-review-and-rating' || Request::segment(2) === 'add-review-and-rating')
@php
$id = $reviewAndRating->id ?? '';
$user_id = $reviewAndRating->user_id ?? '';
$user_name = $reviewAndRating->user_name ?? '';
$package_uuid = $reviewAndRating->package_uuid ?? '';
$rating = $reviewAndRating->rating ?? '';
$review = $reviewAndRating->review ?? '';
$status = $reviewAndRating->status ?? '';
$user_name = $reviewAndRating->user_name ?? '';
$user_image = $reviewAndRating->user_image ?? '';
@endphp

<form action="{{ route('review-and-rating-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ Request::segment(2) === 'add-review-and-rating' ? 'Add' : 'Edit' }} Review And Rating
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Package -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="package_uuid" class="form-label">Package</label>
                                <select name="package_uuid" id="package_uuid" class="form-control @error('package_uuid') is-invalid @enderror">
                                    <option value="">Select Package</option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->uuid }}" {{ old('package_uuid', $package_uuid) == $package->uuid ? 'selected' : '' }}>{{ $package->package_name }}</option>
                                    @endforeach
                                </select>
                                @error('package_uuid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Review -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="review" class="form-label">Review</label>
                                <textarea name="review" id="review" class="form-control ckeditor @error('review') is-invalid @enderror" placeholder="Review" rows="10" required>{{ old('review', $review) }}</textarea>
                                @error('review')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                            
                        <div class="col-md-4">



                            <div class="form-group">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" step="0.5" name="rating" id="rating" value="{{ old('rating', $rating) }}" class="form-control @error('rating') is-invalid @enderror" placeholder="Rating" autocomplete="off" required max="5" min="0">
                                @error('rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="user_id" class="form-label">Review By</label>
                                <!-- <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Select User</option>
                                    @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select> -->
                                <!-- @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                                <input type="text" name="user_name"  value="{{ old('user_name', $user_name) }}" class="form-control @error('user_name') is-invalid @enderror" placeholder="Rating">
                            </div>

                            <div class="form-group">
                                <label for="user_image" class="form-label">User Image</label>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 100%; height: 148px;">
                                        <img id="imageThumb" src="{{ url('/') }}/{!! $user_image !!}"> 
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 148px; line-height: 20px;"></div>
                                </div>
                                <div>
                                    <span class="btn btn-outline-primary btn-file" style="width:100%">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                        <input type="file" name="user_image" id="user_image" accept="image/*" onchange="readURL(this,'imageThumb')">
                                    </span> 
                                </div>
                                @if ($errors->has('user_image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_image') }}</strong>
                                </span>
                                @endif
                            </div>

                            <!-- <div class="form-group">
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
                            </div> -->
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

@elseif(Request::segment(2) === 'view-review-and-rating')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Review And Rating Details</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h5><strong>Package:</strong></h5>
                        <span>
                            {{ $reviewAndRating->package->package_name }}
                        </span>
                    </div>
                    <div class="col-md-4">
                        <h5><strong>Rating:</strong></h5>
                        <p>{!! $reviewAndRating->rating !!}</p>
                    </div>
                    <div class="col-md-4">
                        <h5><strong>Status:</strong></h5>
                        <span class="badge {{ $reviewAndRating->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $reviewAndRating->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5><strong>Review:</strong></h5>
                        <p>{!! $reviewAndRating->review !!}</p>
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
                <h3 class="card-title">Review And Rating</h3>
                <div class="card-options">
                    @can('review-and-rating-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('review-and-rating-create') }}">
                        <i class="fa fa-plus"></i> Create New Review And Rating
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <form action="{{ route('review-and-rating-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Review</th>
                                    <th scope="col">Review By</th>
                                    <th scope="col">Rating</th>
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
                                    <td>{!! @$rows->package->package_name !!}</td>
                                    <td>{!! $rows->review !!}</td>
                                    <td>{!! $rows->user_name !!}</td>
                                    <td>{{ $rows->rating }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            @if($rows->status == '2') 
                                            <span class="text-danger">Inactive</span>
                                            @elseif($rows->status == '1')
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-info">Pending</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            @can('review-and-rating-read')
                                            <a class="btn btn-sm btn-secondary" href="{{ route('review-and-rating-view', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('review-and-rating-edit')
                                            <a class="btn btn-sm btn-primary" href="{{ route('review-and-rating-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('review-and-rating-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('review-and-rating-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
@section('extrajs')
<script type="text/javascript">
    document.querySelectorAll('.ckeditor').forEach(function(textarea) {
        CKEDITOR.replace(textarea);
    });
</script>

@endsection