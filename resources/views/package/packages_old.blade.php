@extends('layouts.master-front')
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
					<div class="search-filter-item width-85">
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

						<button type="button" class="pxs-primary-btn d-lg-none" style="display: inline;" id="filter-button"  onclick="filter()"><i class="fa fa-filter"></i> Filter</button>
						<!-- Trigger Modal Button -->
						<button type="button" class="pxs-primary-btn" data-bs-toggle="modal" data-bs-target="#filterModal" style="display: inline;">
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
		                <form id="filterForm">
		                    <div class="event-sidebar-item">
		                        <h3 class="event-sidebar-title">Filter By Package Type</h3>
		                        <div class="check-box-wrap">
		                            @forelse($packageTypes as $packageType)
		                            <div class="form-check form-item">
		                                <div class="form-left">
		                                    <input class="form-check-input" type="checkbox" name="packageTypes[]" value="{{$packageType->package_type}}" id="packageType_{{$packageType->package_type}}" />
		                                    <label class="form-check-label" for="packageType_{{$packageType->package_type}}"> {{$packageType->package_type}} </label>
		                                </div>
		                            </div>
		                            @empty
		                            <p>No Package Type available</p>
		                            @endforelse
		                        </div>
		                    </div>
		                    
		                    <!-- Price Range Filter -->
		                    <div class="event-sidebar-item">
		                        <h3 class="event-sidebar-title">Filter By Price</h3>
		                        <div class="filter-box">
		                            <div class="range-slider">
		                                <input type="range" name="min_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MIN_FILTER_PRICE',5000)}}" id="min-price-range" />
		                                <input type="range" name="max_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MAX_FILTER_PRICE',500000)}}" id="max-price-range" />
		                                <div class="range-slider-output">
		                                    <h3 class="price">Price: </h3>
		                                    <h3 id="price-output" class="price">
		                                        {{ App\Models\Currency::find(session('currency_id', $appSetting->default_currency))->icon }}
		                                        <span id="min-price-output">{{env('MIN_FILTER_PRICE',5000)}}</span> - 
		                                        {{ App\Models\Currency::find(session('currency_id', $appSetting->default_currency))->icon }}
		                                        <span id="max-price-output">{{env('MAX_FILTER_PRICE',500000)}}</span>
		                                    </h3>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <!-- Rating Filter -->
		                    <div class="event-sidebar-item">
		                        <h3 class="event-sidebar-title">Rating WISE</h3>
		                        <div class="event-rating-btn">
		                            @for($i = 1; $i <= 5; $i++)
		                            <div class="rating-btn-item">
		                                <input type="checkbox" name="ratings[]" value="{{ $i }}" id="rating_{{ $i }}" />
		                                <label for="rating_{{ $i }}"><span>{{ $i }}</span></label>
		                            </div>
		                            @endfor
		                        </div>
		                    </div>

		                    <!-- Submit Button -->
		                    <div class="event-sidebar-item">
		                        <div class="filter-box">
		                            <div class="filter-content">
		                                <button type="button" id="applyFilter" class="pxs-primary-btn">Filter</button>
		                                <span class="reset"><button type="reset">Reset</button></span>
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

<section class="event-listing-section padding">
	<div class="container">
		<div class="row">
			
			<div class="col-lg-3">
				<div class="event-sidebar d-none d-lg-block">
					<form id="filterForm">
						<div class="event-sidebar-item">
							<h3 class="event-sidebar-title">Filter By Package Type</h3>
							<div class="check-box-wrap">
								@forelse($packageTypes as $packageType)
								<div class="form-check form-item">
									<div class="form-left">
										<input class="form-check-input" type="checkbox" name="packageTypes[]" value="{{$packageType->package_type}}" package_type="packageType_{{$packageType->package_type}}" />
										<label class="form-check-label" for="packageType_{{$packageType->package_type}}"> {{$packageType->package_type}} </label>
									</div>
									<div class="form-right">
										<!-- <span>{{App\Models\Package::distinct('uuid')->where('package_type',$packageType->package_type)->count() }}</span> -->
									</div>
								</div>
								@empty
								<p>No Package Type available</p>
								@endforelse
							</div>
						</div>
						<!-- Service Type Filter -->
						<div class="event-sidebar-item">
							<h3 class="event-sidebar-title">Filter By Service</h3>
							<div class="check-box-wrap">
								@forelse($services as $service)
								<div class="form-check form-item">
									<div class="form-left">
										<input class="form-check-input" type="checkbox" name="services[]" value="{{$service->id}}" id="service_{{$service->id}}" />
										<label class="form-check-label" for="service_{{$service->id}}"> {{$service->name}} </label>
									</div>
									<div class="form-right">
										<!-- <span>{{$service->packages_count}}</span> -->
									</div>
								</div>
								@empty
								<p>No services available</p>
								@endforelse
							</div>
						</div>

						<!-- Price Range Filter -->
						<div class="event-sidebar-item">
							<h3 class="event-sidebar-title">Filter By Price</h3>
							<div class="filter-box">
								<div class="range-slider">
									<input type="range" name="min_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MIN_FILTER_PRICE',5000)}}" id="min-price-range" />
									<input type="range" name="max_price" min="{{env('MIN_FILTER_PRICE',5000)}}" max="{{env('MAX_FILTER_PRICE',500000)}}" value="{{env('MAX_FILTER_PRICE',500000)}}" id="max-price-range" />

									<div class="slider-line"></div>

									<div class="range-slider-output">
										<h3 class="price">Price: </h3>
										<h3 id="price-output" class="price">
											{{ App\Models\Currency::find(session('currency_id', $appSetting->default_currency))->icon }}
											<span id="min-price-output">{{env('MIN_FILTER_PRICE',5000)}}</span> - 
											{{ App\Models\Currency::find(session('currency_id', $appSetting->default_currency))->icon }}
											<span id="max-price-output">{{env('MAX_FILTER_PRICE',500000)}}</span>
										</h3>
									</div>
								</div>
							</div>
						</div>

						<!-- Rating Filter -->
						<div class="event-sidebar-item">
							<h3 class="event-sidebar-title">Rating WISE</h3>
							<div class="event-rating-btn">
								@for($i = 1; $i <= 5; $i++)
								<div class="rating-btn-item">
									<input type="checkbox" name="ratings[]" value="{{ $i }}" id="rating_{{ $i }}" />
									<label for="rating_{{ $i }}"><span>{{ $i }}</span></label>
								</div>
								@endfor
							</div>
						</div>

						<!-- Submit Button -->
						<div class="event-sidebar-item">
							<div class="filter-box">
								<div class="filter-content">
									<button type="button" id="applyFilter" class="pxs-primary-btn">Filter</button>
									<span class="reset"><button type="reset">Reset</button></span>
								</div>
							</div>
						</div>
					</form>
				</div>

				<!-- mobile filter -->
				<div class="event-sidebar d-lg-none" id="filterBox" style="display: none;">
					<div>
						<h3 class="event-sidebar-title">Filter By Package Type
							<!-- <span class="close-btn-abs">
								<i class="fa fa-times"></i>
							</span> -->
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
		</div>
		<div class="col-lg-9">
			<div class="event-listing-items" id="eventListing">
				@forelse($packages as $package)
				<div class="event-listing-item  {{$package->service->name}} {{$package->price}} {{ number_format($package->rating, 0) }} ">
					<div class="event-listing-carousel swiper">
						<div class="swiper-wrapper swiper-container">
							@if(count($package->images) > 0)
							@foreach($package->images as $image)
							<div class="swiper-slide">
								<div class="event-listing-thumb">
									
									<a href="{{route('package-detail',$package->slug)}}">
										<img src="{{asset('/'.$image->image_path)}}" alt="{{$package->package_name}}" style="height:250px;" />
									</a>
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
				@endforeach
				@endif
			</div>
		</div>
		<div class="event-listing-content">
			<ul class="post-meta">
				<li>
					@php
					$availableDates = json_decode($package->available_dates);
					$startDate = null;
					$endDate = null;

					if (!empty($availableDates)) {
					foreach ($availableDates as $date) {

					if (!$startDate || \Carbon\Carbon::parse($date->start_date)->lt(\Carbon\Carbon::parse($startDate))) {
					$startDate = $date->start_date;
				}

				if (!$endDate || \Carbon\Carbon::parse($date->end_date)->gt(\Carbon\Carbon::parse($endDate))) {
				$endDate = $date->end_date;
			}
		}
	} else {
	$startDate = '';
}
@endphp
@if(!empty($startDate))
<i class="fa-solid fa-calendar-days"></i>
{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} 
@endif
@if(!empty($endDate))
- {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
@endif

</li>
</ul>
<h3 class="event-listing-title">
	{{$package->package_name}}  
	<!-- <small class="text-success">({{$package->package_type}})</small> -->
</h3>
<p>
	@php
	$content = strip_tags($package->content);
	$limit = 200; // Set the character limit
	$limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
	@endphp

	{!! $limitedContent !!}
</p>
<ul class="event-list">
	<li>
		<i class="fa-regular fa-clock"></i>
		<span>{{$package->duration}}</span>
	</li>
	<li>
		<i class="fa-regular fa-map"></i>
		<span>{{ optional($package->destination)->destination_type == '1' ? 'Domestic' : 'International' }}</span>

	</li>

	<li>
		<i class="fa-solid fa-location-dot text-primary"></i>
		<span>{{$package->destination->name}}</span>
	</li>
	<!-- <li><i class="fa-solid fa-star text-warning"></i>  <span> {{$package->rating}} ({{$package->reviews->count()}} reviews)</span></li> -->
			<!-- <li>
				<i class="fa fa-bookmark text-success"></i>  
				<span> {{$package->bookings->count()}}  Bookings </span>
			</li> -->
		</ul>
		<div class="event-price-wrap">
			<h4 class="price">{{$package->icon}} {{ $package->price }}</h4>
			<!-- <a href="{{route('package-detail',$package->slug)}}" class="pxs-primary-btn">Detail <i class="fa-solid fa-arrow-right-long"></i></a> -->
			<a href="{{ route('package-detail', $package->slug) . (request()->has('destination') ? '?' . http_build_query(request()->only('destination')) : '') }}" class="pxs-primary-btn">
				Detail <i class="fa-solid fa-arrow-right-long"></i>
			</a>

		</div>
	</div>
</div>
@empty
@endforelse

<br>
<div>
	{{ $packages->appends(request()->input())->links('common.pagination') }}
</div>
</div>
</div>
</div>
</div>
</section>
<!-- ./ event-listing-section -->
@section('extrajs')



<script>
	function filter()
	{
		var filterBox = document.getElementById('filterBox');
		var filterButton = document.getElementById('filter-button');
		if (filterBox.style.display === 'none') {
			filterBox.style.display = 'block';
			filterButton.style.display = 'none';
		} else {
			filterButton.style.display = 'inline';
			filterBox.style.display = 'none';
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

    				$.each(response.packages, function(index, package) {
    					var content = package.content ? package.content : '';
    					var limitedContent = content.length > 200 ? content.substring(0, 200) + '...' : content;
    					var availableDates = package.available_dates ? JSON.parse(package.available_dates) : [];

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


    					var formattedStartDate = startDate ?new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    					var formattedEndDate = endDate ? new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';

    					var destinationType = package.destination && package.destination.destination_type === 1 ? 'Domestic' : 'International';


    					var packageHtml = `
    					<div class="event-listing-item service-${package.service.name} price-${package.price} rating-${Math.round(package.rating)}">
    					<div class="event-listing-carousel swiper">
    					<div class="swiper-wrapper swiper-container">
    					<div class="swiper-slide">
    					<div class="event-listing-thumb">
    					<img src="${package.images && package.images[0] ? package.images[0].image_path : 'default-image.jpg'}" alt="${package.package_name}" style="height:250px;" />
    					<div class="event-text feature"><span>${package.service.name}</span></div>
    					</div>
    					</div>
    					</div>
    					</div>
    					<div class="event-listing-content">
    					<ul class="post-meta">
    					<li>
    					<i class="fa-solid fa-calendar-days"></i>
    					${formattedStartDate} ${formattedEndDate ? '- ' + formattedEndDate : ''}
    					</li>
    					</ul>
    					<h3 class="event-listing-title">${package.package_name}</h3>
    					<p>${limitedContent}</p>
    					<ul class="event-list">
    					<li>
    					<i class="fa-regular fa-clock"></i>
    					<span>${package.duration}</span>
    					</li>
    					<li>
    					<i class="fa-regular fa-map"></i>
    					<span>${destinationType}</span>
    					</li>
    					<li>
    					<i class="fa-solid fa-location-dot text-primary"></i>
    					<span>${package.destination.name}</span>
    					</li>`+
    					// <li><i class="fa-solid fa-star text-warning"></i>  
    					// <span>${package.rating} (${package.reviews_count} reviews)</span>
    					// </li>
    					// <li>
    					// <i class="fa fa-bookmark text-success"></i>  
    					// <span>${package.bookings_count} Bookings</span>
    					// </li>
    					`</ul>
    					<div class="event-price-wrap">
    					<h4 class="price">${package.icon} ${package.price}</h4>
    					<a href="/package-detail/${package.slug}" class="pxs-primary-btn">Detail <i class="fa-solid fa-arrow-right-long"></i></a>
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
		url: '{{ route("packages-filter") }}',
		type: 'GET',
		data: { package_type: packageType },
		beforeSend: function() {
		},
		success: function(response) {
			$('#eventListing').empty();
			$.each(response.packages, function(index, package) {
				var content = package.content ? package.content : '';
				var limitedContent = content.length > 200 ? content.substring(0, 200) + '...' : content;
				var availableDates = package.available_dates ? JSON.parse(package.available_dates) : [];

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

				var formattedStartDate = startDate ? new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';
				var formattedEndDate = endDate ? new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';

				var destinationType = package.destination && package.destination.destination_type === 1 ? 'Domestic' : 'International';

				var packageHtml = `
				<div class="event-listing-item service-${package.service.name} price-${package.price} rating-${Math.round(package.rating)}">
				<div class="event-listing-carousel swiper">
				<div class="swiper-wrapper swiper-container">
				<div class="swiper-slide">
				<div class="event-listing-thumb">
				<img src="${package.images && package.images[0] ? package.images[0].image_path : 'default-image.jpg'}" alt="${package.package_name}" style="height:250px;" />
				<div class="event-text feature"><span>${package.service.name}</span></div>
				</div>
				</div>
				</div>
				</div>
				<div class="event-listing-content">
				<ul class="post-meta">
				<li><i class="fa-solid fa-calendar-days"></i> ${formattedStartDate} ${formattedEndDate ? '- ' + formattedEndDate : ''}</li>
				</ul>
				<h3 class="event-listing-title">${package.package_name} </h3>
				<p>${limitedContent}</p>
				<ul class="event-list">
				<li><i class="fa-regular fa-clock"></i><span>${package.duration}</span></li>
				<li><i class="fa-regular fa-map"></i><span>${destinationType}</span></li>
				<li><i class="fa-solid fa-location-dot text-primary"></i><span>${package.destination.name}</span></li>
				</ul>
				<div class="event-price-wrap">
				<h4 class="price">${package.icon} ${package.price}</h4>
				<a href="/package-detail/${package.slug}" class="pxs-primary-btn">Detail <i class="fa-solid fa-arrow-right-long"></i></a>
				</div>
				</div>
				</div>`;

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

	// setTimeout(function() {
	// 	$('.alert').fadeOut('slow', function() {
	// 		$(this).remove();
	// 	});
	// }, 10000);

	$('.select2-show-search').select2({
		minimumResultsForSearch: ''
	});

</script>
@endsection
@endsection