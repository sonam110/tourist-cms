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

  <section class="sign-signup-section">
    <div class="container">
      <div class="form-signin">
        <h3 class="mb-3">Sign Up</h3>
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

        <form action="{{ route('signup-save') }}" method="POST" class="form-horizontal">
          @csrf
          <div class="form-floating mb-4">
            <input type="text" class="form-control" id="floatingInput" placeholder="Full Name" required name="name">
            <label for="floatingInput">Full Name <span class="text-warning">*</span></label>
          </div>
          <div class="form-floating mb-4">
            <input type="email" class="form-control" id="EmailAddress" placeholder="Email address" name="email">
            <label for="EmailAddress">Email address</label>
          </div>
          <div class="d-flex mb-4">
            <input type="text" id="CountryCode1" class="form-control" placeholder="&nbsp;"  style="height: 60px;">
            <input type="hidden" class="form-control" id="CountryCode" placeholder="Country Code" required name="country_code" value="+91" readonly style="width:20%" >
            <input type="tel" class="form-control ms-2" id="PhoneNumber" placeholder="Phone Number" required name="mobile" style=" flex: 1;">
          </div>

          <!-- <div class="form-floating mb-4">
            <input type="tel" class="form-control" id="PhoneNumber" placeholder="Phone Number" required name="mobile" >
            <label for="PhoneNumber">Phone Number <span class="text-warning">*</span></label>
          </div> -->

          <button class="btn btn-warning-custom w-100 mb-4 fw-bold" type="submit">Sign Up</button>
        </form>
        @if (env('IS_GOOGLE_LOGIN_ENABLED', false) || env('IS_FACEBOOK_LOGIN_ENABLED', false))
    <div class="text-center pb-4 position-relative">
        <div class="bg-line border-top border-1 position-relative top-50 start-0 w-100"></div>
        <span class="position-relative z-10 px-2 bg-white fw-bold">Or</span>
    </div>
    @if (env('IS_GOOGLE_LOGIN_ENABLED', false))
    <a href="{{ url('login/google') }}" class="btn btn-dark border w-100 mb-4 fw-bold btn-apple">
        <i class="fab fa-google pe-1"></i> 
        Continue with Google
    </a>
    @endif
    @if (env('IS_FACEBOOK_LOGIN_ENABLED', false))
    <a href="{{ url('login/facebook') }}" class="btn btn-primary w-100 mb-4 fw-bold btn-facebook">
        <i class="fab fa-facebook pe-1"></i> 
        Continue with Facebook
    </a>
    @endif
    @endif
        <!-- <div class="text-center pb-4 position-relative">
          <div class="bg-line  border-top border-1 position-relative top-50 start-0 w-100"></div>
          <span class="position-relative z-10 px-2 bg-white fw-bold">Or</span>
        </div>
        <a href="{{ url('login/google') }}" class="btn btn-dark border w-100 mb-4 fw-bold btn-apple">
          <i class="fab fa-google pe-1"></i> Continue with Google
        </a>
        <a href="{{ url('login/facebook') }}" class="btn btn-primary w-100 mb-4 fw-bold btn-facebook">
          <i class="fab fa-facebook pe-1"></i> Continue with Facebook
        </a> -->
      </div>
    </div>
  </section>
  @endsection

  @section('extrajs')

  <!-- JS for intl-tel-input -->
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
