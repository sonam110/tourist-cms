@extends('admin.layouts.master')
@section('content')
<div class="row row-deck">
<div class="col-12">
    <div class="card">
        <div class="card-header ">
            <h3 class="card-title ">Notification List</h3>
            <div class="card-options">
                &nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
            </div>
        </div>
       
        <div class="card-body">
            <table class="table table-hover table-striped" id="datatable">

               <tbody>
                  @if(Auth::user()->notifications->count()>0)
                  @foreach (Auth::user()->notifications as $notification)
                  <?php  
                    $message = '';
                    $msg = Auth::user()->notifications()->where('id',$notification->id)->first()->toArray();
                    if(@$msg['data']['notificationdata']['title']!=''){
                        $user = App\Models\User::where('id',@$msg['data']['notificationdata']['user_id'])->first();
                         $message = 'User '.@$user->name.' added new game '.@$msg['data']['notificationdata']['title'].' ';
                    }
                    if(@$msg['data']['notificationdata']['name']!=''){
                        $user = App\Models\User::where('id',@$msg['data']['notificationdata']['user_id'])->first();
                         $message = 'New user '.@$msg['data']['notificationdata']['name'].' sign up successfully';
                    }
                     ?>
                 <tr>
                  <td><a class="dropdown-item noti-message" href="#"><i class="fa fa-envelope"></i>
                        {{ $message }}
                        </a></td>
                     <td><div class="small text-muted">{{($notification->created_at)->diffForHumans()}}</div></td>
                 </tr>
                  @endforeach
                 @endif

             
               </tbody>
            </table>
        </div>
    </div>
</div>

@endsection