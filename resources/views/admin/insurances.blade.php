@extends('admin.layouts.master')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header ">
        <h3 class="card-title">Insurance Inquiry</h3>
        <div class="card-options">
          &nbsp;&nbsp;&nbsp;
          <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
            <i class="fa fa-mail-reply"></i>
          </a>
        </div>
      </div>
      <form action="{{ route('insurance-action') }}" method="POST" class="form-horizontal" autocomplete="off">
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
                @foreach($data as $rows)
                <tr>
                  <td>
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
                      <span class="custom-control-label"></span>
                    </label>
                  </td>
                  <td>{!! ++$i !!}</td>
                  <td>{{ $rows->name }}</td>
                  <td>{{ $rows->email }}</td>
                  <td>{{ $rows->mobile }}</td>
                  <td>{{$rows->destination}}</td>
                  <td>{{$rows->travel_start_date}} - {{$rows->travel_end_date}}</td>
                  <td>
                    <p>Adults : {{$rows->number_of_adults}}</p>
                    <p>Children : {{$rows->number_of_children}}</p>
                    <ul>
                    @if(!empty($rows->children_ages))
                    @forelse(json_decode($rows->children_ages) as $key=>$value)
                      <li>
                         Child {{$key+1}} Age : {{$value}}
                      </li>
                    @empty
                    @endforelse
                    @endif
                  </ul>
                   <p>Infants: {{ $rows->number_of_infants }}</p>

                    <ul>
                    @if(!empty($rows->infants_ages))
                    @forelse(json_decode($rows->infants_ages) as $key=>$value)
                      <li>
                         Infant {{$key+1}} Age : {{$value}}
                      </li>
                    @empty
                    @endforelse
                    @endif
                  </ul>
                  </td>
                  <td class="text-center">
                    @if($rows->status == '1')
                    <span class="text-info">Verified</span>
                    @elseif($rows->status == '2')
                    <span class="text-success">Processed</span>
                    @elseif($rows->status == '3') 
                    <span class="text-danger">Rejected</span>
                    @else 
                    <span class="text-warning">Pending</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group btn-group-xs">
                      <a class="btn btn-sm btn-info" href="#" data-toggle="modal" data-target="#largeModal{{$rows->id}}" data-details="{{ json_encode($rows) }}" title="View Details">
                        <i class="fa fa-eye"></i>
                      </a>
                      <!-- Large Modal -->
                      <div id="largeModal{{$rows->id}}" class="modal fade">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header pd-x-20">
                              <h6 class="modal-title">Insurance Inquiry Details</h6>
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
                                      <p><strong>Contact Name:</strong> {!! $rows->name !!}</p>
                                      <p><strong>Phone Number:</strong> {!! $rows->mobile !!}</p>
                                      <p><strong>Contact Email:</strong> {!! $rows->email !!}</p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="card mb-3">
                                    <div class="card-body">
                                      <h6 class="card-title">Basic Information</h6>
                                      <p><strong>Destination:</strong> {!! $rows->destination !!}</p>
                                      <p><strong>Number of Adults:</strong> {!! $rows->number_of_adults !!}</p>
                                      <p><strong>Number of Children:</strong> {!! $rows->number_of_children !!}</p><p><strong>Start Date:</strong> {!! $rows->travel_start_date !!} </p>
                                      <p><strong>End Date:</strong> {{$rows->travel_end_date}}</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div><!-- modal-body -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>

                        </div><!-- modal-dialog -->
                      </div><!-- modal -->
                      @can('insurance-delete')
                      <a class="btn btn-sm btn-danger" href="{{ route('insurance-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
          <div class="row div-margin">
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-hand-o-right"></i>
                </span>
                <select name="cmbaction" class="form-control" id="cmbaction">
                  <option value="">Action</option>
                  <option value="Verify">Verify</option>
                  <option value="Process">Process</option>
                  <option value="Reject">Reject</option>
                  <option value="Delete">Delete</option>
                </select>
              </div>
            </div>
            <div class="col-md-8 col-sm-6 col-xs-6">
              <div class="input-group">
                <button type="submit" class="btn btn-danger pull-right" name="Action" onClick="return delrec(document.getElementById('cmbaction').value);">Apply</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
