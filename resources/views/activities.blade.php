@extends('layouts.master-front')
@section('content')


<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title">Popular <span>activities</span></h1>
        </div>
    </div>
</section>
<!-- ./ blog-page-header -->

<section class="blog-section blog-inner padding bg-dark-deep">
    <div class="container">
        <div class="row">
            @forelse($activities as $activity)
            <div class="col-lg-4 col-md-6">
                <div class="post-card">
                    <div class="w-img">
                        <img src="{{asset('/'.$activity->image_path)}}" alt="{{$activity->title}}" class="activity-image" />
                    </div>
                    <div class="post-content">
                        <div>
                           {{--
                           <ul class="post-meta">
                               <li><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::parse($activity->post_date)->format('M d, Y')}}</li>
                           </ul>
                           --}}
                           <h3 class="post-title">
                               <a href="{{route('packages',['activity' => $activity->id])}}">{{$activity->title}}</a>
                           </h3>
                           <p>
                               {!! $activity->content !!}
                           </p> 
                        </div>
                        <div class="post-box">
                                <div class="post-author">
                                </div>
                                <a href="{{route('packages',['activity' => $activity->id])}}" class="read-more-btn">See Packages <i
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