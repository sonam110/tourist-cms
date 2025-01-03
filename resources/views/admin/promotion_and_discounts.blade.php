@extends('admin.layouts.master')
@section('content')
    @if(in_array(Request::segment(2), ['edit-promotion-and-discount', 'add-promotion-and-discount']))
        @php
            $id = $promotionAndDiscount->id ?? '';
            $language_id = $promotionAndDiscount->language_id ?? '';
            $title = $promotionAndDiscount->title ?? '';
            $coupon_code = $promotionAndDiscount->coupon_code ?? '';
            $description = $promotionAndDiscount->description ?? '';
            $image_path = $promotionAndDiscount->image_path ?? 'assets/img/noimage.jpg';
            $discount_type = $promotionAndDiscount->discount_type ?? '';
            $discount_value = $promotionAndDiscount->discount_value ?? '';
            $min_applicable_amount = $promotionAndDiscount->min_applicable_amount ?? '';
            $status = $promotionAndDiscount->status ?? '';
            $max_discount = $promotionAndDiscount->max_discount ?? '';
            $expiry_date = $promotionAndDiscount->expiry_date ?? '';
            $usage_limit = $promotionAndDiscount->usage_limit ?? '';
            $usage_limit_per_user = $promotionAndDiscount->usage_limit_per_user ?? '';
        @endphp

        <form action="{{ route('promotion-and-discount-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" class="form-control">

            <div class="row row-deck">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ Request::segment(2) === 'add-promotion-and-discount' ? 'Add' : 'Edit' }} Promotion And Discount
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" value="{{ old('title', $title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title" autocomplete="off" required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Coupon Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="coupon_code" class="form-label">Coupon Code</label>
                                        <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $coupon_code) }}" class="form-control @error('coupon_code') is-invalid @enderror" placeholder="Coupon Code" autocomplete="off" required>
                                        @error('coupon_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Discount Type -->
                                    <div class="form-group">
                                        <label for="discount_type" class="form-label">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="form-control" required>
                                            <option value="1" @if(old('discount_type', $discount_type) == 1) selected @endif>Fixed Amount</option>
                                            <option value="2" @if(old('discount_type', $discount_type) == 2) selected @endif>Percentage</option>
                                        </select>
                                        @error('discount_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Min Applicable Amount -->
                                    <div class="form-group">
                                        <label for="min_applicable_amount" class="form-label">Min Applicable Amount</label>
                                        <input type="number" step="0.01" name="min_applicable_amount" id="min_applicable_amount" value="{{ old('min_applicable_amount', $min_applicable_amount) }}" class="form-control @error('min_applicable_amount') is-invalid @enderror" placeholder="Min Applicable Amount" autocomplete="off">
                                        @error('min_applicable_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Expiry Date -->
                                    <div class="form-group">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $expiry_date) }}" class="form-control @error('expiry_date') is-invalid @enderror" placeholder="Expiry Date" autocomplete="off">
                                        @error('expiry_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Usage Limit -->
                                    <div class="form-group">
                                        <label for="usage_limit" class="form-label">Usage Limit</label>
                                        <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $usage_limit) }}" class="form-control @error('usage_limit') is-invalid @enderror" placeholder="Usage Limit" autocomplete="off">
                                        @error('usage_limit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Usage Limit Per User -->
                                    <div class="form-group">
                                        <label for="usage_limit_per_user" class="form-label">Usage Limit Per User</label>
                                        <input type="number" name="usage_limit_per_user" id="usage_limit_per_user" value="{{ old('usage_limit_per_user', $usage_limit_per_user) }}" class="form-control @error('usage_limit_per_user') is-invalid @enderror" placeholder="Usage Limit Per User" autocomplete="off">
                                        @error('usage_limit_per_user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <!-- Language -->
                                    <div class="form-group">
                                        <label for="language_id" class="form-label">Language</label>
                                        <select name="language_id" id="language_id" class="form-control" required>
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

                                    <!-- Discount Value -->
                                    <div class="form-group">
                                        <label for="discount_value" class="form-label">Discount Value</label>
                                        <input type="number" step="0.01" name="discount_value" id="discount_value" value="{{ old('discount_value', $discount_value) }}" class="form-control @error('discount_value') is-invalid @enderror" placeholder="Discount Value" autocomplete="off" required>
                                        @error('discount_value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Max Discount -->
                                    <div class="form-group">
                                        <label for="max_discount" class="form-label">Max Discount</label>
                                        <input type="number" step="0.01" name="max_discount" id="max_discount" value="{{ old('max_discount', $max_discount) }}" class="form-control @error('max_discount') is-invalid @enderror" placeholder="Max Discount" autocomplete="off">
                                        @error('max_discount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Image Path -->
                                    <div class="form-group">
                        <label for="image_path" class="form-label">Image</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 155px;">
                                <img id="imageThumb" src="{{ url('/') }}/{!! $image_path !!}"> 
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 155px; line-height: 20px;"></div>
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file" style="width: 100%;">
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

                                <div class="col-md-6">
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control ckeditor" placeholder="Description" rows="8">{{ old('description', $description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-md-12">
                                    <!-- Submit Button -->
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

@elseif(Request::segment(2) === 'view-promotion-and-discount')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="card-title">Promotion and Discounts Details</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Title:</strong></h5>
                        <p>{{ $promotionAndDiscount->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Coupon Code:</strong></h5>
                        <p>{{ $promotionAndDiscount->coupon_code }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Discount Type:</strong></h5>
                        <p>{{ $promotionAndDiscount->discount_type == 2 ? 'Percentage' : 'Fixed Amount' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Discount Value:</strong></h5>
                        <p>{{ $promotionAndDiscount->discount_value }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Minimum Applicable Amount:</strong></h5>
                        <p>{{ $promotionAndDiscount->min_applicable_amount }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Expiry Date:</strong></h5>
                        <p>{{ \Carbon\Carbon::parse($promotionAndDiscount->expiry_date)->format('d M, Y') }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Usage Limit:</strong></h5>
                        <p>{{ $promotionAndDiscount->usage_limit ?? 'Unlimited' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Usage Limit Per User:</strong></h5>
                        <p>{{ $promotionAndDiscount->usage_limit_per_user ?? 'Unlimited' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Status:</strong></h5>
                        <span class="badge {{ $promotionAndDiscount->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $promotionAndDiscount->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Image:</strong></h5>
                        @if($promotionAndDiscount->image_path)
                            <img src="{{ asset($promotionAndDiscount->image_path) }}" alt="Promotion Image" class="img-fluid rounded shadow-sm">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h5><strong>Description:</strong></h5>
                        <p>{!! $promotionAndDiscount->description !!}</p>
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
				<h3 class="card-title">Promotion And Discount Management</h3>
				<div class="card-options">
                    @can('promotion-and-discount-add')
					<a class="btn btn-sm btn-outline-primary" href="{{ route('promotion-and-discount-create') }}"> 
						<i class="fa fa-plus"></i> Create New Promotion And Discount
					</a>
					&nbsp;&nbsp;&nbsp;
                    @endcan
					<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
						<i class="fa fa-mail-reply"></i>
					</a>
				</div>
			</div>
			<form action="{{ route('promotion-and-discount-action') }}" method="POST" class="form-horizontal" autocomplete="off">
				@csrf
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered w-100">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">#</th>
									<th>Title</th>
									<th>Coupon Code</th>
									<!-- <th>Description</th> -->
									<th>Discount Percent</th>
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
									<td>{{ $rows->title }}</td>
									<td>{{ $rows->coupon_code }}</td>
									<!-- <td>{!! mb_substr($rows->description,0,100) !!}</td> -->
									<td>
                                        @if($rows->discount_type == '2') 
                                        <span class="text-info">
                                        {{ $rows->discount_value }} %</span>
                                        @else 
                                        <span class="text-success">{{@$appSetting->currency->icon}} 
                                        {{ $rows->discount_value }}</span>
                                        @endif
                                    </td>
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
                                            @can('promotion-and-discount-read')
                                            <a class="btn btn-sm btn-secondary" href="{{ route('promotion-and-discount-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('promotion-and-discount-edit')
                                            <a class="btn btn-sm btn-success" href="{{ route('promotion-and-discount-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            	<i class="fa fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('promotion-and-discount-delete')
                                            <a class="btn btn-sm btn-danger" href="{{ route('promotion-and-discount-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
