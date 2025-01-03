@extends('layouts.master-front')
@section('content')

@section('extracss')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style type="text/css">
    .event-listing-items .event-listing-item
    {
        grid-template-columns: none !important;
    }
  .iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 28%;
    }
    .iti__flag-container
    {
      padding: 7px;
      height: 55px;
    }
  </style>

  @endsection

@include('common.slider')

<section class="blog-details padding bg-dark-deep">
    <div class="container">
        <div class="row blog-details-wrap">

            <div class="col-lg-8">
                <div class="event-listing-items" id="eventListing">
                    @forelse($visas as $package)
                    <div class="event-listing-item  {{$package->service->name}} {{$package->price}} {{ number_format($package->rating, 0) }} ">
                        <div class="event-listing-carousel swiper">
                            <div class="swiper-wrapper swiper-container">
                                @if(count($package->images) > 0)
                                @foreach($package->images as $image)
                                <div class="swiper-slide">
                                    <div class="event-listing-thumb">
                                        <a href="{{route('package-detail',$package->slug)}}"><img src="{{asset('/'.$image->image_path)}}" alt="{{$package->package_name}}" style="height:250px;" /></a>
                                        <div class="event-text feature"><span>{{$package->service->name}}</span></div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="event-listing-content">

                            <h3 class="event-listing-title">{{$package->package_name}}</h3>
                            <p>
                                @php
                                $content = strip_tags($package->content);
                                $limit = 200; // Set the character limit
                                $limitedContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
                                @endphp

                                {!! $limitedContent !!}
                            </p>
                            <ul class="event-list">
                                <li>
                                    <i class="fa-regular fa-clock"></i>
                                    <span>{{$package->duration}}</span>
                                </li>
                                <li>
                                    <i class="fa-regular fa-map"></i>
                                    <span>{{ optional($package->destination)->destination_type == '1' ? 'Domestic' : 'International' }}</span>

                                </li>

                                <li>
                                    <i class="fa-solid fa-location-dot text-primary"></i>
                                    <span>{{$package->destination->name}}</span>
                                </li>
                                <!-- <li><i class="fa-solid fa-star text-warning"></i>  <span> {{$package->rating}} ({{$package->reviews->count()}} reviews)</span></li> -->
                            <!-- <li>
                                <i class="fa fa-bookmark text-success"></i>  
                                <span> {{$package->bookings->count()}}  Bookings </span>
                            </li> -->
                        </ul>
                        <div class="event-price-wrap">
                            <h4 class="price">{{$package->icon}} {{ $package->price }}</h4>
                            <a href="{{ route('package-detail', $package->slug) . (request()->has('destination') ? '?' . http_build_query(request()->only('destination')) : '') }}" class="pxs-primary-btn">
                                Detail <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
                <br>
                <div>
                    {{ $visas->appends(request()->input())->links('common.pagination') }}
                    <br>
                </div>
            </div>
        </div>
        <div class="col-lg-4 contact-form">
            <div class="blog-wrapper pxs-contact-form event-sidebar">
                <div id="alert-container-v"></div>
                <form class="form-horizontal" method="POST" action="{{route('visa-save')}}" id="visaForm">
                    @csrf
                    <div class="tab-inner-con text-left">
                        <h3 class="text-center">Tell us your Dream destination, we'll make it happen!</h3>
                        <hr>
                        <div class="hero-box">
                            <!-- Name Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Name</h3>
                                <input type="text" id="v_name" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>

                            <!-- Email Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Email</h3>
                                <input type="email" id="v_email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <!-- Phone Number Input -->
                            <!-- Mobile Number Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Mobile Number</h3>
                                <div class="d-flex">
                                    <!-- Country Code Input -->
                                    <input 
                                        type="text" 
                                        id="v_country_code1" 
                                        class="form-control" 
                                        placeholder="&nbsp;" 
                                        style="width: 20%;height: " 
                                    >
                                    
                                    <!-- Hidden Country Code (for actual form submission) -->
                                    <input 
                                        type="hidden" 
                                        class="form-control" 
                                        id="v_country_code" 
                                        placeholder="Country Code" 
                                        required 
                                        name="country_code" 
                                        value="+91" 
                                        readonly
                                    >

                                    <!-- Mobile Number Input -->
                                    <input 
                                        type="tel" 
                                        class="form-control ms-2" 
                                        id="v_mobile" 
                                        placeholder="Phone Number" 
                                        required 
                                        name="mobile" 
                                        style="flex: 1;" 
                                    >
                                </div>
                            </div>


                            <!-- Location Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Location</h3>
                                <input type="text" id="v_destination" name="location" class="form-control" placeholder="Enter your location" required>
                            </div>

                            <!-- Travel Date Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Travel Date</h3>
                                <input type="date" class="form-control" name="start_date" value="{{date('d-m-Y')}}" id="v_start_date">
                            </div>

                            <!-- Adults Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Adults</h3>
                                <select class="form-control" name="adults" id="v_adults" required>
                                    <option value="" disabled selected>Select</option>
                                    @for($i = 1; $i <= 50; $i++ )
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Children Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Children</h3>
                                <select class="form-control" name="children" id="v_children" onchange="showChildrenAgeFieldsV()">
                                    @for($i = 0; $i <= 50; $i++ )
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div id="childrenAgeContainerV" class="form-group" style="display: none;">
                                <div id="childrenAgesFieldsV"></div>
                            </div> 

                            <!-- Infants Input -->
                            <div class="form-group">
                                <h3 class="box-title visa-form">Infants</h3>
                                <select class="form-control" name="infants" id="v_infants" onchange="showInfantsAgeFieldsV()">
                                    @for($i = 0; $i <= 50; $i++ )
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div id="infantsAgeContainerV" class="form-group" style="display: none;">
                                <div id="infantsAgesFieldsV"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group button-right form-only">
                        <button onclick="visaSave(event)" id="iButton" class="pxs-primary-btn submit visaBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

  <script>
  // Initialize intl-tel-input with India as the default country
  var input = document.querySelector("#v_country_code1"); // Corrected to reference phone number input
  var countryCodeInput = document.querySelector("#v_country_code"); // Get country code input field
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

@section('extrajs')
<script>
// Display child age select fields based on the number of children
function showChildrenAgeFieldsV() {
    const childrenCount = document.getElementById('v_children').value;
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
    const infantsCount = document.getElementById('v_infants').value;
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


function visaSave(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var destination = $('#v_destination').val();
    var start_date = $('#v_start_date').val();
    var adults = $('#v_adults').val();
    var children = $('#v_children').val();
    var infants = $('#v_infants').val();
    var name = $('#v_name').val();
    var email = $('#v_email').val();
    var country_code = $('#v_country_code').val();
    var mobile = $('#v_mobile').val();

    var children_ages = [];
    var infants_ages = [];

    // Capture the ages of children from select elements
    $('select[name="children_ages[]"]').each(function() {
        var age = $(this).val();
        if (age) {
            children_ages.push(parseInt(age));
        }
    });

    // Capture the ages of infants from select elements
    $('select[name="infants_ages[]"]').each(function() {
        var age = $(this).val();
        if (age) {
            infants_ages.push(parseInt(age));
        }
    });

    var iBtn = $('#vButton'); // Submit button
    iBtn.prop('disabled', true); // Disable button to prevent multiple submissions

    $.ajax({
        url: "{{ route('visa-save') }}", // Replace with actual route
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            destination: destination,
            start_date: start_date,
            adults: adults,
            children: children,
            name: name,
            email: email,
            country_code: country_code,
            mobile: mobile,
            children_ages: children_ages.length > 0 ? children_ages : null, // Send null if empty
            infants: infants,
            infants_ages: infants_ages.length > 0 ? infants_ages : null // Send null if empty
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message, 'alert-container-v');
                $('#visaForm')[0].reset(); // Optionally reset the form
                $('#childrenAgeContainerV, #infantsAgeContainerV').hide(); // Hide children and infants ages containers
            } else {
                showAlert('danger', response.message || 'Failed to submit, please try again.', 'alert-container-v');
                iBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation error
                var errors = xhr.responseJSON.errors;
                showAlert('danger', errors.destination || 'Validation error', 'alert-container-v');
                showAlert('danger', errors.email || 'Validation error', 'alert-container-v');
                showAlert('danger', errors.name || 'Validation error', 'alert-container-v');
                showAlert('danger', errors.adults || 'Validation error', 'alert-container-v');
                showAlert('danger', errors.mobile || 'Validation error', 'alert-container-v');
            } else {
                var message = xhr.responseJSON && xhr.responseJSON.message;
                showAlert('danger', message ? message : 'An error occurred. Please try again.', 'alert-container-v');
            }
            iBtn.prop('disabled', false); // Re-enable the submit button on error
        }
    });
}



function subscribe(event) {
    event.preventDefault(); 

    var email = $('#email').val();
    var commentBtn = $('.commentBtn');

    if (!email) {
        showAlert('danger', 'Email is required','alert-container');
        return;
    }

    commentBtn.prop('disabled', true); 

    $.ajax({
        url: "{{ route('newsletter-save') }}",
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            email:email
        },
        success: function(response) {
            if (response.success) {
                $('#newsletter-form')[0].reset();
                showAlert('success', response.message,'alert-container');
            } else {
                showAlert('danger', response.message || 'Failed to Subscribe, please try again.','alert-container');
                commentBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                showAlert('danger', errors.email ? errors.email[0] : 'Validation error','alert-container');
            } else {
                var message = xhr.responseJSON && xhr.responseJSON.message;
                showAlert('danger', message ? message : 'An error occurred. Please try again.','alert-container');
            }
                        commentBtn.prop('disabled', false); // Re-enable the Send OTP button on error
                    }
                });
}

// Function to show alert
function showAlert(type, message, alertcontainer) {
    var alertContainer = $('#'+alertcontainer);
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
@endsection
@endsection
