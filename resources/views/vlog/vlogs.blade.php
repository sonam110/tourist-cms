@extends('layouts.master-front')
@section('content')

    @include('common.slider')
    <section class="blog-page-header bg-grey">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="blog-page-title"><!-- Latest --> <span>Vlogs</span></h1>
            </div>
        </div>
    </section>
    <!-- ./ blog-page-header -->

    <section class="blog-section blog-inner padding bg-dark-deep">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="text-right" style="float: right; padding-bottom: 15px;">
                        <a href="{{route('user.vlog-create')}}" class="btn btn-warning text-white"><i class="fa fa-plus"></i> Add Vlog</a>
                    </div>
                </div>
                @forelse($vlogs as $vlog)

                <div class="col-lg-4 col-md-6">
                  <div class="project-wrap wrap-1">
                    <div class="project-box">
                      <div class="project-thumb">
                        <!--<a href="javascript:;"><img src="https://gofactz.com/touristcomundo/template3/assets/img/images/event-1.jpg" alt="project"></a>-->
                        <a href="javascript:;"><img src="{{asset($vlog->image_path)}}" alt="{{$vlog->title}}"></a>
                        <div class="project-content">
                          <h4><a href="javascript:;" class="project-title">{{$vlog->title}}</a>
                          </h4>
                          {{--
                          <span >
                            <!-- <i class="fa-regular fa-user"></i> &nbsp; {{@$vlog->postedBy->name}}  -->
                            <span class="float vlog-icons"><i class="fa-regular fa-calendar"></i> &nbsp;{{\Carbon\Carbon::parse($vlog->post_date)->format('M d, Y')}}</span></span>
                            --}}
                        </div>

                        <div class="wow fade-in-bottom vlog-video" data-wow-delay="200ms">
                            <a class="video-popup" data-autoplay="true" data-vbtype="video" href="{{$vlog->video_path}}"><i class="fa-solid fa-play"></i>

                            </a>
                        </div>

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