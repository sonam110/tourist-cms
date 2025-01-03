@extends('layouts.master-front')
@section('content')
<section class="blog-page-header bg-grey">
    <div class="container">
        <div class="header-content text-center">
            <h1 class="blog-page-title">Insurance <span>Inquiry</span></h1>
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
                <div class="contact-form">
                    <div class="pxs-contact-form">
                        <div id="alert-container-i"></div>
                            <form class="form-horizontal" method="POST" action="" id="insuranceForm" action="{{route('insurance-save')}}">
                                <div class="tab-inner-con text-left">
                                    <div class="row">
                                        <!-- Location Input -->
                                        <div class="form-group col-md-3">
                                            <h3 class="box-title">Location</h3>
                                            <input type="text" id="i_destination" name="location" class="form-control" placeholder="Enter your location" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <h3 class="box-title">Travel Date</h3>
                                            <input type="date" class="form-control" name="start_date" value="{{date('d-m-Y')}}" id="i_start_date">
                                        </div>

                                        <!-- Adults Input -->
                                        <div class="form-group col-md-3">
                                            <h3 class="box-title">Adults</h3>
                                            <select class="form-control" name="adults" id="i_adults" required>
                                                <option value="" disabled selected>Select</option>
                                                <option value="1">01</option>
                                                <option value="2">02</option>
                                                <option value="3">03</option>
                                                <option value="4">04</option>
                                            </select>
                                        </div>

                                        <!-- Children Input -->
                                        <div class="form-group col-md-3">
                                            <h3 class="box-title">Children</h3>
                                            <select class="form-control" name="children" id="i_children" onchange="showChildrenAgeFields()">
                                                <option value="0">00</option>
                                                <option value="1">01</option>
                                                <option value="2">02</option>
                                                <option value="3">03</option>
                                            </select>
                                        </div>

                                        <div id="childrenAgeContainer" class="form-group" style="display: none;">
                                            <div id="childrenAgesFields"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group button-right form-only">
                                    <button onclick="insuranceSave(event)" id="iButton" class="d-inline-block pxs-primary-btn tabform-button insuranceBtn">Submit</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Automatically dismiss alerts after 5 seconds -->
<script>
    function showChildrenAgeFields() {
    const childrenCount = document.getElementById('i_children').value;
    const childrenAgeContainer = document.getElementById('childrenAgeContainer');
    const childrenAgesFields = document.getElementById('childrenAgesFields');

    childrenAgesFields.innerHTML = '';

    if (childrenCount > 0) {
        childrenAgeContainer.style.display = 'block';

        for (let i = 1; i <= childrenCount; i++) {
            const ageField = document.createElement('div');
            ageField.classList.add('form-group');
            ageField.innerHTML = `
            <input type="number" id="i_child_age_${i}" name="children_ages[]" class="form-control" min="0" max="12" placeholder="Child ${i} Age">
            `;
            childrenAgesFields.appendChild(ageField);
        }
    } else {
        childrenAgeContainer.style.display = 'none';
    }

    // <label for="child_age_${i}">Child ${i} Age</label>
}

function insuranceSave(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var destination = $('#i_destination').val();
    var start_date = $('#i_start_date').val();
    var adults = $('#i_adults').val();
    var children = $('#i_children').val();
    var children_ages = [];

    // Capture the ages of children if any
    $('input[name="children_ages[]"]').each(function() {
        children_ages.push($(this).val());
    });

    var iBtn = $('#iButton'); // Submit button

    iBtn.prop('disabled', true); // Disable button to prevent multiple submissions

    $.ajax({
        url: "{{ route('insurance-save') }}", // Replace with actual route
        type: "POST",
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            destination: destination,
            adults: adults,
            children: children,
            start_date: start_date,
            children_ages: children_ages
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message, 'alert-container-i');
                $('#insuranceForm')[0].reset(); // Optionally reset the form
                $('#childrenAgeContainer').hide(); // Hide children ages container
            } else {
                showAlert('danger', response.message || 'Failed to submit, please try again.', 'alert-container-i');
                iBtn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) { // Validation error
                var errors = xhr.responseJSON.errors;
                showAlert('danger', errors.destination || 'Validation error', 'alert-container-i');
            } else {
                var message = xhr.responseJSON && xhr.responseJSON.message;
                showAlert('danger', message ? message : 'An error occurred. Please try again.', 'alert-container-i');
            }
            iBtn.prop('disabled', false); // Re-enable the submit button on error
        }
    });
}

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
