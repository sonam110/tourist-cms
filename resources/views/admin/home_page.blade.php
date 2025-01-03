@extends('admin.layouts.master')
@section('content')

<form action="{{ route('home-page-update') }}" method="POST" class="card" enctype="multipart/form-data">
	@csrf

	<div class="row row-deck">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Home Page Settings</h3>
			</div>

			<div class="card-body row">
				<!-- Other fields... -->
				<div class="form-group col-md-6">
					<label class="form-label" for="title">Title</label>
					<input type="text" class="form-control" name="title" value="{{ old('title', $homePage->title) }}" placeholder="Enter Title" required>
				</div>
				<div class="form-group col-md-6">
					<label class="form-label" for="sub_title">Sub Title</label>
					<input type="text" class="form-control" name="sub_title" value="{{ old('sub_title', $homePage->sub_title) }}" placeholder="Enter Sub Title">
				</div>
				<div class="form-group col-md-12">
					<label class="form-label" for="short_description">Short Description</label>
					<textarea class="form-control" name="short_description" placeholder="Enter Short Description">{{ old('short_description', $homePage->short_description) }}</textarea>
				</div>

				<!-- Image Path -->
				<div class="form-group col-md-12">
					<div class="row">
						<div class="col-md-6">
							<h4>Hero Images ( W:350 H:250 in PX)</h4>
						</div>
						<div class="text-right col-md-6">
							<button type="button" class="btn btn-outline-success btn-sm" onclick="addNewImageUpload()">Add More Images</button>
						</div>
					</div>
					<hr>
					
					<div id="image-upload-section" class=" row">
						@if(!empty($homePage->image_path))
						@foreach(json_decode($homePage->image_path) as $key => $image)
						<div class="fileupload fileupload-new mb-3 col-md-3" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100%; height: 200px;">
								<img id="hero-image-preview-{{ $key+1 }}" src="{{ asset($image) }}" alt="Hero Image {{ $key+1 }}" style="width: 100%; height: auto;">
							</div>
							<input type="hidden" name="image_path[]" value="{{ $image }}">
							<span class="btn btn-outline-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
								<input type="file" name="image_path[]" id="image_path_{{ $key+1 }}" accept="image/*" onchange="readURL1(this, 'hero-image-preview-{{ $key+1 }}')">
							</span>
							<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeHeroImage(this, '{{ $image }}')">Remove Image</button>
						</div>
						@endforeach
						@endif
					</div>
				</div>
				<br>

				<div class="form-group col-md-4">
					<label class="form-label" for="banner_image_path">Banner Image</label>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="width: 100%; height: 200px;">
							<img id="banner-image-preview" src="{{ asset($homePage->banner_image_path) }}" alt="Banner Image" style="width: 100%; height: auto;">
						</div>
						<input type="hidden" name="banner_image_path" value="{{ $homePage->banner_image_path }}">
						<span class="btn btn-outline-primary btn-file btn-sm">
							<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Banner Image</span>
							<input type="file" name="banner_image_path" id="banner_image_path" accept="image/*" onchange="readURL(this, 'banner-image-preview')">
						</span>
						@if(!empty($homePage->banner_image_path))
						<span>
							<!-- Button to remove Banner image -->
							<button type="button" class="btn btn-outline-danger  btn-sm" id="remove-banner-image-btn" onclick="removeBannerImage()">Remove Image</button>

						</span>
						@endif
					</div>
				</div>

				<!-- Video Path -->
				<div class="col-md-8">
					<div class="form-group">
						<label class="form-label" for="video_path">Video URL</label>
						<input type="text" class="form-control" name="video_path" value="{{ old('video_path', $homePage->video_path) }}" placeholder="Enter Video URL">
					</div>
					<div class="form-group">
						<!-- Duration -->
						<label class="form-label" for="duration">Tag Line</label>
						<input type="text" class="form-control" name="duration" value="{{ old('duration', $homePage->duration) }}" placeholder="Enter Tag Line">
					</div>
					<div class="form-group">

						<label class="form-label" for="background_video_url">Background Video Url</label>
						<input type="text" class="form-control" name="background_video_url" value="{{ old('background_video_url', $homePage->background_video_url) }}" placeholder="Enter Title">
					</div>
				</div>

				<!-- Promo Section -->
				<div class="form-group col-sm-12">
					<div class="row">
						<div class="col-md-6">
							<h4>Promo Section</h4>
						</div>
						<div class="text-right col-md-6">
							<button type="button" class="btn btn-outline-primary mt-3" id="add-promo-item"><i class="fa fa-plus"></i> Add Promo Item</button>
						</div>
					</div>
					<hr>
					<div id="promo-fields-container">
						@if(old('promo', json_decode($homePage->promo)))
						@foreach(json_decode($homePage->promo) as $index => $promoItem)
						<div class="promo-item row align-items-end mb-3" data-index="{{ $index }}">
							<div class="form-group col-md-3">
								<label class="form-label" for="promo[{{ $index }}][title]">Title</label>
								<input type="text" class="form-control" name="promo[{{ $index }}][title]" value="{{ $promoItem->title }}" placeholder="Enter Title">
							</div>
							<div class="form-group col-md-5">
								<label class="form-label" for="promo[{{ $index }}][description]">Description</label>
								<input class="form-control" name="promo[{{ $index }}][description]" placeholder="Enter Description" value="{{ $promoItem->description }}" />
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="fileupload-new thumbnail" style="width: 100px; height: 50px;">
											<img id="promo-icon-{{ $index }}" src="{{ asset($promoItem->icon_path) }}" alt="Icon Image" style="max-width: 100%; height: auto;"> 

											<input type="hidden" name="promo[{{ $index }}][existing_icon_path]" value="{{ $promoItem->icon_path }}">
										</div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Icon ( W:60 H:60 in PX)</span>
											<input type="file" name="promo[{{ $index }}][icon_path]" id="promo_icon_{{ $index }}" accept="image/*" onchange="readURL(this, 'promo-icon-{{ $index }}')">
										</span>
									</div>
								</div>
							</div>
							<div class="form-group col-md-1 text-right">
								<i type="i" class="btn btn-danger remove-promo-item fa fa-times" style="margin-top: 28px;"></i>
							</div>
						</div>
						@endforeach
						@endif
					</div>
				</div>

				<div class="col-md-12">
					<h4>Destination  Section</h4>
					<hr>
				</div>

				<div class="form-group col-sm-12">
					<div id="destination-fields-container">
						@if(old('destination', json_decode($homePage->destination)))
						@foreach(json_decode($homePage->destination) as $index => $destinationItem)
						@if($index % 3 === 0)
						<div class="row mb-3">
							@endif
							<div class="col-md-4" data-index="{{ $index }}">
								<div class="form-group">
									<label class="form-label" for="destination[{{ $index }}][destination]">Destination {{$index + 1}}</label>
									<input type="text" class="form-control" name="destination[{{ $index }}][destination]" value="{{ $destinationItem->destination }}" placeholder="Enter Destination">
								</div>
								<div class="form-group">
									<label class="form-label" for="destination[{{ $index }}][country]">Country</label>
									<input type="text" class="form-control" name="destination[{{ $index }}][country]" value="{{ $destinationItem->country }}" placeholder="Enter Country">
								</div>
								<div class="form-group">
									<label class="form-label" for="destination[{{ $index }}][rating]">Rating</label>
									<input type="number" class="form-control" step="0.1" name="destination[{{ $index }}][rating]" value="{{ $destinationItem->rating }}" placeholder="Enter Rating">
								</div>
								<div class="form-group">
									<label class="form-label" for="destination[{{ $index }}][bottom_title]">Bottom Title</label>
									<input type="text" class="form-control" step="0.1" name="destination[{{ $index }}][bottom_title]" value="{{ $destinationItem->bottom_title }}" placeholder="Enter Bottom Title">
								</div>
								<div class="form-group">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="fileupload-new thumbnail" style="width: 150px; height: 100px;">
											<img id="destination-image-{{ $index }}" src="{{ asset($destinationItem->image_path) }}" alt="Image" style="max-width: 100%; height: auto;"> 
											<input type="hidden" name="destination[{{ $index }}][existing_image_path]" value="{{ $destinationItem->image_path }}">
										</div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
											<input type="file" name="destination[{{ $index }}][image_path]" id="destination_image_{{ $index }}" accept="image/*" onchange="readURL(this, 'destination-image-{{ $index }}')">
										</span>
									</div>
								</div>
							</div>
							@if(($index + 1) % 3 === 0 || $index === count(json_decode($homePage->destination)) - 1)
						</div>
						@endif
						@endforeach
						@endif
					</div>
				</div>

				<!-- Happy Customers Images Section -->
				<div class="form-group col-sm-12">
					<div class="row">
						<div class="col-md-6">
							<h4>Happy Customes Section</h4>
						</div>
						<div class="text-right col-md-6">
							<button type="button" class="btn btn-outline-primary" id="add-happy-customer-image"> <i class="fa fa-plus"></i>Add Customer Image</button>
						</div>
					</div>
					<hr>
					
					<div id="happy-customers-images-container" class="row">
						<div class="col-md-12">
							<label class="form-label" for="happy_customers_images">Happy Customers Images</label>
						</div>
						@if(old('happy_customers_images', json_decode($homePage->happy_customers_images, true)))
						@foreach(json_decode($homePage->happy_customers_images, true) as $index => $imagePath)
						<div class="col-md-3">
							<div class="form-group">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new thumbnail" style="width: 150px; height: 80px;">
										<img id="customer-image-{{ $index }}" src="{{ asset($imagePath) }}" alt="Customer Image" style="max-width: 100%; height: auto;">
										<input type="hidden" name="old_happy_customers_images[{{ $index }}]" value="{{ asset($imagePath) }}">
									</div>
									<div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
											<input type="file" name="happy_customers_images[{{ $index }}]" id="happy_customers_image_{{ $index }}" accept="image/*" onchange="readURL(this, 'customer-image-{{ $index }}')">
										</span>
										<i class="btn btn-danger remove-customer-image fa fa-times"></i>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						@endif
					</div>

					<div class="row">
						<div class="form-group col-sm-6">
							<label class="form-label" for="happy_customers_title">Happ Customers Title</label>
							<input type="text" class="form-control" name="happy_customers_title" value="{{ old('happy_customers_title', $homePage->happy_customers_title) }}" placeholder="Enter Happ Customers Title">
						</div>
						<div class="form-group col-sm-6">
							<label class="form-label" for="happy_customers_sub_title">Happ Customers subtitle</label>
							<input class="form-control" name="happy_customers_sub_title" value="{{ old('happy_customers_sub_title', $homePage->happy_customers_sub_title) }}" />
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<h4>Newsletter  Section</h4>

					<hr>
				</div>
				<div class="form-group col-sm-6">
					<label class="form-label" for="newsletter_video_path">Newsletter Video Path</label>
					<input type="text" class="form-control" name="newsletter_video_path" value="{{ old('newsletter_video_path', $homePage->newsletter_video_path) }}" placeholder="Enter Newsletter Video URL">
				</div>
				<div class="form-group col-sm-6">
					<label class="form-label" for="newsletter_title">Newsletter Title</label>
					<input type="text" class="form-control" name="newsletter_title" value="{{ old('newsletter_title', $homePage->newsletter_title) }}" placeholder="Enter Newsletter Title">
				</div>
				<div class="form-group col-sm-12">
					<label class="form-label" for="newsletter_description">Newsletter Description</label>
					<textarea class="form-control" name="newsletter_description">{{ old('newsletter_description', $homePage->newsletter_description) }}</textarea>
				</div>
				<div class="form-group col-sm-12">
					<label class="form-label" for="extra_description">Extra Description</label>
					<textarea class="form-control" name="extra_description">{{ old('extra_description', $homePage->extra_description) }}</textarea>
				</div>
				<!-- Checkboxes for Special, Featured, Blog, Testimonial, Activity, Newsletter -->
				<div class="form-group col-sm-2">
					<label class="form-label" for="special">Special</label>
					<input type="checkbox" name="special" {{ $homePage->special == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="featured">Featured</label>
					<input type="checkbox" name="featured" {{ $homePage->featured == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="blog">Blog</label>
					<input type="checkbox" name="blog" {{ $homePage->blog == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="testimonial">Testimonial</label>
					<input type="checkbox" name="testimonial" {{ $homePage->testimonial == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="activity">Activity</label>
					<input type="checkbox" name="activity" {{ $homePage->activity == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="newsletter">Newsletter</label>
					<input type="checkbox" name="newsletter" {{ $homePage->newsletter == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="happy_customers">Happy Customers</label>
					<input type="checkbox" name="happy_customers" {{ $homePage->happy_customers == 1 ? 'checked' : '' }}>
				</div>

				<div class="form-group col-sm-2">
					<label class="form-label" for="background_video_on">Background Video</label>
					<input type="checkbox" name="background_video_on" {{ $homePage->background_video_on == 1 ? 'checked' : '' }}>
				</div>

				<!-- Save Button -->
				<div class="form-group col-md-12 text-center">
					<button type="submit" class="btn btn-primary">Update Home Page</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	var promoIndex = {{ count(json_decode($homePage->promo)) }};
	var destinationIndex = {{ count(json_decode($homePage->destination)) }};
	var happyCustomerIndex = {{ count(json_decode($homePage->happy_customers_images)) }};

	function readURL(input, id) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById(id).src = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	// Add Promo Item
	function addPromoItem() {
		var promoFieldsContainer = document.getElementById('promo-fields-container');
		var newPromoItem = `
		<div class="promo-item row align-items-end mb-3" data-index="${promoIndex}">
		<div class="form-group col-md-3">
		<label class="form-label" for="promo[${promoIndex}][title]">Title</label>
		<input type="text" class="form-control" name="promo[${promoIndex}][title]" placeholder="Enter Title">
		</div>
		<div class="form-group col-md-5">
		<label class="form-label" for="promo[${promoIndex}][description]">Description</label>
		<input class="form-control" name="promo[${promoIndex}][description]" placeholder="Enter Description" />
		</div>
		<div class="col-md-3">
		<div class="form-group">
		<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="fileupload-new thumbnail" style="width: 100px; height: 50px;">
		<img id="promo-icon-${promoIndex}" src="#" alt="Icon Image" style="max-width: 100%; height: auto;"> 
		</div>
		<span class="btn btn-outline-primary btn-file">
		<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Icon</span>
		<input type="file" name="promo[${promoIndex}][icon_path]" id="promo_icon_${promoIndex}" accept="image/*" onchange="readURL(this, 'promo-icon-${promoIndex}')">
		</span>
		</div>
		</div>
		</div>
		<div class="form-group col-md-1 text-right">
		<i class="btn btn-danger remove-promo-item fa fa-times" style="margin-top: 28px;"></i>
		</div>
		</div>
		`;

		promoFieldsContainer.insertAdjacentHTML('beforeend', newPromoItem);
		promoIndex++;
	}

	// Add Happy Customer Image
	function addHappyCustomerImage() {
		var happyCustomersImagesContainer = document.getElementById('happy-customers-images-container');
		var newHappyCustomerImage = `
		<div class="col-md-3">
		<div class="form-group">
		<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="fileupload-new thumbnail" style="width: 150px; height: 80px;">
		<img id="customer-image-${happyCustomerIndex}" src="#" alt="Customer Image" style="max-width: 100%; height: auto;">
		</div>
		<div>
		<span class="btn btn-outline-primary btn-file">
		<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
		<input type="file" name="happy_customers_images[${happyCustomerIndex}]" id="happy_customers_image_${happyCustomerIndex}" accept="image/*" onchange="readURL(this, 'customer-image-${happyCustomerIndex}')">
		</span>
		<i class="btn btn-danger remove-customer-image fa fa-times"></i>
		</div>
		</div>
		</div>
		</div>
		`;

		happyCustomersImagesContainer.insertAdjacentHTML('beforeend', newHappyCustomerImage);
		happyCustomerIndex++;
	}

	document.getElementById('add-promo-item').addEventListener('click', addPromoItem);
	document.getElementById('add-happy-customer-image').addEventListener('click', addHappyCustomerImage);

	// Remove Promo Item
	document.addEventListener('click', function(e) {
		if (e.target && e.target.classList.contains('remove-promo-item')) {
			e.target.closest('.promo-item').remove();
		}
	});

	// Remove Customer Image
	document.addEventListener('click', function(e) {
		if (e.target && e.target.classList.contains('remove-customer-image')) {
			e.target.closest('.col-md-3').remove();
		}
	});

	

	function removeBannerImage() {
		if (confirm("Are you sure you want to remove the Baneer Image?")) {
			$.ajax({
	            url: '{{ route("remove-banner-image")}}',  // URL to your route that handles image removal
	            type: 'POST',
	            data: {
	                _token: '{{ csrf_token() }}',  // Include CSRF token for security
	                id: '{{ $homePage->id }}'      // Send the home page ID for identification
	            },
	            success: function(response) {
	            	if (response.success) {
	                    // Update the image preview to a default or blank image
	                    $('#banner-image-preview').attr('src', '');
	                    $('input[name="banner_image_path"]').val(''); // Clear the hidden input value
	                    alert('Image removed successfully.');
	                } else {
	                	alert('Failed to remove image. Please try again.');
	                }
	            },
	            error: function(xhr, status, error) {
	            	console.error(xhr.responseText);
	            	alert('An error occurred while removing the image.');
	            }
	        });
		}
	}

	let imageUploadCount = {{ !empty(json_decode($homePage->image_path)) ? count(json_decode($homePage->image_path)) : 0 }};
 // Track how many images are there

// Function to dynamically add more image upload fields
function addNewImageUpload() {
	imageUploadCount++;
	const uploadSection = document.getElementById('image-upload-section');
	const newUploadHtml = `
	<div class="fileupload fileupload-new mb-3 col-md-3" data-provides="fileupload">
	<div class="fileupload-new thumbnail" style="width: 100%; height: 200px;">
	<img id="hero-image-preview-${imageUploadCount}" src="#" alt="New Hero Image" style="width: 100%; height: auto;">
	</div>
	<span class="btn btn-outline-primary btn-file btn-sm">
	<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
	<input type="file" name="image_path[]" id="image_path_${imageUploadCount}" accept="image/*" onchange="readURL(this, 'hero-image-preview-${imageUploadCount}')">
	</span>
	<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeHeroImage(this)">Remove Image</button>
	</div>
	`;
	uploadSection.insertAdjacentHTML('beforeend', newUploadHtml);
}

// Function to preview the uploaded image
function readURL1(input, previewId) {
	if (input.files && input.files[0]) {
		const reader = new FileReader();
		reader.onload = function(e) {
			const preview = document.getElementById(previewId);
			preview.src = e.target.result;
			preview.style.display = 'block';
		};
		reader.readAsDataURL(input.files[0]);
	}
}

function removeHeroImage(button, imagePath = null) {
	if (confirm("Are you sure you want to remove this image?")) {
		if (imagePath) {
            // Handle removing an existing image on the server via AJAX
            $.ajax({
                url: '{{ route("remove-hero-image") }}',  // Your server-side route for image removal
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // CSRF token for security
                    id: '{{ $homePage->id }}',      // The home page ID or related identifier
                    image_path: imagePath          // The specific image path to be removed
                },
                success: function(response) {
                	if (response.success) {
                        // Remove the image preview and its container after successful server response
                        const fileuploadDiv = button.closest('.fileupload');
                        fileuploadDiv.remove();
                        alert('Image removed successfully.');
                    } else {
                    	alert('Failed to remove the image. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                	console.error(xhr.responseText);
                	alert('An error occurred while removing the image.');
                }
            });
        } else {
            // Handle removing a new image upload preview (not yet uploaded to the server)
            const fileuploadDiv = button.closest('.fileupload');
            fileuploadDiv.remove();
        }
    }
}



</script>

@endsection
