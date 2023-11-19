<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'plazas_disponibles',
        'idioma',
        'actividad_id',
    ];

    protected $dates = ['fecha', 'hora'];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

}
