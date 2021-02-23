<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    
    protected $fillable = [
        'user_id', 'user_id2', 'return_like',
    ];
}
