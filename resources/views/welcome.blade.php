@extends('layouts.master-front')
@section('extracss')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style type="text/css">
	.event-listing-items .event-listing-item
	{
		grid-template-columns: none !important;
	}
	.iti.iti--allow-dropdown.iti--separate-dial-code {
		width: 28%;
	}
	.iti__flag-container
	{
		padding: 5px;
		height: 42px;
	}
	.event-section {
		overflow: visible !important; /* Ensure dropdown can scroll */
		position: relative; /* Add relative positioning if required */
	}
</style>

@endsection
@section('content')

<section class="hero-section padding">
	<div class="container">
		<div class="row align-items-center">
			@if($homePage->background_video_on==1)
			<div class="col-lg-12">
				<div class="video-background">
					<div id="ytplayer2"></div>
					<div class="video-foreground">
						<iframe src="https://www.youtube.com/embed/{{basename($homePage->background_video_url)}}?autoplay=1&mute=1&version=3&loop=1&playlist={{basename($homePage->background_video_url)}}" allowfullscreen="">
						</div>
					</div>
					<div style="margin-top:115px;height:92px;width:272px"><img height="92px" src="/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" width="272px" id="hplogo" alt="Google" title="Google" onload="typeof google==='object'&amp;&amp;google.aft&amp;&amp;google.aft(this)"></div></iframe>
				</div>
			</div>
		</div>


		@endif
		<div class="col-lg-7">
			<div class="hero-left">
				<div class="hero-video-thumb wow fade-in-bottom" data-wow-delay="400ms">
					@if(!empty($homePage->banner_image_path))
					<img src="{{asset('/'.$homePage->banner_image_path)}}" alt="{{$homePage->title}}">
					@endif
					@if(!empty($homePage->video_path))
					<div class="hero-video-btn wow fade-in-bottom" data-wow-delay="200ms">
						<a class="video-popup" data-autoplay="true" data-vbtype="video" href="{{$homePage->video_path}}"><i class="fa-solid fa-play"></i>

						</a>
					</div>
					@endif
				</div>
				<div class="hero-thumb">
					<div class="hero-text wow fade-in-bottom" data-wow-delay="400ms">
						@if(!empty($homePage->image_path))
						<div class="owl-carousel-hero owl-theme wow fade-in-bottom" data-wow-delay="400ms">
							@forelse(json_decode($homePage->image_path) as $imagePath)
							<div class="item">
								<img src="{{asset($imagePath)}}" alt="{{$homePage->title}}" width="200px">
							</div>
							@empty
							@endforelse	
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="hero-content">
				<h1 class="hero-title wow fade-in-right @if($homePage->background_video_on==1) color-white @endif" data-wow-delay="200ms">
					{{$homePage->title}} <span>{{$homePage->sub_title}}</span>
				</h1>
				<p class="wow fade-in-right @if($homePage->background_video_on==1) color-white @endif" data-wow-delay="400ms">
					{!! $homePage->short_description !!}
					<br>
					<br>
				</p>
			</div>
		</div>
	</div>
	{{--
		<div class="hero-bottom">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						@if($homePage->happy_customers==1)
						<div class="hero-author-info wow fade-in-left" data-wow-delay="600ms">
							<ul class="author-list">
								@forelse(json_decode($homePage->happy_customers_images) as $hcimg)
								<li><img src="{{ asset($hcimg) }}" alt="{{$homePage->title}}"></li>
								@empty
								@endforelse
							</ul>
							<div class="author-review">
								<h4 class="author">{{$homePage->happy_customers_title}}</h4>
								<span><i class="fa-solid fa-star"></i>{{$homePage->happy_customers_sub_title}}</span>
							</div>
						</div>
						@endif
					</div>

					<div class="col-lg-8">
						<div class="hero-items wow fade-in-right" data-wow-delay="600ms">
							<div class="hero-item">
								<h3 class="number text-center">{{$homePage->duration}}</h3>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		--}}
	</div>
	<div class="hero-bottom amazing-tabs-off">
		<div class="container">
			<div class="float-left w-100 search-booking-tab-con position-relative main-box">
				<div class="container">
					<ul class="nav nav-tabs text-center align-items-center justify-content-between" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="hotel-tab"  data-bs-toggle="tab" data-bs-target="#hotel" type="button" role="tab" aria-controls="hotel" aria-selected="true"> <img class="img-fluid d-block" src="{{asset('images/1.png')}}" alt="icon"> Domestic</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="international-tab"  data-bs-toggle="tab" data-bs-target="#international" type="button" role="tab" aria-controls="international" aria-selected="true"> <img class="img-fluid d-block" src="{{asset('images/2.png')}}" alt="icon"> International</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="car-tab"  data-bs-toggle="tab" data-bs-target="#car" type="button" role="tab" aria-controls="car" aria-selected="false"><img class="img-fluid d-block" src="{{asset('images/3.png')}}" alt="icon">Ramta Yogi </button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="flight-tab"  data-bs-toggle="tab" data-bs-target="#flight" type="button" role="tab" aria-controls="flight" aria-selected="false"><img class="img-fluid d-block" src="{{asset('images/4.png')}}" alt="icon"> Activities</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="trip-tab"  data-bs-toggle="tab" data-bs-target="#trip" type="button" role="tab" aria-controls="trip" aria-selected="false"><img class="img-fluid d-block" src="{{asset('images/5.png')}}" alt="icon"> Touriversity</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="cruise-tab"  data-bs-toggle="tab" data-bs-target="#cruise" type="button" role="tab" aria-controls="cruise" aria-selected="false"><img class="img-fluid d-block" src="{{asset('images/6.png')}}" alt="icon"> Visa</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="activity-tab"  data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-controls="activity" aria-selected="false"><img class="img-fluid d-block" src="{{asset('images/7.png')}}" alt="icon">  Insurance </button>
						</li>
					</ul>
					<div class="tab-content  offer-section" id="myTabContent">
						<div class="tab-pane fade show active " id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
							<div class="event-section mp-0">
								<div class="event-wrap">
									<div class="event-carousel-wrap">
										<div class="event-carousel swiper">
											<div class="swiper-wrapper swiper-container">
												@forelse($domestics as $domestic)
												<div class="swiper-slide">
													<div class="event-item">
														<div class="event-thumb">
															<div class="event-img">
																@if(count($domestic->images) > 0)
																<a href="{{route('package-detail',$domestic->slug)}}"><img src="{{asset('/'.$domestic->images[0]->image_path)}}" alt="{{$domestic->package_name}}"></a>
																@endif
															</div>
															<div class="event-text feature"><span>Domestic </span>
															</div>
															{{--
																<div class="event-text new"><span>{{$domestic->rating}}
																	<i class="fa fa-star"></i> </span>
																</div>
																--}}
															</div>
															<div class="event-content-wrap">
																<div class="event-content">
																	<div class="event-content-left">
																		<h3 class="event-title"><a href="{{route('package-detail',$domestic->slug)}}">{{$domestic->package_name}}</a></h3>
																		<h4 class="activity">
																			<span><i class="fa fa-map"></i> {{$domestic->destination->name}}</span>
																			<!-- <span><i class="fa fa-tasks"></i> {{$domestic->activityLists->count()}}</span> -->
																			<span><i class="fa-regular fa-clock"></i> {{$domestic->duration}}</span>
																		</h4>
																	</div>

																</div>
																<div class="event-price-wrap">
																	<h4 class="price">{{$domestic->icon}} {{$domestic->price}}</h4>
																	<a href="{{route('package-detail',$domestic->slug)}}" class="pxs-primary-btn">Detail</a>
																</div>
															</div>
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>
											<!-- Carousel Arrows -->
											<div class="swiper-arrow">
												<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
												<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
											</div>
										</div>
									</div>
								</div>
								<div class="box-item button-right">
									<a href="{{route('packages',['destination'=>'domestic'])}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
								</div>
							</div>
							<div class="tab-pane fade show " id="international" role="tabpanel" aria-labelledby="international-tab">
								<div class="event-section mp-0">
									<div class="event-wrap">
										<div class="event-carousel-wrap">
											<div class="event-carousel swiper">
												<div class="swiper-wrapper swiper-container">
													@forelse($internationals as $international)
													<div class="swiper-slide">
														<div class="event-item">
															<div class="event-thumb">
																<div class="event-img">
																	@if(count($international->images) > 0)
																	<a href="{{route('package-detail',$international->slug)}}"><img src="{{asset('/'.$international->images[0]->image_path)}}" alt="{{$international->package_name}}"></a>
																	@endif
																</div>
																<div class="event-text feature"><span>International </span></div>
																{{--
																	<div class="event-text new"><span>{{$international->rating}}
																		<i class="fa fa-star"></i> </span>
																	</div>
																	--}}
																</div>
																<div class="event-content-wrap">
																	<div class="event-content">
																		<div class="event-content-left">
																			<h3 class="event-title"><a href="{{route('package-detail',$international->slug)}}">{{$international->package_name}}</a></h3>
																			<h4 class="activity">
																				<span> <i class="fa fa-map"></i> {{$international->destination->name}}</span>
																				<!-- <span><i class="fa fa-tasks"></i> {{$international->activityLists->count()}}</span> -->
																				<span><i class="fa-regular fa-clock"></i> {{$international->duration}}</span>
																			</h4>
																		</div>

																	</div>

																	<div class="event-price-wrap">
																		<h4 class="price">{{$international->icon}} {{$international->price}}</h4>
																		<a href="{{route('package-detail',$international->slug)}}" class="pxs-primary-btn">Detail</a>
																	</div>
																</div>
															</div>
														</div>
														@empty
														@endforelse
													</div>
												</div>
												<!-- Carousel Arrows -->
												<div class="swiper-arrow">
													<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
													<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
												</div>
											</div>
										</div>
									</div>
									<div class="box-item button-right">
										<a href="{{route('packages',['destination'=>'international'])}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
									</div>
								</div>
								<div class="tab-pane fade" id="car" role="tabpanel" aria-labelledby="car-tab">
									<div class="event-section mp-0">
										<div class="event-wrap">
											<div class="event-carousel-wrap">
												<div class="event-carousel swiper">
													<div class="swiper-wrapper swiper-container">
														@forelse($ramtaYogis as $ramtaYogi)
														<div class="swiper-slide">
															<div class="event-item">
																<div class="event-thumb">
																	<div class="event-img">
																		@if(count($ramtaYogi->images) > 0)
																		<a href="{{route('package-detail',$ramtaYogi->slug)}}"><img src="{{asset('/'.$ramtaYogi->images[0]->image_path)}}" alt="{{$ramtaYogi->package_name}}"></a>
																		@endif
																	</div>
																	<div class="event-text feature"><span>Ramta Yogi</span></div>
																	{{--
																		<div class="event-text new"><span>{{$ramtaYogi->rating}}
																			<i class="fa fa-star"></i> </span>
																		</div>
																		--}}
																	</div>
																	<div class="event-content-wrap">
																		<div class="event-content">
																			<div class="event-content-left">
																				<h3 class="event-title"><a href="{{route('package-detail',$ramtaYogi->slug)}}">{{$ramtaYogi->package_name}}</a></h3>
																				<h4 class="activity">
																					<span> <i class="fa fa-map"></i> {{$ramtaYogi->destination->name}}</span>
																					<!-- <span><i class="fa fa-tasks"></i> {{$ramtaYogi->activityLists->count()}}</span> -->
																					<span><i class="fa-regular fa-clock"></i> {{$ramtaYogi->duration}}</span>
																				</h4>
																			</div>

																		</div>
																		<div class="event-price-wrap">
																			<h4 class="price">{{$ramtaYogi->icon}} {{$ramtaYogi->price}}</h4>
																			<a href="{{route('package-detail',$ramtaYogi->slug)}}" class="pxs-primary-btn">Detail</a>
																		</div>
																	</div>
																</div>
															</div>
															@empty
															@endforelse
														</div>
													</div>
													<!-- Carousel Arrows -->
													<div class="swiper-arrow">
														<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
														<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
													</div>
												</div>
											</div>
										</div>
										<div class="box-item button-right">
											<a href="{{route('packages',['service'=>'ramta-yogi'])}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
										</div>
									</div>
									<div class="tab-pane fade  travel-section mp-0" id="flight" role="tabpanel" aria-labelledby="flight-tab">
										<div class="travel-carousel-wrap">
											<div class="travel-carousel swiper">
												<div class="swiper-wrapper swiper-container">
													@forelse($activityDestinations as $activityDestination)
													<div class="swiper-slide">
														<div class="project-wrap wrap-1">
															<div class="project-box">
																<div class="project-thumb">
																	<a href="{{route('activities',['destination'=>$activityDestination->name])}}" class="project-title"><img src="{{asset($activityDestination->image_path)}}" alt="{{$activityDestination->name}}"></a>
																	<div class="project-content">
																		<h4><a href="{{route('activities',['destination'=>$activityDestination->name])}}" class="project-title">{{$activityDestination->name}}</a>
																		</h4>
																		<span class="destination-icons"><i class="fa-regular fa-user"></i> &nbsp; {{@$activityDestination->destination_type == '1' ? 'Domestic' : 'International'}} <span class="float destination-icons"><i class="fa-regular fa-tasks"></i> &nbsp;{{$activityDestination->activities_count}}</span></span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>
											<div class="box-item button-right">
												<a href="{{route('destinations')}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
											</div>
										</div>
										<div class="box-item button-right">

										</div>
										<!-- car tab -->
									</div>
									<div class="tab-pane fade" id="trip" role="tabpanel" aria-labelledby="trip-tab">
										<div class="container">
											<div class="row">
												@if(count($travelCourses) > 0)
												@forelse($travelCourses as $travelCourse)
												<div class="col-lg-4 col-md-6">
													<div class="post-card">
														<div class="post-thumb w-img">
															<a href="{{route('travel-course-detail',$travelCourse->slug)}}"><img src="{{asset('/'.$travelCourse->image_path)}}" alt="{{$travelCourse->title}}"  style="height: 200px;" /></a>
														</div>
														<div class="post-content">
															<div>

																<h3 class="post-title">
																	<a href="{{route('travel-course-detail',$travelCourse->slug)}}">{{$travelCourse->title}}</a>
																</h3>
															</div>
														</div>
													</div>
												</div>
												@empty
												@endforelse
												<div class="box-item button-right">
													<a href="{{route('travel-courses')}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
												</div>
												<br>
												@endif
											</div>
										</div>

										<!-- trip tab -->
									</div>
									<div class="tab-pane fade" id="cruise" role="tabpanel" aria-labelledby="cruise-tab">
										<div class="event-section mp-0">
											@if(count($visas) > 0)
											<div class="event-wrap">
												<div class="event-carousel-wrap">
													<div class="event-carousel swiper">
														<div class="swiper-wrapper swiper-container">
															@forelse($visas as $visa)
															<div class="swiper-slide">
																<div class="event-item">
																	<div class="event-thumb">
																		<div class="event-img">
																			@if(count($visa->images) > 0)
																			<a href="{{route('package-detail',$visa->slug)}}"><img src="{{asset('/'.$visa->images[0]->image_path)}}" alt="{{$visa->package_name}}"></a>
																			@endif
																		</div>
																		<div class="event-text feature"><span>{{$visa->service->name}}</span></div>
																		{{--
																			<div class="event-text new"><span>{{$visa->rating}}
																				<i class="fa fa-star"></i> </span>
																			</div>
																			--}}
																		</div>
																		<div class="event-content-wrap">
																			<div class="event-content">
																				<div class="event-content-left">
																					<h3 class="event-title"><a href="{{route('package-detail',$visa->slug)}}">{{$visa->package_name}}</a></h3>
																					<h4 class="activity">
																						<span> <i class="fa fa-map"></i> {{$visa->destination->name}}</span>
																						<!-- <span><i class="fa fa-tasks"></i> {{$visa->activityLists->count()}}</span> -->
																						<span><i class="fa-regular fa-clock"></i> {{$visa->duration}}</span>
																					</h4>
																				</div>

																			</div>
																			<div class="event-price-wrap">
																				<h4 class="price">{{$visa->icon}} {{$visa->price}}</h4>
																				<a href="{{route('package-detail',$visa->slug)}}" class="pxs-primary-btn">Detail</a>
																			</div>
																		</div>
																	</div>
																</div>
																@empty
																@endforelse
															</div>
														</div>
														<!-- Carousel Arrows -->
														<div class="swiper-arrow">
															<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
															<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
														</div>
													</div>
												</div>
												
												<div class="box-item button-right">
													<a href="{{route('visa-inquiry')}}" class="d-inline-block pxs-primary-btn tabform-button"> View All</a>
													<br>
													<br>
												</div>
												<br>
												@endif
											</div>
											<div id="alert-container-v"></div>
											<br>
											<br>

											<form class="search-form tabform form-visa-sec" id="visaForm" action="{{route('visa-save')}}">
												<div class="tab-inner-con text-left">
													<div class="row bg-white padding-2x" id="childrenAge">
														<div class="col-md-4 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Name</h3>
															<input type="text" id="v_name" name="name" class="form-control" placeholder="Enter your name" required>
														</div>

														<!-- Email Input -->
														<div class="col-md-4 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Email</h3>
															<input type="email" id="v_email" name="email" class="form-control" placeholder="Enter your email" required>
														</div>

														<!-- Mobile Number Input -->
														<div class="col-md-4 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Mobile Number</h3>
															<div class="d-flex">
																<!-- Country Code Input -->
																<input 
																type="text" 
																id="v_country_code1" 
																class="form-control" 
																placeholder="Code" 
																style="width: 25%;" 
																>

																<!-- Hidden Country Code -->
																<input 
																type="hidden" 
																id="v_country_code" 
																name="country_code" 
																value="+91" 
																readonly
																>

																<!-- Mobile Number Input -->
																<input 
																type="tel" 
																id="v_mobile" 
																name="mobile" 
																class="form-control ms-2" 
																placeholder="Phone Number" 
																required 
																style="flex: 1;" 
																>
															</div>
														</div>
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title">Destination</h3>
															<input type="text" id="v_destination" name="destination" class="form-control" placeholder="Enter Country or City">
														</div>
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title">Travel Date</h3>
															<input type="date" class="form-control" name="start_date" value="{{date('d-m-Y')}}" id="v_start_date" min="{{date('Y-m-d')}}">
														</div>
														<!-- Adults Input -->
														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title">Adults</h3>
															<select class="form-design nice-select" name="adults" id="v_adults" required>
																<option value="" disabled selected>Select</option>
																@for($i = 1; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
														</div>

														<!-- Children Input -->
														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title children">Children</h3>
															<select class="form-design nice-select" name="children" id="v_children" onchange="showChildrenAgeFieldsV()">
																@for($i = 0; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
														</div>


														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title infant">Infants</h3>
															<select class="form-design nice-select" name="infants" id="v_infants" onchange="showInfantsAgeFieldsV()">
																@for($i = 0; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
															<br>
															<br>
														</div>
													</div>
												</div>
												<div class="box-item button-right form-only">
													<button onclick="visaSave(event)" class="d-inline-block pxs-primary-btn tabform-button visaBtn">Inquire Now</button>
												</div>
											</form>

										</div>
										<div class="tab-pane fade" id="activity" role="tabpanel" aria-labelledby="activity-tab">
											<br>
											<div id="alert-container-i"></div>
											<br>
											<br>

											<form class="search-form tabform form-isurrance-sec" method="POST" action="" id="insuranceForm" action="{{route('insurance-save')}}">
												<div class="tab-inner-con text-left">

													<div class="row bg-white padding-2x" id="insChildrenAge">
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Name</h3>
															<input type="text" id="i_name" name="name" class="form-control" placeholder="Enter your name" required>
														</div>

														<!-- Email Input -->
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Email</h3>
															<input type="email" id="i_email" name="email" class="form-control" placeholder="Enter your email" required>
														</div>

														<!-- Mobile Number Input -->
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title visa-form">Mobile Number</h3>
															<div class="d-flex">
																<!-- Country Code Input -->
																<input 
																type="text" 
																id="i_country_code1" 
																class="form-control" 
																placeholder="Code" 
																style="width: 25%;" 
																>

																<!-- Hidden Country Code -->
																<input 
																type="hidden" 
																id="i_country_code" 
																name="country_code" 
																value="+91" 
																readonly
																>

																<!-- Mobile Number Input -->
																<input 
																type="tel" 
																id="i_mobile" 
																name="mobile" 
																class="form-control ms-2" 
																placeholder="Phone Number" 
																required 
																style="flex: 1;" 
																>
															</div>
														</div>
														<!-- Location Input -->
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title">Location</h3>
															<input type="text" id="i_destination" name="location" class="form-control" placeholder="Enter your location" required>
														</div>
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title">Travel Start Date</h3>
															<input type="date" class="form-control" name="start_date" value="{{date('d-m-Y')}}" id="i_start_date" min="{{date('Y-m-d')}}">
														</div>
														<div class="col-md-3 col-sm-6 col-xs-12">
															<h3 class="box-title">Travel End Date</h3>
															<input type="date" class="form-control" name="end_date" value="{{date('d-m-Y')}}" id="i_end_date" min="{{date('Y-m-d',strtotime('+1 days'))}}">
														</div>
														<!-- Adults Input -->
														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title">Adults</h3>
															<select class="form-design nice-select" name="adults" id="i_adults" required>
																<option value="" disabled selected>Select</option>
																@for($i = 1; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
														</div>

														<!-- Children Input -->
														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title children">Children</h3>
															<select class="form-design nice-select" name="children" id="i_children" onchange="showChildrenAgeFieldsI()">
																@for($i = 0; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
														</div>

														<div class="col-md-2 col-sm-6 col-xs-12">
															<h3 class="box-title infant">Infants</h3>
															<select class="form-design nice-select" name="infants" id="i_infants" onchange="showInfantsAgeFieldsI()">
																@for($i = 0; $i <= 50; $i++ )
																<option value="{{$i}}">{{$i}}</option>
																@endfor
															</select>
														</div>

													</div>
												</div>

												<!-- Submit Button -->
												<div class="box-item button-right form-only">
													<button onclick="insuranceSave(event)" id="iButton" class="d-inline-block pxs-primary-btn tabform-button insuranceBtn">Submit</button>
												</div>
											</form>
										</div>
									</div>
									<!-- container -->
								</div>
								<!-- search booking tab con -->
							</div>
						</div>
					</div>
				</section>

				<!-- ./ ads -->
				@include('common.slider')

				<!-- ./ hero-section -->
				@if($trendings->isNotEmpty())

				<section class="travel-section bg-white padding-5x">
					<div class="container">
						<div class="travel-top wow fade-in-bottom" data-wow-delay="200ms">
							<div class="section-heading">
								<h2 class="section-title">TRENDING TRIPS</h2>
							</div>
							<!-- Carousel Arrows -->
							<div class="swiper-arrow">
								<div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-left-long"></i></div>
								<div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-right-long"></i></div>
							</div>
						</div>

						<div class="travel-carousel-wrap wow fade-in-bottom" data-wow-delay="400ms">
							<div class="travel-carousel swiper">
								<div class="swiper-wrapper swiper-container">
									@forelse($trendings as $trending)
									<div class="swiper-slide">
										<div class="event-item">
											<div class="event-thumb">
												<div class="event-img">
													@if(count($trending->images) > 0)
													<a href="{{route('package-detail',$trending->slug)}}"><img src="{{asset('/'.$trending->images[0]->image_path)}}" alt="{{$trending->package_name}}"></a>
													@endif
												</div>
												<div class="event-text feature"><span>{{$trending->service->name}}</span></div>
												{{--
													<div class="event-text new"><span>{{$trending->rating}}
														<i class="fa fa-star"></i> </span>
													</div>
													--}}
												</div>
												<div class="event-content-wrap">
													<div class="event-content">
														<div class="event-content-left">
															<h3 class="event-title"><a href="{{route('package-detail',$trending->slug)}}">{{$trending->package_name}}</a></h3>
															<h4 class="activity">
																<span> <i class="fa fa-map"></i> {{$trending->destination->name}}</span>
																<!-- <span> <i class="fa fa-fighter-jet"></i> {{$trending->service->name}}</span> -->
																<span><i class="fa-regular fa-clock"></i> {{$trending->duration}}</span>
															</h4>
														</div>

													</div>
													<div class="event-price-wrap">
														<h4 class="price">{{$trending->icon}} {{$trending->price}}</h4>
														<a href="{{route('package-detail',$trending->slug)}}" class="pxs-primary-btn">Detail</a>
													</div>
												</div>
											</div>
										</div>
										@empty
										@endforelse
									</div>
								</div>
							</div>
						</section>
						@endif

						<!-- ./project-section -->

						@if($homePage->featured==1)
						<section class="travel-section bg-grey padding">
							<div class="container">
								<div class="event-top wow fade-in-bottom" data-wow-delay="200ms">
									<div class="section-heading">
										<h2 class="section-title">Feature Trips</h2>
									</div>
									<a href="{{route('packages')}}" class="see-more-btn">See All Packages<i class="fa-regular fa-arrow-right-long"></i></a>
								</div>
								<div class="event-wrap">
									<div class="travel-carousel-wrap wow fade-in-bottom" data-wow-delay="400ms">
										<div class="travel-carousels swiper">
											<div class="swiper-wrapper swiper-container">
												@forelse($featureds as $feature)
												<div class="swiper-slide">
													<div class="event-item">
														<div class="event-thumb">
															<div class="event-img">
																@if(count($feature->images) > 0)
																<a href="{{route('package-detail',$feature->slug)}}"><img src="{{asset('/'.$feature->images[0]->image_path)}}" alt="{{$feature->package_name}}"></a>
																@endif
															</div>
															<!-- <div class="event-text feature"><span>Feature</span></div> -->
															{{--
																<div class="event-text new"><span>{{$feature->rating}}
																	<i class="fa fa-star"></i> </span>
																</div>
																--}}
															</div>
															<div class="event-content-wrap">
																<div class="event-content">
																	<div class="event-content-left">
																		<h3 class="event-title"><a href="{{route('package-detail',$feature->slug)}}">{{$feature->package_name}}</a></h3>
																		<h4 class="activity">
																			<span> <i class="fa fa-map"></i> {{$feature->destination->name}}</span>
																			<span> <i class="fa fa-fighter-jet"></i> {{$feature->service->name}}</span>
																			<span><i class="fa-regular fa-clock ml-25"></i> {{$feature->duration}}</span>
																		</h4>
																	</div>
																</div>
																<div class="event-price-wrap">
																	<h4 class="price">{{$feature->icon}} {{$feature->price}}</h4>
																	<a href="{{route('package-detail',$feature->slug)}}" class="pxs-primary-btn">Detail</a>
																</div>
															</div>
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>
											<!-- Carousel Arrows -->
											<div class="swiper-arrow">
												<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
												<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
											</div>
										</div>
									</div>
								</div>
							</section>
							@endif
							<!-- ./ event-section -->


							@if($homePage->special==1)
							<section class="offer-section padding bg-white">
								<div class="container">
									<div class="section-heading wow fade-in-bottom" data-wow-delay="200ms">
										<h2 class="section-title">Special offers</h2>
									</div>
									<div class="offer-carousel-wrap wow fade-in-bottom" data-wow-delay="400ms">
										<div class="offer-carousel swiper">
											<div class="swiper-wrapper swiper-container">
												@forelse($specials as $special)
												<div class="swiper-slide">
													<div class="offer-item">
														<div class="offer-shape"></div>
														<div class="offer-thumb w-img">
															@if(count($special->images) > 0)
															<a href="{{route('package-detail',$special->slug)}}"><img src="{{asset('/'.$special->images[0]->image_path)}}" alt="{{$special->package_name}}" style="height: 200px;"></a>
															@endif
														</div>
														<div class="offer-content">
															<a href="{{route('package-detail',$special->slug)}}">
																<span class="offer-text">{{$special->service->name}}</span>
																<h3 class="offer-title">{{$special->package_name}}</h3>
																<h4 class="offer-desc">{{$special->duration}}</h4>
																<span class="places">{{$special->destination->name}}</span>
															</a>
														</div>
														{{--
															<div class="discount-box">
																<h4 class="discount" style="font-size:20px;"><i class="fa fa-star" ></i> {{$special->rating}} <span>({{$special->reviews->count()}} Reviews)</span></h4>
															</div>
															--}}
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>
											<!-- Carousel Arrows -->
											<div class="swiper-arrow">
												<div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
												<div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
											</div>
										</div>
									</div>
								</section>
								@endif
								<!-- ./ offer-section -->

								@if($homePage->activity==1)
								<section class="travel-section bg-grey padding">
									<div class="container">
										<div class="travel-top wow fade-in-bottom" data-wow-delay="200ms">
											<div class="section-heading">
												<h2 class="section-title"> Adventures And Tickets</h2>
											</div>
											<!-- Carousel Arrows -->
											<div class="swiper-arrow">
												<div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-left-long"></i></div>
												<div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-right-long"></i></div>
											</div>
										</div>
										<div class="travel-carousel-wrap wow fade-in-bottom" data-wow-delay="400ms">
											<div class="travel-carousel swiper">
												<div class="swiper-wrapper swiper-container">
													@forelse($activityDestinations as $ad)
													<div class="swiper-slide">
														<div class="project-wrap wrap-1">
															<div class="project-box">
																<div class="project-thumb">
																	<a href="{{route('activities',['destination'=>$ad->name])}}" class="project-title"><img src="{{asset($ad->image_path)}}" alt="{{$ad->name}}"></a>
																	<div class="project-content">
																		<h4><a href="{{route('activities',['destination'=>$ad->name])}}" class="project-title">{{$ad->name}}</a>
																		</h4>
																		<span class="destination-icons"><i class="fa-regular fa-user"></i> &nbsp; {{@$ad->destination_type == '1' ? 'Domestic' : 'International'}} <span class="float destination-icons"><i class="fa-regular fa-tasks"></i> &nbsp;{{$ad->activities_count}}</span></span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>

											<a href="{{route('destinations')}}" class="see-more-btn text-right" style="float: right;">See All<i class="fa-regular fa-arrow-right-long"></i></a>
										</div>
									</div>
								</section>
								@endif
								<!-- ./ travel-section -->

								@if($homePage->testimonial==1)
								<section class="testimonial-section padding bg-grey">
									<div class="testi-bg"></div>
									<div class="container">
										<div class="event-top wow fade-in-bottom" data-wow-delay="200ms">
											<div class="section-heading">
												<h2 class="section-title">Client Testimonial</h2>
											</div>
											<a href="{{route('testimonials')}}" class="see-more-btn">See All<i class="fa-regular fa-arrow-right-long"></i></a>
										</div>
										<div class="testimonial-carousel swiper">
											<div class="swiper-wrapper swiper-container">
												@forelse($reviews as $review)
												<div class="swiper-slide">
													<div class="testi-item text-center">
														<div class="testi-thumb text-center">
															<img src="{{asset(@$review->user_image)}}" class="author-image" alt="{{@$review->user_name}}">
														</div>
														<h3 class="testi-title">{{$review->user_name}}</h3>
														<ul class="ratings">

															@for ($i = 1; $i <= 5; $i++)
															@if ($i <= $review->rating)
															<li><i class="fa-solid fa-star"></i></li> <!-- Filled star -->
															@else
															<li><i class="fa fa-star" style="color: #ddd;"></i></li> <!-- Empty star -->
															@endif
															@endfor
														</ul>
														<!-- <p> -->
															{!! $review->review !!}
															<!-- </p> -->
														</div>
													</div>
													@empty
													@endforelse
												</div>
											</div>
											<!-- Carousel Arrows -->
											<div class="swiper-arrow">
												<div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-left-long"></i></div>
												<div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-right-long"></i></div>
											</div>
										</div>
									</section>
									@endif
									<!-- ./ testimonial-section -->


									<section class="travel-section bg-white padding">
										<div class="container">
											<div class="travel-top wow fade-in-bottom event-top" data-wow-delay="200ms">
												<div class="section-heading">
													<h2 class="section-title"> Journey In Frames</h2>
												</div>

												<!-- Carousel Arrows -->
												<div class="swiper-arrow">
													<div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-left-long"></i></div>
													<div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-right-long"></i></div>
												</div>

											</div>
											<div class="travel-carousel-wrap wow fade-in-bottom" data-wow-delay="400ms">
												<div class="travel-carousel swiper">
													<div class="swiper-wrapper swiper-container">
														@forelse($galleries as $gallery)
														<div class="swiper-slide">
															<div class="project-wrap wrap-1">
																<div class="project-box">
																	<div class="project-thumb">
																		<a href="{{route('galleries')}}?gallery={{$gallery->name}}" class="project-title"><img src="{{asset($gallery->image_path)}}" alt="{{$gallery->name}}"></a>
																		<div class="project-content">
																			<h4><a href="{{route('galleries')}}?gallery={{$gallery->name}}" class="project-title">{{$gallery->name}}</a>
																			</h4>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														@empty
														@endforelse
													</div>
												</div>
												<a href="{{route('galleries')}}" class="see-more-btn text-right" style="float: right;">See All Journey In Frames<i class="fa-regular fa-arrow-right-long"></i></a>
											</div>
										</div>
									</section>


									@if($homePage->newsletter==1)
									<section class="subscribe-section bg-white padding">
										<!-- <div class="subscribe-bg"></div> -->
										<div class="container">
											<div class="row">
			<!-- <div class="col-md-6">
				<div class="subscribe-video-btn">
					<div class="video-btn">
						<a class="video-popup" data-autoplay="true" data-vbtype="video" href="{{$homePage->newsletter_video_path}}"><i class="fa-solid fa-play"></i>
						</a>
					</div>
				</div>
			</div> -->
			<div class="col-md-12">
				<div class="subscribe-content">
					<h2 class="subscribe-title wow fade-in-right" data-wow-delay="200ms">
						<!-- {{$homePage->newsletter_title}}  -->
						<span>Newsletter</span>
					</h2>
					<p class="wow fade-in-right" data-wow-delay="400ms">
						{{$homePage->newsletter_description}}
					</p>
					<div id="alert-container"></div>
					<form class="subscribe-form wow fade-in-right" data-wow-delay="500ms" id="newsletter-form" method="POST" action="{{url('newsletter-save')}}">
						@csrf
						<input type="email" id="email" name="email" class="form-control"
						placeholder="Enter your email address" required>
						<button id="commentBtn" onclick="subscribe(event)" class="pxs-primary-btn">Subscribe <i class="fa fa-location-arrow"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- ./ subscribe-section -->

@if($homePage->blog==1)
<section class="blog-section bg-grey padding">
	<div class="container">
		<div class="blog-top wow fade-in-bottom" data-wow-delay="200ms">
			<div class="section-heading">
				<h2 class="section-title">Blogs</h2>
			</div>
			<a href="{{route('blogs')}}" class="see-more-btn">See All Blogs<i class="fa-regular fa-arrow-right-long"></i></a>
		</div>
		<div class="row">
			@forelse($blogs as $blog)
			<div class="col-lg-4 col-md-6">
				<div class="post-card">
					<div class="post-thumb w-img">
						<a href="{{route('blog-detail',$blog->slug)}}"><img src="{{asset('/'.$blog->image_path)}}" alt="{{$blog->title}}"  style="height: 200px;" /></a>
					</div>
					<div class="post-content">
						<div>
							{{--
								<ul class="post-meta">
									<li><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}</li>
								</ul>
								--}}
								<h3 class="post-title">
									<a href="{{route('blog-detail',$blog->slug)}}">{{$blog->title}}</a>
								</h3>
							<!-- <p>
								@php
								$content = strip_tags($blog->content);
								$limit = 200; // Set the character limit
								$limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
								@endphp

								{!! $limitedContent !!}
							</p>  -->
						</div>
						<div class="post-box">
							<div class="post-author">
								<!-- <img src="{{asset($blog->postedBy->profile_image)}}" class="author-image" alt="{{@$blog->postedBy->name}}" />
									<h3 class="post-name">{{@$blog->postedBy->name}}  -->
										<!-- <span>{{@$blog->postedBy->name}}</span> -->
										<!-- </h3> -->
									</div>
									<a href="{{route('blog-detail',$blog->slug)}}" class="read-more-btn">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
								</div>
							</div>
						</div>
					</div>
					@empty
					@endforelse
				</div>
			</div>
		</section>

		<section class="blog-section  bg-white padding">
			<div class="container">
				<div class="blog-top wow fade-in-bottom" data-wow-delay="200ms">
					<div class="section-heading">
						<h2 class="section-title">Vlogs</h2>
					</div>
					<a href="{{route('vlogs')}}" class="see-more-btn">See All Vlogs<i class="fa-regular fa-arrow-right-long"></i></a>
				</div>
				<div class="row">
					@forelse($vlogs as $vlog)
					<div class="col-lg-4 col-md-6">
						<div class="project-wrap wrap-1">
							<div class="project-box">
								<div class="project-thumb">
									<a href="javascript:;"><img src="{{asset($vlog->image_path)}}" alt="{{$vlog->title}}"></a>
									<div class="project-content">
										<h4><a href="javascript:;" class="project-title">{{$vlog->title}}</a>
										</h4>
									</div>

									<div class="wow fade-in-bottom vlog-video" data-wow-delay="200ms">
										<a class="video-popup" data-autoplay="true" data-vbtype="video" href="{{$vlog->video_path}}"><i class="fa-solid fa-play"></i>

										</a>
									</div>

								</div>
							</div>
						</div>
					</div>
					@empty
					@endforelse
				</div>
			</div>
		</section>
		@endif
		<!-- ./ blog-section -->

		@if(!empty($homePage->promo))
		<section class="promo-section padding bg-grey">
			<div class="container">
				<div class="row">
					@forelse(json_decode($homePage->promo) as $promo)
					<div class="col-md-4">
						<div class="promo-item wow fade-in-bottom" data-wow-delay="200ms">
							<div class="promo-icon">
								<img src="{{asset($promo->icon_path)}}" alt="{{$promo->title}}">
							</div>
							<div class="promo-content">
								<h3>{{$promo->title}}</h3>
								<p>{{$promo->description}}</p>
							</div>
						</div>
					</div>
					@empty
					@endforelse
				</div>
			</div>
		</section>
		@endif
		<!-- ./ promo-section -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

		<script>
			var input = document.querySelector("#v_country_code1");
			var countryCodeInput = document.querySelector("#v_country_code");
			var iti = window.intlTelInput(input, {
				initialCountry: "in",
				separateDialCode: true,
				geoIpLookup: function(callback) {
					fetch("https://ipinfo.io?token=<YOUR_TOKEN>", {
						headers: { 'Accept': 'application/json' }
					})
					.then((resp) => resp.json())
					.then((resp) => callback(resp.country))
					.catch(() => callback("IN"));
				},
				utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
			});
			countryCodeInput.value = '+91';
			input.addEventListener('countrychange', function() {
				var dialCode = iti.getSelectedCountryData().dialCode;
				countryCodeInput.value = '+' + dialCode;
			});
			document.querySelector('#visaForm').addEventListener('submit', function(e) {
				e.preventDefault();
				var phoneNumber = input.value.trim();
				this.submit();
			});

			var inputI = document.querySelector("#i_country_code1");
			var countryCodeInputI = document.querySelector("#i_country_code");
			var iti = window.intlTelInput(inputI, {
				initialCountry: "in",
				separateDialCode: true,
				geoIpLookup: function(callback) {
					fetch("https://ipinfo.io?token=<YOUR_TOKEN>", {
						headers: { 'Accept': 'application/json' }
					})
					.then((resp) => resp.json())
					.then((resp) => callback(resp.country))
					.catch(() => callback("IN"));
				},
				utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
			});
			countryCodeInputI.value = '+91';
			inputI.addEventListener('countrychange', function() {
				var dialCodeI = iti.getSelectedCountryData().dialCode;
				countryCodeInputI.value = '+' + dialCodeI;
			});
			document.querySelector('#insuranceForm').addEventListener('submit', function(e) {
				e.preventDefault();
				var phoneNumber = inputI.value.trim();
				this.submit();
			});
		</script>

		@section('extrajs')
		<script>
// Display child age select fields based on the number of children
function showChildrenAgeFieldsI() {
	document.querySelectorAll('.incChildAgeDiv').forEach(e => e.remove());
	const childrenCount = document.getElementById('i_children').value;

	if (childrenCount > 0) {
        // Create select fields with labels for each child
        for (let i = 1; i <= childrenCount; i++) {
        	const ageField = document.createElement('div');
        	ageField.classList.add('col-md-2');
        	ageField.classList.add('col-sm-6');
        	ageField.classList.add('col-xs-12');
        	ageField.classList.add('incChildAgeDiv');

            // Create label for child age
            const label = document.createElement('h3');
            label.setAttribute('for', `child_age_${i}`);
            label.textContent = `Child ${i} Age:`;
            label.classList.add('box-title');
            label.classList.add('children');

            // Create select element for age
            const select = document.createElement('select');
            select.id = `child_age_${i}`;
            select.name = 'children_ages[]';
            select.classList.add('nice-select');

            // Create options for ages 3 to 12
            for (let age = 3; age <= 12; age++) {
            	const option = document.createElement('option');
            	option.value = age;
            	option.textContent = age;
            	select.appendChild(option);
            }

            // Append label and select to the ageField container
            ageField.appendChild(label);
            ageField.appendChild(select);
            $("#insChildrenAge").append(ageField);
        }
    } else {
        document.querySelectorAll('.incChildAgeDiv').forEach(e => e.remove()); // Hide container if no children selected
    }
}

// Function to dynamically show infant age select fields
function showInfantsAgeFieldsI() {
	document.querySelectorAll('.incInfantAgeDiv').forEach(e => e.remove());
	const infantsCount = document.getElementById('i_infants').value;
	
	if (infantsCount > 0) {


        // Create select fields with labels for each infant
        for (let i = 1; i <= infantsCount; i++) {
        	const ageField = document.createElement('div');
        	ageField.classList.add('col-md-2');
        	ageField.classList.add('col-sm-6');
        	ageField.classList.add('col-xs-12');
        	ageField.classList.add('incInfantAgeDiv');

            // Create label for infant age
            const label = document.createElement('h3');
            label.setAttribute('for', `i_infant_age_${i}`);
            label.textContent = `Infant ${i} Age:`;
            label.classList.add('box-title');
            label.classList.add('infant');

            // Create select element for infant age
            const select = document.createElement('select');
            select.id = `i_infant_age_${i}`;
            select.name = 'infants_ages[]';
            select.classList.add('nice-select');
            
            // Create options for ages 1 and 2
            for (let age = 1; age <= 2; age++) {
            	const option = document.createElement('option');
            	option.value = age;
            	option.textContent = age;
            	select.appendChild(option);
            }

            // Append label and select to the ageField container
            ageField.appendChild(label);
            ageField.appendChild(select);
            $("#insChildrenAge").append(ageField);
        }
    } else {
        document.querySelectorAll('.incInfantAgeDiv').forEach(e => e.remove()); // Hide container if no children selected
    }
}

function insuranceSave(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var destination = $('#i_destination').val();
    var start_date = $('#i_start_date').val();
    var end_date = $('#i_end_date').val();
    var adults = $('#i_adults').val();
    var children = $('#i_children').val();
    var infants = $('#i_infants').val();
    var name = $('#i_name').val();
    var email = $('#i_email').val();
    var country_code = $('#i_country_code').val();
    var mobile = $('#i_mobile').val();
    var children_ages = [];
    var infants_ages = [];

    // Capture the ages of children from select elements
    $('select[name="children_ages[]"]').each(function() {
    	var age = $(this).val();
    	if (age) {
    		children_ages.push(parseInt(age));
    	}
    });

    // Capture the ages of infants from select elements
    $('select[name="infants_ages[]"]').each(function() {
    	var age = $(this).val();
    	if (age) {
    		infants_ages.push(parseInt(age));
    	}
    });

    var iBtn = $('#iButton'); // Submit button

    iBtn.prop('disabled', true); // Disable button to prevent multiple submissions

    $.ajax({
        url: "{{ route('insurance-save') }}", // Replace with actual route
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            destination: destination,
            adults: adults,
            name: name,
            email: email,
            country_code: country_code,
            mobile: mobile,
            children: children,
            start_date: start_date,
            end_date: end_date,
            children_ages: children_ages,
            infants: infants,
            infants_ages: infants_ages
        },
        success: function(response) {
        	if (response.success) {
        		showAlert('success', response.message, 'alert-container-i');
                $('#insuranceForm')[0].reset(); // Optionally reset the form
            } else {
            	showAlert('danger', response.message || 'Failed to submit, please try again.', 'alert-container-i');
            	iBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation error
            	var errors = xhr.responseJSON.errors;
            	showAlert('danger', errors.destination || 'Validation error', 'alert-container-i');
            } else {
            	var message = xhr.responseJSON && xhr.responseJSON.message;
            	showAlert('danger', message ? message : 'An error occurred. Please try again.', 'alert-container-i');
            }
            iBtn.prop('disabled', false); // Re-enable the submit button on error
        }
    });
}

// Display child age select fields based on the number of children
function showChildrenAgeFieldsV() {
	document.querySelectorAll('.childAgeDiv').forEach(e => e.remove());
	const childrenCount = document.getElementById('v_children').value;
	
	if (childrenCount > 0) {
        // Create select fields with labels for each child
        for (let i = 1; i <= childrenCount; i++) {
        	const ageField = document.createElement('div');
        	ageField.classList.add('col-md-2');
        	ageField.classList.add('col-sm-6');
        	ageField.classList.add('col-xs-12');
        	ageField.classList.add('childAgeDiv');
        	

            // Create label for child age
            const label = document.createElement('h3');
            label.setAttribute('for', `child_age_${i}`);
            label.textContent = `Child ${i} Age:`;
            label.classList.add('box-title');
            label.classList.add('children');

            // Create select element for age
            const select = document.createElement('select');
            select.id = `child_age_${i}`;
            select.name = 'children_ages[]';
            select.classList.add('nice-select');

            // Create options for ages 3 to 12
            for (let age = 3; age <= 12; age++) {
            	const option = document.createElement('option');
            	option.value = age;
            	option.textContent = age;
            	select.appendChild(option);
            }

            // Append label and select to the ageField container
            ageField.appendChild(label);
            ageField.appendChild(select);
            $("#childrenAge").append(ageField);
        }
    } else {
        document.querySelectorAll('.childAgeDiv').forEach(e => e.remove()); // Hide container if no children selected
    }
}

// Function to dynamically show infant age select fields
function showInfantsAgeFieldsV() {
	document.querySelectorAll('.infantAgeDiv').forEach(e => e.remove());
	const infantsCount = document.getElementById('v_infants').value;
	const infantsAgeContainer = document.getElementById('infantsAgeContainerV');

	if (infantsCount > 0) {

        // Create select fields with labels for each infant
        for (let i = 1; i <= infantsCount; i++) {
        	const ageField = document.createElement('div');
        	ageField.classList.add('col-md-2');
        	ageField.classList.add('col-sm-6');
        	ageField.classList.add('col-xs-12');
        	ageField.classList.add('infantAgeDiv');

            // Create label for infant age
            const label = document.createElement('h3');
            label.setAttribute('for', `v_infant_age_${i}`);
            label.textContent = `Infant ${i} Age:`;
            label.classList.add('box-title');
            label.classList.add('infant');

            // Create select element for infant age
            const select = document.createElement('select');
            select.id = `v_infant_age_${i}`;
            select.name = 'infants_ages[]';
            select.classList.add('nice-select');
            
            // Create options for ages 1 and 2
            for (let age = 1; age <= 2; age++) {
            	const option = document.createElement('option');
            	option.value = age;
            	option.textContent = age;
            	select.appendChild(option);
            }

            // Append label and select to the ageField container
            ageField.appendChild(label);
            ageField.appendChild(select);
            $("#childrenAge").append(ageField);
        }
    } else {
        document.querySelectorAll('.childAgeDiv').forEach(e => e.remove()); // Hide container if no children selected
    }
}


function visaSave(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var destination = $('#v_destination').val();
    var start_date = $('#v_start_date').val();
    var adults = $('#v_adults').val();
    var children = $('#v_children').val();
    var infants = $('#v_infants').val();
    var name = $('#v_name').val();
    var email = $('#v_email').val();
    var country_code = $('#v_country_code').val();
    var mobile = $('#v_mobile').val();

    var children_ages = [];
    var infants_ages = [];

    // Capture the ages of children from select elements
    $('select[name="children_ages[]"]').each(function() {
    	var age = $(this).val();
    	if (age) {
    		children_ages.push(parseInt(age));
    	}
    });

    // Capture the ages of infants from select elements
    $('select[name="infants_ages[]"]').each(function() {
    	var age = $(this).val();
    	if (age) {
    		infants_ages.push(parseInt(age));
    	}
    });
    var iBtn = $('#vButton'); // Submit button
    iBtn.prop('disabled', true); // Disable button to prevent multiple submissions

    $.ajax({
        url: "{{ route('visa-save') }}", // Replace with actual route
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            destination: destination,
            start_date: start_date,
            adults: adults,
            name: name,
            email: email,
            country_code: country_code,
            mobile: mobile,
            children: children,
            children_ages: children_ages,
            infants: infants,
            infants_ages: infants_ages
        },
        success: function(response) {
        	if (response.success) {
        		showAlert('success', response.message, 'alert-container-v');
                $('#visaForm')[0].reset(); // Optionally reset the form
            } else {
            	showAlert('danger', response.message || 'Failed to submit, please try again.', 'alert-container-v');
            	iBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation error
            	var errors = xhr.responseJSON.errors;
            	showAlert('danger', errors.destination || 'Validation error', 'alert-container-v');
            } else {
            	var message = xhr.responseJSON && xhr.responseJSON.message;
            	showAlert('danger', message ? message : 'An error occurred. Please try again.', 'alert-container-v');
            }
            iBtn.prop('disabled', false); // Re-enable the submit button on error
        }
    });
}




function subscribe(event) {
	event.preventDefault(); 

	var email = $('#email').val();
	var commentBtn = $('.commentBtn');

	if (!email) {
		showAlert('danger', 'Email is required','alert-container');
		return;
	}

	commentBtn.prop('disabled', true); 

	$.ajax({
		url: "{{ route('newsletter-save') }}",
		type: "POST",
		data: {
			_token: '{{ csrf_token() }}',
			email:email
		},
		success: function(response) {
			if (response.success) {
				$('#newsletter-form')[0].reset();
				showAlert('success', response.message,'alert-container');
			} else {
				showAlert('danger', response.message || 'Failed to Subscribe, please try again.','alert-container');
				commentBtn.prop('disabled', false);
			}
		},
		error: function(xhr) {
			if (xhr.status === 422) {
				var errors = xhr.responseJSON.errors;
				showAlert('danger', errors.email ? errors.email[0] : 'Validation error','alert-container');
			} else {
				var message = xhr.responseJSON && xhr.responseJSON.message;
				showAlert('danger', message ? message : 'An error occurred. Please try again.','alert-container');
			}
                        commentBtn.prop('disabled', false); // Re-enable the Send OTP button on error
                    }
                });
}


function showAlert(type, message, alertcontainer) {
	var alertContainer = $('#'+alertcontainer);
	var alertHtml = `
	<div class="alert alert-${type} alert-dismissible fade show" role="alert">
	<strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div><br>
	`;
	alertContainer.html(alertHtml);

	setTimeout(function() {
		$('.alert').fadeOut('slow', function() {
			$(this).remove();
		});
	}, 10000);
}
</script>
@endsection
@endsection