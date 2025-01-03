@extends('layouts.master-front')
@section('extracss')
<style type="text/css">
	.width-75{
		width: 75% !important;
	}
	.travel-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr); /* Three columns */
		gap: 20px;
	}

	.grid-item {
		display: flex;
		flex-direction: column;
	}

	@media (max-width: 992px) {
		.travel-grid {
			grid-template-columns: repeat(2, 1fr); /* Two columns for medium screens */
		}
	}

	@media (max-width: 576px) {
		.travel-grid {
			grid-template-columns: 1fr; /* One column for small screens */
		}
		}/* General Modal Styling */
		.modal .modal-content {
			padding: 20px;
			background-color: #f9f9f9;
		}

		/* Package Type Styling */
		.event-sidebar-title {
			font-size: 1.2em;
			font-weight: bold;
			margin-bottom: 15px;
		}

		.check-box-wrap {
			display: flex;
			flex-direction: column;
		}

		/* Price Range Slider Styling */
		.range-slider {
			position: relative;
			display: flex;
			align-items: center;
			gap: 15px;
			padding: 10px 0;
		}

		.range-slider input[type="range"] {
			-webkit-appearance: none;
			width: 100%;
			height: 8px;
			background: #ddd;
			border-radius: 5px;
			outline: none;
			cursor: pointer;
		}

		.range-slider input[type="range"]::-webkit-slider-thumb {
			-webkit-appearance: none;
			width: 18px;
			height: 18px;
			border-radius: 50%;
			background: #007bff;
		}

		.range-slider-output {
			display: flex;
			align-items: center;
			font-size: 1em;
			gap: 5px;
		}

		.price {
			font-weight: bold;
			margin-right: 10px;
		}

		/* Rating Stars Styling */
		.event-rating-btn {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.rating-btn-item {
			display: flex;
			align-items: center;
		}

		.rating-btn-item i.fa-star {
			margin-right: 2px;
			font-size: 1em;
		}


		.pxs-secondary-btn {
			background-color: #ccc;
			color: #333;
			padding: 8px 16px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			margin-left: 10px;
		}


	</style>
	@endsection
	@section('content')
	<div class="col-md-12">
		@if($message = Session::get('success'))
		<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
			<span class="emoji round">🏆</span>
			<h3 class="text-center">{!! $message !!}</h3> 
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endif
	</div>
	@include('common.slider')

	<section class="event-listing-section pt-0 padding-0">
		<div class="container">
			<div class="page-header-content">
				<form action="{{ route('packages') }}" method="GET">
					<div class="search-filter-items">
						<div class="search-filter-item width-75">
							<h3 class="search-filter-header">Location</h3>
							<div class="search-filter-icon">
								<i class="fa-regular fa-calendar"></i>
							</div>
							@php
							$destinationType = null;
							if (request()->query('destination') == 'domestic') 
							{
								$destinationType = 1;
							} elseif (request()->query('destination') == 'international') {
							$destinationType = 2;
						}

						$destinations = App\Models\Destination::when($destinationType, function ($query, $destinationType) {
						return $query->where('destination_type', $destinationType);
					})->get();
					@endphp
					<select class="form-design width-100 select2-show-search" name="destination" id="pet-select">
						<option value="">Where are you going</option>
						@forelse($destinations as $destination)
						<option value="{{$destination->name}}">{{$destination->name}}</option>
						@empty
						<option value="">No destinations available</option>
						@endforelse
					</select>
				</div>
				<div class="search-filter-item">
					<button type="submit" class="pxs-primary-btn"><i class="fa-solid fa-globe"></i>Search</button>

					<button type="button" class="pxs-primary-btn d-lg-none" style="display: inline;" id="filter-button"  onclick="filter()"><i class="fa fa-filter" ></i> <span id="toggle-text">Filter</span></button>
					<!-- Trigger Modal Button -->
					<button type="button" class="pxs-primary-btn d-xs-none" data-bs-toggle="modal" data-bs-target="#filterModal" style="display: inline;">
						<i class="fa fa-filter"></i>  Filter
					</button>
				</div>
			</div>
		</form>
	</div>

	<!-- Modal Structure -->
	<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- Filter Form Start -->
					<form id="filterForm" class="row">
						@php
						$fullUrl = url()->full(); // Get the full URL

						if (str_contains($fullUrl, 'international')) {
							$requestData = 'international';
							$paramName = 'destination';
						} elseif (str_contains($fullUrl, 'domestic')) {
							$requestData = 'domestic';
							$paramName = 'destination';
						} elseif (str_contains($fullUrl, 'ramta-yogi')) {
							$requestData = 'ramta-yogi';
							$paramName = 'service';
						} else
						{
							$requestData = '';
							$paramName = '';
						}
			@endphp

			<input type="hidden" name="{{$paramName}}" value="{{$requestData}}">

			<!-- Package Type Filter -->
			<div class="col-md-3">
				<h3 class="event-sidebar-title">Filter By Package Type</h3>
				<div class="check-box-wrap">
					@forelse($packageTypes as $packageType)
					<div class="form-check form-item">
						<input class="form-check-input" type="checkbox" name="packageTypes[]" value="{{$packageType->package_type}}" id="packageType_{{$packageType->package_type}}" />
						<label class="form-check-label" for="packageType_{{$packageType->package_type}}">
							{{$packageType->package_type}}
						</label>
					</div>
					@empty
					<p>No Package Type available</p>
					@endforelse
				</div>
			</div>


			<!-- Rating Filter -->
			<div class="col-md-3">
				<h3 class="event-sidebar-title">Rating</h3>
				<div class="event-rating-btn">
					@for($i = 5; $i >= 1; $i--)
					<div class="rating-btn-item">
						<input type="checkbox" name="ratings[]" value="{{ $i }}" id="rating_{{ $i }}" />
						<label for="rating_{{ $i }}">
							@for($j = 1; $j <= $i; $j++)
							<i class="fa fa-star" style="color: #FFD700;"></i>
							@endfor
							@for($j = $i+1; $j <= 5; $j++)
							<i class="fa fa-star" style="color: #ddd;"></i>
							@endfor
						</label>
					</div>
					@endfor
				</div>
			</div>
			<!-- Price Range Filter -->
			<div class="col-md-6">
				<h3 class="event-sidebar-title">Filter By Price</h3>
				<div class="filter-box">
					<div class="range-slider">
						<input type="range" name="min_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MIN_FILTER_PRICE',5000)}}" id="min-price-range" />
						<input type="range" name="max_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MAX_FILTER_PRICE',500000)}}" id="max-price-range" />
					</div>
					<div class="range-slider-output">
						<h4 id="price-output" class="price">
							{{ App\Models\Currency::find(session('currency_id', $appSetting->default_currency))->icon }}
							<span id="min-price-output">{{env('MIN_FILTER_PRICE',5000)}}</span> - 
							<span id="max-price-output">{{env('MAX_FILTER_PRICE',500000)}}</span>
						</h4>
					</div>
				</div>
			</div>

			<!-- Submit Button -->
			<div class="event-sidebar-item">
				<div class="filter-box">
					<div class="filter-content text-center">
						<button type="button" id="applyFilter" class="pxs-primary-btn">Apply Filter</button>
						<button type="reset" class="pxs-secondary-btn">Reset</button>
					</div>
				</div>
			</div>
		</form>
		<!-- Filter Form End -->
	</div>
</div>
</div>
</div>

</div>
</section>
<!-- ./ page header -->
<section class="travel-section bg-grey padding">
	<div class="container">
		<!-- mobile filter -->
		<div class="event-sidebar d-lg-none" id="filterBox" style="display: none;">
			<div>
				<h3 class="event-sidebar-title">Filter By Package Type
				</h3>
				<div class="filter-box">
					<div>
						@forelse($packageTypes as $packageType)
						<button class="margin-5 btn btn-success filter-mobile-btn" 
						data-package-type="{{$packageType->package_type}}">
						{{$packageType->package_type}}
					</button>
					@empty
					<p>No package types available</p>
					@endforelse
				</div>
			</div>
		</div>
	</div>
	<div class="event-wrap">
		<div class="travel-grid-wrap wow fade-in-bottom" data-wow-delay="400ms">
			<div class="travel-grid"  id="eventListing">
				@forelse($packages as $package)
				<div class="grid-item">
					<div class="event-item">
						<div class="event-thumb">
							<div class="event-img">
								@if(count($package->images) > 0)
								<a href="{{ route('package-detail', $package->slug) }}">
									<img src="{{ asset('/' . $package->images[0]->image_path) }}" alt="{{ $package->package_name }}">
								</a>
								@endif
								@php
								$serviceName = $package->service->name; // Default service name
								$fullUrl = url()->full(); // Get the full URL

								if (str_contains($fullUrl, 'international')) {
								$serviceName = 'International';
							} elseif (str_contains($fullUrl, 'domestic')) {
							$serviceName = 'Domestic';
						} elseif (str_contains($fullUrl, 'ramta-yogi')) {
						$serviceName = 'Ramta Yogi';
					}
					@endphp

					<div class="event-text feature"><span>

					{{ $serviceName }}</span></div>
				</div>
			</div>
			<div class="event-content-wrap">
				<div class="event-content">
					<div class="event-content-left">
						<h3 class="event-title">
							<a href="{{ route('package-detail', $package->slug) }}">{{ $package->package_name }}</a>
						</h3>
						<h4 class="activity">
							<span> <i class="fa fa-map"></i> {{ $package->destination->name }}</span>
							<span> <i class="fa fa-fighter-jet"></i> {{ $package->service->name }}</span>
							<span><i class="fa-regular fa-clock ml-25"></i> {{ $package->duration }}</span>
						</h4>
					</div>
				</div>
				<div class="event-price-wrap">
					<h4 class="price">{{ $package->icon }} {{ $package->price }}</h4>
					<a href="{{ route('package-detail', $package->slug) . (request()->has('destination') ? '?' . http_build_query(request()->only('destination')) : '') }}" class="pxs-primary-btn">Detail</a>
				</div>
			</div>
		</div>
	</div>
	@empty
	@endforelse
</div>
</div>
</div>
</div>
</section>

<section class="event-listing-section padding">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="event-listing-items">
					{{ $packages->appends(request()->input())->links('common.pagination') }}
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ./ event-listing-section -->
@section('extrajs')



<script>
	function filter() {
		var filterBox = document.getElementById('filterBox');
	    // var filterButton = document.getElementById('filter-button');
	    var filterButton = document.getElementById('toggle-text');


	    if (filterBox.style.display === 'none' || filterBox.style.display === '') {
	    	filterBox.style.display = 'block';
	    	filterButton.innerText = 'Hide';
	    } else {
	    	filterBox.style.display = 'none';
	    	filterButton.innerText = 'Filter';
	    }
	}


	const minPriceRange = document.getElementById('min-price-range');
	const maxPriceRange = document.getElementById('max-price-range');
	const minPriceOutput = document.getElementById('min-price-output');
	const maxPriceOutput = document.getElementById('max-price-output');

    // Update the displayed prices when the slider is adjusted
    minPriceRange.addEventListener('input', function() {
    	minPriceOutput.textContent = this.value;
    });

    maxPriceRange.addEventListener('input', function() {
    	maxPriceOutput.textContent = this.value;
    });

    // Ensure that the minimum price is always less than or equal to the maximum price
    minPriceRange.addEventListener('input', function() {
    	if (parseInt(minPriceRange.value) > parseInt(maxPriceRange.value)) {
    		maxPriceRange.value = minPriceRange.value;
    		maxPriceOutput.textContent = minPriceRange.value;
    	}
    });

    maxPriceRange.addEventListener('input', function() {
    	if (parseInt(maxPriceRange.value) < parseInt(minPriceRange.value)) {
    		minPriceRange.value = maxPriceRange.value;
    		minPriceOutput.textContent = maxPriceRange.value;
    	}
    });
    $(document).ready(function() {
    	$('#applyFilter').on('click', function(e) {
    		e.preventDefault();
    		var formData = $('#filterForm').serialize();
    		$('#filterModal').modal('hide');
    		$.ajax({
    			url: '{{ route("packages-filter") }}',
    			type: 'GET',
    			data: formData,
    			beforeSend: function() {
    				var mainUrlQueryParams = window.location.search;
    				var queryString = $.param(formData);
    				if (mainUrlQueryParams) {
    					this.url += mainUrlQueryParams + '&' + queryString;
    				} else {
    					this.url += '?' + queryString;
    				}
    				this.url = this.url.replace(/(\?.*?)\?/g, '$1&');
    			},
    			success: function(response) {
    				$('#eventListing').empty();

    				$.each(response.packages, function(index, packageData) {
    					var content = packageData.content ? packageData.content : '';
    					var limitedContent = content.length > 200 ? content.substring(0, 200) + '...' : content;
    					var availableDates = packageData.available_dates ? JSON.parse(packageData.available_dates) : [];

    					var startDate = null;
    					var endDate = null;

    					if (availableDates.length > 0) {
    						availableDates.forEach(function(date) {
    							if (!startDate || new Date(date.start_date) < new Date(startDate)) {
    								startDate = date.start_date;
    							}
    							if (!endDate || new Date(date.end_date) > new Date(endDate)) {
    								endDate = date.end_date;
    							}
    						});
    					}

    					var formattedStartDate = startDate ? new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    					var formattedEndDate = endDate ? new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';

    					var destinationType = packageData.destination && packageData.destination.destination_type === 1 ? 'Domestic' : 'International';

    					var serviceName = packageData.service ? packageData.service.name : 'Service';
    					var fullUrl = window.location.href;

    					if (fullUrl.includes('international')) {
    						serviceName = 'International';
    					} else if (fullUrl.includes('domestic')) {
    						serviceName = 'Domestic';
    					} else if (fullUrl.includes('ramta-yogi')) {
    						serviceName = 'Ramta Yogi';
    					}

    					var packageHtml = `
    					<div class="grid-item">
    					<div class="event-item">
    					<div class="event-thumb">
    					<div class="event-img">
    					${packageData.images && packageData.images.length > 0 ? `
    						<a href="/package-detail/${packageData.slug}">
    						<img src="/${packageData.images[0].image_path}" alt="${packageData.package_name}">
    						</a>
    						` : ''}
    						<div class="event-text feature"><span>${serviceName}</span></div>
    						</div>
    						</div>
    						<div class="event-content-wrap">
    						<div class="event-content">
    						<div class="event-content-left">
    						<h3 class="event-title">
    						<a href="/package-detail/${packageData.slug}">${packageData.package_name}</a>
    						</h3>
    						<h4 class="activity">
    						<span><i class="fa fa-map"></i> ${packageData.destination ? packageData.destination.name : ''}</span>
    						<span><i class="fa fa-fighter-jet"></i> ${serviceName}</span>
    						<span><i class="fa-regular fa-clock ml-25"></i> ${packageData.duration}</span>
    						</h4>
    						</div>
    						</div>
    						<div class="event-price-wrap">
    						<h4 class="price">${packageData.icon} ${packageData.price}</h4>
    						<a href="/package-detail/${packageData.slug}${new URLSearchParams(window.location.search).has('destination') ? '?destination=' + new URLSearchParams(window.location.search).get('destination') : ''}" class="pxs-primary-btn">Detail</a>
    						</div>
    						</div>
    						</div>
    						</div>`;
    						$('#eventListing').append(packageHtml);
    					});
    			},
    			error: function(xhr, status, error) {
    				console.error('Error filtering data:');
    				console.error('Status:', status);
    				console.error('Error:', error);
    				console.error('Response:', xhr.responseText);
    			}
    		});
		});
	});

	$('.filter-mobile-btn').on('click', function(e) {
		e.preventDefault();

		var packageType = $(this).data('package-type');
		$.ajax({
			url: '{{ route("packages-filter",[$paramName => $requestData]) }}',
			type: 'GET',
			data: { package_type: packageType },
			beforeSend: function() {
			},
			success: function(response) {
				$('#eventListing').empty();
				
				$.each(response.packages, function(index, packageData) {
					var content = packageData.content ? packageData.content : '';
					var limitedContent = content.length > 200 ? content.substring(0, 200) + '...' : content;
					var availableDates = packageData.available_dates ? JSON.parse(packageData.available_dates) : [];

					var startDate = null;
					var endDate = null;

					if (availableDates.length > 0) {
						availableDates.forEach(function(date) {
							if (!startDate || new Date(date.start_date) < new Date(startDate)) {
								startDate = date.start_date;
							}
							if (!endDate || new Date(date.end_date) > new Date(endDate)) {
								endDate = date.end_date;
							}
						});
					}

					var formattedStartDate = startDate ? new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
					var formattedEndDate = endDate ? new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';

					var destinationType = packageData.destination && packageData.destination.destination_type === 1 ? 'Domestic' : 'International';

					var serviceName = packageData.service ? packageData.service.name : 'Service';
					var fullUrl = window.location.href;

					if (fullUrl.includes('international')) {
						serviceName = 'International';
					} else if (fullUrl.includes('domestic')) {
						serviceName = 'Domestic';
					} else if (fullUrl.includes('ramta-yogi')) {
						serviceName = 'Ramta Yogi';
					}

					var packageHtml = `
					<div class="grid-item">
					<div class="event-item">
					<div class="event-thumb">
					<div class="event-img">
					${packageData.images && packageData.images.length > 0 ? `
						<a href="/package-detail/${packageData.slug}">
						<img src="/${packageData.images[0].image_path}" alt="${packageData.package_name}">
						</a>
						` : ''}
						<div class="event-text feature"><span>${serviceName}</span></div>
						</div>
						</div>
						<div class="event-content-wrap">
						<div class="event-content">
						<div class="event-content-left">
						<h3 class="event-title">
						<a href="/package-detail/${packageData.slug}">${packageData.package_name}</a>
						</h3>
						<h4 class="activity">
						<span><i class="fa fa-map"></i> ${packageData.destination ? packageData.destination.name : ''}</span>
						<span><i class="fa fa-fighter-jet"></i> ${serviceName}</span>
						<span><i class="fa-regular fa-clock ml-25"></i> ${packageData.duration}</span>
						</h4>
						</div>
						</div>
						<div class="event-price-wrap">
						<h4 class="price">${packageData.icon} ${packageData.price}</h4>
						<a href="/package-detail/${packageData.slug}${new URLSearchParams(window.location.search).has('destination') ? '?destination=' + new URLSearchParams(window.location.search).get('destination') : ''}" class="pxs-primary-btn">Detail</a>
						</div>
						</div>
						</div>
						</div>`;
						$('#filterModal').modal('hide');
						$('#eventListing').append(packageHtml);
					});
				filter();
			},
			error: function(xhr, status, error) {
				console.error('Error filtering data:', error);
				filter();
			}
		});
	});

	$('.select2-show-search').select2({
		minimumResultsForSearch: ''
	});

</script>
@endsection
@endsection