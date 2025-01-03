@extends('layouts.master-front')
@section('content')

@include('common.slider')
<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title"> <span>Career</span></h1>
        </div>
    </div>
</section>

@if($detail==1)
<section class="blog-section bg-grey padding">
  <div class="container">
    <div class="row">

        <div class="col-lg-12 col-md-12 pt-15">
            <div class="post-card">
              <div class="post-content">
                <h3 class="post-title">
                  <a href="{{route('career', [$career->slug])}}">{{$career->title}}</a>
                </h3>
                <p>
                  {{$career->subtitle}}
                </p>
                <div class="post-box">
                  <div class="post-author">

                    <ul class="post-meta">
                      @if(!empty($career->location))
                      <li><i class="fa-solid fa-map"></i><strong>{{$career->location}}</strong></li>
                      @endif
                      @if(!empty($career->salary))
                      <li><i class="fa-solid fa-dollar"></i><strong>&nbsp;&nbsp;{{$career->salary}}</strong></li>
                      @endif
                    </ul>
                  </div>
                </div>
                <p>
                    <hr>
                    {!! $career->description !!}
                </p>
                <div class="post-box">
                  <div class="post-author">
                        <a href="{{route('career')}}" class="read-more-btn">Back to career<i class="fa-regular fa-arrow-right-long"></i></a>
                    </div>
                </div>
              </div>
            </div>
          </div>

      
    </div>
  </div>
</section>
@else
<section class="blog-section bg-grey padding">
  <div class="container">
    <div class="row">
    
        @forelse($careers as $career)
        <div class="col-lg-4 col-md-6 pt-15">
            <div class="post-card">
              <div class="post-content">
                <h3 class="post-title">
                  <a href="{{route('career', [$career->slug])}}">{{$career->title}}</a>
                </h3>
                <p>
                  {{$career->subtitle}}
                </p>
                <div class="post-box">
                  <div class="post-author">
                    <ul class="post-meta">
                      {{--
                      <li><i class="fa-solid fa-calendar-days"></i>{{date('d F Y', strtotime($career->created_at))}}</li>
                      --}}
                      @if(!empty($career->location))
                      <li><i class="fa-solid fa-map"></i><strong>{{$career->location}}</strong></li>
                      @endif
                      @if(!empty($career->salary))
                      <li><strong><i class="fa-solid fa-dollar"></i>&nbsp;&nbsp;{{$career->salary}}</strong></li>
                      @endif
                    </ul>
                  </div>
                  <a href="{{route('career', [$career->slug])}}" class="read-more-btn">Read More <i
                      class="fa-regular fa-arrow-right-long"></i></a>
                </div>
              </div>
            </div>
          </div>
        @empty
            <h1 class="text-center">No Records found...</h1>
        @endforelse
      
    </div>
  </div>
</section>
@endif
@endsection