<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['destination_type','name','status','image_path','view_on_home'];

    public function activities()
    {
        $appSetting = AppSetting::first();
        return $this->hasMany(Package::class, 'destination_id', 'id')->where('language_id',session('language_id', $appSetting->default_language))->where('data_for','activity');
    }

    public function packages()
    {
        $appSetting = AppSetting::first();
        return $this->hasMany(Package::class, 'destination_id', 'id')->where('language_id',session('language_id', $appSetting->default_language))->where('data_for','package');
    }
}
