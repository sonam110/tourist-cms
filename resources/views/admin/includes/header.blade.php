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
                @can('file-upload-browse')
                <div class="dropdown d-none d-md-flex" data-container="body" data-toggle="popover" data-popover-color="default" data-placement="left" data-content="Uploaded images" data-original-title="">
					<a href="javascript:;" data-toggle="modal" data-target="#fileUpload" data-type="default"  class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-image"></i>
					</a>
				</div>
				@endcan
				
				<div class="dropdown d-none d-md-flex " >
					<a  class="nav-link icon full-screen-link">
						<i class="mdi mdi-arrow-expand-all"  id="fullscreen-button"></i>
					</a>
				</div>
				<div class="dropdown">
					<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
						<span class="avatar avatar-md brround"><img src="{{url('/')}}/{{auth()->user()->profile_image}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround" onerror="this.onerror=null;this.src='{{ url('/') }}/{{ $appSetting->app_logo }}';"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
						<div class="text-center">
							<a href="#" class="dropdown-item text-center font-weight-sembold user">{{Auth::user()->name}}</a>

							<div class="dropdown-divider"></div>
						</div>
						<a class="dropdown-item @if(Request::segment(2)==='edit-profile') active @endif" href="{{ route('edit-profile') }}">
							<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
						</a>
						@can('app-setting-update')
						<a class="dropdown-item @if(Request::segment(2)==='app-setting') active @endif" href="{{ route('app-setting') }}">
							<i class="dropdown-icon  mdi mdi-settings"></i> 
							App Setting
						</a>
						<a class="dropdown-item @if(Request::segment(2)==='home-page') active @endif" href="{{ route('home-page') }}">
							<i class="dropdown-icon  fa fa-home"></i> 
							Home Page
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
function removeImage(id, index) {
	if(confirm("Are you sure you want to delete this image?")) {
		$.ajax({
            url: '{{ route("file-upload-image-delete") }}', // Add your route here
            type: 'DELETE',
            data: {
            	_token: '{{ csrf_token() }}',
            	id: id
            },
            success: function(response) {
            	if(response.success) {
                    // Remove the image from the DOM
                    $('#image-' + index).remove();
                    showAlert('success', response.message);
                } else {
                	showAlert('danger', response.message);
                }
            },
            error: function(xhr) {
            	showAlert('danger', 'failed to remove image');
            }
        });
	}
}

function showAlert(type, message) {
	var alertContainer = $('#alert-container');
	var alertHtml = `
	<div class="alert alert-${type} alert-dismissible fade show" role="alert">
	<strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
	</div>
	`;
	alertContainer.html(alertHtml);

	setTimeout(function() {
		$('.alert').fadeOut('slow', function() {
			$(this).remove();
		});
	}, 5000);
}

function copyImageUrl(url, index) {
        // Use the clipboard API to copy the URL
        navigator.clipboard.writeText(url).then(function() {
            // Change the text to "URL Copied"
            document.getElementById('copy-url-' + index).innerHTML = ' URL Copied';
            
            // Optionally, revert the text after some delay
            setTimeout(function() {
            	document.getElementById('copy-url-' + index).innerHTML = ' Copy Url';
            }, 10000); // Revert text after 3 seconds
        }).catch(function(error) {
        	console.error('Failed to copy URL:', error);
        });
    }
</script>
