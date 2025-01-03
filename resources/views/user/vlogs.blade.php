@extends('layouts.master-front')
@section('extracss')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
@endsection
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
						<br>
						@if ($errors->any())
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif

						@if ($message = Session::get('success'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>Success!</strong> {{ $message }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif

						@if ($message = Session::get('error'))
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Error!</strong> {{ $message }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						@endif
						@if(Request::segment(2) === 'edit-vlog' || Request::segment(2) === 'add-vlog')
						@if(Request::segment(2) === 'add-vlog')
						<?php
						$id           = '';
						$title        = '';
						$categories   = [];
						$content      = '';
						$image_path   = 'assets/img/noimage.jpg';
						$video_path   = '';
						$order_number = '';
						$seo_key      = '';
						?>
						@else
						<?php
						$id           = $vlog->id;
						$title        = $vlog->title;
						$categories   = json_decode($vlog->categories);
						$content      = $vlog->content;
						$image_path   = $vlog->image_path;
						$video_path   = $vlog->video_path;
						$seo_key      = $vlog->seo_key;
						?>
						@endif

						<form id="vlog-save-form" action="{{ route('user.vlog-save') }}" method="POST" class="booking-information" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{ $id }}" class="form-control">

							<!-- Title -->
							<div class="booking-item mb-30">
								<h3 class="booking-title">Title</h3>
								<div class="booking-form">
									<input type="text" name="title" id="title" value="{{ $title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter your title" required>
									@if ($errors->has('title'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('title') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<!-- Video Path -->
							<div class="booking-item mb-30">
								<h3 class="booking-title">Video Path</h3>
								<div class="booking-form">
									<input type="text" name="video_path" id="video_path" value="{{ $video_path }}" class="form-control @error('video_path') is-invalid @enderror" placeholder="Enter Video Path" required>
									@if ($errors->has('video_path'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('video_path') }}</strong>
									</span>
									@endif
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="booking-item mb-30">
										<h3 class="booking-title">Categories</h3>
										<div class="booking-form">
											<select name="categories[]" id="categories" class="form-control select2"  data-placeholder="Select Categories" required style="width: 100%;">
												@foreach(App\Models\Category::all() as $cat)
												<option value="{{ $cat->id }}" {{ in_array($cat->id, $categories) ? 'selected' : '' }}>
													{{ $cat->name }}
												</option>
												@endforeach
											</select>
											@if ($errors->has('categories'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('categories') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="booking-item mb-30">
										<h3 class="booking-title">SEO Key</h3>
										<div class="booking-form">
											<input type="text" name="seo_key" id="seo_key" value="{{ $seo_key }}" class="form-control @error('seo_key') is-invalid @enderror" placeholder="Enter SEO key">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="booking-item mb-30">
										<h3 class="booking-title">Image</h3>
										<div class="mt-3 text-center">
											<img id="image-path-preview" src="{{asset('/'.$image_path)}}" alt="{{$title}}" style="height: 100px;"/>
										</div>
										<br>
										<div class="booking-form">
											<input type="file" name="image_path" id="image_path" class="form-control form-file" accept="image/*" />
											@if ($errors->has('image_path'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('image_path') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>
							</div>
							<!-- Submit Button -->
							<div class="row">
								<div id="alert-container"></div>
								<div class="booking-item text-center">
									<button type="submit" class="pxs-primary-btn">Save</button>
								</div>
							</div>
						</form>

						@else
						<div class="author-information-right">
							<div class="user-name-box">
								<h3 class="user-title">My Vlogs List</h3>
								<a href="{{url('user/add-vlog')}}" class="edit-btn"><i class="fa fa-plus"></i> Add Vlog</a>
							</div>
						</div>
						<hr>
						<div class="booking-tab">
							<div class="bookmark-item-wrap row">
								@forelse($vlogs as $vlog)
								<div class="col-lg-6 col-md-6">
									<div class="project-wrap wrap-1">
										<div class="project-box">
											<div class="project-thumb">
												<a href="javascript:;"><img src="{{asset($vlog->image_path)}}" alt="{{$vlog->title}}"></a>
												<div class="project-content">
													<h4><a href="event-details.html" class="project-title">{{$vlog->title}}</a>
													</h4>
													<span class="vlog-icons">
														<a href="{{route('user.vlog-edit',$vlog->slug)}}" class="remove-btn">&nbsp;<i class="fa-regular fa-pencil"></i> &nbsp; EDIT &nbsp;</a>
														<span class="float vlog-icons">
															<a href="{{route('user.vlog-delete',$vlog->slug)}}" class="remove-btn" onclick="return alert('are you sure delete this vlog?')">&nbsp;<i class="fa-regular fa-trash"></i> &nbsp; DELETE &nbsp; </a>
														</span>
													</span>
												</div>
												<div class="wow fade-in-bottom vlog-video" data-wow-delay="200ms">
													<a class="video-popup" data-autoplay="true" data-vbtype="video" href="{{$vlog->video_path}}"><i class="fa-solid fa-play"></i>

													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								@empty
								@endforelse
							</div>
							<div class="tab-content" id="nav-tabContent">

								<div class="tab-pane fade show active" id="nav-blog" role="tabpanel" aria-labelledby="nav-blog-tab">

								</div>
								<div class="tab-pane fade" id="nav-vlog" role="tabpanel" aria-labelledby="nav-vlog-tab">
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@section('extrajs')
<script type="importmap">
	{
		"imports": {
		"ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
		"ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
	}
}
</script>
<script type="module">
	import {
		ClassicEditor,
		Essentials,
		Paragraph,
		Bold,
		Italic,
		Font
	} from 'ckeditor5';

	ClassicEditor
	.create( document.querySelector( '#content' ), {
		plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
		toolbar: [
		'undo', 'redo', '|', 'bold', 'italic', '|',
		'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
		]
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( error => {
		console.error( error );
	} );
</script>

<script type="text/javascript">
	// Handle profile image preview
	$('#image_path').on('change', function() {
		var file = this.files[0];
		if (file) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#image-path-preview').attr('src', e.target.result);
				$('#image-path-preview').show();
			}
			reader.readAsDataURL(file);
		} else {
			$('#image-path-preview').hide();
		}
	});
</script>
@endsection

@endsection