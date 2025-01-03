<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\HasManyJson;

class Vlog extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','categories','video_path','order_number','posted_by','post_date','seo_key','views','status','language_id','image_path','view_on_home'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'vlog_id', 'id')->where('status',1)->where('parent_id',NULL)->with('childComments');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }

    public function categoryLists()
    {
        $foreignKey = 'categories';
        $instance = new Category();
        $localKey = 'id';
        // dont forget to import the HasManyJson class as well in the top of this model)
        return new HasManyJson($instance->newQuery(), $this, $instance->getTable().'.'.$localKey, $foreignKey);
    }
}
