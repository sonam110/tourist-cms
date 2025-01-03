<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['language_id','template_for','mail_subject','mail_body','image_path','status'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
