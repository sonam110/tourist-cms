@extends('admin.layouts.master')
@section('content')
@if($appSetting->default_language == 10)
<form action="{{ route('booking-inquiry-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-question">
                        @if(Request::segment(2)==='add-booking-inquiry')
                            Add
                        @else
                            Edit
                        @endif
                        Booking Inquiry
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <!-- Destination -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" name="destination" id="destination" value="{{ old('destination') }}" class="form-control @error('destination') is-invalid @enderror" placeholder="Package Name / Destination Name" required>
                                @error('destination')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Date of Departure -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_departure" class="form-label">Date of Departure</label>
                                <input type="text" name="date_of_departure" id="date_of_departure" value="{{ old('date_of_departure') }}" class="form-control @error('date_of_departure') is-invalid @enderror" placeholder="Date of Departure" required readonly>
                                @error('date_of_departure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- City of Departure -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city_of_departure" class="form-label">City of Departure</label>
                                <input type="text" name="city_of_departure" id="city_of_departure" value="{{ old('city_of_departure') }}" class="form-control @error('city_of_departure') is-invalid @enderror" placeholder="City of Departure" required>
                                @error('city_of_departure')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_name" class="form-label">Your Name</label>
                                <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" class="form-control @error('contact_name') is-invalid @enderror" placeholder="Your Name" required>
                                @error('contact_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Mobile No." required pattern="\d{10}">
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email ID -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email" class="form-label">Email ID</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Your E-mail Address" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Number of Adults, Children, Infants -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adults" class="form-label">Adults</label>
                                <input type="number" name="adults" id="adults" value="{{ old('adults', 1) }}" class="form-control @error('adults') is-invalid @enderror" min="1" max="10" required>
                                @error('adults')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="children" class="form-label">Children</label>
                                <input type="number" name="children" id="children" value="{{ old('children', 0) }}" class="form-control @error('children') is-invalid @enderror" min="0" max="10">
                                @error('children')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="infants" class="form-label">Infants</label>
                                <input type="number" name="infants" id="infants" value="{{ old('infants', 0) }}" class="form-control @error('infants') is-invalid @enderror" min="0" max="10">
                                @error('infants')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-footer text-center">
                        <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@else

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header ">
        <h3 class="card-title">Inquiry</h3>
        <div class="card-options">
          &nbsp;&nbsp;&nbsp;
          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
            <i class="fa fa-mail-reply"></i>
          </a>
        </div>
      </div>
      <form action="{{ route('booking-inquiry-action') }}" method="POST" class="form-horizontal" autocomplete="off">
        @csrf
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">#</th>
                  <th scope="col">Package</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Mobile</th>
                  <th scope="col">Travel Date</th>
                  <th scope="col">Traveller Count</th>
                  <th scope="col">Message</th>
                  <th scope="col" width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 0 @endphp
                @foreach($data as $rows)
                <tr>
                  <td>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
                      <span class="custom-control-label"></span>
                    </label>
                  </td>
                  <td>{!! ++$i !!}</td>
                  <td>{!! $rows->package->name !!}</td>
                  <td>{!! $rows->name !!}</td>
                  <td>{!! $rows->email !!}</td>
                  <td>{!! $rows->mobile !!}</td>
                  <td>{!! $rows->travel_date !!}</td>
                  <td>{!! $rows->traveller_count !!}</td>
                  <td>{!! $rows->message !!}</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      @can('booking-inquiry-delete')
                      <a class="btn btn-sm btn-danger" href="{{ route('booking-inquiry-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                        <i class="fa fa-trash"></i>
                      </a>
                      @endcan
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endif

@endsection
