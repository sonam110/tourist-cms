@extends('layouts.master-front')
@section('content')


    <section class="blog-page-header bg-grey">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="blog-page-title">Frequently Asked <span>Questions</span></h1>
            </div>
        </div>
    </section>
    <!-- ./ blog-page-header -->

    <section class="faq-section padding">
        <div class="container">
            <div class="faq-content">
                <div class="accordion" id="accordionExample">
                    @forelse($faqs as $key=>$faq)
                    <div class="accordion-item wow fade-in-bottom" data-wow-delay="200ms">
                        <h2 class="accordion-header" id="heading{{$faq->id}}">
                            <button class="accordion-button @if($key != 0) collapsed @endif" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{$faq->id}}" aria-expanded="@if($key == 0)  true @else false @endif" aria-controls="collapse{{$faq->id}}">
                                {!! $faq->question !!}
                            </button>
                        </h2>
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse @if($key == 0) show @endif" aria-labelledby="heading{{$faq->id}}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- ./ faq-section -->
    @endsection