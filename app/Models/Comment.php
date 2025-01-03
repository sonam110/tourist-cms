<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['blog_id','parent_id','comment','posted_by','post_date','status'];

   public function childComments()
   {
   		return $this->hasMany(Comment::class, 'parent_id', 'id')->where('status',1)->with('childComments');
   }

   public function postedBy()
	{
	    return $this->belongsTo(User::class, 'posted_by', 'id');
	}
}
