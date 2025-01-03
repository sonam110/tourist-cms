@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-game' )
<?php
$id               = $game->id;
$title            = $game->title;
$genres_id        = $game->genres_id;
$dev_stage_id     = $game->dev_stage_id;
$platform         = $game->platform;
$app_url         = $game->app_url;
$website_url         = $game->website_url;
$description         = $game->description;
$genres           = $genres;
$developingStage  = $developingStage;
$androidAppID        = $game->androidAppID;
$iosAppID        = $game->iosAppID;
$required         = 'required';
?>

{{ Form::open(array('route' => 'admin-game-save','id'=>
'myForm', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
@csrf
<div class="row row-deck">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Edit
                </h3>
                <div class="card-options">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label"> Title <span class="requiredLabel">:</span></label>
                            {{ $title }}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Genres <span class="requiredLabel">:</span></label>
                            {!! ($game->genres) ? $game->genres->name:'' !!}
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Developing Stage <span class="requiredLabel">:</span></label>
                            {!! ($game->stage) ? $game->stage->name:'' !!}
                        </div>
                    </div>
                     <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label"> Website Url  <span class="requiredLabel">:</span></label>
                            {!! $website_url !!}
                           
                        </div>
                    </div>
                     <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label"> App Url <span class="requiredLabel">:</span> </label>
                            {!! $app_url !!}
                           
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label"> App Publisher Name <span class="requiredLabel">:</span> </label>
                            {!! $game->app_publisher_name !!}
                           
                        </div>
                    </div>
                    
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Bundle ID <span class="requiredLabel">:</span> </label>
                            {!! $game->bundle_id !!}
                           
                        </div>
                    </div>
                     <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label">Game Platforms <span class="requiredLabel">:</span></label>
                             {{ $platform }}
                        </div>
                    </div>

                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="title" class="form-label"> Description  <span class="requiredLabel">:</span></label>
                            {!! $description !!}
                           
                        </div>
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="title" class="form-label"> androidAppID <span class="requiredLabel">*</span></label>
                            {!! Form::text('androidAppID',$androidAppID, array('id'=>'androidAppID','class'=> $errors->has('androidAppID') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'androidAppID', 'autocomplete'=>'off',$required)) !!}
                            @if ($errors->has('androidAppID'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('androidAppID') }}</strong>
                            </span>
                            @endif

                        </div>
                    </div>
                     <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="title" class="form-label"> iosAppID <span class="requiredLabel">*</span></label>
                            {!! Form::text('iosAppID',$iosAppID, array('id'=>'iosAppID','class'=> $errors->has('iosAppID') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'iosAppID', 'autocomplete'=>'off',$required)) !!}
                            @if ($errors->has('iosAppID'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('iosAppID') }}</strong>
                            </span>
                            @endif

                        </div>
                    </div>

                    <div class="col-xs-9 col-sm-9 col-md-9">
                       <div class="form-group">
                          <label for="number" class="form-label">ADservingData <span class="requiredLabel">*</span><button class="btn btn-primary addMorenumber" data-toggle="tooltip" type="button" data-placement="top" title="Add more ADservingData"><i class="fa fa-plus"></i></button></label>
                          <div class="input-group">
                         <!--  {!! Form::text('ADservingData[]','',array('id'=>'ADservingData','class'=> $errors->has('number') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'ADserving Data', 'autocomplete'=>'off','required'=>'required')) !!} -->
                            
                            
                          </div>
                       </div>
                    </div>
                    <div class="col-md-9">
                   <div class="numberBox">
                      <div class="blockNumber">
                      </div>
                   </div>
                  </div>
                    @if($ADservingData !='')
                    @foreach($ADservingData as $data)
                    <div class="col-md-9">
                       <div class="numberBox">
                          <div class="blockNumber">
                             <div class="form-group">
                                <div class="input-group">
                                  {!! Form::text('ADservingData[]',$data,array('id'=>'ADservingData','class'=> $errors->has('ADservingData') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'ADservingData', 'autocomplete'=>'off','required'=>'required')) !!}
                                    <span class="input-group-append">
                                      <button class="btn btn-danger removeNumber" data-toggle="tooltip" type="button" data-placement="top" title="Remove this number"><i class="fa fa-minus"></i></button>
                                    </span>
                                  </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    @endforeach 
                    @endif
                  
                    
                     <div class="col-xs-9 col-sm-9 col-md-9">
                       <div class="form-group">
                          <label for="number" class="form-label">DSPEndpoints <span class="requiredLabel">*</span><button class="btn btn-primary addMorenumber1" data-toggle="tooltip" type="button" data-placement="top" title="Add more DSPEndpoints"><i class="fa fa-plus"></i></button></label>
                          <div class="input-group">
                         <!--  {!! Form::text('DSPEndpoints[]','',array('id'=>'DSPEndpoints','class'=> $errors->has('DSPEndpoints') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'DSPEndpoints', 'autocomplete'=>'off','required'=>'required')) !!} -->
                            
                          </div>
                       </div>
                    </div>
                    <div class="col-md-9">
                       <div class="numberBox1">
                          <div class="blockNumber1">
                          </div>
                       </div>
                    </div>
                 
                 
                     @if($DSPEndpoints !='')
                    @foreach($DSPEndpoints as $point)
                    <div class="col-md-9">
                       <div class="numberBox1">
                          <div class="blockNumber1">
                             <div class="form-group">
                                <div class="input-group">
                                  {!! Form::text('DSPEndpoints[]',$point,array('id'=>'DSPEndpoints','class'=> $errors->has('DSPEndpoints') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'DSPEndpoints', 'autocomplete'=>'off','required'=>'required')) !!}
                                    <span class="input-group-append">
                                      <button class="btn btn-danger removeNumber1" data-toggle="tooltip" type="button" data-placement="top" title="Remove this number"><i class="fa fa-minus"></i></button>
                                    </span>
                                  </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    @endforeach 
                    @endif 
                  
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                       <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-xs-3 col-sm-2 col-md-2">
                                      <label for="number" class="form-label">Height <span class="requiredLabel">*</span></label>
                                      <div class="input-group">
                                      {!! Form::number('height[]','',array('id'=>'height','class'=> $errors->has('height') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'height', 'autocomplete'=>'off','required'=>'required')) !!}
                                       @if ($errors->has('height'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('height') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                               </div>
                                <div class="col-xs-2 col-sm-2 col-md-2">
                                      <label for="number" class="form-label">Width <span class="requiredLabel">*</span></label>
                                      <div class="input-group">
                                      {!! Form::number('width[]','',array('id'=>'width','class'=> $errors->has('width') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'width', 'autocomplete'=>'off','required'=>'required')) !!}
                                       @if ($errors->has('width'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('width') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                               </div> -->

                                <div class="col-xs-5 col-sm-5 col-md-5">
                                  <label for="number" class="form-label">AdunitID <span class="requiredLabel">*</span><button class="btn btn-primary addMorenumber2" data-toggle="tooltip" type="button" data-placement="top" title="Add more "><i class="fa fa-plus"></i></button></label>
                                  <div class="input-group">
                                <!--   {!! Form::text('AdunitID[]','',array('id'=>'AdunitID','class'=> $errors->has('AdunitID') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'AdunitID', 'autocomplete'=>'off','required'=>'required')) !!}
                                     -->
                                    
                                   
                                  </div>
                              </div>
                           </div>
                      </div>
                       
                    </div>
                    <div class="col-md-12">
                       <div class="numberBox2">
                          <div class="blockNumber2">
                          </div>
                       </div>
                    </div>
                 
                 
                    @if($AdunitIDs !='')
                    @foreach($AdunitIDs as $key=> $ads)
                    <?php 
                        $data = explode('x',$key) ;
                        $width = @$data[1];
                        $height = @$data[2];

                     ?>
                    <div class="col-md-12">
                       <div class="numberBox2">
                          <div class="blockNumber2">
                            <div class="form-group">
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2">

                                      <div class="input-group">
                                      {!! Form::number('height[]',$height,array('id'=>'height','class'=> $errors->has('height') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'height', 'autocomplete'=>'off','required'=>'required')) !!}
                                       @if ($errors->has('height'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('height') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                               </div>
                               <div class="col-xs-2 col-sm-2 col-md-2">
                                      
                                      <div class="input-group">
                                      {!! Form::number('width[]',$width,array('id'=>'width','class'=> $errors->has('width') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'width', 'autocomplete'=>'off','required'=>'required')) !!}
                                       @if ($errors->has('width'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('width') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                               </div>
                                <div class="col-xs-5 col-sm-5 col-md-5">

                                  <div class="input-group">
                                  {!! Form::text('AdunitID[]',$ads,array('id'=>'AdunitID','class'=> $errors->has('AdunitID') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'AdunitID', 'autocomplete'=>'off','required'=>'required')) !!}
                                    
                                    @if ($errors->has('AdunitID'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('AdunitID') }}</strong>
                                    </span>
                                    @endif
                                    <span class="input-group-append"> <button class="btn btn-danger removeNumber2" type="button" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button> </span>
                                   
                                  </div>
                              </div>
                           </div>
                          </div>
                          </div>
                       </div>
                    </div>
                    @endforeach 
                    @endif 
                   
                   
                </div>
               <div class="form-footer">
               {!! Form::submit('Save', array('class'=>'btn btn-primary btn-fixed')) !!}
            </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

@else
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">Users Game</h3>
                <div class="card-options">
                   <!--  <a class="btn btn-sm btn-outline-primary" href="{{ route('admin-game-add') }}"> <i class="fa fa-plus"></i> Add New Game</a> -->
                    &nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>

                                <th scope="col" width="5%">#</th>
                                <th scope="col"> Client</th>
                                <th scope="col"> Game ID</th>
                                <th scope="col"> Title</th>
                                <th scope="col"> Genres</th>
                                <th scope="col"> Developing Stage</th>
                                <th scope="col"> Platform</th>
                                <th scope="col"> Date</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($gametList as $rows)
                            <tr>
                                <td>{!! ++$i !!}</td>
                                <td>{!! ($rows->Client) ? $rows->Client->name :'' !!}</td>
                                <td>{!! $rows->uuid !!}</td>
                                <td>{!! $rows->title !!}</td>
                                <td>{!! ($rows->genres) ? $rows->genres->name:'' !!}</td>
                                <td>{!! ($rows->stage) ? $rows->stage->name:'' !!}</td>
                                 <td>{!! $rows->platform !!}</td>
                                 <td>{!! date('Y-m-d',strtotime($rows->created_at)) !!}</td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin-game-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                       
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif

@endsection
@section('extrajs')
<script type="text/javascript">
    $('.addMorenumber').click(function() {
        $('.blockNumber:last').after('<div class="blockNumber"><div class="form-group"> <div class="input-group"> <input id="ADservingData" class="form-control" placeholder="ADserving Data" autocomplete="off" required="required" name="ADservingData[]" type="text" value=""> <span class="input-group-append"> <button class="btn btn-danger removeNumber" type="button" data-toggle="tooltip" data-placement="top" title="Remove this ADservingData"><i class="fa fa-minus"></i></button> </span> </div></div></div>'); 
    });
    $('.numberBox').on('click','.removeNumber',function() {
      $(this).tooltip("hide");
      $(this).parents(".blockNumber").remove();
    });

      $('.addMorenumber1').click(function() {
        $('.blockNumber1:last').after('<div class="blockNumber1"><div class="form-group"> <div class="input-group"> <input id="DSPEndpoints" class="form-control" placeholder="DSPEndpoints" autocomplete="off" required="required" name="DSPEndpoints[]" type="text" value=""> <span class="input-group-append"> <button class="btn btn-danger removeNumber1" type="button" data-toggle="tooltip" data-placement="top" title="Remove this DSPEndpoints"><i class="fa fa-minus"></i></button> </span> </div></div></div>'); 
    });
    $('.numberBox1').on('click','.removeNumber1',function() {
      $(this).tooltip("hide");
      $(this).parents(".blockNumber1").remove();
    });

     $('.addMorenumber2').click(function() {
        $('.blockNumber2:last').after('<div class="blockNumber2"><div class="form-group"> <div class="row"> <div class="col-xs-2 col-sm-2 col-md-2"> <div class="input-group"> <input id="height" class="form-control" placeholder="height" autocomplete="off" required="required" name="height[]" type="number" value=""> </div> </div> <div class="col-xs-2 col-sm-2 col-md-2"> <div class="input-group"> <input id="width" class="form-control" placeholder="width" autocomplete="off" required="required" name="width[]" type="number" value=""> </div> </div> <div class="col-xs-5 col-sm-5 col-md-5"> <div class="input-group"> <input id="AdunitID" class="form-control" placeholder="AdunitID" autocomplete="off" required="required" name="AdunitID[]" type="text" value=""> <span class="input-group-append"> <button class="btn btn-danger removeNumber2" type="button" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button> </span> </div> </div> </div> </div></div>'); 
    });
    $('.numberBox2').on('click','.removeNumber2',function() {
      $(this).tooltip("hide");
      $(this).parents(".blockNumber2").remove();
    });
</script>
@endsection