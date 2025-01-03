<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appsetting extends Model
{
    protected $fillable = [
        'app_name','description','app_logo','email','mobilenum','app_key','logo_thumb_path','fav_icon','fb_url','twitter_url','insta_url','linkedIn_url','pinterest_url','copyright_text','address','seo_keyword','seo_description','google_analytics','default_language','default_currency','ads_enabled','footer_description','pro_forma_invoice_remarks','footer_logo','payment_image','contact_description','contact_title'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'default_language', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'default_currency', 'id');
    }
}
