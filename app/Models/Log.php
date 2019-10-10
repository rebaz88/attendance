<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends BaseModel
{
    protected $fillable = [
        'pin', 'time', 'status',
    ];
}
