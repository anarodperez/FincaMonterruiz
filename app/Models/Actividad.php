<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'nombre', 'descripcion','duracion',
        'precio_adulto', 'precio_nino','aforo','imagen','activa'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
