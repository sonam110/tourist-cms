<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id','name','slug','order_number','position_type','status','icon_path'];

    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
    
}
