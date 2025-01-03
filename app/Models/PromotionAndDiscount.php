<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionAndDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['language_id','title','coupon_code','discount_type','discount_value','description','min_applicable_amount','max_discount','expiry_date','usage_limit','used','usage_limit_per_user','image_path','status'];
}
