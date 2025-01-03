@extends('layouts.master-front')
@section('content')

@include('common.slider')
<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title"><!-- Latest --> <span>Blogs</span></h1>
        </div>
    </div>
</section>
<!-- ./ blog-page-header -->

<section class="blog-section blog-inner padding bg-dark-deep">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="text-right" style="float: right; padding-bottom: 15px;">
                    <a href="{{route('user.blog-create')}}" class="btn btn-warning text-white"><i class="fa fa-plus"></i> Add Blog</a>
                </div>
            </div>
            @forelse($blogs as $blog)
            <div class="col-lg-4 col-md-6">
                <div class="post-card">
                    <div class="post-thumb w-img">
                        <a href="{{route('blog-detail',$blog->slug)}}"><img src="{{asset('/'.$blog->image_path)}}" alt="{{$blog->title}}" class="blog-image" /></a>
                    </div>
                    <div class="post-content">
                        <div  class="blog-content">
                           {{--
                           <ul class="post-meta">
                               <li><i class="fa-solid fa-calendar-days"></i>{{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}</li>
                           </ul>
                           --}}
                           <h3 class="post-title">
                               <a href="{{route('blog-detail',$blog->slug)}}">{{$blog->title}}</a>
                           </h3>
                           <p>
                               @php
                               $content = strip_tags($blog->content);
                               $limit = 180; // Set the character limit
                               $limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
                               @endphp

                               {!! $limitedContent !!}
                           </p> 
                        </div>
                        <div class="post-box">
                            <div class="post-author">
                                <!-- <img src="{{asset(@$blog->postedBy->profile_image)}}" class="author-image" alt="{{$blog->title}}" />
                                <h3 class="post-name">{{@$blog->postedBy->name}}  -->
                                    <!-- <span>{{@$blog->postedBy->name}}</span> -->
                                <!-- </h3> -->
                            </div>
                            <a href="{{route('blog-detail',$blog->slug)}}" class="read-more-btn">Read More <i class="fa-regular fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
              <strong>Info!</strong> No records found...
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection