<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'hora','actividad_id',
        'plazas_disponibles', 'idioma'
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }
}
