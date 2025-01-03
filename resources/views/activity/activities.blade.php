@extends('layouts.master-front')
@section('content')

@include('common.slider')
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
            <div class="col-md-12">
              @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <h3>{!! $message !!}</h3> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
            </div>
            @forelse($activities as $activity)
            <div class="col-lg-4 col-md-6">
                <div class="post-card">
                    <div class="w-img">
                        @if(count($activity->images) > 0)
                        <a href="{{route('activity-detail', $activity->slug)}}"><img src="{{asset('/'.$activity->images[0]->image_path)}}" alt="{{$activity->package_name}}" class="activity-image" /></a>
                        @endif
                    </div>
                    <div class="post-content">
                        <div>
                           {{--
                           <ul class="post-meta">
                               <li><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::parse($activity->post_date)->format('M d, Y')}}</li>
                           </ul>
                           --}}
                           <h3 class="post-title">
                               <a href="{{route('activity-detail', $activity->slug)}}">{{$activity->package_name}}</a>
                           </h3>
                           <p class="mt-15">
                               @php
                               $content = strip_tags($activity->description);
                               $limit = 180; // Set the character limit
                               $limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
                               @endphp

                               {{ strip_tags($limitedContent) }}
                           </p> 
                        </div>
                        <div class="post-box">
                                <div class="post-author">
                                    <span>{{$activity->icon}} 
                                        <strong>
                                            {{ $activity->price }}
                                        </strong>
                                    </span>
                                </div>
                                <a href="{{route('activity-detail', $activity->slug)}}" class="read-more-btn">See Detail <i
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