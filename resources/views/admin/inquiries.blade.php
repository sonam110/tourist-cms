@extends('admin.layouts.master')
@section('content')

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
                  <td>{!! @$rows->package->package_name !!}</td>
                  <td>{!! $rows->name !!}</td>
                  <td>{!! $rows->email !!}</td>
                  <td>{!! $rows->mobile !!}</td>
                  <td>{!! $rows->travel_date !!}</td>
                  <td>{!! $rows->traveller_count !!}</td>
                  <td>{!! $rows->message !!}</td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <a class="btn btn-sm btn-danger" href="{{ route('inquiry-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>

@endsection
