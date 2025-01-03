<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
	@include('admin.includes.head')
	<script type="text/javascript">
		var appurl = '{{url("/")}}/';

	</script>
	@yield('extracss')
</head>
<body class="app sidebar-mini rtl">
	<div id="global-loader" ></div>
	<div class="page">
		@include('admin.includes.header')
		@include('admin.includes.leftbar')
		<div class="app-content  my-3 my-md-5">
			<div class="side-app">
				@include('admin.includes.message')
				@yield('content')
				
			</div>
		</div>
		<div class="modal fade" id="fileUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content ">
					<div class="modal-header pd-x-20">
						<h6 class="modal-title">File Uploads</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										@can('file-upload-add')
										<form action="{{ route('file-upload-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
											@csrf
											<div class="row">
												<div class="col-md-9">
													<div class="form-group">
														<input class="form-control" type="file" name="image_path[]" id="image_path" accept="image/*" multiple required>
														@if ($errors->has('image_path'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('image_path') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-md-3">
													<button type="submit" class="btn btn-primary btn-fixed">Add File Images</button>
												</div>
											</div>
										</form>
										@endcan
									</div>

									<div class="card-body">
										<div id="alert-container"></div>
										<div class="row">
											@forelse(App\Models\FileUploads::all() as $image)
											<div class="col-md-4" id="image-{{$loop->index}}">
												<div class="fileupload-new thumbnail">
													<img id="image-{{$loop->index}}" src="{{ asset($image->image_path) }}">
													<span class="badge badge-danger copy-button" onclick="copyImageUrl('{{ asset($image->image_path) }}', {{$loop->index}})">
														<span class="fileupload-new"><i class="fa fa-share" id="copy-url-{{$loop->index}}"  >  Copy URL </i> </span>
													</span> 
													
													<span class="badge badge-danger remove-img-2" onclick="removeImage('{{$image->id}}', {{$loop->index}})">
														<span class="fileupload-new"><i class="fa fa-times"></i> Remove</span>
													</span> 
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
					<!-- Modal Footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@include('admin.includes.footer')
	</div>
	<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
	<a href="javascript:;" id="go-to-bottom" onclick="scrollSmoothToBottom()"><i class="fa fa-angle-down"></i></a>

	@include('admin.includes.footer_script')
	@notify_render
	@yield('extrajs')
	<script>
	//code to add to * to labels with required fields
	document.addEventListener("DOMContentLoaded", function() {
	    // Select all required input, select, and textarea fields
	    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
	    
	    requiredFields.forEach(function(field) {
	      // Find the corresponding label
	      const label = document.querySelector(`label[for="${field.id}"]`);
	      
	      if (label) {
	        // Add an asterisk (*) to the label
	        label.innerHTML += ' <span style="color: red;">*</span>';
	    }
	});
	});
</script>
<script type="text/javascript">
	setIdleTimeout(<?= 1000*60*Auth::user()->locktimeout; ?>, function() {
		window.location.href = "{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}";
	}, function() {});

	function setIdleTimeout(millis, onIdle, onUnidle) {
		var timeout = 0;
		$(startTimer);

		function startTimer() {
			timeout = setTimeout(onExpires, millis);
			$(document).on("mousemove keypress", onActivity);
		}

		function onExpires() {
			timeout = 0;
			onIdle();
		}

		function onActivity() {
			if (timeout) clearTimeout(timeout);
			else onUnidle();
			$(document).off("mousemove keypress", onActivity);
			setTimeout(startTimer, 1000);
		}
	}
</script>
</body>
</html>