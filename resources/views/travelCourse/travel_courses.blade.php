@extends('layouts.master-front')
@section('content')

    @include('common.slider')
    <section class="blog-page-header bg-grey">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="blog-page-title"><!-- Latest --> <span>Touriversity</span></h1>
            </div>
        </div>
    </section>
    <!-- ./ blog-page-header -->

    <section class="blog-section blog-inner padding bg-dark-deep">
        <div class="container">
            <div class="row">
                @forelse($travelCourses as $travelCourse)
                <div class="col-lg-4 col-md-6">
                    <div class="post-card">
                        <div class="post-thumb w-img">
                           <a href="{{route('travel-course-detail',$travelCourse->slug)}}"> <img src="{{asset('/'.$travelCourse->image_path)}}" alt="{{$travelCourse->title}}"  style="height: 200px;" /></a>
                        </div>
                        <div class="post-content">
                            <div style="height: 200px;">
                                {{--
                                <ul class="post-meta">
                                    <li><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::parse($travelCourse->post_date)->format('M d, Y')}}</li>
                                </ul>
                                --}}
                                <h3 class="post-title">
                                    <a href="{{route('travel-course-detail',$travelCourse->slug)}}">{{$travelCourse->title}}</a>
                                </h3>
                                <p>
                                    @php
                                        $content = strip_tags($travelCourse->content);
                                        $limit = 200; // Set the character limit
                                        $limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
                                    @endphp

                                    {!! $limitedContent !!}
                                </p>
                            </div>
                            <div class="post-box">
                                <div class="post-author">
                                    <!-- <img src="{{asset('img/blog/post-author.jpg')}}" alt="post" />
                                    <h3 class="post-name">{{@$travelCourse->postedBy->name}}  -->
                                        <!-- <span>{{@$travelCourse->postedBy->name}}</span> -->
                                    <!-- </h3> -->
                                </div>
                                <a href="{{route('travel-course-detail',$travelCourse->slug)}}" class="read-more-btn">Read More <i
                                        class="fa-regular fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    @endsection