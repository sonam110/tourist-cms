@extends('layouts.master-front')
@section('content')

<!-- Blog Details Section -->
<section class="blog-details padding bg-dark-deep">
    <div class="container">
        <div class="row blog-details-wrap">
            <div class="col-lg-12">
                <!-- Error & Success Messages -->
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

            <!-- Blog Details -->
            <div class="col-lg-8">
                <div class="blog-wrapper">
                    <div class="pxs-blog">
                        @if(!empty($travelCourse->video_link))
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{basename($travelCourse->video_link)}}?rel=0" allowfullscreen></iframe>
                        </div>
                        <br>
                        @else
                        <div class="blog-details-thumb w-img">
                            <img src="{{asset('/'.$travelCourse->image_path)}}" alt="{{$travelCourse->title}}" />
                        </div>
                        @endif
                        
                        <div class="blog-author-box">
                            {{--
                            <div class="author-info">
                                <h3 class="author-name">
                                    <!-- {{@$travelCourse->postedBy->name}}  -->
                                    
                                    <span>{{\Carbon\Carbon::parse($travelCourse->post_date)->format('M d, Y')}}</span>
                                    
                                </h3>
                            </div>
                            --}}
                            <div class="author-social">
                                <a href="{{route('contact-us')}}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-link"></i> <span>Inquire Now</span>
                                </a>
                            </div>
                        </div>
                        
                        <h2 class="pxs-blog-title">{{$travelCourse->title}}</h2>
                        {!! $travelCourse->content !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-4">
                <div class="sidebar-wrapper">
                    <!-- Categories List -->
                   <!--  <div class="sidebar-item">
                        <h3 class="sidebar-title">Categories</h3>
                        <ul class="category-list">
                            @forelse(App\Models\Category::limit(5)->withCount('travelCourses')->get() as $category)
                            <li><a href="#">{{$category->name}}</a><span>{{$category->travelCourses_count}}</span></li>
                            @empty
                            @endforelse
                        </ul>
                    </div> -->

                    <!-- Popular Posts -->
                    <div class="sidebar-item">
                        <h3 class="sidebar-title">Popular Post</h3>
                        <ul class="thumb-post">
                            @forelse(App\Models\TravelCourse::where('id','!=',$travelCourse->id)->where('status',1)->orderBy('id','DESC')->limit(5)->get() as $travelCourseList)
                            <li>
                                <div class="thumb-post-info">
                                    <h3 class="thumb-post-title">
                                        <a href="{{route('travel-course-detail',$travelCourseList->slug)}}">{{$travelCourseList->title}}</a>
                                    </h3>
                                    {{--
                                    <h3 class="date">{{ \Carbon\Carbon::parse($travelCourseList->post_date)->format('M d, Y') }}</h3>
                                    --}}
                                </div>
                            </li>
                            @empty
                            <h5>No Related Posts Found</h5>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Newsletter Section -->
                    <div class="sidebar-item">
                        <h3 class="sidebar-title">Newsletter</h3>
                        <div class="search-box box-2 padding-0x">
                            <div id="alert-container"></div>
                            <form id="newsletter-form" method="POST" class="search-form">
                                @csrf
                                <input id="email" type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
                                <button id="commentBtn" onclick="subscribe(event)" class="search-btn" type="submit">Submit</button>
                            </form>
                            <div id="newsletter-feedback" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('extrajs')
<script>
    function subscribe(event) {
        event.preventDefault();

        var email = $('#email').val();
        var commentBtn = $('#commentBtn');

        if (!email) {
            showAlert('danger', 'Email is required', 'alert-container');
            return;
        }

        commentBtn.prop('disabled', true);

        $.ajax({
            url: "{{ route('newsletter-save') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(response) {
                if (response.success) {
                    $('#newsletter-form')[0].reset();
                    showAlert('success', response.message, 'alert-container');
                } else {
                    showAlert('danger', response.message || 'Failed to subscribe, please try again.', 'alert-container');
                    commentBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    showAlert('danger', errors.email ? errors.email[0] : 'Validation error', 'alert-container');
                } else {
                    var message = xhr.responseJSON && xhr.responseJSON.message;
                    showAlert('danger', message ? message : 'An error occurred. Please try again.', 'alert-container');
                }
                commentBtn.prop('disabled', false);
            }
        });
    }

    function showAlert(type, message, alertContainerId) {
        var alertContainer = $('#' + alertContainerId);
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

@endsection
