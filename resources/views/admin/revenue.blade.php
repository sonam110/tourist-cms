@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header ">
            <h3 class="card-title ">Revenue</h3>
            <div class="card-options">
               &nbsp;&nbsp;&nbsp;<a href="{{ route('user-revenue') }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
            </div>
         </div>
         <div class="card-body p-12">
          <div class="panel panel-primary">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label">Filter By User</label>
                  {!! Form::select('user_id', $allUsers,'', array('class' => 'form-control' ,'placeholder' => 'All Users' ,'id'=>'user_id')) !!}
                </div>
               </div>
               <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label">Filter By Game</label>
                  {!! Form::select('game_id', $allGames,'', array('class' => 'form-control' ,'placeholder' => 'All Games' ,'id'=>'game_id')) !!}
                </div>
               </div>
               
               <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label">Filter Date From</label>
                  {!! Form::date('date_from','',array('id'=>'date_from','class'=> 'form-control', 'placeholder'=>'Date From', 'autocomplete'=>'off')) !!}
                </div>
               </div>
               <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label">Filter Date To</label>
                  {!! Form::date('date_to','',array('id'=>'date_to','class'=> 'form-control', 'placeholder'=>'Date To', 'autocomplete'=>'off')) !!}
                </div>
               </div>
               <div class="col-md-2">
                <div class="form-group">
                  <label class="form-label">Excel Download</label>
                   {!! Form::button('Download', array('class'=>'btn btn-primary btn-fixed','id'=>'excel-download')) !!}
                </div>
               </div>
            </div>
          </div>
            <div class="">
              <table id="datatable" class="table table-striped table-bordered datatable">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Info</th>
                        <th scope="col">Game</th>
                        <th scope="col">Genres</th>
                        <th scope="col">Commission</th>
                        <th scope="col">Total Payout</th>
                        <th scope="col">Payto Dev</th>
                        <th scope="col">Admin Profit</th>
                        <th scope="col">Watched</th>
                        <th scope="col">Date</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <div class="row div-margin">
               <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="input-group"> 
                     <span class="input-group-addon" id="show-total-revenue" style="color:#171a1c" ></span>
                      <span class="input-group-addon" id="show-admin-revenue" style="color:#171a1c" ></span>
                     
                  </div>
               </div>
              
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('extrajs')


<script>
   $(document).ready(function () {
      getRevenueData();
      getRevenue();
      getAdminRevenue();
   });
  $('#user_id,#game_id,#date_from,#date_to').on('change keyup', function(e) {
    getRevenueData();
    getRevenue();
    getAdminRevenue();
  });
  var table;
  function getRevenueData(){
    table=  $('#datatable').DataTable({
       "searching": false,
        "targets": 'no-sort',
        "bSort": false,
        "lengthChange": false,
        "processing": false,
        "serverSide": true,
        "bRetrieve": true,
        "language": {
            "emptyTable": 'No Record found into system',
        },
       "ajax":{
           'url' : "{!! route('api.revenue-all') !!}",
           'type' : 'POST',
           'data': function(d) {
            d.user_id   =  $('#user_id').val();
            d.game_id   =  $('#game_id').val();
            d.date_from = $('#date_from').val();
            d.date_to   = $('#date_to').val();
        },
    },
    "order": [["1", "desc" ]],
    "columns": [
      { "data": 'DT_RowIndex', orderable: false, searchable: false},
      { "data": "user_id" },
      { "data": "game_id" },
      { "data": "genres" },
      { "data": "commission" },
      { "data": "actual_payout" },
      { "data": "payout" },
      { "data": "admin_payout" },
      { "data": "watched" },
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
  table.ajax.reload();
}

function getRevenue() {
  var user_id   =  $('#user_id').val();
  var game_id   =  $('#game_id').val();
  var date_from = $('#date_from').val();
  var date_to   = $('#date_to').val();
  $.ajax({
    url: "{{route('api.get-user-revenue')}}",
    type: 'POST',
    data: {user_id:user_id,game_id:game_id,date_from:date_from,date_to:date_to},
    success:function(info){
      $('#show-total-revenue').html(info);
      
    }
  });
 
}
function getAdminRevenue() {
  var user_id   =  $('#user_id').val();
  var game_id   =  $('#game_id').val();
  var date_from = $('#date_from').val();
  var date_to   = $('#date_to').val();
  $.ajax({
    url: "{{route('api.get-admin-revenue')}}",
    type: 'POST',
    data: {user_id:user_id,game_id:game_id,date_from:date_from,date_to:date_to},
    success:function(info){
      $('#show-admin-revenue').html(info);
      
    }
  });
 
}
$('#excel-download').on('click', function(e) {
  var user_id   =  $('#user_id').val();
  var game_id   =  $('#game_id').val();
  var date_from = $('#date_from').val();
  var date_to   = $('#date_to').val();
  $.ajax({
    url: "{{route('api.download-revenue')}}",
    type: 'POST',
    data: {user_id:user_id,game_id:game_id,date_from:date_from,date_to:date_to},
    success:function(response){
      var obj = JSON.parse(response);
      var url = obj['url'];
      var a = document.createElement('a');
      a.href = url;
      a.download = obj['fileName'];
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
    //alert('your file has downloaded!');

    }
  });
 
});
</script>
@endsection
