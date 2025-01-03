<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
	<div class="app-sidebar__user">
		<div class="dropdown user-pro-body">
			<div>
				<img src="{{url('/')}}/{{$appSetting->app_logo}}" alt="{{url('/')}}/{{$appSetting->app_logo}}" class="avatar avatar-xl brround mCS_img_loaded">
				<a href="{{ route('edit-profile') }}" class="profile-img">
					<span class="fa fa-pencil" aria-hidden="true"></span>
				</a>
			</div>
			<div class="user-info mb-2">
				<h4 class="font-weight-semibold text-dark mb-1">{{Auth::user()->name}}</h4>
				<!-- <span class="mb-0 text-muted">{{Auth::user()->companyName}}</span> -->
			</div>
			@can('app-setting-update')
			<a href="{{ route('app-setting') }}" title="" class="user-button" data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="setting"><i class="fa fa-cog"></i></a>
			@endcan
			<a href="{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}" title="" class="user-button"  data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="Screen Lock"><i class="fa fa-lock"></i></a>

			<a href="{{url('logout')}}" title="" class="user-button"  data-container="body" data-toggle="popover" data-popover-color="default" data-placement="top" title="" data-content="Sign Out"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i></a>
			
			
		</div>
	</div>
	<ul class="side-menu">
		@can('dashboard-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('dashboard') }}"><i class="side-menu__icon fa fa-desktop"></i><span class="side-menu__label">Dashboard</span></a>
		</li>
		@endcan

		@can('user-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('users-list') }}"><i class="side-menu__icon fa fa-user"></i><span class="side-menu__label">Users List</span></a>
		</li>
		@endcan

		@can('package-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('packages-list') }}"><i class="side-menu__icon fa fa-globe"></i><span class="side-menu__label">Packages List</span></a>
		</li>
		@endcan
		@can('pro-forma-invoice-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('pro-forma-invoices-list') }}"><i class="side-menu__icon fa fa-file-pdf-o"></i><span class="side-menu__label">Pro Forma Invoice List</span></a>
		</li>
		@endif
		@can('blog-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('blogs-list') }}"><i class="side-menu__icon fa fa-pencil"></i><span class="side-menu__label">Blog List</span></a>
		</li>
		@endcan
		@can('vlog-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('vlogs-list') }}"><i class="side-menu__icon fa fa-video-camera"></i><span class="side-menu__label">Vlog List</span></a>
		</li>
		@endcan
		@can('travel-course-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('travel-courses-list') }}"><i class="side-menu__icon fa fa-plane"></i><span class="side-menu__label">Travel Courses List</span></a>
		</li>
		@endcan
		@can('promotion-and-discount-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('promotion-and-discounts-list') }}"><i class="side-menu__icon fa fa-tag"></i><span class="side-menu__label">Promotion And Discounts</span></a>
		</li>
		@endcan
		@can('career-list')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('career-list') }}"><i class="side-menu__icon fa fa-male"></i><span class="side-menu__label">Career</span></a>
		</li>
		@endcan
		@can('review-and-rating-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('review-and-ratings-list') }}"><i class="side-menu__icon fa fa-star"></i><span class="side-menu__label">Review And Rating</span></a>
		</li>
		@endcan
		@can('contact-us-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('contact-us-list') }}"><i class="side-menu__icon fa fa-address-book"></i><span class="side-menu__label">Contact Us</span></a>
		</li>
		@endcan
		@can('newsletter-browse')
		<li>
			<a class="side-menu__item menu-c" href="{{ route('newsletter-list') }}"><i class="side-menu__icon fa fa-envelope"></i><span class="side-menu__label">Newsletter</span></a>
		</li>
		@endcan
		
		<li>
			<a class="side-menu__item menu-c" href="{{ route('booking-inquiries-list') }}"><i class="side-menu__icon fa fa-file"></i><span class="side-menu__label">Booking  Inquiries</span></a>
		</li>
		<li class="slide">
			<a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fa fa-cog"></i><span class="side-menu__label">Master Setting</span><i class="angle fa fa-angle-right"></i></a>
			<ul class="slide-menu">
				@can('app-setting-update')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('app-setting') }}"><span class="side-menu__label">App Setting</span></a>
				</li>
				@endcan
				<!-- @can('menu-browse')<li>
					<a class="side-menu__item menu-c" href="{{ route('menus-list') }}"><span class="side-menu__label">Menu List</span></a>
				</li>
				@endcan -->
				@can('destination-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('destinations-list') }}"><span class="side-menu__label">Destination List</span></a>
				</li>
				@endcan
				@can('category-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('categories-list') }}"><span class="side-menu__label">Category List</span></a>
				</li>
				@endcan
				@can('faq-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('faqs-list') }}"><span class="side-menu__label">Faq List</span></a>
				</li>
				@endcan
				@can('dynamic-page-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('dynamic-pages-list') }}"><span class="side-menu__label">Dynamic Page List</span></a>
				</li>
				@endcan
				@can('email-template-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('email-templates-list') }}"><span class="side-menu__label">Email Template List</span></a>
				</li>
				@endcan
				@can('service-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('services-list') }}"><span class="side-menu__label">Service List</span></a>
				</li>
				@endcan
				@can('address-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('addresses-list') }}"><span class="side-menu__label">Address List</span></a>
				</li>
				@endcan
				@can('role-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('roles-list') }}"><span class="side-menu__label">Role List</span></a>
				</li>
				@endcan
				@can('permission-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('permissions-list') }}"><span class="side-menu__label">Permission List</span></a>
				</li>
				@endcan
				@can('language-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('languages-list') }}"><span class="side-menu__label">Language List</span></a>
				</li>
				@endcan
				@can('currency-browse')
				<li>
					<a class="side-menu__item menu-c" href="{{ route('currencies-list') }}"><span class="side-menu__label">Currency List</span></a>
				</li>
				@endcan
			</ul>
			</li>
		</ul>
	</aside>