<div class="app-header header py-1 d-flex">
	<div class="container-fluid">
		<div class="d-flex">
			<a class="header-brand" href="{{route('dashboard')}}">
				<img src="{{url('/')}}/{{$appSetting->app_logo}}" class="front_header_logo" alt="" width="70px">
			</a>
			<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
			<!-- <div class="d-none d-lg-block horizontal">
				@if(Auth::user()->userType == 'admin')
				<ul class="nav">
					<li class="notification-icon" data-container="body" data-toggle="popover" data-popover-color="default" data-placement="left" data-content="Notification" data-original-title="">
						<div class="dropdown d-md-flex border-right">
							<a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
								<i class="fe fe-mail floating"></i>
								<span class=" nav-unread badge badge-warning  badge-pill">6</span>
							</a>
							@if(Auth::check())
							
							@endif
						</div>
					</li>
					
				</ul>
				@endif
			</div> -->
           <!--  <div class="d-flex order-lg-2 ml-auto">
				<a href="javascript:;" data-toggle="modal" class="btn btn-primary btn-block" data-target="#getImage" id="getImageId" data-type="default"  class="d-flex nav-link pr-0  mt-3 country-flag1" data-toggle="dropdown" aria-expanded="false">Get Images</a>
			</div> -->
			<div class="d-flex order-lg-2 ml-auto">
			<!-- <div class="dropdown d-none d-md-flex"  data-content="CLIENT ID" data-original-title="CLIENT ID">
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;"  class="" style="margin-top: 15px" >
					<i class="fa fa-user"></i> CLIENT ID :   <input type="text" class="form" value="{{Auth::user()->uuid}}" id="myInput" readonly="">

				</a>
				<button onclick="myFunction()"  style="height: 27px;margin-top: 15px" >Copy</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
			</div> -->
			<!-- <div class="dropdown d-none d-md-flex"  data-content="CLIENT ID" data-original-title="CLIENT ID">
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://www.nativv.tech/nativv-sdk-doc.php"   target="_blank" class="" style="margin-top: 15px" >
					<i class="fa fa-file"></i> Document
				</a>
				
			</div> -->
			
			<!-- 
				<div class="mt-2">
					<div class="searching mt-2 ml-2 mr-3">
						<a href="javascript:void(0)" class="search-open mt-3">
							<i class="fa fa-search text-dark"></i>
						</a>
						<div class="search-inline">
							<form>
								<input type="text" class="form-control" placeholder="Search here">
								<button type="submit">
									<i class="fa fa-search"></i>
								</button>
								<a href="javascript:void(0)" class="search-close">
									<i class="fa fa-times"></i>
								</a>
							</form>
						</div>
					</div>
				</div> -->
				
				<div class="dropdown d-none d-md-flex " >
					<a  class="nav-link icon full-screen-link">
						<i class="mdi mdi-arrow-expand-all"  id="fullscreen-button"></i>
					</a>
				</div>
				<div class="dropdown">
					<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
						<span class="avatar avatar-md brround"><img src="{{url('/')}}/{{$appSetting->logo_thumb_path}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
						<div class="text-center">
							<a href="#" class="dropdown-item text-center font-weight-sembold user">{{Auth::user()->name}}</a>

							<div class="dropdown-divider"></div>
						</div>
						<a class="dropdown-item @if(Request::segment(1)==='edit-profile') active @endif" href="{{ route('edit-profile') }}">
							<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
						</a>
						@can('app-setting-update')
						<a class="dropdown-item @if(Request::segment(1)==='app-setting') active @endif" href="{{ route('app-setting') }}">
							<i class="dropdown-icon  mdi mdi-settings"></i> 
							App Setting
						</a>
						@endcan
						<div class="dropdown-divider"></div>
						<!-- <a class="dropdown-item @if(Request::segment(1)==='need-help') active @endif" href="{{ route('need-help') }}">
							<i class="dropdown-icon fa fa-question-circle"></i> Help & Support?
						</a> -->
						<a class="dropdown-item" href="{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}">
							<i class="dropdown-icon fa fa-lock"></i> Screen Lock
						</a>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							<i class="dropdown-icon mdi  mdi-logout-variant"></i>
                            {{ __('Sign out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);
  
  /* Alert the copied text */
  //alert("Copied the client ID: " + copyText.value);
}
</script>