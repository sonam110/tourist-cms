@extends('layouts.master-front')
@section('content')

<section class="blog-page-header bg-grey">
  <div class="container">
    <div class="header-content text-center">
      <h1 class="blog-page-title">About <span>Us</span></h1>
      <p>
        We deliver top-tier, responsive software solutions optimized for mobile devices, using the latest technology to
        enhance user experiences and meet modern digital demands. </p>
    </div>
  </div>
</section>
<!-- ./ blog-page-header -->

<section class="about-section padding">
  <div class="container">
    <div class="section-heading">
      <h2 class="section-title">More About Us</h2>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="about-content">
          <div class="row">
            <div class="col-md-6">
              <div class="about-item">
                <h3 class="about-title"><a href="#">Spacial Offers</a></h3>
                <p>
                  We are a digital and branding company that believes in the power of creative
                  strategy and along with great design.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="about-item item-2">
                <h3 class="about-title"><a href="#">Safe & Secured</a></h3>
                <p>
                  We are a digital and branding company that believes in the power of creative
                  strategy and along with great design.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="about-item">
                <h3 class="about-title"><a href="#">Experienced Team</a></h3>
                <p>
                  We are a digital and branding company that believes in the power of creative
                  strategy and along with great design.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="about-item item-2">
                <h3 class="about-title"><a href="#">Tour Guidance</a></h3>
                <p>
                  We are a digital and branding company that believes in the power of creative
                  strategy and along with great design.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="about-img">
    <div class="video-btn">
      <a class="video-popup" data-autoplay="true" data-vbtype="video" href="https://youtu.be/iyd7qUH3oH0"><i
          class="fa-solid fa-play"></i>
      </a>
    </div>
  </div>
</section>
<!-- ./about-section -->

<section class="promo-section padding pt-0">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="promo-item">
          <div class="promo-icon">
            <img src="{{asset('img/icon/promo-icon-1.png')}}" alt="img"/>
          </div>
          <div class="promo-content">
            <h3>Best Policy</h3>
            <p>Fully layered dolor adipisicing elit facere, nobis, id expedita.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="promo-item">
          <div class="promo-icon">
            <img src="{{asset('img/icon/promo-icon-2.png')}}" alt="img"/>
          </div>
          <div class="promo-content">
            <h3>Acces to all events</h3>
            <p>Fully layered dolor adipisicing elit facere, nobis, id expedita.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="promo-item">
          <div class="promo-icon">
            <img src="{{asset('img/icon/promo-icon-3.png')}}" alt="img"/>
          </div>
          <div class="promo-content">
            <h3>Parking Facility</h3>
            <p>Fully layered dolor adipisicing elit facere, nobis, id expedita.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ./ promo-section -->

<section class="offer-section padding pt-0">
  <div class="container">
    <div class="section-heading">
      <h2 class="section-title">Special offers</h2>
    </div>
    <div class="offer-carousel-wrap">
      <div class="offer-carousel swiper">
        <div class="swiper-wrapper swiper-container">
          <div class="swiper-slide">
            <div class="offer-item">
              <div class="offer-shape"></div>
              <div class="offer-thumb w-img">
                <img src="{{asset('img/images/offer-1.png')}}" alt="offer"/>
              </div>
              <div class="offer-content">
                <span class="offer-text">Artemis Faelight</span>
                <h3 class="offer-title">Kerala River View Tour</h3>
                <h4 class="offer-desc">3 Days 4 Nights, Capcity 20</h4>
                <span class="places">12 Places</span>
              </div>
              <div class="discount-box">
                <h4 class="discount">50% <span>Discount</span></h4>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="offer-item">
              <div class="offer-shape"></div>
              <div class="offer-thumb w-img">
                <img src="{{asset('img/images/offer-2.png')}}" alt="offer"/>
              </div>
              <div class="offer-content">
                <span class="offer-text">Artemis Faelight</span>
                <h3 class="offer-title">Kerala River View Tour</h3>
                <h4 class="offer-desc">3 Days 4 Nights, Capcity 20</h4>
                <span class="places">12 Places</span>
              </div>
              <div class="discount-box">
                <h4 class="discount">50% <span>Discount</span></h4>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="offer-item">
              <div class="offer-shape"></div>
              <div class="offer-thumb w-img">
                <img src="{{asset('img/images/offer-3.png')}}" alt="offer"/>
              </div>
              <div class="offer-content">
                <span class="offer-text">Artemis Faelight</span>
                <h3 class="offer-title">Kerala River View Tour</h3>
                <h4 class="offer-desc">3 Days 4 Nights, Capcity 20</h4>
                <span class="places">12 Places</span>
              </div>
              <div class="discount-box">
                <h4 class="discount">50% <span>Discount</span></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Carousel Arrows -->
      <div class="swiper-arrow">
        <div class="swiper-nav swiper-next"><i class="fa-solid fa-chevron-left"></i></div>
        <div class="swiper-nav swiper-prev"><i class="fa-solid fa-chevron-right"></i></div>
      </div>
    </div>
  </div>
</section>
<!-- ./ offer-section -->

<section class="testimonial-section padding">
  <div class="testi-bg"></div>
  <div class="container">
    <div class="section-heading">
      <h2 class="section-title">Client Testimonial</h2>
    </div>
    <div class="testimonial-carousel swiper">
      <div class="swiper-wrapper swiper-container">
        <div class="swiper-slide">
          <div class="testi-item text-center">
            <div class="testi-thumb text-center">
              <img src="{{asset('img/testi/testi-img-1.png')}}" alt="testi"/>
            </div>
            <h3 class="testi-title">Jhone Walker Hussy</h3>
            <ul class="ratings">
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <p>
              Quote testimonials are ads or artwork that display positive statements about your
              company from a brand evangelist or a delighted customer. The quote is usually
              accompanied by an image.
            </p>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testi-item text-center">
            <div class="testi-thumb text-center">
              <img src="{{asset('img/testi/testi-img-1.png')}}" alt="testi"/>
            </div>
            <h3 class="testi-title">Jhone Walker Hussy</h3>
            <ul class="ratings">
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
              <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <p>
              Quote testimonials are ads or artwork that display positive statements about your
              company from a brand evangelist or a delighted customer. The quote is usually
              accompanied by an image.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Carousel Arrows -->
    <div class="swiper-arrow">
      <div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-left-long"></i></div>
      <div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-right-long"></i></div>
    </div>
  </div>
</section>
<!-- ./ testimonial-section -->

<section class="subscribe-section bg-grey padding">
  <div class="subscribe-bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="subscribe-video-btn">
          <div class="video-btn">
            <a class="video-popup" data-autoplay="true" data-vbtype="video"
               href="https://youtu.be/iyd7qUH3oH0"><i class="fa-solid fa-play"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="subscribe-content">
          <h2 class="subscribe-title">Get Every Monthly <span>Newsletter</span></h2>
          <p>
            Select a category that best suites your interest. Use filters to coustomize your search
            and to find exactly what you want
          </p>
          <form action="#" class="subscribe-form">
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="Enter your email address" required=""/>
            <button class="pxs-primary-btn">Subscribe <i class="fa fa-location-arrow"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ./ subscribe-section -->

<section class="blog-section bg-grey padding">
  <div class="container">
    <div class="blog-top">
      <div class="section-heading">
        <h2 class="section-title">Tour Events for you</h2>
      </div>
      <a href="#" class="see-more-btn">See All Event<i class="fa-regular fa-arrow-right-long"></i></a>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="post-card">
          <div class="post-thumb w-img">
            <img src="{{asset('img/blog/post-1.jpg')}}" alt="post"/>
          </div>
          <div class="post-content">
            <ul class="post-meta">
              <li><i class="fa-solid fa-calendar-days"></i>SEPTEMBER 19, 2022</li>
            </ul>
            <h3 class="post-title">
              <a href="blog-details.html">The Bottom Line on Dietary Supplements</a>
            </h3>
            <p>
              One may not need charts and graphs at this point to know that in the past couple of
              years expecially, the buying and selling on....
            </p>
            <div class="post-box">
              <div class="post-author">
                <img src="{{asset('img/blog/post-author.jpg')}}" alt="post"/>
                <h3 class="post-name">John Singleton <span>Nutritionist</span></h3>
              </div>
              <a href="blog-details.html" class="read-more-btn">Read More <i
                  class="fa-regular fa-arrow-right-long"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="post-card">
          <div class="post-thumb w-img">
            <img src="{{asset('img/blog/post-2.jpg')}}" alt="post"/>
          </div>
          <div class="post-content">
            <ul class="post-meta">
              <li><i class="fa-solid fa-calendar-days"></i>SEPTEMBER 19, 2022</li>
            </ul>
            <h3 class="post-title">
              <a href="blog-details.html">The Bottom Line on Dietary Supplements</a>
            </h3>
            <p>
              One may not need charts and graphs at this point to know that in the past couple of
              years expecially, the buying and selling on....
            </p>
            <div class="post-box">
              <div class="post-author">
                <img src="{{asset('img/blog/post-author.jpg')}}" alt="post"/>
                <h3 class="post-name">John Singleton <span>Nutritionist</span></h3>
              </div>
              <a href="blog-details.html" class="read-more-btn">Read More <i
                  class="fa-regular fa-arrow-right-long"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="post-card">
          <div class="post-thumb w-img">
            <img src="{{asset('img/blog/post-3.jpg')}}" alt="post"/>
          </div>
          <div class="post-content">
            <ul class="post-meta">
              <li><i class="fa-solid fa-calendar-days"></i>SEPTEMBER 19, 2022</li>
            </ul>
            <h3 class="post-title">
              <a href="blog-details.html">The Bottom Line on Dietary Supplements</a>
            </h3>
            <p>
              One may not need charts and graphs at this point to know that in the past couple of
              years expecially, the buying and selling on....
            </p>
            <div class="post-box">
              <div class="post-author">
                <img src="{{asset('img/blog/post-author.jpg')}}" alt="post"/>
                <h3 class="post-name">John Singleton <span>Nutritionist</span></h3>
              </div>
              <a href="blog-details.html" class="read-more-btn">Read More <i
                  class="fa-regular fa-arrow-right-long"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ./ blog-section -->
@endsection