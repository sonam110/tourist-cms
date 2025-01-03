<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\HasManyJson;


class Package extends Model
{
    use HasFactory;
    protected $appends = ['icon','price','price_cal'];
    protected $fillable = ['language_id','uuid','destination_id','package_name','description','duration','inclusions','exclusions','itinerary','activities','available_dates','terms_and_conditions','status','service_id','price_in_currency_1','price_in_currency_2','price_in_currency_3','price_in_currency_4','price_in_currency_5','special','featured','view_on_home','rating','slug','package_type','data_for','trending'];

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(PackageImage::class, 'package_id', 'id');
    }

    public function prices()
    {
        return $this->hasMany(PackagePrice::class, 'package_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_uuid', 'uuid');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewAndRating::class, 'package_uuid', 'uuid')->where('status',1);
    }

    public function activityLists()
    {
        $foreignKey = 'activities';
        $instance = new Activity();
        $localKey = 'id';
        // dont forget to import the HasManyJson class as well in the top of this model)
        return new HasManyJson($instance->newQuery(), $this, $instance->getTable().'.'.$localKey, $foreignKey);
    }

    public function getIconAttribute()
    {
        $currency_id = AppSetting::first()->default_currency;
        $currency_id = session('currency_id',$currency_id);
        $icon = Currency::find($currency_id)->icon;
        return $icon;
    }

    public function getPriceAttribute()
    {
        $default_currency = AppSetting::first()->default_currency;
        $currency_id = session('currency_id', $default_currency);
        $price_field = 'price_in_currency_' . $currency_id;
        if (isset($this->$price_field)) {
            return number_format($this->$price_field,2);
        }
        return null;
    }
    public function getPricecalAttribute()
    {
        $default_currency = AppSetting::first()->default_currency;
        $currency_id = session('currency_id', $default_currency);
        $price_field = 'price_in_currency_' . $currency_id;
        if (isset($this->$price_field)) {
            return  $this->$price_field;
        }
        return null;
    }

}
