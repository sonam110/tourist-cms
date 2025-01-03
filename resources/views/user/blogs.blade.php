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
						@if(Request::segment(2) === 'edit-blog' || Request::segment(2) === 'add-blog')
						@if(Request::segment(2) === 'add-blog')
						<?php
						$id           = '';
						$title        = '';
						$categories   = [];
						$content      = '';
						$image_path   = 'assets/img/noimage.jpg';
						$order_number = '';
						$seo_key      = '';
						?>
						@else
						<?php
						$id           = $blog->id;
						$title        = $blog->title;
						$categories   = json_decode($blog->categories);
						$content      = $blog->content;
						$image_path   = $blog->image_path;
						$seo_key      = $blog->seo_key;
						?>
						@endif

						<form id="blog-save-form" action="{{ route('user.blog-save') }}" method="POST" class="booking-information" enctype="multipart/form-data">
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

							<!-- Content -->
							<div class="booking-item mb-30">
								<h3 class="booking-title">Content</h3>
								<div class="booking-form">
									<textarea name="content" id="content" class="form-control ckeditor  @error('content') is-invalid @enderror" rows="10" placeholder="Enter your content">{{ $content }}</textarea>
									@if ($errors->has('content'))
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('content') }}</strong>
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
								<h3 class="user-title">My Blogs List</h3>
								<a href="{{url('user/add-blog')}}" class="edit-btn"><i class="fa fa-plus"></i> Add Blog</a>
							</div>
						</div>
						<hr>
						<div class="booking-tab">
							<div class="bookmark-item-wrap">
								@forelse($blogs as $blog)
								<div class="bookmark-item">
									<div class="bookmark-thumb">
										<img src="{{asset('/'.$blog->image_path)}}" alt="{{$blog->title}}" />
										<!-- <div class="bookmark-shape"></div> -->
										<div class="bookmark-text">
											<span>
												<i class="fa-solid fa-eye"></i> {{$blog->views}} views
											</span>
										</div>
									</div>
									<div class="bookmark-content">
										<div class="bookmark-top-content">
											<div class="bookmark-left">
												<h3 class="bookmark-title">{{$blog->title}}</h3>
												<div class="left-box">
													@forelse($blog->categoryLists as $category)
													<span><i class="fas fa-concierge-bell"></i>{{$category->name}}</span>
													@empty
													@endforelse
												</div>
											</div>
											<div class="booking-right">
												<a href="{{route('blog-detail',$blog->slug)}}" class="pxs-primary-btn"><i class="fa-regular fa-eye"></i>View</a>
											</div>
										</div>
										<div class="booking-bottom-content">
											@php
											$content = strip_tags($blog->content);
											$limit = 200; // Set the character limit
											$limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
											@endphp

											{!! $limitedContent !!}
											<hr>
										</div>
										<div class="booking-bottom-content">
											<div class="bottom-items">
												<div class="booking-rating">
													<i class="fa-solid fa-message"></i>{{$blog->comments_count}} Comments
												</div>
												<div class="booking-rating">
													<i class="fa-solid fa-atlas btn-primary"></i>{{$blog->views}} Views
												</div>
												<a href="{{route('user.blog-edit',$blog->slug)}}" class="remove-btn"><i class="fa-regular fa-pencil text-success"></i>Edit</a>
												<a href="{{route('user.blog-delete',$blog->slug)}}" class="remove-btn" onclick="return alert('are you sure delete this blog?')"><i class="fa-solid fa-ban"></i>Remove</a>
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
<script type="text/javascript">
    document.querySelectorAll('.ckeditor').forEach(function(textarea) {
        CKEDITOR.replace(textarea);
    });
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