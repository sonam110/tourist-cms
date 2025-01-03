<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;

class CommentController extends Controller
{
    protected $intime;
    public function __construct()
    {
        $this->intime = \Carbon\Carbon::now();        
    }

    public function comments(Request $request)
    {
        try 
        {
            $query = Comment::orderBy('created_at','ASC');

            if(!empty($request->comment))
            { 
                $query->where('comment', 'LIKE', '%'.$request->comment.'%');
            }
            if(!empty($request->posted_by))
            {
                $query->where('posted_by', 'LIKE', '%'.$request->posted_by.'%');
            }
            if(!empty($request->blog_id))
            {
                $query->where('blog_id',$request->blog_id);
            }

            if(!empty($request->per_page_record))
            {
                $perPage = $request->per_page_record;
                $page = $request->input('page', 1);
                $total = $query->count();
                $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

                $pagination =  [
                    'data' => $result,
                    'total' => $total,
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'last_page' => ceil($total / $perPage)
                ];
                $query = $pagination;
            }
            else
            {
                $query = $query->get();
            }
            return prepareResult(true,$this->intime,getLangByLabelGroups('BcCommon','message_list'),$query,config('httpcodes.success'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_something_went_wrong'),$exception->getMessage(),config('httpcodes.internal_server_error'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        try 
        {
            $checkId= Comment::find($comment->id);
            if($checkId)
            {
                return prepareResult(true,$this->intime,getLangByLabelGroups('BcCommon','message_show'),$checkId,config('httpcodes.success'));
            }
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_record_not_found'),[],config('httpcodes.not_found'));
        }
        catch(Exception $exception) 
        { 
            \Log::error($exception);
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_something_went_wrong'),$exception->getMessage(),config('httpcodes.internal_server_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        try 
        {
            $checkId = Comment::find($comment->id);
            if($checkId)
            {
                $checkId->delete();
                return prepareResult(true,$this->intime,getLangByLabelGroups('BcCommon','message_delete'),[],config('httpcodes.success'));
            }
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_record_not_found'),[],config('httpcodes.not_found'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_something_went_wrong'),$exception->getMessage(),config('httpcodes.internal_server_error'));
        }
    }

    public function commentAction(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'ids'      => 'required',
            'action'      => 'required',
        ]);

        if ($validation->fails()) {
            return prepareResult(false,$this->intime,$validation->errors()->first(),$validation->errors(),config('httpcodes.bad_request'));
        }
        DB::beginTransaction();
        try 
        {
            if($request->action == 'delete')
            {
                $comments = Comment::whereIn('id',$request->ids)->delete();
                $message = 'Comment Deleted Succesfully!';
            }
            elseif($request->action == 'inactive')
            {
                Comment::whereIn('id',$request->ids)->update(['status'=>"2"]);
                $message = 'Comment InActivated Succesfully!';
            }
            elseif($request->action == 'active')
            {
                Comment::whereIn('id',$request->ids)->update(['status'=>"1"]);
                $message = 'Comment Activated Succesfully!';
            }
            $comments = Comment::whereIn('id',$request->ids)->get();
            DB::commit();
            return prepareResult(true,$this->intime,$message,$comments,config('httpcodes.success'));
        }
        catch(Exception $exception) {
            \Log::error($exception);
            return prepareResult(false,$this->intime,getLangByLabelGroups('BcCommon','message_something_went_wrong'),$exception->getMessage(),config('httpcodes.internal_server_error'));
        }
    }
}
