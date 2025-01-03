<div class="container">
    <div class="primary-header">
        <div class="primary-header-inner">
            <div class="header-logo d-none d-lg-block">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('/'.$appSetting->app_logo) }}" alt="Logo">
                </a>
            </div>
            <div class="header-menu-wrap">
                <div class="mobile-menu-items">
                    <ul class="sub-menu">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="{{ request()->is('about-us') ? 'active' : '' }}">
                            <a href="{{ url('about-us') }}">About Us</a>
                        </li>
                        <li class="{{ request()->is('blogs') ? 'active' : '' }}">
                            <a href="{{ url('blogs') }}">Blogs</a>
                        </li>
                        <li class="{{ request()->is('vlogs') ? 'active' : '' }}">
                            <a href="{{ url('vlogs') }}">Vlogs</a>
                        </li>
                        <li class="has-dropdown {{ request()->is('packages*') ? 'active' : '' }}">
                            <a href="{{ url('packages') }}">Packages</a>
                            <ul>
                                <li class="{{ request()->is('packages?service=ramta-jogi') ? 'active' : '' }}">
                                    <a href="{{ url('packages?service=ramta-yogi') }}">Ramta Yogi</a>
                                </li>
                                <li class="{{ request()->is('packages?destination=domestic') ? 'active' : '' }}">
                                    <a href="{{ url('packages?destination=domestic') }}">Domestic</a>
                                </li>
                                <li class="{{ request()->is('packages?destination=international') ? 'active' : '' }}">
                                    <a href="{{ url('packages?destination=international') }}">International</a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ request()->is('activities') ? 'active' : '' }}">
                            <a href="{{ url('activities') }}">Activities</a>
                        </li>
                        <li class="{{ request()->is('travel-courses') ? 'active' : '' }}">
                            <a href="{{ url('travel-courses') }}">Travel Coursces</a>
                        </li>
                        <li class="{{ request()->is('faqs') ? 'active' : '' }}">
                            <a href="{{ url('faqs') }}">Faq</a>
                        </li>
                        <li class="{{ request()->is('contact-us') ? 'active' : '' }}">
                            <a href="{{ url('contact-us') }}">Contact</a>
                        </li>
                        @forelse(App\Models\DynamicPage::where('placed_in','header_menu')->get() as $dynamicPage)
                        <li class="{{ request()->is($dynamicPage->slug) ? 'active' : '' }}">
                            <a href="{{url($dynamicPage->slug)}}">{{ucfirst($dynamicPage->title)}}</a>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <div class="header-right d-flex align-items-center">
                    <div class="header-logo d-lg-none">
                        <a href="#">
                            <img src="{{ asset('/'.$appSetting->app_logo) }}" alt="Logo">
                        </a>
                    </div>
                    <div class="header-right-item">
                        <div class="search-icon dl-search-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>

