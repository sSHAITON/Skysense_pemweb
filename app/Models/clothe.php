<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clothe extends Model
{
    protected $fillable = [
        'name',
        'category',
        'subcategory',
        'color',
        'image_path',
        'description',
        'user_id'
    ];

    const CATEGORIES = [
        'top' => [
            'long_sleeve',
            'hoodie',
            't_shirt'
        ],
        'bottom' => [
            'jeans',
            'shorts',
            'joggers'
        ],
        'cap' => [
            'baseball',
            'beanie'
        ]
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
