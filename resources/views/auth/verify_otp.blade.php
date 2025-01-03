@extends('layouts.master-front')
@section('content')
<!-- Login form Start -->
<section class="sign-signup-section">
  <div class="container">
    <div class="form-signin">
      <h3 class="mb-3">Sign In</h3>
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
      <form action="{{route('otp-verify')}}" method="post">
        @csrf
        <h5 class="mb-4 mt-4">Enter Your 4 digit OTP</h5>
        <input type="hidden" name="email" value="{{$email}}">
        <div class="d-flex justify-content-between mb-4">
            <input class="form-control otp-input" type="number" max="9" id="otp-input-1" maxlength="1" oninput="updateOtp()">
            <input class="form-control otp-input" type="number" max="9" id="otp-input-2" maxlength="1" oninput="updateOtp()">
            <input class="form-control otp-input" type="number" max="9" id="otp-input-3" maxlength="1" oninput="updateOtp()">
            <input class="form-control otp-input" type="number" max="9" id="otp-input-4" maxlength="1" oninput="updateOtp()">
            <input type="hidden" name="otp" id="otp-hidden-input">
        </div>
        


        <button class="btn btn-warning-custom w-100 fw-bold" type="submit">Submit PIN</button>
      </form>
      <p class="mb-4 pb-1">
          <form action="{{ route('user.login') }}" method="POST" style="display:inline;">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">
              Didn’t get the code? 
              <button type="submit" class="fw-bold" style="border:none; background:none; color:#007bff; padding:0; cursor:pointer;">
                  Resend
              </button>
          </form>
      </p>
    </div>
  </div>
</section>

<!-- Login form  END -->
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
    function updateOtp() {
        const otp1 = document.getElementById('otp-input-1').value;
        const otp2 = document.getElementById('otp-input-2').value;
        const otp3 = document.getElementById('otp-input-3').value;
        const otp4 = document.getElementById('otp-input-4').value;

        document.getElementById('otp-hidden-input').value = otp1 + otp2 + otp3 + otp4;
    }

    function updateOtp(event) {
    const currentInput = event.target;
    const maxLength = currentInput.maxLength;
    const nextInputId = parseInt(currentInput.id.split('-').pop()) + 1;
    const nextInput = document.getElementById(`otp-input-${nextInputId}`);

    if (currentInput.value.length >= maxLength && nextInput) {
        nextInput.focus(); // Move focus to the next input
    }

    // Update the hidden input value
    const otp1 = document.getElementById('otp-input-1').value;
    const otp2 = document.getElementById('otp-input-2').value;
    const otp3 = document.getElementById('otp-input-3').value;
    const otp4 = document.getElementById('otp-input-4').value;

    document.getElementById('otp-hidden-input').value = otp1 + otp2 + otp3 + otp4;
}

</script>
@endsection