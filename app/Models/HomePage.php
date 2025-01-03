<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = ['title','sub_title','short_description','banner_image_path','image_path','video_path','promo','destination','newsletter_video_path','newsletter_title','newsletter_description','special','featured','blog','testimonial','activity','newsletter','happy_customers_images','happy_customers_title','happy_customers_sub_title','extra_description','background_video_url','happy_customers','background_video_on'];
}
