@extends('layouts.master-front')
@section('extracss')

<!-- CSS for intl-tel-input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style type="text/css">
  .iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 28%;
    }
    .iti__flag-container
    {
      padding: 7px;
    }
  </style>

  @endsection
@section('content')
<section class="event-details padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="event-details-left">
                    <div class="event-details-carousel-wrap">
                        <div class="">
                            <div class="swiper-container">
                                <div id="slider" class="flexslider">
                                  <ul class="slides">
                                    @foreach($package->images as $key => $image)
                                    <li>
                                        <a href="{{asset('/'.$image->image_path)}}" data-gall="img-popup" class="img-popup">
                                            <img src="{{asset('/'.$image->image_path)}}" class="package-img" />
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div id="carousel" class="flexslider flex-hide">
                              <ul class="slides">
                                @foreach($package->images as $key => $image)
                                <li>
                                  <img src="{{asset('/'.$image->image_path)}}" class="package-img" />
                              </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          <div class="event-details-content">
            <div class="details-left-content">
                <h3 class="details-content-title">
                 {{$package->package_name}}
             </h3>
             <ul>
                {{--
                    <li>
                        <i class="fa-solid fa-star"></i>
                        {{$package->rating}} 
                        <span>({{$package->reviews->count()}} reviews)</span>
                    </li>
                    <li>
                        <i class="fa fa-paper-plane text-info"></i> 
                        <span>{{$package->package_type }} </span>
                    </li>
                    --}}
                    <li>
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <span>{{$package->destination->name}}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-bolt text-danger"></i>  <span>{{$package->service->name}}</span>
                    </li>
                    @if($package->service->name=='Ramta Yogi')
                    <li>
                        <i class="fa fa-paper-plane text-info"></i> 
                        <span>{{($package->destination->destination_type==1) ? 'Domestic' : 'International' }} </span>
                    </li>
                    @endif
                                <!-- <li>
                                    <i class="fa fa-bookmark text-success"></i> 
                                    {{$package->bookings->count()}} <span>Bookings </span>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="event-schedule">
                        <h3 class="schedule-title">Package Schedule</h3>
                        <ul class="schedule-list">
                            @if(!empty($package->available_dates))
                            @if(!empty(json_decode($package->available_dates)[0]->start_date))
                            <li>
                                <img src="{{asset('img/icon/schedule-icon-1.png')}}" alt="{{$package->package_name}}" />
                                <h3 class="list-title">Start Date <span>{{@json_decode($package->available_dates)[0]->start_date}}</span></h3>
                            </li>
                            @endif
                            @if(!empty(json_decode($package->available_dates)[0]->end_date))
                            <li>
                                <img src="{{asset('img/icon/schedule-icon-1.png')}}" alt="{{$package->package_name}}" />
                                <h3 class="list-title">End Date <span>{{@json_decode($package->available_dates)[0]->end_date}}</span></h3>
                            </li>
                            @endif
                            @endif
                            <li>
                                <img src="{{asset('img/icon/schedule-icon-2.png')}}" alt="{{$package->package_name}}" />
                                <h3 class="list-title">Duration <span>{{$package->duration}}</span></h3>
                            </li>
                            <li>
                                <img src="{{asset('img/icon/schedule-icon-3.png')}}" alt="{{$package->package_name}}" />
                                <h3 class="list-title">Price Starting From 
                                    <span>{{$package->icon}} {{ $package->price }}
                                    </span>
                                </h3>
                            </li>
                        </ul>
                    </div>
                    <div class="event-nav-wrap">
                        <ul class="nav tab-navigation" id="product-tab-navigation" role="tablist">
                            <li role="presentation">
                                <button class="active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true"> Description  </button>
                            </li>
                            <li role="presentation">
                                <button id="itenerary-tab" data-bs-toggle="tab" data-bs-target="#itenerary" type="button" role="tab" aria-controls="itenerary" aria-selected="false"> Itenerary </button>
                            </li>
                            <li role="presentation">
                                <button id="inclusions-tab" data-bs-toggle="tab" data-bs-target="#inclusions" type="button" role="tab" aria-controls="inclusions" aria-selected="false"> Inclusions </button>
                            </li>
                            <li role="presentation">
                                <button id="exclusions-tab" data-bs-toggle="tab" data-bs-target="#exclusions"  type="button" role="tab" aria-controls="exclusions" aria-selected="false"> Exclusions  </button>
                            </li>
                            <!-- <li role="presentation">
                                <button id="exclusions-tab" data-bs-toggle="tab" data-bs-target="#activities"  type="button" role="tab" aria-controls="activities" aria-selected="false"> Activities  </button>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="product-tab-content">
                            <div class="tab-pane fade show active description" id="home" role="tabpanel" aria-labelledby="home-tab">
                                {!! $package->description !!}
                            </div>
                            <div class="tab-pane fade" id="itenerary" role="tabpanel" aria-labelledby="itenerary-tab">
                                <ul>
                                    @if(!empty($package->itinerary))
                                    @forelse(json_decode($package->itinerary) as $key=>$itinerary)
                                    @if($itinerary->title != null)
                                    <li><strong>{{$itinerary->title}}</strong></li>
                                    <p>{!! $itinerary->description !!}</p>
                                    @endif
                                    @empty
                                    @endforelse
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade review" id="inclusions" role="tabpanel" aria-labelledby="inclusions-tab"> 
                                <ul>
                                    @if(!empty($package->inclusions))
                                    @forelse(json_decode($package->inclusions) as $key=>$inclusion)
                                    @if(!empty($inclusion))
                                    <li>{{$inclusion}}</li>
                                    @endif
                                    @empty
                                    @endforelse
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade review" id="exclusions" role="tabpanel" aria-labelledby="exclusions-tab"> 
                                <ul>
                                    @if(!empty($package->exclusions))
                                    @forelse(json_decode($package->exclusions) as $key=>$exclusion)
                                    @if(!empty($exclusion))
                                    <li>{{$exclusion}}</li>
                                    @endif
                                    @empty
                                    @endforelse
                                    @endif
                                </ul>
                            </div>
                            {{--
                                <div class="tab-pane fade review" id="activities" role="tabpanel" aria-labelledby="activities-tab"> 
                                    <ul>
                                        @forelse($package->activityLists as $activity)
                                        <li><a href="{{route('activities')}}">{{$activity->title}}</a></li>
                                        @empty
                                        @endforelse
                                    </ul>
                                </div>
                                --}}
                            </div>
                        </div>
                        <div class="comments-area">
                            <h3 class="comment-header"><span class="review-count">{{$package->reviews->count()}}</span> Reviews available</h3>
                            @forelse($package->reviews as $review)
                            <div class="comment-item">
                                <div class="comment-thumb">
                                    <img src="{{asset('/'.$review->user_image)}}" class="author-image" alt="comment" />
                                </div>
                                <div class="comment-content">
                                    <div class="comment-top">
                                        <h3 class="comment-title">{{$review->user->name}}</h3>
                                        <p>
                                            @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                            <i class="fa fa-star" style="color: #ffc700;"></i> <!-- Filled star -->
                                            @else
                                            <i class="fa fa-star" style="color: #ddd;"></i> <!-- Empty star -->
                                            @endif
                                            @endfor
                                        </p>
                                        {{--
                                            <h4 class="date">Date: <span>{{Carbon\Carbon::parse($review->created_at)->format('M d Y')}}</span></h4>
                                            --}}
                                        </div>
                                        <p>
                                            {!! $review->review!!}
                                        </p>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="event-form">
                                <h3 class="form-header">Review And Rate</h3>
                                <div id="alert-container"></div>
                                <form id="reviewForm">
                                    @csrf
                                    <input type="hidden" id="package_uuid" name="package_uuid" value="{{$package->uuid}}">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="feedback">
                                                <div class="rating">
                                                  <input type="radio" name="rating" id="star5" value="5">
                                                  <label for="star5"></label>
                                                  <input type="radio" name="rating" id="star4" value="4">
                                                  <label for="star4"></label>
                                                  <input type="radio" name="rating" id="star3" value="3">
                                                  <label for="star3"></label>
                                                  <input type="radio" name="rating" id="star2" value="2">
                                                  <label for="star2"></label>
                                                  <input type="radio" name="rating" id="star1" value="1">
                                                  <label for="star1"></label>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                        <textarea style="max-height:100px !important;" id="message" name="message" rows="1" class="form-control address" placeholder="Enter your review" required></textarea>
                                    </div>
                                </div>
                                <div id="review-feedback" class="mt-2"></div>
                                <div class="form-item">
                                    <button id="reviewBtn" class="pxs-primary-btn submit" onclick="review(event)">
                                        Submit <i class="fa-solid fa-arrow-right-long"></i>
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="event-details-right">
                        <div class="event-banner">
                            <div class="banner-content">
                                <h3 class="banner-title">{{$package->icon}} {{ $package->price }} <span>/ Standard Ticket</span></h3>
                                <!-- <h4 class="discount">{{$package->discount}} %</h4> -->
                            </div>
                        </div>
                        <div class="event-sidebar">
                            @if(env('SHOW_INQUIRY_FORM') === 'show')
                            <form action="{{route('inquiry-store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="package_id" value="{{$package->id}}">
                                <div >
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Name*</label>
                                        <input type="text" class="form-control" id="name" name="name" required placeholder="Full Name">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email*</label>
                                        <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                                    </div>
                                    <div class="d-flex flex-column form-group mb-3">
                                        
                                        <label for="mobile" class="form-label mt-2">Mobile Number*</label>
                                        <div class="d-flex">
                                            <input type="text" id="CountryCode1" class="form-control" placeholder="&nbsp;" style="width: 20%;">
                                            <input type="hidden" class="form-control" id="CountryCode" placeholder="Country Code" required name="country_code" value="+91" readonly>
                                            <input type="tel" class="form-control ms-2" id="PhoneNumber" placeholder="Phone Number" required name="mobile" style="flex: 1;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="travel_date" class="form-label">Travel Date*</label>
                                        <input type="date" class="form-control" id="travel_date" name="travel_date" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="traveller_count" class="form-label">Traveller Count*</label>
                                        <input type="number" class="form-control" id="traveller_count" name="traveller_count" required min="1">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group mb-3" style="padding-bottom: 15px;">
                                          {!! NoCaptcha::renderJs() !!}
                                          {!! NoCaptcha::display() !!}
                                          @if ($errors->has('g-recaptcha-response'))
                                          <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <form action="{{ route('booking-save') }}" method="POST">
                                @csrf
                                <input type="hidden" name="package_uuid" value="{{$package->uuid}}">
                                <div class="schedule-box">
                                    <div class="start-box">
                                        <span class="top-content">Start Date*</span>
                                        <h5 class="date">
                                            <input type="date" id="start_date" name="start_date" required min="{{date('Y-m-d')}}">
                                            <span>{{date('d')}}</span> {{date('M y')}}, <span class="weekday">{{date('D')}}</span>
                                        </h5>
                                    </div>
                                    <div class="start-box">
                                        <span class="top-content">End Date</span>
                                        <h5 class="date">
                                            <input type="date" name="end_date" min="{{date('Y-m-d')}}">
                                            <span>{{date('d')}}</span> {{date('M y')}}, <span class="weekday">{{date('D')}}</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="ticket-info">
                                    <div class="ticket-item">
                                        <h3 class="ticket-title">Adult 
                                            <span>
                                                {{$package->icon}} {{ $package->price }} per ticket
                                            </span>
                                        </h3>
                                        <div class="number">
                                            <button type="button" class="minus text-design">-</button>
                                            <input type="number" value="1" id="number_of_adults" name="number_of_adults" onchange="calculateTotal()" required min="1">
                                            <button type="button" class="plus text-design">+</button>
                                        </div>
                                    </div>
                                    <div class="ticket-item">
                                        <h3 class="ticket-title">Children 
                                            <span>
                                                {{$package->icon}} {{ number_format($package->price_cal / 2, 2) }} per ticket
                                            </span>
                                        </h3>
                                        <div class="number">
                                            <button type="button" class="minus text-design">-</button>
                                            <input type="number" value="0" id="number_of_children" name="number_of_children" onchange="calculateTotal()">
                                            <button type="button" class="plus text-design">+</button>
                                        </div>
                                    </div>
                                    <div id="childrenAgeContainerV" class="form-group" style="display: none;">
                                        <div id="childrenAgesFieldsV"></div>
                                    </div>
                                    <div class="ticket-item">
                                        <h3 class="ticket-title">Infant 
                                            <span>
                                                {{$package->icon}} {{ number_format($package->price_cal / 5, 2) }} per ticket
                                            </span>
                                        </h3>
                                        <div class="number">
                                            <button type="button" class="minus text-design">-</button>
                                            <input type="number" value="0" id="number_of_infants" name="number_of_infants" onchange="calculateTotal()">
                                            <button type="button" class="plus text-design">+</button>
                                        </div>
                                    </div>
                                    <div id="infantsAgeContainerV" class="form-group" style="display: none;">
                                        <div id="infantsAgesFieldsV"></div>
                                    </div>
                                </div>
                                <div class="promo-code">
                                    <h3 class="promo-title">Coupon Code</h3>
                                    <div class="promo-code-box">
                                        <input type="text" id="coupon_code" name="coupon_code" class="form-control" placeholder="Coupon Code">
                                        <button type="button" id="applyCoupon" class="promo-code-btn">Apply Coupon</button>
                                    </div>
                                </div>
                                <div class="price-box">
                                    <h3 class="price-title">Price</h3>
                                    <ul class="price-list" id="priceList">
                                        <!-- Dynamic price list will be inserted here -->
                                    </ul>
                                </div>
                                <div class="payment">
                                    <h3 class="payment-title">Total Payment</h3>
                                    <h3 class="payment-title" id="totalPayment">{{$package->icon}} 0</h3>
                                </div>
                                <div class="event-sidebar-btn text-center">
                                    <button type="submit" id="submitButton" class="pxs-primary-btn">Book Now <i class="fa-solid fa-arrow-right-long"></i></button>
                                    <span>You will not get charged yet</span>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="event-sidebar-tour">
                        <h3 class="tour-header">Similar Tour</h3>

                        @forelse($similarPackages as $sp)
                        <div class="tour-item">
                            <div class="tour-thumb">
                                @if(count($sp->images) > 0)
                                <img src="{{asset('/'.$sp->images[0]->image_path)}}" alt="{{$sp->package_name}}" class="similar-data-image" />
                                @endif
                            </div>
                            <div class="tour-content">
                                <h3 class="tour-title">{{$sp->package_name}}</h3>
                                <ul>
                                    <!-- <li><i class="fa-solid fa-star"></i>{{$sp->rating}} <span>({{$sp->reviews->count()}} reviews)</span></li> -->
                                    <li>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>{{$sp->destination->name}}</span>
                                    </li>
                                </ul>
                                <h3 class="price">{{$sp->icon}} {{$sp->price}} <a href="{{route('package-detail',$sp->slug)}}" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i>View</a></h3>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ event-details -->
    <script>

        function showChildrenAgeFieldsV() {
            const childrenCount = document.getElementById('number_of_children').value;
            const childrenAgeContainerV = document.getElementById('childrenAgeContainerV');
            const childrenAgesFieldsV = document.getElementById('childrenAgesFieldsV');

        childrenAgesFieldsV.innerHTML = ''; // Reset the container

        if (childrenCount > 0) {
            childrenAgeContainerV.style.display = 'block'; // Show container

            // Create select fields with labels for each child
            for (let i = 1; i <= childrenCount; i++) {
                const ageField = document.createElement('div');
                ageField.classList.add('form-group');
                
                // Create label for child age
                const label = document.createElement('label');
                label.setAttribute('for', `child_age_${i}`);
                label.textContent = `Child ${i} Age:`;

                // Create select element for age
                const select = document.createElement('select');
                select.id = `child_age_${i}`;
                select.name = 'children_ages[]';
                select.classList.add('form-control');

                // Create options for ages 3 to 12
                for (let age = 3; age <= 12; age++) {
                    const option = document.createElement('option');
                    option.value = age;
                    option.textContent = age;
                    select.appendChild(option);
                }

                // Append label and select to the ageField container
                ageField.appendChild(label);
                ageField.appendChild(select);
                childrenAgesFieldsV.appendChild(ageField);
            }
        } else {
            childrenAgeContainerV.style.display = 'none'; // Hide container if no children selected
        }
    }

    // Function to dynamically show infant age select fields
    function showInfantsAgeFieldsV() {
        const infantsCount = document.getElementById('number_of_infants').value;
        const infantsAgeContainer = document.getElementById('infantsAgeContainerV');
        const infantsAgesFields = document.getElementById('infantsAgesFieldsV');

        infantsAgesFields.innerHTML = ''; // Reset the container

        if (infantsCount > 0) {
            infantsAgeContainer.style.display = 'block'; // Show container

            // Create select fields with labels for each infant
            for (let i = 1; i <= infantsCount; i++) {
                const ageField = document.createElement('div');
                ageField.classList.add('box-item');
                
                // Create label for infant age
                const label = document.createElement('label');
                label.setAttribute('for', `v_infant_age_${i}`);
                label.textContent = `Infant ${i} Age:`;

                // Create select element for infant age
                const select = document.createElement('select');
                select.id = `v_infant_age_${i}`;
                select.name = 'infants_ages[]';
                select.classList.add('form-control');
                
                // Create options for ages 1 and 2
                for (let age = 1; age <= 2; age++) {
                    const option = document.createElement('option');
                    option.value = age;
                    option.textContent = age;
                    select.appendChild(option);
                }

                // Append label and select to the ageField container
                ageField.appendChild(label);
                ageField.appendChild(select);
                infantsAgesFields.appendChild(ageField);
            }
        } else {
            infantsAgeContainer.style.display = 'none'; // Hide container if no infants selected
        }
    }


    const pricePerAdult = @json($package->price_cal);

    const pricePerChild = pricePerAdult / 2;
    const pricePerInfant = pricePerAdult / 5;

    const numberOfAdultsInput = document.getElementById('number_of_adults');
    const numberOfChildrenInput = document.getElementById('number_of_children');
    const numberOfInfantsInput = document.getElementById('number_of_infants');
    const priceList = document.getElementById('priceList');
    const totalPayment = document.getElementById('totalPayment');
    const applyCouponBtn = document.getElementById('applyCoupon');
    const couponCodeInput = document.getElementById('coupon_code');

    function calculateTotal() {
        const numberOfAdults = parseInt(numberOfAdultsInput.value) || 1;
        const numberOfChildren = parseInt(numberOfChildrenInput.value) || 0;
        const numberOfInfants = parseInt(numberOfInfantsInput.value) || 0;

        const totalAdultPrice = numberOfAdults * pricePerAdult;
        const totalChildPrice = numberOfChildren * pricePerChild;
        const totalInfantPrice = numberOfInfants * pricePerInfant;

        const total = totalAdultPrice + totalChildPrice + totalInfantPrice;

        priceList.innerHTML = `
        <li><span>${numberOfAdults} Adult(s)</span><span>${totalAdultPrice.toLocaleString()}</span></li>
        <li><span>${numberOfChildren} Child</span><span>${totalChildPrice.toLocaleString()}</span></li>
        <li><span>${numberOfInfants} Infant(s)</span><span>${totalInfantPrice.toLocaleString()}</span></li>
        `;

        totalPayment.innerHTML = `{{$package->icon}} ${total.toLocaleString()}`;



        // Dynamic Ages Field
        showChildrenAgeFieldsV();
        showInfantsAgeFieldsV();
    }

    // Event listeners for recalculating the total
    // numberOfAdultsInput.addEventListener('input', calculateTotal);
    // numberOfChildrenInput.addEventListener('input', calculateTotal);
    // numberOfInfantsInput.addEventListener('input', calculateTotal);

    // Handle coupon application via AJAX
    applyCouponBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission
        calculateTotal();

        const couponCode = couponCodeInput.value.trim();
        const totalAmount = pricePerAdult * (parseInt(numberOfAdultsInput.value) || 0)
        + pricePerChild * (parseInt(numberOfChildrenInput.value) || 0)
        + pricePerInfant * (parseInt(numberOfInfantsInput.value) || 0);

        if (!couponCode) {
            alert('Please enter a coupon code');
            return;
        }

        fetch('{{ route('apply-coupon') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ coupon_code: couponCode, amount:totalAmount })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success == 'true') {
                alert(data.message);
                const discount = parseFloat(data.discounted_amount);
                const currentTotal = parseFloat(totalPayment.textContent.replace('{{$package->icon}}', ''));
                const newTotal = currentTotal - discount;

                priceList.innerHTML += `<li><span>Coupon Discount</span><span>-${discount}</span></li>`;
                totalPayment.innerHTML = `{{$package->icon}} ${newTotal.toFixed(2)}`;
            } else {
                alert(data.message);
                // alert('Invalid coupon code');
            }
        })
        .catch(error => {
            console.error('Error applying coupon:', error);
            alert('An error occurred while applying the coupon');
        });
    });

    // Initial calculation
    calculateTotal();

    function review(event) {
        event.preventDefault(); 

        var review = $('#message').val();
        var rating = $('input[name="rating"]:checked').val();
        var package_uuid = $('#package_uuid').val();
        var reviewBtn = $('.reviewBtn');



        if (!rating) {
            showAlert('danger', 'Rating is required');
            return;
        }
        if (!review) {
            showAlert('danger', 'Review is required');
            return;
        }

        reviewBtn.prop('disabled', true); 

        $.ajax({
            url: "{{ route('rating-save') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                package_uuid: package_uuid,
                rating: rating,
                review:review
            },
            success: function(response) {
                if (response.success) {
                    $('#reviewForm')[0].reset();
                    showAlert('success', response.message);
                } else {
                    showAlert('danger', response.message || 'Failed to send OTP, please try again.');
                    reviewBtn.prop('disabled', false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    showAlert('danger', errors.package_uuid ? errors.package_uuid[0] : 'Validation error');
                } else {
                    var message = xhr.responseJSON && xhr.responseJSON.message;
                    showAlert('danger', message ? message : 'An error occurred. Please try again.');
                }
                sendOtpButton.prop('disabled', false); // Re-enable the Send OTP button on error
            }
        });
    }

    function showAlert(type, message) {
        var alertContainer = $('#alert-container');
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

  <script>
  // Initialize intl-tel-input with India as the default country
  var input = document.querySelector("#CountryCode1"); // Corrected to reference phone number input
  var countryCodeInput = document.querySelector("#CountryCode"); // Get country code input field
  var iti = window.intlTelInput(input, {
    initialCountry: "in", // Set default country to India
    separateDialCode: true, // Enables separate country code dropdown
    geoIpLookup: function(callback) {
      fetch("https://ipinfo.io?token=<YOUR_TOKEN>", {
        headers: { 'Accept': 'application/json' }
      })
      .then((resp) => resp.json())
      .then((resp) => callback(resp.country))
      .catch(() => callback("IN")); // Default to India
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
  });

  // Set the initial country code to +91
  countryCodeInput.value = '+91';

  // Update the country code field when the country is selected
  input.addEventListener('countrychange', function() {
    var dialCode = iti.getSelectedCountryData().dialCode;
    countryCodeInput.value = '+' + dialCode; // Set the country code in the hidden field
  });

  // Format phone number before submitting
  document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Get the entered phone number without the dial code
    var phoneNumber = input.value.trim();

    // Submit the form with the phone number and separate country code
    this.submit();
  });
  </script>
@endsection