<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    use HasFactory;

    protected $fillable = ['language_id','title','sub_title','slug','content','banner_image_path','status','placed_in','seo_keyword','order_number'];
}
