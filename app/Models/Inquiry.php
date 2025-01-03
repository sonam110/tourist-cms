<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = ['name','email','mobile','travel_date','traveller_count','package_id','message'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
