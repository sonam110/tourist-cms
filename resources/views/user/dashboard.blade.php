@extends('layouts.master-front')
@section('content')


<section class="account-section padding">
	<!-- <div class="account-cover">
		<img src="{{asset('img/images/account-cover-img.jpg')}}" alt="cover" />
		<a href="#" class="cover-btn"><i class="fa-solid fa-pencil"></i>Edit cover</a>
	</div>
	<div class="container">
		<div class="row"> -->
			@include('user.side_menu')
			<div class="col-lg-9 col-md-8">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="author-information-right">
							<div class="user-name-box">
								<h3 class="user-title"> Hi {{$user->name}}</h3>
								<a href="{{url('user/edit-profile')}}" class="edit-btn">Edit your profile</a>
							</div>
							<ul class="information-list">
								<li>
									<h3 class="list-left">
										<i class="fa-solid fa-house"></i><span
										class="list-left-title">Address</span>
									</h3>
									<span>{{$user->address ?? 'Not Available'}}</span>
								</li>
							</ul>
							<ul class="information-list">
								<li>
									<h3 class="list-left">
										<i class="fa-solid fa-route"></i><span class="list-left-title">Mobile
										Number</span>
									</h3>
									<span><a href="tel:{{$user->country_code}} {{$user->mobile}}">{{$user->country_code}} {{$user->mobile}}</a></span>
								</li>
								<li>
									<h3 class="list-left">
										<i class="fa-regular fa-envelope"></i><span class="list-left-title">Email
										Address</span>
									</h3>
									<span><a href="mailto:artemis@gmail.com">{{$user->email}}</a></span>
								</li>
							</ul>
						</div>
					</div>
					<div class="tab-pane fade" id="myBooking" role="tabpanel" aria-labelledby="myBooking-tab">
						<div class="booking-tab">
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
									data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
									aria-selected="true">
									<i class="fa-solid fa-hotel"></i>Booking </button>
								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<div class="bookmark-item-wrap">
										<div class="bookmark-item">
											<div class="bookmark-thumb">
												<img src="{{asset('img/images/bookmark-img-1.jpg')}}" alt="bookmark" />
												<div class="bookmark-shape"></div>
												<div class="discount-box">
													<h4 class="discount">50% <span>Discount</span></h4>
												</div>
												<div class="bookmark-text">
													<span>Feature</span>
												</div>
												<a href="#"><i class="fa-solid fa-camera"></i>10</a>
											</div>
											<div class="bookmark-content">
												<div class="bookmark-top-content">
													<div class="bookmark-left">
														<h3 class="bookmark-title">Gorgeous House Hotel</h3>
														<div class="left-box">
															<h4 class="price">$7600 <span>$4500</span></h4>
															<span><i class="fa-solid fa-location-dot"></i>70 Bright St New
															Your, USA</span>
														</div>
													</div>
													<div class="booking-right">
														<a href="event-details.html" class="pxs-primary-btn"><i class="fa-regular fa-eye"></i>View</a>
													</div>
												</div>
												<div class="booking-bottom-content">
													<ul class="booking-list">
														<li><img src="{{asset('img/icon/single-bed.png')}}" alt="icon" />2</li>
														<li><img src="{{asset('img/icon/shower.png')}}" alt="icon" />1</li>
														<li><img src="{{asset('img/icon/user.png')}}" alt="icon" />2</li>
														<li><img src="{{asset('img/icon/scale.png')}}" alt="icon" />106 sqft</li>
													</ul>
													<div class="bottom-items">
														<div class="booking-rating">
															<i class="fa-solid fa-star"></i>4.8 <span>(12 reviews)</span>
														</div>
														<a href="#" class="remove-btn"><i class="fa-solid fa-ban"></i>Remove</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-table">
										<table class="table NRTInc-table">
											<thead>
												<tr>
													<th scope="col">Title</th>
													<th scope="col">Order Date</th>
													<th scope="col">Execution Time</th>
													<th scope="col">Total</th>
													<th scope="col">Paid</th>
													<th scope="col">Remain</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row">River Sight</th>
													<td>01/10/2022</td>
													<td>1 night</td>
													<td>$999</td>
													<td>$500</td>
													<td>$499</td>
													<td>
														<a href="#" class="table-btn btn-1"><i class="fa-solid fa-circle-exclamation"></i>Details</a>
														<a href="#" class="table-btn"><i class="fa-solid fa-file-invoice"></i>invoice</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="bookmark" role="tabpanel" aria-labelledby="bookmark-tab">
						<div class="booking-tab">
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<button class="nav-link active" id="nav-blog-tab" data-bs-toggle="tab" data-bs-target="#nav-blog" type="button" role="tab" aria-controls="nav-blog" aria-selected="true">
									<i class="fa-solid fa-hotel"></i>Blogs </button>
									<button class="nav-link" id="nav-vlog-tab" data-bs-toggle="tab"
									data-bs-target="#nav-vlog" type="button" role="tab"
									aria-controls="nav-vlog" aria-selected="false">
									<i class="fa-solid fa-calendar-days"></i>Vlogs </button>
									
								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-blog" role="tabpanel" aria-labelledby="nav-blog-tab">
									<div class="bookmark-item-wrap">
										@forelse($blogs as $blog)
										<div class="bookmark-item">
											<div class="bookmark-thumb">
												<img src="{{asset('/'.$blog->image_path)}}" alt="bookmark" />
												<div class="bookmark-shape"></div>
												<!-- <div class="discount-box">
													<h4 class="discount">50% <span>Discount</span></h4>
												</div> -->
												<div class="bookmark-text">
													<span>{{@$blog->categoryLists->first()->name}}</span>
												</div>
											</div>
											<div class="bookmark-content">
												<div class="bookmark-top-content">
													<div class="bookmark-left">
														<h3 class="bookmark-title">{{$blog->title}}</h3>
														<div class="left-box">
															@forelse($blog->categoryLists as $category)
															<span><i class="fa-solid fa-location-dot"></i>{{$category->name}}</span>
															@empty
															@endforelse
														</div>
													</div>
													<div class="booking-right">
														<a href="{{route('blog-detail',$blog->slug)}}" class="pxs-primary-btn"><i class="fa-regular fa-eye"></i>View</a>
													</div>
												</div>
												<div class="booking-bottom-content">
													<div class="bottom-items">
														<div class="booking-rating">
															<i class="fa-solid fa-message"></i>{{$blog->comments_count}} 
														</div>
														<div class="booking-rating">
															<i class="fa-solid fa-eye"></i> ({{$blog->views}} views)
														</div>
														<a href="{{url('user/blog-edit/'.$blog->id)}}" class="remove-btn"><i class="fa-solid fa-pencil"></i>Edit</a>
														<a href="{{url('user/blog-delete/'.$blog->id)}}" class="remove-btn"><i class="fa-solid fa-ban"></i>Remove</a>
													</div>
												</div>
											</div>
										</div>
										@empty
										@endforelse
									</div>
								</div>
								<div class="tab-pane fade" id="nav-vlog" role="tabpanel" aria-labelledby="nav-vlog-tab">
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<form id="update-profile-form" action="{{ route('user.update-profile') }}" class="booking-information" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-8">
									<div class="booking-item  mb-30">
										<h3 class="booking-title">Full Name</h3>
										<div class="booking-form">
											<input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" placeholder="Enter your name" required=""/>
										</div>
									</div>
									<div class="booking-item mb-30">
										<h3 class="booking-title">Email Address</h3>
										<div class="booking-form">
											<input type="email" id="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Enter your Email"/>
										</div>
									</div>
									<div class="booking-item mb-30">
										<h3 class="booking-title">Phone Number</h3>
										<div class="booking-form">
											<input type="text" id="mobile" name="mobile" class="form-control" value="{{$user->mobile}}" placeholder="Enter mobile number"/>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="booking-item mb-30">
										<h3 class="booking-title">Profile Image</h3>
										<div class="mt-3">
											<img id="profile-image-preview" src="{{asset('/'.$user->profile_image)}}" alt="Profile Image Preview" style="max-width: 100%;height: 226px;width: 100%;"/>
										</div>
										<br>
										<div class="booking-form">
											<input type="file" id="profile_image" name="profile_image" class="form-control"/>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="booking-item address mb-30">
										<h3 class="booking-title">Address</h3>
										<div class="booking-form">
											<div class="form-group">
												<textarea id="address" name="address" cols="30" rows="5" class="form-control address" placeholder="Enter your address">{{$user->address}}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">

								<div id="alert-container"></div>
								<div class="booking-item text-center">
									<button type="submit" class="pxs-primary-btn">Update</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ./account-section -->
<script>
	$(document).ready(function() {
        // Handle profile form submission
        $('#update-profile-form').on('submit', function(e) {
        	e.preventDefault();

        	var formData = new FormData(this);

        	$.ajax({
        		url: $(this).attr('action'),
        		type: 'POST',
        		data: formData,
        		contentType: false,
        		processData: false,
        		success: function(response) {
        			if (response.status === 'success') {
        				$('#user-profile-pic').html(
        					`<img src="${response.profile_image_url}" alt="user" />`
        					);
        				showAlert('success', response.message);
        			} else {
        				showAlert('danger', response.message || 'Failed to update profile, please try again.');
        			}
        		},
        		error: function(xhr) {
        			if (xhr.status === 422) {
        				var errors = xhr.responseJSON.errors;
        				var errorMessages = '';
        				$.each(errors, function(key, value) {
        					errorMessages += value[0] + '<br>';
        				});
        				showAlert('danger', errorMessages);
        			} else {
        				var message = xhr.responseJSON && xhr.responseJSON.message;
        				showAlert('danger', message ? message : 'An error occurred. Please try again.');
        			}
        		}
        	});
        });

        // Handle profile image preview
        $('#profile_image').on('change', function() {
        	var file = this.files[0];
        	if (file) {
        		var reader = new FileReader();
        		reader.onload = function(e) {
        			$('#profile-image-preview').attr('src', e.target.result);
        			$('#profile-image-preview').show();
        		}
        		reader.readAsDataURL(file);
        	} else {
        		$('#profile-image-preview').hide();
        	}
        });

        // Show alert function
        function showAlert(type, message) {
        	var alertContainer = $('#alert-container');
        	var alertHtml = `
        	<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        	<strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
        	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        	</div>
        	`;
        	alertContainer.html(alertHtml);

        	setTimeout(function() {
        		$('.alert').fadeOut('slow', function() {
        			$(this).remove();
        		});
        	}, 10000);
        }
    });
</script>


@endsection