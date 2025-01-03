@extends('admin.layouts.master')
@section('content')

<div class="row row-cards">
	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-primary shadow-primary">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{$getUsers}}</h3>
							<p class="text-white mt-1">Total Users </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-user"></i>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-info shadow-info">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\Blog::count()}}</h3>
							<p class="text-white mt-1">Total Blogs </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-pencil"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-warning shadow-info">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\Vlog::count()}}</h3>
							<p class="text-white mt-1">Total Vlogs </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-video-camera"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-secondary shadow-info">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\Package::where('data_for','package')->distinct('uuid')->count()}}</h3>
							<p class="text-white mt-1">Total Packages </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-list"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-danger shadow-info">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\TravelCourse::count()}}</h3>
							<p class="text-white mt-1">Total Travel Courses </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-plane"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-success shadow-info">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\Booking::count()}}</h3>
							<p class="text-white mt-1">Total Booking Inquiries </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-pencil"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
		<div class="card card-counter bg-gradient-primary shadow-primary">
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div class="mt-4 mb-0 text-white">
							<h3 class="mb-0">{{App\Models\ContactUs::count()}}</h3>
							<p class="text-white mt-1">Total Contact Us </p>
						</div>
					</div>
					<div class="col-4">
						<i class="fa fa-envelope"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
			<div class="card-header ">
				<h3 class="card-title">Todays Booking Inquiry</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="example" class="table table-striped table-bordered w-100">
					  <thead>
					    <tr>
					      <th scope="col"></th>
					      <th scope="col">#</th>
					      <th scope="col">User</th>
					      <th scope="col">Booking For</th>
					      <th scope="col">Name</th>
					      <th scope="col">Destination</th>
					      <th scope="col">Date</th>
					      <th scope="col">Pax</th>
					      <th scope="col">Payable Amount</th>
					      <th scope="col">Status</th>
					      <th scope="col" width="10%">Action</th>
					    </tr>
					  </thead>
					  <tbody>
					    @php $i = 0 @endphp
						@foreach(App\Models\Booking::whereDate('created_at','LIKE','%'.date('Y-m-d'.'%'))->get() as $rows)
					    <tr>
					      <td>
					        <label class="custom-control custom-checkbox">
					          <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
					          <span class="custom-control-label"></span>
					        </label>
					      </td>
					      <td>{!! ++$i !!}</td>
					      <th scope="row">{{$rows->user->name}}</th>
					      <td>{{$rows->package->data_for}}</td>
					      <td>{{$rows->package_name}}</td>
					      <td>{{$rows->destination_name}}</td>
					      <td>{{$rows->start_date}} - {{$rows->end_date}}</td>
					      <td>
					        <p>Adults : {{$rows->number_of_adults}}</p>
					        <p>Children : {{$rows->number_of_children}}</p>
					        <p>Infants : {{$rows->number_of_infants}}</p>
					      </td>
					      <td>{{$rows->payable_amount}}</td>
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
					                  <h6 class="modal-title">Booking Inquiry Details</h6>
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
					                          <p><strong>Contact Name:</strong> {!! $rows->user->name !!}</p>
					                          <p><strong>Phone Number:</strong> {!! $rows->user->mobile !!}</p>
					                          <p><strong>Contact Email:</strong> {!! $rows->user->email !!}</p>
					                        </div>
					                      </div>
					                    </div>
					                    <div class="col-md-6">
					                      <div class="card mb-3">
					                        <div class="card-body">
					                          <h6 class="card-title">Basic Information</h6>
					                          <p><strong>Package Name:</strong> {!! $rows->package_name !!}</p>
					                          <p><strong>Destination Name:</strong> {!! $rows->destination_name !!}</p>
					                          <p><strong>City of Departure:</strong> {!! $rows->city_of_departure !!}</p>
					                          <p><strong>Number of Adults:</strong> {!! $rows->number_of_adults !!}</p>
					                          <p><strong>Number of Children:</strong> {!! $rows->number_of_children !!}</p>
					                          <p><strong>Number of Infants:</strong> {!! $rows->number_of_infants !!}</p>
					                        </div>
					                      </div>
					                    </div>
					                    <div class="col-md-6">
					                      <div class="card mb-3">
					                        <div class="card-body">
					                          <h6 class="card-title">Additional Details</h6>
					                          <p><strong>Start Date:</strong> {!! $rows->start_date !!} </p>
					                          <p><strong>End Date:</strong> {{$rows->end_date}}</p>
					                          <p><strong>Price:</strong> {!! $rows->price !!}</p>
					                          <p><strong>Coupon Code:</strong> {!! $rows->coupon_code !!}</p>
					                          <p><strong>Coupon Code Discount:</strong> {!! $rows->coupon_code_discount !!}</p>
					                          <p><strong>Payable Amount:</strong> {!! $rows->payable_amount !!}</p>
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
		</div>
	</div>

	
</div>

@endsection
@section('extrajs')
<script src="{{asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>
<script src="{{asset('assets/plugins/echarts/echarts.js')}}"></script>
<script src="{{asset('assets/plugins/highcharts/highcharts.js')}}"></script>


@endsection

