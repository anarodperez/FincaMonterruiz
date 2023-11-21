<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Horario extends Model
{
    protected $fillable = [
        'dia_semana',
        'hora',
        'plazas_disponibles',
        'idioma',
        'actividad_id',
    ];

    // Atributo de acceso mutador para almacenar solo la hora
    public function setHoraAttribute($value)
    {
        $this->attributes['hora'] = Carbon::createFromFormat('H:i:s', $value);
    }

    // Atributo de acceso para obtener solo la hora
    public function getHoraAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }
}
