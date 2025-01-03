@extends('layouts.master-front')
@section('content')

<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title">Vlog <span>Detail</span></h1>
        </div>
    </div>
</section>
<!-- ./ blog-page-header -->

<section class="blog-details padding bg-dark-deep">
    <div class="container">
        <div class="row blog-details-wrap">
            <div class="col-lg-12">
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
            </div>
            <div class="col-lg-8">
                <div class="blog-wrapper">
                    <div class="pxs-blog">
                        <div class="blog-details-thumb w-img">
                            <iframe width="100%" height="315" 
                            src="{{ str_replace('watch?v=', 'embed/', $vlog->video_path) }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>

                    <div class="blog-author-box">
                        <div class="author-info">
                            <img src="{{asset($vlog->postedBy->profile_image)}}" class="author-image" alt="{{@$vlog->postedBy->name}}" />
                            <h3 class="author-name">{{@$vlog->postedBy->name}} <span>{{\Carbon\Carbon::parse($vlog->post_date)->format('M d, Y')}}</span></h3>
                        </div>
                        <div class="author-social">
                            <button href="#" class="author-link" data-link="{{route('vlog-detail',$vlog->slug)}}">
                                <i class="fa-solid fa-link"></i><span>Copy Link</span>
                            </button>
                        </div>
                    </div>
                    <h2 class="pxs-blog-title">{{$vlog->title}}</h2>
                    {!! $vlog->content !!}
                </div>
            </div>
            <!-- ./ blog-wrapper -->
        </div>
        <div class="col-lg-4">
            <div class="sidebar-wrapper">
                <div class="sidebar-item">
                    <h3 class="sidebar-title">Categories</h3>
                    <ul class="category-list">
                        @forelse(App\Models\Category::limit(5)->withCount('blogs')->get() as $category)
                        <li><a href="#">{{$category->name}}</a><span>{{$category->blogs_count}}</span></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                <!--Categories-->
                <div class="sidebar-item">
                    <h3 class="sidebar-title">Popular Post</h3>
                    <ul class="thumb-post">
                        @forelse(App\models\Vlog::where('status',1)->orderBy('id','DESC')->limit(5)->get() as $vlogList)
                        <li>
                            <div class="thumb-post-info">
                                <h3 class="thumb-post-title">
                                    <a href="{{route('vlog-detail',$vlogList->slug)}}">{{$vlogList->title}}</a>
                                </h3>
                                <h3 class="date">{{ \Carbon\Carbon::parse($vlogList->post_date)->format('M d, Y') }}</h3>
                            </div>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
                
                
                <!--Recent Thumb Post-->
                <div class="sidebar-item">
                    <h3 class="sidebar-title">Newsletter</h3>
                    <div class="search-box box-2">

                        <form id="newsletter-form" method="POST" action="{{url('newsletter-save')}}" class="search-form">
                            @csrf
                            <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
                            <button class="search-btn" type="submit">Submit</button>
                        </form>
                        <div id="newsletter-feedback" class="mt-2"></div>
                    </div>
                </div>
                <!-- ./ search-box -->
            </div>
        </div>
        <!--Sidebar-->
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="comments-area">
                <h3 class="comment-header">{{$vlog->comments_count}} Comments available</h3>
                @forelse($vlog->comments as $comment)
                <div class="comment-item">
                    <div class="comment-thumb">
                        <img src="{{asset(''.$comment->postedBy->profile_image)}} class="author-image"" alt="{{@$comment->postedBy->name}}" />
                    </div>
                    <div class="comment-content">
                        <div class="comment-top">
                            <h3 class="comment-title">{{@$comment->postedBy->name}}</h3>
                            <h4 class="date">Date: <span>{{\Carbon\Carbon::parse($comment->post_date)->format('M d, Y')}}</span></h4>
                        </div>
                        <p>{!! $comment->comment !!}</p>
                    </div>
                </div>
                @empty
                <p>No comments yet.</p>
                @endforelse
                <div class="event-form">
                    <h3 class="form-header">Leave a Reply</h3>
                    <div id="alert-container"></div>
                    <form id="commentForm">
                        @csrf
                        <input type="hidden" id="vlog_id" name="vlog_id" value="{{$vlog->id}}">
                        <div class="row">
                            <div class="form-group">
                                <textarea style="height:130px !important;" id="message" name="message" rows="1" class="form-control address" placeholder="Enter your comment" required></textarea>
                            </div>
                        </div>
                        <div id="comment-feedback" class="mt-2"></div>
                        <div class="form-item">
                            <button id="commentBtn" class="pxs-primary-btn submit" onclick="comment(event)">
                                Post Comment <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
</section>

<script>
    function comment(event) {
        event.preventDefault(); 

        var comment = $('#message').val();
        var vlog_id = $('#vlog_id').val();
        var commentBtn = $('.commentBtn');

        if (!comment) {
            showAlert('danger', 'Comment is required');
            return;
        }

        commentBtn.prop('disabled', true); 

        $.ajax({
            url: "{{ route('comment-save') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                vlog_id: vlog_id,
                comment:comment
            },
            success: function(response) {
                if (response.success) {
                    $('#message').val('');
                    showAlert('success', response.message);
                } else {
                    showAlert('danger', response.message || 'Failed to post Comment, please try again.');
                    commentBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    showAlert('danger', errors.vblog_id ? errors.vblog_id[0] : 'Validation error');
                } else {
                    var message = xhr.responseJSON && xhr.responseJSON.message;
                    showAlert('danger', message ? message : 'An error occurred. Please try again.');
                }
                    sendOtpButton.prop('disabled', false); // Re-enable the Send OTP button on error
                }
            });
    }

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
</script>

@endsection
