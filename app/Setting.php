<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    protected $fillable = [
        'user_id','place_id', 'address', 'lat', 'lng', 'muestrame', 'rango_edad_min', 'rango_edad_max'
    ];
    public $timestamps = false;

    /* public function scopeFilter($query, $mues, $r_min, $r_max)
    {
        return $query->where('muestrame', $mues)
                    ->where('rango_edad_min', $r_min)
                    ->where('rango_edad_max', $r_max);
    } */
}
