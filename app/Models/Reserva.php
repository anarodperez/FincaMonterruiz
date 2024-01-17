<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reserva extends Model
{
    protected $fillable = [
        'num_personas',
        'horario_id',
        'user_id',
        'actividad_id',
        'paypal_sale_id',
        'total_pagado'
    ];

    // Aquí puedes agregar relaciones, por ejemplo, con el modelo Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($reserva) {
    //         $reserva->token = Str::random(16); // Genera un token de 16 caracteres
    //     });
    // }
}
