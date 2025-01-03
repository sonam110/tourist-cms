<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id','name','status'];

    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id', 'id');
    }

    public function packages()
    {
        $appSetting = AppSetting::first();
        return $this->hasMany(Package::class, 'service_id', 'id')->where('language_id',session('language_id', $appSetting->default_language));
    }
}
