@extends('layouts.master-front')

@section('extracss')
<!-- CSS for intl-tel-input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style type="text/css">
  .iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 100px;
    }
    .iti__flag-container
    {
      padding: 7px;
    }
  </style>

@endsection

@section('content')
<section class="account-section padding">
    <!-- <div class="account-cover" id="user-banner-pic">
    <img src="{{asset('img/images/account-cover-img.jpg')}}" alt="cover" />
  </div>
  <div class="container">
    <div class="row"> -->
      @include('user.side_menu')
      <div class="col-lg-9 col-md-8">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form id="update-profile-form" action="{{ route('user.update-profile') }}" class="booking-information" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-8">
                  <div class="booking-item  mb-30">
                    <h3 class="booking-title">Full Name</h3>
                    <div class="booking-form">
                      <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" placeholder="Enter your name" required=""/>
                    </div>
                  </div>
                  <div class="booking-item mb-30">
                    <h3 class="booking-title">Email Address</h3>
                    <div class="booking-form">
                      <input type="email" id="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Enter your Email"/>
                    </div>
                  </div>
                  <div class="booking-item mb-30">
                    <h3 class="booking-title">Phone Number</h3>
                    <div class="booking-form d-flex" >
                      <input type="text" id="CountryCode1" class="form-control"  style="height: 60px;">
                      <input type="hidden" class="form-control" id="CountryCode" placeholder="Country Code" required name="country_code" value="{{$user->country_code}}" readonly>
                      <input type="text" id="mobile" name="mobile" class="form-control" value="{{$user->mobile}}" placeholder="Enter your mobile number" />
                    </div>
                  </div>

                </div>

                <div class="col-md-4">
                  <div class="booking-item mb-30">
                    <h3 class="booking-title">Profile Image</h3>
                    <small>(W:120px H:120px)</small>
                    <div class="mt-3 text-center">
                      <img id="profile-image-preview" src="{{asset('/'.$user->profile_image)}}" alt="Profile Image Preview" style="max-width: 100%"/>
                    </div>
                    <br>
                    <div class="booking-form">
                      <input type="file" id="profile_image" name="profile_image" class="form-control" />
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="booking-item mb-30">
                    <h3 class="booking-title">Banner Image</h3>
                    <small>(W:1250px H:250px)</small>
                    <div class="mt-3">
                      <img id="banner-image-preview" src="{{asset('/'.$user->banner_image)}}" alt="Banner Image Preview" style="max-width: 100%;" />
                    </div>
                    <br>
                    <div class="booking-form">
                      <input type="file" id="banner_image" name="banner_image" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="booking-item address mb-30">
                    <h3 class="booking-title">Address</h3>
                    <div class="booking-form">
                      <div class="form-group">
                        <textarea id="address" name="address" cols="30" rows="5" class="form-control address" placeholder="Enter your address">{{$user->address}}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div id="alert-container"></div>
                <div class="booking-item text-center">
                  <button type="submit" class="pxs-primary-btn">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('extrajs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ./account-section -->
<script>
  $(document).ready(function() {
    // Handle profile form submission
    $('#update-profile-form').on('submit', function(e) {
      e.preventDefault();

      var formData = new FormData(this);

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.status === 'success') {
            $('#user-profile-pic').html(`<img src="${response.profile_image_url}" alt="user" style="width: 120px; height: 120px;" />`);
            $('#user-banner-pic').html(`<img src="${response.banner_image_url}" alt="user" style="width: 100%; height: 250px;" />`);
            showAlert('success', response.message);
          } else {
            showAlert('danger', response.message || 'Failed to update profile, please try again.');
          }
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = '';
            $.each(errors, function(key, value) {
              errorMessages += value[0] + '<br>';
            });
            showAlert('danger', errorMessages);
          } else {
            var message = xhr.responseJSON && xhr.responseJSON.message;
            showAlert('danger', message ? message : 'An error occurred. Please try again.');
          }
        }
      });
    });

    // Handle profile image preview
    $('#profile_image').on('change', function() {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#profile-image-preview').attr('src', e.target.result);
          $('#profile-image-preview').show();
        }
        reader.readAsDataURL(file);
      } else {
        $('#profile-image-preview').hide();
      }
    });

    // Handle profile image preview
    $('#banner_image').on('change', function() {
      var file = this.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#banner-image-preview').attr('src', e.target.result);
          $('#banner-image-preview').show();
        }
        reader.readAsDataURL(file);
      } else {
        $('#banner-image-preview').hide();
      }
    });

    // Show alert function
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
    // Initialize intl-tel-input with the user's default country code
var input = document.querySelector("#CountryCode1"); // Phone number input
var countryCodeInput = document.querySelector("#CountryCode"); // Country code input field

// Map of dial codes to ISO 2-letter country codes
// Comprehensive Map of Dial Codes to ISO 2-letter Country Codes
var countryDialCodeMap = {
  "+93": "af",   // Afghanistan
  "+355": "al",  // Albania
  "+213": "dz",  // Algeria
  "+1684": "as", // American Samoa
  "+376": "ad",  // Andorra
  "+244": "ao",  // Angola
  "+1264": "ai", // Anguilla
  "+672": "aq",  // Antarctica
  "+54": "ar",   // Argentina
  "+374": "am",  // Armenia
  "+297": "aw",  // Aruba
  "+61": "au",   // Australia
  "+43": "at",   // Austria
  "+994": "az",  // Azerbaijan
  "+1242": "bs", // Bahamas
  "+973": "bh",  // Bahrain
  "+880": "bd",  // Bangladesh
  "+1246": "bb", // Barbados
  "+375": "by",  // Belarus
  "+32": "be",   // Belgium
  "+501": "bz",  // Belize
  "+229": "bj",  // Benin
  "+1441": "bm", // Bermuda
  "+975": "bt",  // Bhutan
  "+591": "bo",  // Bolivia
  "+387": "ba",  // Bosnia and Herzegovina
  "+267": "bw",  // Botswana
  "+55": "br",   // Brazil
  "+246": "io",  // British Indian Ocean Territory
  "+673": "bn",  // Brunei Darussalam
  "+359": "bg",  // Bulgaria
  "+226": "bf",  // Burkina Faso
  "+257": "bi",  // Burundi
  "+855": "kh",  // Cambodia
  "+237": "cm",  // Cameroon
  "+1": "ca",    // Canada
  "+238": "cv",  // Cape Verde
  "+1345": "ky", // Cayman Islands
  "+236": "cf",  // Central African Republic
  "+235": "td",  // Chad
  "+56": "cl",   // Chile
  "+86": "cn",   // China
  "+61": "cx",   // Christmas Island
  "+57": "co",   // Colombia
  "+269": "km",  // Comoros
  "+242": "cg",  // Congo (Brazzaville)
  "+243": "cd",  // Congo (Kinshasa)
  "+682": "ck",  // Cook Islands
  "+506": "cr",  // Costa Rica
  "+385": "hr",  // Croatia
  "+53": "cu",   // Cuba
  "+599": "cw",  // Curacao
  "+357": "cy",  // Cyprus
  "+420": "cz",  // Czech Republic
  "+45": "dk",   // Denmark
  "+253": "dj",  // Djibouti
  "+1767": "dm", // Dominica
  "+1": "do",    // Dominican Republic
  "+593": "ec",  // Ecuador
  "+20": "eg",   // Egypt
  "+503": "sv",  // El Salvador
  "+240": "gq",  // Equatorial Guinea
  "+291": "er",  // Eritrea
  "+372": "ee",  // Estonia
  "+268": "sz",  // Eswatini (Swaziland)
  "+251": "et",  // Ethiopia
  "+500": "fk",  // Falkland Islands (Malvinas)
  "+298": "fo",  // Faroe Islands
  "+679": "fj",  // Fiji
  "+358": "fi",  // Finland
  "+33": "fr",   // France
  "+594": "gf",  // French Guiana
  "+689": "pf",  // French Polynesia
  "+241": "ga",  // Gabon
  "+220": "gm",  // Gambia
  "+995": "ge",  // Georgia
  "+49": "de",   // Germany
  "+233": "gh",  // Ghana
  "+350": "gi",  // Gibraltar
  "+30": "gr",   // Greece
  "+299": "gl",  // Greenland
  "+1473": "gd", // Grenada
  "+590": "gp",  // Guadeloupe
  "+1671": "gu", // Guam
  "+502": "gt",  // Guatemala
  "+224": "gn",  // Guinea
  "+245": "gw",  // Guinea-Bissau
  "+592": "gy",  // Guyana
  "+509": "ht",  // Haiti
  "+39": "va",   // Holy See (Vatican City State)
  "+504": "hn",  // Honduras
  "+852": "hk",  // Hong Kong
  "+36": "hu",   // Hungary
  "+354": "is",  // Iceland
  "+91": "in",   // India
  "+62": "id",   // Indonesia
  "+98": "ir",   // Iran
  "+964": "iq",  // Iraq
  "+353": "ie",  // Ireland
  "+972": "il",  // Israel
  "+39": "it",   // Italy
  "+1876": "jm", // Jamaica
  "+81": "jp",   // Japan
  "+962": "jo",  // Jordan
  "+7": "kz",    // Kazakhstan
  "+254": "ke",  // Kenya
  "+686": "ki",  // Kiribati
  "+965": "kw",  // Kuwait
  "+996": "kg",  // Kyrgyzstan
  "+856": "la",  // Lao
  "+371": "lv",  // Latvia
  "+961": "lb",  // Lebanon
  "+266": "ls",  // Lesotho
  "+231": "lr",  // Liberia
  "+218": "ly",  // Libya
  "+423": "li",  // Liechtenstein
  "+370": "lt",  // Lithuania
  "+352": "lu",  // Luxembourg
  "+853": "mo",  // Macau
  "+389": "mk",  // Macedonia
  "+261": "mg",  // Madagascar
  "+265": "mw",  // Malawi
  "+60": "my",   // Malaysia
  "+960": "mv",  // Maldives
  "+223": "ml",  // Mali
  "+356": "mt",  // Malta
  "+692": "mh",  // Marshall Islands
  "+596": "mq",  // Martinique
  "+222": "mr",  // Mauritania
  "+230": "mu",  // Mauritius
  "+262": "yt",  // Mayotte
  "+52": "mx",   // Mexico
  "+691": "fm",  // Micronesia
  "+373": "md",  // Moldova
  "+377": "mc",  // Monaco
  "+976": "mn",  // Mongolia
  "+382": "me",  // Montenegro
  "+1664": "ms", // Montserrat
  "+212": "ma",  // Morocco
  "+258": "mz",  // Mozambique
  "+95": "mm",   // Myanmar
  "+264": "na",  // Namibia
  "+674": "nr",  // Nauru
  "+977": "np",  // Nepal
  "+31": "nl",   // Netherlands
  "+687": "nc",  // New Caledonia
  "+64": "nz",   // New Zealand
  "+505": "ni",  // Nicaragua
  "+227": "ne",  // Niger
  "+234": "ng",  // Nigeria
  "+683": "nu",  // Niue
  "+672": "nf",  // Norfolk Island
  "+850": "kp",  // North Korea
  "+1670": "mp", // Northern Mariana Islands
  "+47": "no",   // Norway
  "+968": "om",  // Oman
  "+92": "pk",   // Pakistan
  "+680": "pw",  // Palau
  "+970": "ps",  // Palestinian Territory
  "+507": "pa",  // Panama
  "+675": "pg",  // Papua New Guinea
  "+595": "py",  // Paraguay
  "+51": "pe",   // Peru
  "+63": "ph",   // Philippines
  "+48": "pl",   // Poland
  "+351": "pt",  // Portugal
  "+1": "pr",    // Puerto Rico
  "+974": "qa",  // Qatar
  "+262": "re",  // Reunion
  "+40": "ro",   // Romania
  "+7": "ru",    // Russia
  "+250": "rw",  // Rwanda
  "+590": "bl",  // Saint Barthelemy
  "+290": "sh",  // Saint Helena
  "+1869": "kn", // Saint Kitts and Nevis
  "+1758": "lc", // Saint Lucia
  "+590": "mf",  // Saint Martin
  "+508": "pm",  // Saint Pierre and Miquelon
  "+1784": "vc", // Saint Vincent and the Grenadines
  "+685": "ws",  // Samoa
  "+378": "sm",  // San Marino
  "+239": "st",  // Sao Tome and Principe
  "+966": "sa",  // Saudi Arabia
  "+221": "sn",  // Senegal
  "+381": "rs",  // Serbia
  "+248": "sc",  // Seychelles
  "+232": "sl",  // Sierra Leone
  "+65": "sg",   // Singapore
  "+421": "sk",  // Slovakia
  "+386": "si",  // Slovenia
  "+677": "sb",  // Solomon Islands
  "+252": "so",  // Somalia
  "+27": "za",   // South Africa
  "+82": "kr",   // South Korea
  "+211": "ss",  // South Sudan
  "+34": "es",   // Spain
  "+94": "lk",   // Sri Lanka
  "+249": "sd",  // Sudan
  "+597": "sr",  // Suriname
  "+268": "sz",  // Swaziland
  "+46": "se",   // Sweden
  "+41": "ch",   // Switzerland
  "+963": "sy",  // Syria
  "+886": "tw",  // Taiwan
  "+992": "tj",  // Tajikistan
  "+255": "tz",  // Tanzania
  "+66": "th",   // Thailand
  "+670": "tl",  // Timor-Leste
  "+228": "tg",  // Togo
  "+690": "tk",  // Tokelau
  "+676": "to",  // Tonga
  "+1868": "tt", // Trinidad and Tobago
  "+216": "tn",  // Tunisia
  "+90": "tr",   // Turkey
  "+993": "tm",  // Turkmenistan
  "+1649": "tc", // Turks and Caicos Islands
  "+688": "tv",  // Tuvalu
  "+256": "ug",  // Uganda
  "+380": "ua",  // Ukraine
  "+971": "ae",  // United Arab Emirates
  "+44": "gb",   // United Kingdom
  "+1": "us",    // United States
  "+598": "uy",  // Uruguay
  "+998": "uz",  // Uzbekistan
  "+678": "vu",  // Vanuatu
  "+58": "ve",   // Venezuela
  "+84": "vn",   // Vietnam
  "+681": "wf",  // Wallis and Futuna
  "+212": "eh",  // Western Sahara
  "+967": "ye",  // Yemen
  "+260": "zm",  // Zambia
  "+263": "zw"   // Zimbabwe
};


// Get the user's country code from Blade (dial code format, e.g., +91)
var userCountryCode = "{{ $user->country_code }}"; // e.g., "+91"

// Convert userCountryCode to ISO 2-letter code
var initialCountryCode = countryDialCodeMap[userCountryCode] || "in"; // Default to India if not found

var iti = window.intlTelInput(input, {
  initialCountry: initialCountryCode, // Set default country based on user's dial code
  separateDialCode: true, // Enables separate country code dropdown
  geoIpLookup: function(callback) {
    fetch("https://ipinfo.io?token=<YOUR_TOKEN>", {
      headers: { 'Accept': 'application/json' }
    })
    .then((resp) => resp.json())
    .then((resp) => callback(resp.country))
    .catch(() => callback(initialCountryCode)); // Use user's country code or default to initialCountryCode
  },
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
});

// Set the initial country code in the hidden input
countryCodeInput.value = userCountryCode; // Keep the dial code format in the hidden field

// Update the country code field when the country is selected
input.addEventListener('countrychange', function() {
  var dialCode = iti.getSelectedCountryData().dialCode;
  countryCodeInput.value = '+' + dialCode; // Update hidden field with the new dial code
});

// Format phone number before submitting
document.querySelector('form').addEventListener('submit', function(e) {
  e.preventDefault();

  // Get the entered phone number without the dial code
  var phoneNumber = input.value.trim();

  // Submit the form with the phone number and separate country code
  this.submit();
});

});
</script>


<!-- JS for intl-tel-input -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>

@endsection
