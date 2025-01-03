@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2) === 'visa-destinations')   
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visa Destination Management</h3>
                    <div class="card-options">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Destination Name</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $rows->destination_name }}</td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                                <a class="btn btn-sm btn-danger" href="{{ route('visa-destination-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
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
    <form action="{{ route('visa-destination-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                           Add  Visa Destination
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Destination Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="destination_name" class="form-label">Destination Name</label>
                                    <input type="text" name="destination_name" id="destination_name" value="{{ old('destination_name') }}" class="form-control @error('destination_name') is-invalid @enderror" placeholder="Destination Name" autocomplete="off" required>
                                    @error('destination_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            

                        <!-- Submit Button -->
                            <div class="col-md-4">
                              <label for="" class="form-label">&nbsp;</label>
                              <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                            </div>
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
      <div class="card-header">
        <h3 class="card-title">Visa Inquiry</h3>
        <div class="card-options">
          @can('destination-add')
          <a class="btn btn-sm btn-outline-primary" href="{{ route('visa-destinations') }}">
              <i class="fa fa-cc-visa"></i> Visa Destinations
          </a>
          &nbsp;&nbsp;&nbsp;
          @endcan
          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go Back">
            <i class="fa fa-mail-reply"></i>
          </a>
        </div>
      </div>
      <form action="{{ route('visa-action') }}" method="POST" class="form-horizontal" autocomplete="off">
        @csrf
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Mobile</th>
                  <th scope="col">Destination</th>
                  <th scope="col">Date</th>
                  <th scope="col">Pax</th>
                  <th scope="col">Status</th>
                  <th scope="col" width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 0 @endphp
                @foreach($data as $row)
                <tr>
                  <td>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" name="boxchecked[]" value="{{ $row->id }}" class="colorinput-input custom-control-input">
                      <span class="custom-control-label"></span>
                    </label>
                  </td>
                  <td>{{ ++$i }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->mobile }}</td>
                  <td>{{ $row->destination }}</td>
                  <td>{{ $row->travel_start_date }} <!-- - {{ $row->travel_end_date }} --></td>
                  <td>
                    <p>Adults: {{ $row->number_of_adults }}</p>
                    <p>Children: {{ $row->number_of_children }}</p>

                    <ul>
                    @if(!empty($row->children_ages))
                    @forelse(json_decode($row->children_ages) as $key=>$value)
                      <li>
                         Child {{$key+1}} Age : {{$value}}
                      </li>
                    @empty
                    @endforelse
                    @endif
                  </ul>
                  <p>Infants: {{ $row->number_of_infants }}</p>

                    <ul>
                    @if(!empty($row->infants_ages))
                    @forelse(json_decode($row->infants_ages) as $key=>$value)
                      <li>
                         Infant {{$key+1}} Age : {{$value}}
                      </li>
                    @empty
                    @endforelse
                    @endif
                  </ul>
                  </td>
                  <td class="text-center">
                    @if($row->status == '1')
                    <span class="text-info">Verified</span>
                    @elseif($row->status == '2')
                    <span class="text-success">Processed</span>
                    @elseif($row->status == '3') 
                    <span class="text-danger">Rejected</span>
                    @else 
                    <span class="text-warning">Pending</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#largeModal{{ $row->id }}" data-details="{{ json_encode($row) }}" title="View Details">
                        <i class="fa fa-eye"></i>
                      </a>
                      <div id="largeModal{{ $row->id }}" class="modal fade">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header pd-x-20">
                              <h6 class="modal-title">Visa Inquiry Details</h6>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body pd-20">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="card mb-3">
                                    <div class="card-body">
                                      <h6 class="card-title">Contact Information</h6>
                                      <p><strong>Contact Name:</strong> {{ $row->name }}</p>
                                      <p><strong>Phone Number:</strong> {{ $row->mobile }}</p>
                                      <p><strong>Contact Email:</strong> {{ $row->email }}</p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="card mb-3">
                                    <div class="card-body">
                                      <h6 class="card-title">Basic Information</h6>
                                      <p><strong>Destination:</strong> {{ $row->destination }}</p>
                                      <p><strong>Number of Adults:</strong> {{ $row->number_of_adults }}</p>
                                      <p><strong>Number of Children:</strong> {{ $row->number_of_children }}</p>
                                      <p><strong>Start Date:</strong> {{ $row->travel_start_date }}</p>
                                      <p><strong>End Date:</strong> {{ $row->travel_end_date }}</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a class="btn btn-sm btn-danger" href="javascript:;" data-toggle="tooltip" title="Delete">
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
      </form>
    </div>
  </div>
</div>
@endif
@endsection
