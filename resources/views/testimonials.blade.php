@extends('layouts.master-front')
@section('content')

    @include('common.slider')
    <section class="blog-page-header bg-grey">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="blog-page-title"><!-- Latest --> <span>Testimonials</span></h1>
            </div>
        </div>
    </section>
    <!-- ./ blog-page-header -->

    <section class="blog-section blog-inner padding bg-dark-deep">
        <div class="container">
            <div class="row">
                @forelse($reviews as $review)
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                  <div class="testi-item text-center">
                    <div class="testi-thumb text-center">
                        <img src="{{asset(@$review->user_image)}}" class="author-image" alt="{{@$review->user_name}}">
                    </div>
                    <h3 class="testi-title">{{$review->user_name}}</h3>
                    <ul class="ratings">

                        @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                        <li><i class="fa-solid fa-star"></i></li> <!-- Filled star -->
                        @else
                        <li><i class="fa fa-star" style="color: #ddd;"></i></li> <!-- Empty star -->
                        @endif
                        @endfor
                    </ul>
                    <!-- <p> -->
                        {!! $review->review !!}
                    <!-- </p> -->
                  </div>
                </div>
                <div class="col-md-3">
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