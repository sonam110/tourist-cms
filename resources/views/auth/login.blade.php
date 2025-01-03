@extends('layouts.master-front')
@section('content')
<style type="text/css">
    @if(empty(Session::get('email')))
    .otp {
        display: none;

    }

    .resend-otp {
        display: none;
        margin-top: 10px;
    }
    @else
    .otp_button{
        display: none;
    }
    @endif
</style>

<!-- Here your page content START -->
<section class="sign-signup-section">
  <div class="container">
    <div class="form-signin">
      <h3 class="mb-3">Sign In</h3>
      <p class="mb-4 mt-3">New user?
        <a href="{{ url('register') }}" class="fw-bold">Create an account</a></p>

        <!-- Alert messages will be dynamically inserted here by JavaScript -->
        <div id="alert-container"></div>

        <form id="login-form">
            @csrf
            <input type="hidden" name="backUrl" id="backUrl" value="{{@$_SERVER['HTTP_REFERER']}}">
            <div class="form-floating mb-4">
               <input type="email" class="form-control" id="email" placeholder="Email address" required name="email" value="{{ Session::get('email') }}">

               <label for="email">Email address</label>
           </div>

            <div class="form-floating mb-4">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @if ($errors->has('gRecaptcha'))
                      <span class="help-block">
                          <strong>{{ $errors->first('gRecaptcha') }}</strong>
                      </span>
                @endif
            </div>

           <h5 class="mb-4 mt-4 otp">Enter Your 4 digit OTP</h5>
           <div class="d-flex justify-content-between mb-4 otp">
            <input class="form-control otp-input otp" type="number" max="9" id="otp-input-1" maxlength="1" oninput="updateOtp(event)" required>
            <input class="form-control otp-input otp" type="number" max="9" id="otp-input-2" maxlength="1" oninput="updateOtp(event)" required>
            <input class="form-control otp-input otp" type="number" max="9" id="otp-input-3" maxlength="1" oninput="updateOtp(event)" required>
            <input class="form-control otp-input otp" type="number" max="9" id="otp-input-4" maxlength="1" oninput="updateOtp(event)" required>
            <input type="hidden" name="otp" id="otp-hidden-input">
        </div>
        <button class="btn btn-warning-custom w-100 mb-4 fw-bold otp_button" onclick="userLogin(event)" type="button">Send Otp</button>
        <button class="btn btn-warning-custom w-100 mb-4 fw-bold otp" type="button" onclick="verifyOtpAndLogin(event)">Login</button>
        <div class="resend-otp text-center">
            <span id="resend-timer">Resend OTP in <span id="resend-countdown">60</span> seconds</span>
            <button class="btn btn-link fw-bold" id="resend-otp-button" onclick="userLogin(event)" disabled>Resend OTP</button>
        </div>
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
</div>
</div>
</section>
<!-- Here your page content END -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    });

    function userLogin(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var email = $('#email').val();
    var gRecaptcha = $('#g-recaptcha-response').val();
    var sendOtpButton = $('.otp_button');
    var resendOtpButton = $('#resend-otp-button');
    
    if (!email) {
        showAlert('danger', 'Email is required');
        return;
    }

    sendOtpButton.prop('disabled', true); // Disable the Send OTP button
    resendOtpButton.prop('disabled', true);

    $.ajax({
        url: "{{ route('user.login') }}",
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            email: email,
            gRecaptcha: gRecaptcha
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                $('.otp').show(); // Show the OTP elements
                $('.otp_button').hide(); // Hide the Send OTP button
                $('.resend-otp').show(); // Show the Resend OTP section
                startResendOtpTimer(); // Start the resend OTP timer
            } else {
                showAlert('danger', response.message || 'Failed to send OTP, please try again.');
                sendOtpButton.prop('disabled', false); // Re-enable the Send OTP button on failure
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                showAlert('danger', errors.email ? errors.email[0] : 'Validation error');
            } else {
                var message = xhr.responseJSON && xhr.responseJSON.message;
                showAlert('danger', message ? message : 'An error occurred. Please try again.');
            }
            sendOtpButton.prop('disabled', false); // Re-enable the Send OTP button on error
        }
    });
}

function startResendOtpTimer() {
    var countdownElement = $('#resend-countdown');
    var resendOtpButton = $('#resend-otp-button');
    var countdown = 60;

    var interval = setInterval(function() {
        countdown--;
        countdownElement.text(countdown);

        if (countdown <= 0) {
            clearInterval(interval);
            resendOtpButton.prop('disabled', false);
            countdownElement.text('0');
        }
    }, 1000); // 1 second interval
}


$(document).ready(function() {
        @if(Session::has('email'))
            startResendOtpTimer();
        @endif
    });

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
    }, 10000); // Automatically dismiss after 10 seconds
}

function updateOtp(event) {
    const currentInput = event.target;
    const maxLength = currentInput.maxLength;

    // Enforce single digit input
    if (currentInput.value.length > maxLength) {
        currentInput.value = currentInput.value.slice(0, maxLength);
    }

    // Move focus to the next input if the current input is filled
    if (currentInput.value.length >= maxLength) {
        const nextInputId = parseInt(currentInput.id.split('-').pop()) + 1;
        const nextInput = document.getElementById(`otp-input-${nextInputId}`);
        
        if (nextInput) {
            nextInput.focus(); // Move focus to the next input
        }
    }

    // Update the hidden input value
    const otp1 = document.getElementById('otp-input-1').value;
    const otp2 = document.getElementById('otp-input-2').value;
    const otp3 = document.getElementById('otp-input-3').value;
    const otp4 = document.getElementById('otp-input-4').value;

    document.getElementById('otp-hidden-input').value = otp1 + otp2 + otp3 + otp4;
}

function verifyOtpAndLogin(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    var email = $('#email').val();
    var otp = $('#otp-hidden-input').val();
    var backUrl = $('#backUrl').val();

    $.ajax({
        url: "{{ route('verify-otp') }}",
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}',
            email: email,
            otp: otp,
        },
        success: function(response) {
            if (response.success) {
                if(backUrl!='')
                {
                    window.location.href = backUrl;
                }
                else
                {
                    window.location.href = response.redirectUrl;
                }
            } else {
                showAlert('danger', response.message || 'Failed to verify OTP, please try again.');
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                showAlert('danger', errors.email ? errors.email[0] : 'Validation error');
            } else {
                var message = xhr.responseJSON && xhr.responseJSON.message;
                showAlert('danger', message ? message : 'An error occurred. Please try again.');
            }
        }
    });
}
</script>
@endsection
