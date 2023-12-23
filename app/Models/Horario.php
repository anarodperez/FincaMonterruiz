<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente del nombre del modelo en plural
    // protected $table = 'horarios';

    // Define las propiedades que se pueden asignar masivamente
    protected $fillable = ['actividad_id', 'fecha', 'hora', 'idioma', 'frecuencia', 'repeticiones'];

    // Define la relación con la actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    // Aquí puedes añadir más métodos del modelo, como scopes o métodos auxiliares
}
