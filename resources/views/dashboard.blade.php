@extends('layouts.master')
@section('content')
@include('common.slider')
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
							<h3 class="mb-0">{{App\Models\Package::count()}}</h3>
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
							<h3 class="mb-0">{{App\Models\BookingInquiry::count()}}</h3>
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
								<th scope="col">Destination</th>
								<th scope="col">DOD</th>
								<th scope="col">Name</th>
								<th scope="col">Number</th>
								<th scope="col">Email</th>
								<th scope="col">Status</th>
								<th scope="col" width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							@php $i = 0 @endphp
							@foreach(App\Models\BookingInquiry::whereDate('created_at','Y-m-d')->get() as $rows)
							<tr>
								<td>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
										<span class="custom-control-label"></span>
									</label>
								</td>
								<td>{!! ++$i !!}</td>
								<td>{!! $rows->destination_name !!}</td>
								<td>{!! $rows->date_of_departure !!}</td>
								<td>{!! $rows->contact_name !!}</td>
								<td>{!! $rows->phone_number !!}</td>
								<td>{!! $rows->email !!}</td>
								<td class="text-center">
									@if($rows->status == '3') 
									<span class="text-danger">Rejected</span>
									@elseif($rows->status == '2')
									<span class="text-success">Processed</span>
									@elseif($rows->status == '1')
									<span class="text-info">Verified</span>
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
																		<p><strong>Contact Name:</strong> {!! $rows->contact_name !!}</p>
																		<p><strong>Phone Number:</strong> {!! $rows->phone_number !!}</p>
																		<p><strong>Contact Email:</strong> {!! $rows->email !!}</p>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="card mb-3">
																	<div class="card-body">
																		<h6 class="card-title">Basic Information</h6>
																		<p><strong>Destination Type:</strong> {!! $rows->destination_type == 1 ? 'Domestic' : 'International' !!}</p>
																		<p><strong>Package Name:</strong> {!! $rows->package_name !!}</p>
																		<p><strong>Destination Name:</strong> {!! $rows->destination_name !!}</p>
																		<p><strong>Date of Departure:</strong> {!! $rows->date_of_departure !!}</p>
																		<p><strong>City of Departure:</strong> {!! $rows->city_of_departure !!}</p>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="card mb-3">
																	<div class="card-body">
																		<h6 class="card-title">Additional Details</h6>
																		<p><strong>Number of Adults:</strong> {!! $rows->number_of_adults !!}</p>
																		<p><strong>Number of Children:</strong> {!! $rows->number_of_children !!}</p>
																		<p><strong>Number of Infants:</strong> {!! $rows->number_of_infants !!}</p>
																		<p><strong>Budget:</strong> {!! $rows->budget !!}</p>
																		<p><strong>Coupon Code:</strong> {!! $rows->coupon_code !!}</p>
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

