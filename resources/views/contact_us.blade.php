@extends('layouts.master-front')
@section('extracss')
<!-- CSS for intl-tel-input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style type="text/css">
  .iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 28%;
        margin-top: -30px;
}
.iti__flag-container
{
  padding: 7px;
}



.error_message{
    color:red;
}
</style>
@endsection
@section('content')
<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title">Contact <span>Us</span></h1>
            <p>
            </p>
        </div>
    </div>
</section>
<!-- ./ blog-page-header -->

<section class="contact-section padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="contact-content">
                    <h3 class="contact-title">
                     {{$appSetting->contact_title}}
                 </h3>
                 <p>{!! $appSetting->contact_description !!}</p>
                 <!-- <ul class="contact-list">
                    <li>
                        <img src="{{asset('img/icon/contact-location.png')}}" alt="contact" />
                        <span>{{$appSetting->address}} <br /> -->
                        <!-- </span>
                    </li>
                    <li>
                        <img src="{{asset('img/icon/contact-phone.png')}}" alt="contact" />
                        <a href="tel:{{$appSetting->mobilenum}}">{{$appSetting->mobilenum}}</a>
                    </li>
                    <li>
                        <img src="{{asset('img/icon/contact-envelope.png')}}" alt="contact" />
                        <a href="mailto:{{$appSetting->email}}">{{$appSetting->email}}</a>
                    </li>
                </ul> -->
                <br>
                @if(App\Models\Address::count() > 0)
                @forelse(App\Models\Address::get() as $address)
                <h4>{{$address->title}}</h4>
                <hr>
                <ul class="contact-list">
                    <li>
                        <img src="{{asset('img/icon/contact-location.png')}}" alt="contact" />
                        <span>{!! nl2br($address->address) !!} <br />
                            <!-- Kentucky 39495 -->
                        </span>
                    </li>
                    <li>
                        <img src="{{asset('img/icon/contact-phone.png')}}" alt="contact" />
                        <a href="tel:{{$address->mobilenum}}">{{$address->mobilenum}}</a>
                    </li>
                    <li>
                        <img src="{{asset('img/icon/contact-envelope.png')}}" alt="contact" />
                        <a href="mailto:{{$address->email}}">{{$address->email}}</a>
                    </li>
                </ul>
                <br>
                @empty
                @endforelse
                @endif
            </div>
        </div>
        <div class="col-lg-8">
            <div class="contact-form">
                <div class="pxs-contact-form">
                    <form action="{{ route('contact-us') }}" method="post" id="ajax_contact" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-6">
                                    <!-- @if ($errors->has('first_name'))
                                        <span class="error_message">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif -->
                                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Full Name" value="{{ old('first_name') }}" required />
                                    </div>
                                    <div class="form-group col-sm-6">
                                    <!-- @if ($errors->has('last_name'))
                                        <span class="error_message">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif -->
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                    <!-- @if ($errors->has('email'))
                                        <span class="error_message">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif -->
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                    <!-- @if ($errors->has('phone'))
                                        <span class="error_message">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif -->
                                        <div class="d-flex align-items-center">
                                          <!-- Country Code -->
                                          <input type="text" id="CountryCode1" class="form-control" placeholder="Country Code" style="width: 20%; height: 55px; display: inline;">
                                          <input type="hidden" id="CountryCode" name="country_code" value="+91">

                                          <!-- Phone -->
                                          <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required pattern="[0-9]{10}"  title="Please enter a valid 10-digit phone number" value="{{ old('phone') }}" style="width: 80%; height: 55px;">
                                        </div>

                                    </div>
                                    <div class="form-group col-12">
                                    <!-- @if ($errors->has('message'))
                                        <span class="error_message">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                        @endif -->
                                        <textarea id="message" name="message" cols="30" rows="5" class="form-control address" placeholder="Message" required>{{ old('message') }}</textarea>
                                    </div>

                                    <div class="form-group col-12" style="padding-bottom: 15px;">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                      </span>
                                      @endif
                                  </div>
                              </div>


                              <div class="form-item">
                                <button class="pxs-primary-btn submit" type="submit">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('extrajs')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.add('fade');
                setTimeout(function () {
                    alert.remove();
                }, 500);
            }
        }, 5000); // 5000 milliseconds = 5 seconds

        const phoneInput = this.value;
        const phonePattern = /^[0-9]{10}$/;

        if (!phonePattern.test(phoneInput)) {
            this.setCustomValidity('Please enter a valid 10-digit phone number.');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
<!-- ./account-section -->
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
