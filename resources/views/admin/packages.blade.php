@extends('admin.layouts.master')
@section('extracss')
<style type="text/css">
	.suggestions-list {
        border: 1px solid #ddd;
        max-height: 150px;
        overflow-y: auto;
        background-color: white;
        list-style: none;
        padding-left: 0;
    }
    .suggestions-list li {
        padding: 8px;
        cursor: pointer;
    }
    .suggestions-list li:hover {
        background-color: #f0f0f0;
    }
    .margin-top-20{
    	margin-top: 20px;
    }
</style>
@endsection
@section('content')
@php
$package_label =  str_contains(url()->current(), 'activity') ? 'Activity' : 'Package';
@endphp
@php
$fullUrl = request()->getRequestUri();
if (str_contains($fullUrl, 'ramta-yogi')) {
$queryParam = 'ramta-yogi';

}elseif (str_contains($fullUrl, 'domestic')) {
$queryParam = 'domestic';

} elseif (str_contains($fullUrl, 'international')) {
$queryParam = 'international';

} elseif (str_contains($fullUrl, 'visa')) {
$queryParam = 'visa';

} elseif (str_contains($fullUrl, 'activity')) {
	$queryParam = 'activity';

}else {
$queryParam = '';
}
@endphp

@if(Request::segment(2)==='edit-package' || Request::segment(2)==='add-package' || Request::segment(2)==='edit-activity' || Request::segment(2)==='add-activity')

<form action="{{ route('package-save',$queryParam) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
	@csrf
	<div class="row row-deck">
		<div class="col-lg-12">
			<div class="card">
				@foreach(App\Models\Language::all() as $key=>$lang)

				@if(Request::segment(2)==='add-package' || Request::segment(2)==='add-activity')
				<?php
				$id = '';
				$uuid = '';
				$destination_id = '';
				$special = 2;
				$featured = 2;
				$view_on_home = 2;
				$destination_type = '';
				$package_type = '';
				$language_id = '';
				$service_id = '';
				$package_name = '';
				$description = '';
				$duration = '';
				$inclusions = [];
				$exclusions = [];
				$itinerary = [];
				$activities = [];
				$available_dates = [];
				$terms_and_conditions = '';
				$status = '';
				$data_for = 'package';
				$images = [];
				?>
				@else
				<?php
				$package = App\Models\Package::where('uuid',$uuid)->where('language_id',$lang->id)->first();

				if (!empty($package)) {


					$id = $package->id;
					$uuid = $uuid;
					$destination_id = $package->destination_id;
					$destination_type = $package->destination->destination_type;
					$package_type = $package->package_type;
					$language_id = $package->language_id;
					$service_id = $package->service_id;
					$package_name = $package->package_name;
					$description = $package->description;
					$duration = $package->duration;
					$inclusions = json_decode($package->inclusions);
					$exclusions = json_decode($package->exclusions);
					$itinerary = json_decode($package->itinerary);
					$activities = json_decode($package->activities);
					$available_dates = json_decode($package->available_dates);
					$terms_and_conditions = $package->terms_and_conditions;
					$status = $package->status;
					$images = $package->images;
					$special = $package->special;
					$featured = $package->featured;
					$view_on_home = $package->view_on_home;
					$data_for = $package->data_for;
				}
				else
				{
					$id = '';
					$uuid = $uuid;
					$destination_id = '';
					$language_id = '';
					$destination_type = '';
					$package_type = '';
					$service_id = '';
					$package_name = '';
					$description = '';
					$duration = '';
					$inclusions = [];
					$exclusions = [];
					$itinerary = [];
					$activities = [];
					$available_dates = [];
					$terms_and_conditions = '';
					$status = '';
					$data_for = 'package';
					$images = [];
					$special = 2;
					$featured = 2;
					$view_on_home = 2;
				}
				?>
				@endif

				@if($key != 0)
				<hr>
				@endif
				<div class="card-header">
					<h3 class="card-title">
						@if(Request::segment(2) === 'add-package')
						Add
						@else
						Edit
						@endif
						{{$package_label}} In {{$lang->name}}
					</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<input type="hidden" name="uuid" value="{{$uuid}}">

						<!-- {{$package_label}} Name -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="package_name" class="form-label">{{$package_label}} Name </label>
								<input type="text" name="{{$lang->id}}[package_name]" id="{{$lang->id}}package_name" value="{{ old('package_name', $package_name) }}" class="form-control @error('package_name') is-invalid @enderror" placeholder="{{$package_label}} Name" autocomplete="off" @if($appSetting->default_language == $lang->id)required @endif>
								@error('package_name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Duration -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="duration" class="form-label">Duration </label>
								<input type="text" name="{{$lang->id}}[duration]" id="{{$lang->id}}duration" value="{{ old('duration', $duration) }}" class="form-control @error('duration') is-invalid @enderror" placeholder="Duration" @if($appSetting->default_language == $lang->id)required @endif>
								@error('duration')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						@if($lang->id == $appSetting->default_language)


						<!-- Data For -->
						<input type="hidden" name="{{$lang->id}}[data_for]" value="{{ str_contains(url()->current(), 'activity') ? 'activity' : 'package' }}">
						

						<div class="col-md-4">
							<div class="form-group">
								<label for="{{$lang->id}}[package_type]" class="form-label">{{$package_label}} Type</label>
								<select name="{{$lang->id}}[package_type]" id="package_type" class="form-control @error('package_type') is-invalid @enderror select2-show-search">
									<option value="">Select Package Type</option>
									@foreach(App\Models\PackageType::all() as $key => $value)
									<option value="{{ $value->package_type }}" {{ $package_type == $value->package_type ? 'selected' : '' }}>{{ $value->package_type }}</option>
									@endforeach
								</select>
								@error('package_type')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
								<ul id="package-type-suggestions" class="suggestions-list" style="display: none;"></ul>
							</div>
						</div>


						<!-- Destination Type ID -->
						<div class="col-md-4">
							<div class="form-group">
								<label for="destination_type" class="form-label">Destination Type</label>
								<select name="{{$lang->id}}[destination_type]" id="destination_type_{{$lang->id}}" 
									class="form-control @error('destination_type') is-invalid @enderror" 
									onchange="getDestinations(this.value)" 
									@if($queryParam == 'domestic' || $queryParam == 'international') disabled @endif>
									<option value="1" {{ $destination_type == '1' || $queryParam == 'domestic' ? 'selected' : '' }}>Domestic</option>
									<option value="2" {{ $destination_type == '2' || $queryParam == 'international' ? 'selected' : '' }}>International</option>
								</select>
							</div>
						</div>


						<!-- Destination ID -->
						<div class="col-md-4">
							<div class="form-group">
								<label for="destination_id" class="form-label">Destination</label>
								<select name="{{$lang->id}}[destination_id]" id="destination_id" class="form-control @error('destination_id') is-invalid @enderror select2-show-search" required>
									<option value="">Select Destination</option>
									@foreach($destinations as $key => $value)
									<option value="{{ $value->id }}" {{ $destination_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
									@endforeach
								</select>
								@error('destination_id')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Service ID -->
						<div class="col-md-4">
							<div class="form-group">
								<label for="service_id" class="form-label">Service </label>
								@if($queryParam == 'ramta-yogi')
								<?php $val = App\Models\Service::where('name','ramta yogi')->first() ?>
								@elseif($queryParam == 'visa')
								<?php $val = App\Models\Service::where('name','visa')->first() ?>
								@elseif($queryParam == 'international')
								<?php $val = App\Models\Service::where('name','LIKE','%international%')->first() ?>
								@elseif($queryParam == 'domestic')
								<?php $val = App\Models\Service::where('name','LIKE','%domestic%')->first() ?>
								@elseif($queryParam == 'activity')
								<?php $val = App\Models\Service::where('name','LIKE','%activity%')->first() ?>
								@endif
								@if($queryParam == 'ramta-yogi' || $queryParam == 'visa' || $queryParam == 'international' || $queryParam == 'domestic'|| $queryParam == 'activity')
								<input type="hidden" name="{{$lang->id}}[service_id]" value="{{@$val->id}}" readonly>
								<input type="text" class="form-control" name="" value="{{@$val->name ?? $queryParam}}" readonly>
								@else
								<select name="{{$lang->id}}[service_id]" id="{{$lang->id}}service_id" class="form-control @error('service_id') is-invalid @enderror" @if($appSetting->default_language == $lang->id) required @endif>
									<option value="">Select Service</option>
									@foreach($services as $key => $value)
									<option value="{{ $value->id }}" {{ $service_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
									@endforeach
								</select>
								@endif
								@error('service_id')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>



						@foreach(App\Models\Currency::all() as $currency)
						<div class="col-md-4">
							<div class="form-group">
								<label for="price_{{ $currency->id }}" class="form-label">Price In {{ $currency->name }} </label>
								<input type="number" step="0.01"
								name="{{$lang->id}}[price][{{ $currency->id }}]"
								id="{{$lang->id}}price_{{ $currency->id }}"
								value="{{ old('price.' . $currency->id, $price[$currency->id] ?? '') }}"
								class="form-control @error('price.' . $currency->id) is-invalid @enderror"
								placeholder="Price" required>
								@error('price.' . $currency->id)
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						@endforeach
						@endif

						<!-- Description -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="{{$lang->id}}description" class="form-label">Description</label>
								<textarea name="{{$lang->id}}[description]" id="{{$lang->id}}description" class="form-control ckeditor  @error('description') is-invalid @enderror" placeholder="Description" @if($appSetting->default_language == $lang->id)required @endif>{{ old('description', $description) }}</textarea>
								@error('description')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Inclusions -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="inclusions" class="form-label">Inclusions</label>
								<div id="{{$lang->id}}inclusions">
									@foreach((array)old('inclusions', $inclusions) as $inclusion)
									<div class="input-group mb-2">
										<input type="text" name="{{$lang->id}}[inclusions][]" value="{{ $inclusion }}" class="form-control">
										<div class="input-group-append">
											<button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
										</div>
									</div>
									@endforeach
								</div>
								<button type="button" onclick="addField('{{$lang->id}}inclusions', 'text')" class="btn btn-primary btn-sm">Add Inclusion</button>

								@error('inclusions')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Exclusions -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="exclusions" class="form-label">Exclusions (Optional)</label>
								<div id="{{$lang->id}}exclusions">
									@foreach((array)old('exclusions', $exclusions) as $exclusion)
									<div class="input-group mb-2">
										<input type="text" name="{{$lang->id}}[exclusions][]" value="{{ $exclusion }}" class="form-control">
										<div class="input-group-append">
											<button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
										</div>
									</div>
									@endforeach
								</div>
								<button type="button" onclick="addField('{{$lang->id}}exclusions', 'text')" class="btn btn-primary btn-sm">Add Exclusion</button>
								@error('exclusions')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Itinerary -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="itinerary" class="form-label">Itinerary (Optional)</label>
								<div id="{{$lang->id}}itinerary">
									@foreach((array)old('itinerary', $itinerary) as $key1 => $itineraryItem)
									<div class="input-group mb-2">
										<input type="text" name="{{$lang->id}}[itinerary][{{ $key1 }}][title]" value="{{ $itineraryItem->title }}" class="form-control">
										<div class="input-group-append">
											<button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
										</div>
										<textarea class="ckeditor margin-top-20" name="{{$lang->id}}[itinerary][{{ $key1 }}][description]">{{$itineraryItem->description}}</textarea>
										<br>
									</div>
									@endforeach
								</div>
								<button type="button" onclick="addItineraryField('{{$lang->id}}itinerary',1)" class="btn btn-primary btn-sm">Add Itinerary</button>
								@error('itinerary')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Available Dates -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="available_dates" class="form-label">Available Dates (Optional)</label>
								<div id="{{$lang->id}}available_dates">
									@foreach((array)old('available_dates', $available_dates) as $key => $date)
									<div class="input-group mb-2">
										<input type="date" name="{{$lang->id}}[available_dates][{{ $key }}][start_date]" value="{{ $date->start_date ?? '' }}" class="form-control">
										<input type="date" name="{{$lang->id}}[available_dates][{{ $key }}][end_date]" value="{{ $date->end_date ?? '' }}" class="form-control">
										<div class="input-group-append">
											<button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
										</div>
									</div>
									@endforeach
								</div>
								<button type="button" onclick="addDateField('{{$lang->id}}available_dates')" class="btn btn-primary btn-sm">Add Date</button>
								@error('available_dates')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<!-- Images -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="images" class="form-label">Images (W:1200 H:800 (in PX))</label>
								<div id="{{$lang->id}}images-uploads">
									<div class="input-group mb-2">
										<input type="file" name="{{$lang->id}}[images][]" multiple class="form-control" @if(($appSetting->default_language == $lang->id) && (count($images) <= 0)) required @endif>
									</div>
								</div>
								@error('images')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						@forelse($images as $image)
						<div class="col-md-3">
							<div class="form-group">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
										<img id="image-{{$loop->index}}" src="{{ asset($image->image_path) }}">
										<span class="badge badge-danger remove-img" onclick="removeImage('{{$image->id}}', {{$loop->index}})">
											<span class="fileupload-new"><i class="fa fa-times"></i> Remove</span>
										</span> 
									</div>
								</div>
								<div>

								</div>
							</div>
						</div>
						@empty
						@endforelse


						<!-- Terms and Conditions -->
						<div class="col-md-12">
							<div class="form-group">
								<label for="terms_and_conditions" class="form-label">Terms and Conditions (Optional)</label>
								<textarea name="{{$lang->id}}[terms_and_conditions]" id="{{$lang->id}}terms_and_conditions']" class="form-control @error('terms_and_conditions') is-invalid @enderror" placeholder="Terms and Conditions">{{ old('terms_and_conditions', $terms_and_conditions) }}</textarea>
								@error('terms_and_conditions')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-center">
					<div class="row">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">
							@if(Request::segment(2) === 'add-package' || Request::segment(2) === 'add-activity')
							Add
							@else
							Update
							@endif
							{{$package_label}}
						</button>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</form>


@elseif(Request::segment(2)==='view-package' || Request::segment(2)==='view-activity')

<div class="row">


	@forelse(App\Models\Language::all() as $lang)
	@php
	$package = App\Models\Package::where('uuid',$uuid)->where('language_id',$lang->id)->first();
	@endphp
	@if (!empty($package))
	<!-- {{$package_label}} Information -->
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h3><b>{{ $package->package_name }}  / {{$package->duration}}</b></h3>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<h4>Description</h4>
						<p>{!! $package->description !!}</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- {{$package_label}} Dates -->
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					@foreach($package->images as $image)
					<div class="col-md-12">
						<img src="{{ asset($image->image_path) }}" alt="{{$package_label}} Image" class="img-fluid">
					</div>
					@endforeach
					<div class="col-md-3">
						<h5>Destination -  {{ @$package->destination->name }}</h5>
					</div>
					<div class="col-md-3">
						<h5>Service -  {{ @$package->service->name }}</h5>
					</div>
					@forelse(App\Models\Currency::all() as $currency)
					<div class="col-md-3">
						@php
						$priceAttribute = 'price_in_currency_' . $currency->id; // Dynamically construct the price attribute name
						@endphp
						<h5>Price in {{$currency->name}} - {{$currency->icon}} {{ $package->$priceAttribute }}</h5>
					</div>
					@empty
					<p>No Price available.</p>
					@endforelse

					<div class="col-md-3">
						<h5>Status -  {{ $package->status == 1 ? 'Active' : 'Inactive' }}</h5>
					</div>
					<div class="col-md-12">
						<h4><b>Available Dates</b></h4>
						<ul>
							@foreach(json_decode($package->available_dates) as $date)
							<li>{{$date->start_date}} - {{$date->end_date}}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Images -->
    <!-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4><b>Images</b></h4>
                <div class="row">
                    @foreach($package->images as $image)
                        <div class="col-md-4">
                            <img src="{{ asset($image->image_path) }}" alt="{{$package_label}} Image" class="img-fluid">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> -->

    <!-- Inclusions and Exclusions -->
    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body">
    			<h4><b>Inclusions</b></h4>
    			<ul>
    				@foreach(json_decode($package->inclusions) as $inclusion)
    				<li>{{ $inclusion }}</li>
    				@endforeach
    			</ul>
    		</div>
    	</div>
    </div>

    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body">
    			<h4><b>Exclusions</b></h4>
    			<ul>
    				@if(!empty($package->exclusions))
    				@foreach(json_decode($package->exclusions) as $exclusion)
    				<li>{{ $exclusion }}</li>
    				@endforeach
    				@endif
    			</ul>
    		</div>
    	</div>
    </div>

    <!-- Activities -->
    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body">
    			<h4><b>Activities</b></h4>
    			<ul>
    				@foreach($package->activityLists as $activity)
    				<li>{{ $activity->title }}</li>
    				@endforeach
    			</ul>
    		</div>
    	</div>
    </div>

    <!-- Terms And Conditions -->
    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body">
    			<div class="row">
    				<div class="col-md-12">
    					<h4>Terms And Conditions</h4>
    					<p>{{$package->terms_and_conditions}}</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    @endif

    @empty
    @endforelse

    <!-- Action Buttons -->
    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body border">
    			<div class="terms">
    				@php
    				$package = App\Models\Package::where('uuid',$uuid)->first();
    				@endphp
    				<a href="{{ route('package-edit',$package->id) }}" class="btn btn-primary">Edit</a>
    				<a href="{{ route('packages-list') }}" class="btn btn-secondary">Back to Packages</a>
    			</div>
    		</div>
    	</div>
    </div>
</div>


@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{{$package_label}} Management</h3>
				<div class="card-options">
					<a class="btn btn-sm btn-outline-primary" href="{{ route('package-create', $queryParam) }}">
						<i class="fa fa-plus"></i> Create New Package
					</a>
					&nbsp;&nbsp;&nbsp;
					<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
						<i class="fa fa-mail-reply"></i>
					</a>
				</div>
			</div>
			<form action="{{ route('package-action') }}" method="POST" class="form-horizontal" autocomplete="off">
				@csrf
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered w-100">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Type</th>
									<th scope="col">Destination</th>
									<th scope="col">D-Type</th>
									<th scope="col">Service</th>
									<th scope="col">Price</th>
									<th scope="col">Status</th>
									<th scope="col" width="10%">Action</th>
								</tr>
							</thead>
							<tbody>
								@php $i = 0 @endphp
								@foreach($packages as $package)
								<tr>
									<td>
										<label class="custom-control custom-checkbox">
											<input type="checkbox" name="boxchecked[]" value="{{ $package->uuid }}" class="colorinput-input custom-control-input">
											<span class="custom-control-label"></span>
										</label>
									</td>
									<td>{!! ++$i !!}</td>
									<td>{!! $package->package_name !!}</td>
									<td>{!! $package->package_type !!}</td>
									<td>{!! @$package->destination->name !!}</td>
									<td>{!! @$package->destination->destination_type == 1 ? 'Domestic' : 'International' !!}</td>
									<td>{!! @$package->service->name !!}</td>
									<td> 
										<ul class="list-group">
											{{$appSetting->currency->icon}} 
											{{ $package->{'price_in_currency_' . $appSetting->default_language} }}

										</ul>
									</td>
									<td class="text-center">
										<div class="btn-group btn-group-xs">
											@if($package->status=='2')
											<span class="text-danger">Inactive</span>
											@else
											<span class="text-success">Active</span>
											@endif
										</div>
									</td>
									<td>
										<div class="btn-group btn-group-xs">
											<a class="btn btn-sm btn-secondary" href="{{ route('package-view', $package->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
												<i class="fa fa-eye"></i>
											</a>
											<a class="btn btn-sm btn-primary" href="{{ route('package-edit', $package->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
												<i class="fa fa-edit"></i>
											</a>
											<a class="btn btn-sm btn-danger" href="{{ route('package-delete', $package->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
												<i class="fa fa-trash"></i>
											</a>
											<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal{{$package->uuid}}" ><i class="fa fa-cog"></i></button>
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
@forelse($packages as $package)
<div id="modal{{$package->uuid}}" class="modal fade">
	<div class="modal-dialog role="document">
		<div class="modal-content ">
			<div class="modal-header pd-x-20">
				<h6 class="modal-title">Select  Actions</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('package-setting') }}" method="POST" class="form-horizontal" autocomplete="off">
				@csrf
				<input type="hidden" name="uuid" value="{{$package->uuid}}">
				<div class="modal-body">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="trending" @if($package->trending == 1) Checked @endif id="actionSpecial">
						<label class="form-check-label" for="actionSpecial">
							Trending
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="special" @if($package->special == 1) Checked @endif id="actionSpecial">
						<label class="form-check-label" for="actionSpecial">
							Special
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="featured" @if($package->featured == 1) Checked @endif id="actionFeatured">
						<label class="form-check-label" for="actionFeatured">
							Featured
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="view_on_home" @if($package->view_on_home == 1) Checked @endif id="actionViewOnHome">
						<label class="form-check-label" for="actionViewOnHome">
							View On Home
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="sumit" class="btn btn-primary">Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>

			</form>
		</div>
	</div><!-- modal-dialog -->
</div>
@empty
@endforelse
@endif
@section('extrajs')
<script>
	window.onload = function() {
	    // getDestinations(document.getElementById('destination_type_1').value);
	    ckEditor();
	};
	function addField(id, type) {
		let container = document.getElementById(id);
    // let langId = container.id.split(id)[0]; // Extract language ID from container ID
    let langId =(id)[0]; // Extract language ID from container ID

    let div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
    <input type="${type}" name="${langId}[${id.replace(langId, '').replace('-uploads', '')}][]" class="form-control">
    <div class="input-group-append">
    <button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
    </div>`;
    container.appendChild(div);
}

function addItineraryField(id,initiate) {
	let container = document.getElementById(id);
    let langId = container.id.split('itinerary')[0]; // Extract language ID from container ID
    let index = container.children.length; // Use length to index the new field
    let contentIndex = index + 6;
    let div = document.createElement('div');
    div.className = 'input-group mb-2';

    // Updated input fields (title as text input and description as textarea)
    div.innerHTML = `
    <input type="text" name="${langId}[itinerary][${index}][title]" class="form-control" placeholder="Title">
    <div class="input-group-append">
    <button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
    </div>
    <textarea name="${langId}[itinerary][${index}][description]" class="ckeditor  margin-top-20" placeholder="Description"></textarea><br>`;
    
    container.appendChild(div);

    // Initialize RichTextEditor for the new textarea
    // if (initiate == 1) {
    // 	$('.content' + contentIndex).richText();
    // }
    ckEditor();

}


function addDateField(id) {
	let container = document.getElementById(id);
    let langId = container.id.split('available_dates')[0]; // Extract language ID from container ID
    let index = container.children.length; // Use length to index the new date field
    let div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
    <input type="date" name="${langId}[available_dates][${index}][start_date]" class="form-control" placeholder="Start Date">
    <input type="date" name="${langId}[available_dates][${index}][end_date]" class="form-control" placeholder="End Date">
    <div class="input-group-append">
    <button type="button" class="btn btn-danger" onclick="removeField(this)">Remove</button>
    </div>`;
    container.appendChild(div);
}

function removeField(button) {
	let container = button.closest('.col-md-12').querySelector('.form-group > div');
	button.parentElement.parentElement.remove();

    // Reindex only for available_dates
    if (container.id.admin.includes('available_dates')) {
    	Array.from(container.children).forEach((child, index) => {
            let langId = container.id.split('available_dates')[0]; // Extract language ID from container ID
            child.querySelector('input[name*="[start_date]"]').name = `${langId}available_dates[${index}][start_date]`;
            child.querySelector('input[name*="[end_date]"]').name = `${langId}available_dates[${index}][end_date]`;
        });
    }
}

// Ensure at least one input box for each field on page load
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['inclusions', 'exclusions']; //, 'activities'
    fields.forEach(field => {
    	document.querySelectorAll('[id*=' + field + ']').forEach(container => {
    		if (container.children.length === 0) {
    			addField(container.id, 'text');
    		}
    	});
    });

    document.querySelectorAll('[id*="available_dates"]').forEach(container => {
    	if (container.children.length === 0) {
    		addDateField(container.id);
    	}
    });

    document.querySelectorAll('[id*="itinerary"]').forEach(container => {
    	if (container.children.length === 0) {
    		addItineraryField(container.id,0);
    	}
    });
});

function removeImage(image_id, index) {
	if(confirm("Are you sure you want to delete this image?")) {
		$.ajax({
            url: '{{ route("package-image-delete") }}', // Add your route here
            type: 'DELETE',
            data: {
            	_token: '{{ csrf_token() }}',
            	image_id: image_id
            },
            success: function(response) {
            	if(response.success) {
                    // Remove the image from the DOM
                    $('#image-' + index).remove();
                } else {
                	alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
            	alert('Failed to remove the image.');
            }
        });
	}
}

function getDestinations(value)
{
	// Make AJAX request
	$.ajax({
	    url: "{{ route('get-destinations') }}", // The URL to fetch destinations
	    method: 'GET',
	    data: {
	    	destination_type: value
	    },
	    success: function(response) {
	    	var destinationDropdown = $('#destination_id');
	        destinationDropdown.empty(); // Clear the current dropdown

	        destinationDropdown.append('<option value="">Select Destination</option>'); // Add default option
	        $.each(response.destinations, function(index, destination) {
	        	destinationDropdown.append('<option value="' + destination.id + '">' + destination.name + '</option>');
	        });
	    },
	    error: function(xhr) {
	        console.log(xhr.responseText); // Handle errors
	    }
	});
}

$(document).ready(function() {
    // Handle input event for package type suggestions
    $('#package_type').on('input', function() {
    	let query = $(this).val();

        // If input is not empty, send AJAX request
        if (query.length > 1) {
        	$.ajax({
        		url: "{{ route('get-package-types') }}",
        		type: 'GET',
        		data: { term: query },
        		success: function(data) {
        			let suggestions = $('#package-type-suggestions');
                    suggestions.empty();  // Clear previous suggestions

                    // If data exists, show suggestions
                    if (data.length > 0) {
                    	suggestions.show();
                    	data.forEach(function(packageType) {
                    		suggestions.append('<li>' + packageType + '</li>');
                    	});
                    } else {
                        suggestions.hide();  // Hide if no suggestions
                    }
                }
            });
        } else {
            $('#package-type-suggestions').hide();  // Hide suggestions on empty input
        }
    });

    // Handle suggestion click
    $('#package-type-suggestions').on('click', 'li', function() {
        $('#package_type').val($(this).text());  // Set selected value
        $('#package-type-suggestions').hide();  // Hide suggestions
    });
});

$(function() {
 $('.select2-show-search').select2({
   minimumResultsForSearch: ''
 });
})

function ckEditor()
{
	document.querySelectorAll('.ckeditor').forEach(function(textarea) {
        CKEDITOR.replace(textarea);
    });
}


</script>
@endsection


@endsection
