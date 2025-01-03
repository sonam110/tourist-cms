<header class="header sticky-active">
  <div class="top-bar">
    <div class="container">
      <div class="top-bar-inner">
        <div class="top-left-content">
          <ul class="top-left-list">
            <li>
              <a href="tel:+{{$appSetting->mobilenum}}"><i class="fa-regular fa-phone"></i>(+{{$appSetting->mobilenum}})</a>
            </li>
            <li>
              <a href="mailto:{$appSetting->email}}"><i class="fa-regular fa-envelope"></i>{{$appSetting->email}}</a>
            </li>
          </ul>
        </div>
        <div class="top-right-content">
          <ul class="top-right-list">
            <li class="usd">
              <form action="{{ route('swich-currency') }}" method="POST">
                @csrf
                <select class="ddl-select nice-select" id="currency_id" name="currency_id" onchange="this.form.submit()">
                  @forelse(App\Models\Currency::all() as $currency)
                  <option value="{{ $currency->id }}" 
                    @if(session('currency_id') == $currency->id) selected @endif>
                    {{ $currency->name }}
                  </option>
                  @empty
                  <option value="">No currencies available</option>
                  @endforelse
                </select>
              </form>
            </li>
            <li>
             @if(session('flag'))
                  <img src="{{ asset(session('flag')) }}" alt="flag">
              @else
                  <img src="{{ asset('img/images/english-flag.jpg') }}" alt="default flag">
              @endif

              <form action="{{ route('swich-language') }}" method="POST">
                @csrf
                <select class="ddl-select nice-select" id="language_id" name="language_id" onchange="this.form.submit()">
                  @forelse(App\Models\Language::all() as $language)
                  <option value="{{ $language->id }}" 
                    @if(session('language_id') == $language->id) selected @endif>
                    {{ $language->name }}
                  </option>
                  @empty
                  <option value="">No languages available</option>
                  @endforelse
                </select>
              </form>
            </li>
            <li>
              <ul class="top-social-list">
                @if(!empty($appSetting->fb_url))
                <li>
                  <a href="{{$appSetting->fb_url}}" target="blank"><i class="fab fa-facebook-f"></i></a>
                </li>
                @endif
                @if(!empty($appSetting->linkedIn_url))
                <li>
                  <a href="{{$appSetting->linkedIn_url}}" target="blank"><i class="fab fa-linkedin"></i></a>
                </li>
                @endif
                @if(!empty($appSetting->twitter_url))
                <li>
                  <a href="{{$appSetting->twitter_url}}" target="blank"><i class="fab fa-twitter"></i></a>
                </li>
                @endif
                @if(!empty($appSetting->insta_url))
                <li>
                  <a href="{{$appSetting->insta_url}}" target="blank"><i class="fab fa-instagram"></i></a>
                </li>
                @endif
              </ul>
            </li>
          </ul>
          <div class="header-btn">
            @if(Auth::user())

            <button type="button" class="pxs-header-btn" onclick="location.href='{{ route('user.dashboard') }}'">
              My Account
            </button>
            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="pxs-header-btn">
                Sign Out
              </button>
            </form> -->
            @else
            <!-- <button type="button" class="pxs-header-btn" data-bs-toggle="modal" data-bs-target="#signModal">
              Sign in
            </button> -->
            <button type="button" class="pxs-header-btn" onclick="location.href='{{ url('login') }}'">
              Sign in
            </button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="primary-header">
      <div class="primary-header-inner">
        <div class="header-logo d-none d-lg-block">
          <a href="{{ url('/') }}">
            <img src="{{ asset('/'.$appSetting->app_logo) }}" alt="Logo">
          </a>
        </div>
        <div class="header-menu-wrap  header-container">
          <div class="mobile-menu-items">
            <ul class="sub-menu  action-panel" id="top-panel">
              <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="has-dropdown {{ request()->is('packages*')|| request()->segment(1) == 'package-detail' ? 'active' : '' }}">
                <a href="javascript:;">Packages</a>
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
              <li class="{{ request()->is('activities') || request()->is('destinations') || request()->segment(1) == 'activity-detail' ? 'active' : '' }}">
                <a href="{{ url('destinations') }}">Activities</a>
              </li>
              <li class="{{ request()->is('travel-courses') ? 'active' : '' }}">
                <a href="{{ url('travel-courses') }}">Touriversity</a>
              </li>
              <li class="{{ request()->is('blogs') ? 'active' : '' }}">
                <a href="{{ url('blogs') }}">Blogs</a>
              </li>
              <li class="{{ request()->is('vlogs') ? 'active' : '' }}">
                <a href="{{ url('vlogs') }}">Vlogs</a>
              </li>
              <li class="{{ request()->is('faqs') ? 'active' : '' }}">
                <a href="{{ url('faqs') }}">FAQ</a>
              </li>
              <li class="{{ request()->is('about-us') ? 'active' : '' }}">
                <a href="{{ url('about-us') }}">About Us</a>
              </li>
              <li class="{{ request()->is('contact-us') ? 'active' : '' }}">
                <a href="{{ url('contact-us') }}">Contact</a>
              </li>
              @forelse(App\Models\DynamicPage::where('placed_in','header_menu')->where('slug','!=','about-us')->get() as $dynamicPage)
              <li class="{{ request()->is($dynamicPage->slug) ? 'active' : '' }}">
                <a href="{{url($dynamicPage->slug)}}">{{ucfirst($dynamicPage->title)}}</a>
              </li>
              @empty
              @endforelse
            </ul>
          </div>
          <div class="header-right d-flex align-items-center">
            <div class="header-logo d-lg-none">
              <a href="{{route('home')}}">
                <img src="{{ asset('/'.$appSetting->app_logo) }}" alt="Logo">
              </a>
            </div>
            <div class="header-right-item" >
              <div class="search-icon search-toggle" id="form-open">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <a href="javascript:void(0)" class="mobile-side-menu-toggle d-lg-none"><i
                class="fa-solid fa-bars"></i></a>
                <div class="search-holder">
                  <form id="search-form" class="search-form" action="{{route('packages')}}" method="get">
                    <input type="text" name="search" placeholder="Type your keyword(s)" class="search-input">
                    <button type="submit" id="form-submit" class="search-toggle">
                      <i class="fa fa-search"></i>
                    </button>
                    <button type="reset" id="form-close" class="search-close">
                      <i class="fa fa-times"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.header-right -->
          </div>
          <!-- /.header-menu-wrap -->
        </div>
        <!-- /.primary-header-inner -->
      </div>
      <!-- /.primary-header -->
    </div>
  </header>
  <!-- /.Main Header -->

  <div id="popup-search-box">
    <div class="box-inner-wrap d-flex align-items-center">
      <form id="form" class="popup-search" action="#" method="get" role="search">
        <input id="popup-search" type="text" name="s" placeholder="Search here...">
        <button id="popup-search-button" type="submit" name="submit"></button>
      </form>
    </div>
  </div>
  <!-- /#popup-search-box -->

  <div class="signin-box modal fade" id="signModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="bg"></div>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="signin-body-wrap">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class="signin-carousel-wrapper">
                  <div class="signin-carousel swiper">
                    <div class="swiper-wrapper swiper-container">
                      <div class="swiper-slide">
                        <div class="signin-item">
                          <div class="signin-thumb">
                            <img src="{{asset('img/images/sign-up-img.png')}}" alt="sign">
                          </div>
                          <div class="signin-left-content text-center">
                            <h3 class="title">Customizable Multipurpose Dashboard</h3>
                            <p>
                              Everything you need in an easily customizable dashboard.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="signin-item">
                          <div class="signin-thumb">
                            <img src="{{asset('img/images/sign-up-img.png')}}" alt="sign">
                          </div>
                          <div class="signin-left-content text-center">
                            <h3 class="title">Customizable Multipurpose Dashboard</h3>
                            <p>
                              Everything you need in an easily customizable dashboard.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Carousel Dots -->
                  <div class="swiper-pagination"></div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="signin-form-box">
                  <h3 class="title">Sign in</h3>
                  <h4 class="account">New user? <a href="sign-up.html">Create an account</a></h4>
                  <div class="signin-form">
                    <div class="mail-form">
                      <input type="email" id="email-2" name="email" class="form-control"
                      placeholder="Phone / Email address">
                    </div>
                    <button class="pxs-primary-btn">Continue</button>
                  </div>
                  <div class="signup-btn-box">
                    <div class="separator title-border">
                      <span>Or</span>
                    </div>
                    <a href="#" class="signup-btn google">
                      <img src="{{asset('img/icon/google-icon.png')}}" alt="icon">Continue with
                      google
                    </a>
                    <a href="#" class="signup-btn facebook">
                      <img src="{{asset('img/icon/facebook-icon.png')}}" alt="icon">Continue with
                      google
                    </a>
                    <a href="#" class="signup-btn apple">
                      <img src="{{asset('img/icon/apple-icon.png')}}" alt="icon">Continue with
                      google
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ./ sign-in-box -->

  <div class="mobile-side-menu">
    <div class="side-menu-content">
      <div class="side-menu-head">
        <button class="mobile-side-menu-close"><i class="fa fa-times"></i></button>
      </div>
      <div class="side-menu-wrap"></div>
    </div>
  </div>
  <!-- /.mobile-side-menu -->
  <div class="mobile-side-menu-overlay"></div>
