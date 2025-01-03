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
							<div class="booking-tab">
								<nav>
									<div class="nav nav-tabs" id="nav-tab" role="tablist">
										<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
										data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
										aria-selected="true">
										<i class="fa-solid fa-hotel"></i>My Bookings </button>
									</div>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
										<div class="tab-table">
											<div class="bookmark-item-wrap">
											@forelse($bookings as $booking)
											<div class="bookmark-item">
											    <div class="bookmark-thumb">
											        <img src="{{@asset($booking->package->images[0]->image_path)}}" alt="{{@$booking->package->package_name}}" />
											        @if(!empty($booking->coupon_code_discount))
											        <div class="bookmark-shape"></div>
											        <div class="discount-box">
											            <h4 class="discount">{{$booking->coupon_code_discount}} <span>Discount</span></h4>
											        </div>
											        @endif
											        <div class="bookmark-text">
											            <span>
											            	@if($booking->status == '1')
										                    Verified
										                    @elseif($booking->status == '2')
										                    Processed
										                    @elseif($booking->status == '3') 
										                    Rejected
										                    @else 
										                    Pending
										                    @endif
											            </span>
											        </div>
											    </div>
											    <div class="bookmark-content">
											        <div class="bookmark-top-content">
											            <div class="bookmark-left">
											                <h3 class="bookmark-title">{{$booking->package_name}}</h3>
											                <div class="left-box">
											                    <h4 class="price">{{$booking->city_of_departure}} {{$booking->price}} <span>{{($booking->price<$booking->payable_amount) ? $booking->city_of_departure.' '.$booking->payable_amount : null}}</span></h4>
											                    <span><i class="fa-solid fa-location-dot"></i>{{$booking->destination_name}}</span>

											                    <span><i class="fa-solid fa-calendar"></i>{{$booking->start_date}} @if(!empty($booking->end_date)) - {{$booking->end_date}} @endif</span>
											                    
											                </div>
											            </div>
											            <div class="booking-right">
											                <a href="{{route('package-detail',$booking->package->slug)}}" class="pxs-primary-btn"><i class="fa-regular fa-eye"></i>View</a>
											            </div>
											        </div>
											        <div class="booking-bottom-content">
											            <ul class="booking-list">
											                <li>Adults : {{$booking->number_of_adults}}</li>
											                <li>Children : {{$booking->number_of_children}}</li>
											                <li>Infants : {{$booking->number_of_infants}}</li>
											            </ul>
											            <div class="bottom-items">
											                {{--
											                <div class="booking-rating">
											                    <i class="fa-solid fa-star"></i>{{@$booking->package->rating}} <span>({{@$booking->package->reviews->count()}} reviews)</span>
											                </div>
											                --}}
											                @if($booking->status == '1')
										                    <a href="#" class="badge badge-success"><i class="fa-solid fa-info"></i> <span class="">Verified</span></a>
										                    @elseif($booking->status == '2')
										                    <a href="#" class="badge badge-info"><i class="fa-solid fa-info"></i> <span class="">Processed</span></a>
										                    @elseif($booking->status == '3') 
										                    <a href="#" class="badge badge-danger"><i class="fa-solid fa-info"></i> <span class="">Rejected</span></a>
										                    @else 
										                    <a href="#" class="badge badge-warning"><i class="fa-solid fa-info"></i> <span class="">Pending</span></a>
										                    @endif
											            </div>
											        </div>
											    </div>
											</div>
											@empty
											@endforelse
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
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