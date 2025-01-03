<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_url',
        'user_id',
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
