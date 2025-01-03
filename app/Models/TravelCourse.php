<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelCourse extends Model
{
    use HasFactory;

    protected $fillable = ['language_id','title','slug','content','image_path','video_link','status','seo_keyword'];

    
}
