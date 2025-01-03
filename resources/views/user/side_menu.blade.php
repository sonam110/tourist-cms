<div class="" id="user-banner-pic">
  @if(!empty(Auth::user()->banner_image))
    <img class="banner_image" src="{{asset(Auth::user()->banner_image)}}" alt="{{Auth::user()->name}}" style="width: 100%; height: 250px;" />
    @else
    <img class="banner_image" src="{{asset('img/images/account-cover-img.jpg')}}" alt="banner_image" >
    @endif
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-4">
        <div class="account-information">
          <div class="account-user text-center">
            <div class="user-thumb" id="user-profile-pic">
              <img src="{{asset('/'.Auth::user()->profile_image)}}" alt="{{Auth::user()->name}}" />
            </div>
            <h3 class="user-name">{{Auth::user()->name}}</h3>
          </div>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{route('user.dashboard')}}"> <i class="fa-regular fa-user"></i>My Account
              </a>
            </li>
            <li class="nav-item " role="presentation">
              <a class="nav-link {{ request()->is('user/bookings') ? 'active' : '' }}" href="{{route('user.bookings')}}"> <i class="fa-regular fa-calendar"></i>My Bookings
              </a>
            </li>
            <li class="nav-item" role="presentation">
            	<a class="nav-link {{ request()->is('user/blogs-list') ? 'active' : '' }}" href="{{route('user.blogs-list')}}"> <i class="fa-regular fa-pencil"></i>My Blogs
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link {{ request()->is('user/vlogs-list') ? 'active' : '' }}" href="{{route('user.vlogs-list')}}"> <i class="fa-regular fa-video-camera"></i>My Vlogs
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link {{ request()->is('user/edit-profile') ? 'active' : '' }}" href="{{route('user.edit-profile')}}"><i class="fa-solid fa-unlock"></i>Edit Profile</a>
            </li>
            <li class="nav-item" role="presentation">
              <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link" aria-controls="logout"
                aria-selected="false"> <i class="fa-solid fa-lock"></i> Sign Out </button> 
              </form>
            </li>
          </ul>
        </div>
      </div>