@extends('admin.layouts.master')
@section('content')

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header ">
            <h3 class="card-title">Contact Us</h3>
            <div class="card-options">
                &nbsp;&nbsp;&nbsp;
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                    <i class="fa fa-mail-reply"></i>
                </a>
            </div>
        </div>
        <form action="{{ route('contact-us-action') }}" method="POST" class="form-horizontal" autocomplete="off">
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
                                <th scope="col">Phone</th>
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
                                <td>{!! $rows->first_name !!} {!! $rows->last_name !!}</td>
                                <td>{!! $rows->email !!}</td>
                                <td>{{ $rows->phone }}</td>
                                <td>{!! $rows->message !!}</td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @can('contact-us-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('contact-us-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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