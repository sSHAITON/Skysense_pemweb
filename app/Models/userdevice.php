<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $table = 'userdevices';

    protected $fillable = [
        'user_id',
        'device_id',
        'device_name',
        'is_connected'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
