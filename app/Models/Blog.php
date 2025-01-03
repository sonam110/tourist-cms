<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\HasManyJson;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['language_id','title','slug','categories','content','image_path','order_number','posted_by','post_date','seo_key','views','status','view_on_home'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id', 'id')->where('status',1)->where('parent_id',NULL)->with('childComments');
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
