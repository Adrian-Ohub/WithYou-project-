<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function photos()
    {
        return $this->hasMany('App\Photo', 'user_id', 'id');
    }
    public function setting()
    {
        return $this->hasOne('App\Setting');
    }
    public function location()
    {
        return $this->hasOne('App\Location');
    }

    //Devuelve la edad a partir de la fecha invocando '->age'
    public function getAgeAttribute() 
    {
        $dateNow = Carbon::now();
        return ($dateNow->diffInYears(Carbon::parse($this->attributes['fecha_nacimiento'])));    
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido1', 'fecha_nacimiento', 'sexo', 'imagen', 'descripcion', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
