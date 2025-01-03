@extends('layouts.master-front')
@section('content')

<!-- <section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title">Blog <span>Detail</span></h1>
        </div>
    </div>
</section> -->
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
                            <img src="{{asset('/'.$blog->image_path)}}" alt="{{$blog->title}}" />
                        </div>
                        <div class="blog-author-box">
                            <div class="author-info">
                                <!-- <img src="{{asset($blog->postedBy->profile_image)}}" class="author-image" alt="{{$blog->title}}" /> -->
                                {{--
                                <h3 class="author-name">
                                    <!-- {{@$blog->postedBy->name}}  -->
                                    <span>{{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}</span>
                                </h3>
                                --}}
                                </div>
                                <div class="author-social">
                                    {{--
                                    <button href="#" class="author-link" data-link="{{route('blog-detail',$blog->slug)}}">
                                        <i class="fa-solid fa-link"></i><span>Copy Link</span>
                                    </button>
                                    --}}
                                    <ul>
                                        <li>
                                            <a href="javascript:;"  onclick="shareonFb('{{$blog->title}}', '{{asset('/'.$blog->image_path)}}','{{route('blog-detail',$blog->slug)}}')"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                        {{--
                                        <li>
                                            <a href="https://twitter.com/intent/tweet?text={{$blog->title}}&amp;url={{route('blog-detail',$blog->slug)}}&amp;via={{env('APP_NAME')}}" target="_blank"><i class="fab fa-twitter"></i></a>
                                        </li>
                                        --}}
                                        <li>
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{route('blog-detail',$blog->slug)}}&title={{$blog->title}}" target="_blank"><i class="fab fa-linkedin"></i></a>
                                        </li>
                                        <li>
                                            <a href="whatsapp://send?text={{route('blog-detail',$blog->slug)}}" data-action="share/whatsapp/share" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <h2 class="pxs-blog-title">{{$blog->title}}</h2>
                            {!! $blog->content !!}
                        </div>
                    </div>
                    <!-- ./ blog-wrapper -->
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-wrapper">
                        <!-- <div class="sidebar-item">
                            <h3 class="sidebar-title">Categories</h3>
                            <ul class="category-list">
                                @forelse(App\Models\Category::limit(5)->withCount('blogs')->get() as $category)
                                <li>
                                    <a href="#">{{$category->name}}</a>
                                    <span>
                                        {{ App\Models\Blog::whereJsonContains('categories', $category->id)->count() }}
                                    </span>
                                </li>
                                @empty
                                @endforelse
                            </ul>
                        </div> -->
                        <!--Categories-->
                        <div class="event-sidebar-tour">
                            <h3 class="tour-header">Popular posts</h3>

                            @forelse(App\models\Blog::where('id','!=',$blog->id)->where('status',1)->inRandomOrder()->limit(5)->get() as $blogList)
                            <div class="tour-item">
                                
                             <div class="tour-content">
                                <div class="tour-thumb">
                                 <a href="{{route('blog-detail',$blogList->slug)}}"> <img src="{{asset('/'.$blogList->image_path)}}" alt="{{$blogList->package_name}}" class="" /></a>
                             </div>
                             {{--
                             <h3 class="price mt-2">{{ \Carbon\Carbon::parse($blogList->post_date)->format('M d, Y') }}
                                </h3>
                            --}}
                                <h4 class="tour-title mt-2">
                                    <a href="{{route('blog-detail',$blogList->slug)}}">{{$blogList->title}}
                                    </a>
                                </h4>
                                
                                
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <br>
                    <!-- <div class="sidebar-item">
                            <h3 class="sidebar-title">Popular Category</h3>
                            <ul class="tags">
                                @foreach(App\models\Category::orderBy('name', 'ASC')->get() as $category)
                                <li><a href="{{route('blogs')}}?cat={{$category->id}}&name={{$category->name}}">{{$category->name}}</a></li>
                                @endforeach
                                
                            </ul>
                        </div> -->
                    <br>
                    <!--Recent Thumb Post-->
                    <div class="sidebar-item">
                        <h3 class="sidebar-title">Newsletter</h3>
                        <div class="search-box box-2">
                            <div id="alert-container"></div>
                            <form id="newsletter-form" method="POST" id="newsletter-form" class="search-form">
                                @csrf
                                <input id="email" type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
                                <button id="commentBtn" onclick="subscribe(event)" class="search-btn" type="submit">Submit</button>
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
                    <h3 class="comment-header">{{$blog->comments_count}} Comments available</h3>
                    @forelse($blog->comments as $comment)
                    <div class="comment-item">
                        <div class="comment-thumb">
                            <img src="{{ asset(@$comment->postedBy->profile_image) }}" class="author-image" alt="{{ $blog->title }}" />

                        </div>
                        <div class="comment-content">
                            <div class="comment-top">
                                <h3 class="comment-title">{{@$comment->postedBy->name}}</h3>
                                {{--
                                <h4 class="date">Date: <span>{{\Carbon\Carbon::parse($comment->post_date)->format('M d, Y')}}</span></h4>
                                --}}
                            </div>
                            <p>{!! $comment->comment !!}</p>
                        </div>
                    </div>
                    @empty
                    <p>No comments yet.</p>
                    @endforelse
                    <div class="event-form">
                        <h3 class="form-header">Leave a Reply</h3>
                        <div id="alert-container-comment"></div>
                        <form id="commentForm">
                            @csrf
                            <input type="hidden" id="blog_id" name="blog_id" value="{{$blog->id}}">
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

@section('extrajs')
<script>
    function subscribe(event) {
        event.preventDefault(); 

        var email = $('#email').val();
        var commentBtn = $('.commentBtn');

        if (!email) {
            showAlert('danger', 'Email is required','alert-container');
            return;
        }

        commentBtn.prop('disabled', true); 

        $.ajax({
            url: "{{ route('newsletter-save') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                email:email
            },
            success: function(response) {
                if (response.success) {
                    $('#newsletter-form')[0].reset();
                    showAlert('success', response.message,'alert-container');
                } else {
                    showAlert('danger', response.message || 'Failed to Subscribe, please try again.','alert-container');
                    commentBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    showAlert('danger', errors.email ? errors.email[0] : 'Validation error','alert-container');
                } else {
                    var message = xhr.responseJSON && xhr.responseJSON.message;
                    showAlert('danger', message ? message : 'An error occurred. Please try again.','alert-container');
                }
                        commentBtn.prop('disabled', false); // Re-enable the Send OTP button on error
                    }
                });
    }
    function comment(event) {
        event.preventDefault(); 

        var comment = $('#message').val();
        var blog_id = $('#blog_id').val();
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
                blog_id: blog_id,
                comment:comment
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message,'alert-container-comment');
                } else {
                    showAlert('danger', response.message || 'Failed to send OTP, please try again.','alert-container-comment');
                    commentBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    showAlert('danger', errors.blog_id ? errors.blog_id[0] : 'Validation error','alert-container-comment');
                } else {
                    var message = xhr.responseJSON && xhr.responseJSON.message;
                    showAlert('danger', message ? message : 'An error occurred. Please try again.','alert-container-comment');
                }
                    commentBtn.prop('disabled', false); // Re-enable the Send OTP button on error
                }
            });
    }


    function showAlert(type, message, alertcontainer) {
        var alertContainer = $('#'+alertcontainer);
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
    window.fbAsyncInit = function() {
      FB.init({
        appId      : 786147451810321,
        xfbml      : true,
        version    : 'v2.5'
    });
  };

  (function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

  function shareonFb(title,img,link){
      FB.ui(
      {
        method: 'feed',
        name: title,
        link: link,
        picture: img
    });
  }

  function googleplusbtn(url) {
      sharelink = "https://plus.google.com/share?url="+url;
      newwindow=window.open(sharelink,'name','height=400,width=600');
      if (window.focus) {newwindow.focus()}
        return false;
}
</script>
@endsection
@endsection
