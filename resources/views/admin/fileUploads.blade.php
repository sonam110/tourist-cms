@extends('admin.layouts.master')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header ">
				<h3 class="card-title">Files  Management</h3>
				<div class="card-options">
					<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" url_link="" data-original-url_link="Go To Back">
						<i class="fa fa-mail-reply"></i>
					</a>
				</div>
			</div>
			<div class="card-body">
				@can('file-upload-add')
				<form action="{{ route('file-upload-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-md-6">&nbsp;</div>
						<div class="col-md-4">
							<div class="form-group">
								<input class="form-control" type="file" name="image_path[]" id="image_path" accept="image/*" multiple required>
								@if ($errors->has('image_path'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('image_path') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary btn-fixed">Add File Images</button>
						</div>
					</div>
				</form>
				@endcan
			</div>

			<div class="card-body">
				<div id="alert-container"></div>
				<div class="row">
					@forelse($fileUploads as $image)
					<div class="col-md-3" id="image-{{$loop->index}}">
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
@section('extrajs')
<script type="text/javascript">
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
@endsection
@endsection
