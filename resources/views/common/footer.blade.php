<!-- ./ mobile-new-navigation -->
<nav class="amazing-tabs">
	<div class="filters-container">
		<div class="filters-wrapper">
			<ul class="filter-tabs">
				<li>
					<a href="{{route('visa-inquiry')}}" class="filter-button @if(Request::segment(1)==='visa-inquiry') filter-active @endif" data-translate-value="0">
						Visa
					</a>
				</li>
				<li>
					<a href="{{route('travel-courses')}}" class="filter-button @if(Request::segment(1)==='travel-courses' || Request::segment(1)==='travel-course-detail') filter-active @endif" data-translate-value="100%">
						Touriversity
					</a>
				</li>
				<li>
					<a href="{{route('insurance-inquiry')}}" class="filter-button @if(Request::segment(1)==='insurance-inquiry') filter-active @endif" data-translate-value="100%">
						Insurance
					</a>
				</li>
			</ul>
			<div class="filter-slider" aria-hidden="true">
				<div class="filter-slider-rect">&nbsp;</div>
			</div>
		</div>
	</div>
	<div class="main-tabs-container">
		<div class="main-tabs-wrapper">
			<ul class="main-tabs"> 
				<li>
					<a href="{{route('packages',['destination'=>'domestic'])}}" class="round-button" data-translate-value="0" data-color="red">
						<span class="avatar @if(@$_REQUEST['destination']=='domestic') active @endif">
							<img src="{{asset('images/1.png')}}" alt="Domestic" class="" />
							Domestic
						</span>
					</a>
				</li>

				<li>
					<a href="{{route('packages',['destination'=>'international'])}}" class="round-button" data-translate-value="0" data-color="red">
						<span class="avatar @if(@$_REQUEST['destination']=='international') active @endif">
							<img src="{{asset('images/2.png')}}" alt="International" class="" />
							International
						</span>
					</a>
				</li>

				<li>
					<a href="{{route('packages',['service'=>'ramta-yogi'])}}" class="round-button" data-translate-value="0" data-color="red">
						<span class="avatar @if(@$_REQUEST['service']=='ramta-yogi') active @endif">
							<img src="{{asset('images/3.png')}}" alt="Ramta Yogi" class="" />
							Ramta&nbsp;Yogi 
						</span>
					</a>
				</li>

				<li>
					<a href="{{route('destinations')}}" class="round-button" data-translate-value="0" data-color="red">
						<span class="avatar @if(Request::segment(1)==='destinations' || Request::segment(1)==='activities' || Request::segment(1)==='activity-detail') active @endif">
							<img src="{{asset('images/4.png')}}" alt="Visa" class="" />
							Activities
						</span>
					</a>
				</li>
			</ul>
			<div class="main-slider" aria-hidden="true">
				<div class="main-slider-circle">&nbsp;</div>
			</div>
		</div>
	</div>
</nav>

<!--footer-->
<footer class="footer-section bg-white">
	<div class="footer-shape-1"></div>
	<div class="footer-shape"></div>
	<div class="container">
		<div class="footer-top">
			<div class="row">
				<div class="col-lg-4 col-md-4">
					<div class="widget-item wow fade-in-bottom" data-wow-delay="200ms">
						<h3 class="widget-header">About Us</h3>
						<p class="desc">
							@php
							$footer_description = strip_tags($appSetting->footer_description);
							$limit = 200; // Set the character limit
							$limitedDesc = strlen($footer_description) > $limit ? substr($footer_description, 0, $limit) . '...' : $footer_description;
							@endphp

							{!! $limitedDesc !!}<a href="{{url('about-us')}}" class="text-info">Know More About Us</a>
						</p>
						<a href="{{ url('/') }}">
							<img src="{{ asset('/'.$appSetting->footer_logo) }}" alt="Logo"  class="img-white">
						</a>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="widget-item wow fade-in-bottom" data-wow-delay="400ms">
						<h3 class="widget-header">Explore</h3>
						<ul class="widget-list">
							@forelse(App\Models\DynamicPage::where('placed_in','footer_menu')-> orderBy('order_number','ASC')->get() as $dynamicPage)
							<li><a class="{{ request()->is($dynamicPage->slug) ? 'active' : '' }}" href="{{url($dynamicPage->slug)}}">{{ucfirst($dynamicPage->title)}}</a></li>
							@empty
							@endforelse
							<li><a class="{{ request()->is('faqs') ? 'active' : '' }}"  href="{{route('faqs')}}">FAQ </a></li>
							<li><a class="{{ request()->is('career') ? 'active' : '' }}" href="{{route('career')}}">Career</a></li>
							<li><a class="{{ request()->is('contact-us') ? 'active' : '' }}" href="{{route('contact-us')}}">Contact </a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<div class="widget-item wow fade-in-bottom" data-wow-delay="500ms">
						<h3 class="widget-header">Brands</h3>
						@forelse(App\Models\Brand::get() as $brand)
							<div class="brand-images">
								<img src="{{asset($brand->image_path)}}" align="brand">
								<!-- class="img-popup" href="{{asset($brand->image_path)}}" style="cursor: pointer;" -->
							</div>
						@empty
						@endforelse
					</div>
					@if(App\Models\Brand::count() > 0)
					<hr>
					@endif
					@if(!empty($appSetting->payment_image))
					<img src="{{asset($appSetting->payment_image)}}" alt="{{asset('images/nimage.jpg')}}">
					@endif
				</div>
			</div>
		</div>
		<br>
		@if(App\Models\Address::count() > 0)
		<div class="row">
				@forelse(App\Models\Address::get() as $address)
				<div class="col-md-4 col-sm-6 col-xs-12">
					
					<div class="footer-address-section text-white">
					<h4>{{$address->title}}</h4>
					<ul id="footer-address">
					 	<li id="map-icon">
					 		{!! nl2br($address->address) !!}
					 	</li>
					 	<li id="phone-icon">
					 		<a href="tel:{{$address->mobilenum}}">
						 		{{$address->mobilenum}}
						 	</a>
						 </li>
					 	<li id="envelope-icon">
					 		<a href="mailto:{{$address->email}}">
						 		{{$address->email}}
						 	</a>
					 	</li>
					</ul>
					</div>
				</div>
				@empty
				@endforelse
			</div>
		</div>
		@endif
		
		<div class="footer-bottom">
			<div class="widget-item wow fade-in-bottom" data-wow-delay="200ms">
				<ul class="widget-social">
					@if(!empty($appSetting->fb_url))
					<li>
						<a target="_blank" href="{{$appSetting->fb_url}}"><i class="fab fa-facebook-f"></i></a>
					</li>
					@endif
					@if(!empty($appSetting->twitter_url))
					<li>
						<a target="_blank" href="{{$appSetting->twitter_url}}"><i class="fab fa-twitter"></i></a>
					</li>
					@endif
					@if(!empty($appSetting->insta_url))
					<li>
						<a target="_blank" href="{{$appSetting->insta_url}}"><i class="fab fa-instagram"></i></a>
					</li>
					@endif
					@if(!empty($appSetting->pinterest_url))
					<li>
						<a target="_blank" href="{{$appSetting->pinterest_url}}"><i class="fab fa-pinterest"></i></a>
					</li>
					@endif
					@if(!empty($appSetting->linkedIn_url))
					<li>
						<a target="_blank" href="{{$appSetting->linkedIn_url}}"><i class="fab fa-linkedin"></i></a>
					</li>
					@endif
				</ul>
			</div>
			<br>
			<span class="portfolio">{{$appSetting->copyright_text}} <span class="d-none">||  Designed By <a href="https://nrt.co.in/" target="_blank" class="created_by">NewRise Technosys Pvt. Ltd.</a></span></span>
		</div>
	</div>
</footer>