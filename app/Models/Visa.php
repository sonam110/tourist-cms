<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    use HasFactory;

    protected $fillable = ['destination','travel_start_date','travel_end_date','name','mobile','email','number_of_adults','number_of_children','status','children_ages','number_of_infants','infants_ages'];
}
