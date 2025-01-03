<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingInquiry extends Model
{
    use HasFactory;

    protected $fillable = ['destination_type','package_name','destination_name','date_of_departure','city_of_departure','contact_name','phone_number','email','number_of_adults','number_of_children','number_of_infants','budget','coupon_code','status'];
}
