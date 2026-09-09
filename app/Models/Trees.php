<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trees extends Model
{
    protected $fillable = [
        'level',
        'health',
        'progress',
        'status',
    ];
}
