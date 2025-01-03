@extends('layouts.master')
 @section('extracss')
{!! Html::style('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') !!}
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header ">
            <h3 class="card-title ">Analytics</h3>
            <div class="card-options">
               &nbsp;&nbsp;&nbsp;<a href="{{ route('analytics') }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
            </div>
         </div>
         <div class="card-body p-12">
           <!--  {{ Form::open(array('url' => 'admin/analytics-import', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
            @csrf
            <div class="panel panel-primary">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label">Select User</label>
                  {!! Form::select('user_id', $allUsers,'', array('class' => 'form-control' ,'placeholder' => 'All Users' ,'id'=>'user_id')) !!}
                  @if ($errors->has('user_id'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('user_id') }}</strong>
                  </span>
                  @endif
                </div>
               </div>
               <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label">Select Game</label>
                  {!! Form::select('game_id', $allGames,'', array('class' => 'form-control' ,'placeholder' => 'All Games' ,'id'=>'game_id')) !!}
                  @if ($errors->has('game_id'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('game_id') }}</strong>
                  </span>
                  @endif
                </div>
               </div>
               
               <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label">Choose Files</label>
                  <div class="input-group"> 
                      <span class="btn btn-outline-primary btn-file">
                          <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choose File</span>
                          {!! Form::file('file_name[]',array('id'=>'file','data-icon'=>'false','required'=>'required','multiple'=>'multiple')) !!}

                      </span> 
                  </div>
                  @if ($errors->has('file_name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('file_name') }}</strong>
                  </span>
                  @endif
                </div>
               </div>
               <div class="col-md-3">
                <label class="form-label">.</label>
                  {!! Form::submit('Import File', array('class'=>'btn btn-primary')) !!}
               </div>
            </div>
          </div>
            {{ Form::close() }} -->
            <div class="table-responsive">
              <table id="datatable" class="table table-striped table-bordered datatable">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">UserName</th>
                        <th scope="col">File</th>
                        <th scope="col">Is Read</th>
                        <th scope="col">Date</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('extrajs')

<script>

   $(document).ready( function () {
    $('#datatable').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax":{
           'url' : "{!! route('api.get-analytics') !!}",
           'type' : 'POST'
    },
    "order": [["1", "desc" ]],
    "columns": [
      { "data": 'DT_RowIndex', orderable: false, searchable: false},
      { "data": "user_id" },
      { "data": "file_name" },
      { "data": "is_read" },
      { "data": "created_at" },
    ],
     preDrawCallback: function(settings) {
         if ($.fn.DataTable.isDataTable('#datatable')) {
             var dt = $('#datatable').DataTable();
             var settings = dt.settings();
             if (settings[0].jqXHR) {
                 settings[0].jqXHR.abort();
             }
         }
     }
  });
});
</script>
@endsection
