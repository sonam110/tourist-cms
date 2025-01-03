<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','package_uuid','package_name','destination_name','start_date','end_date','city_of_departure','name','mobile','email','number_of_adults','number_of_children','number_of_infants','price','coupon_code','coupon_code_discount','payable_amount','status'];

    public function user()
	{
	    return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function package()
    {
    	$appSetting = AppSetting::first();
        return $this->belongsTo(Package::class, 'package_uuid', 'uuid')->where('language_id',session('language_id', $appSetting->default_language));
    }
}
