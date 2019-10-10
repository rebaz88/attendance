<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends BaseModel
{
    protected $fillable = [
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
