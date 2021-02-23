<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    protected $fillable = [
        'user_id','place_id', 'address', 'lat', 'lng'
    ];
    protected $primaryKey = 'user_id';
}
