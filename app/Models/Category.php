<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id','name','status'];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status',1);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'categories', 'id')
                    ->where('status', 1)
                    ->whereJsonContains('categories', $this->id);
    }

    public function vlogs()
    {
        return $this->hasMany(Vlog::class, 'categories', 'id')
                    ->where('status', 1)
                    ->whereJsonContains('categories', $this->id);
    }

    public function travelCourses()
    {
        return $this->hasMany(TravelCourse::class, 'categories', 'id')
                    ->where('status', 1)
                    ->whereJsonContains('categories', $this->id);
    }
}
