<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewAndRating extends Model
{
    use HasFactory;
    protected $fillable = ['package_uuid','review','rating','status','user_id','user_image','user_name'];

    public function package()
    {
    	$default_language = AppSetting::first()->default_language;
    	if (empty($default_language)) {
    		$default_language = Language::first()->id;
    	}
        return $this->belongsTo(Package::class, 'package_uuid', 'uuid')->where('language_id',$default_language);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
