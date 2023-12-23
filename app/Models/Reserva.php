<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'num_personas',
        'horario_id',
        'user_id',
        'actividad_id'
        // otros campos según sea necesario
    ];

    // Aquí puedes agregar relaciones, por ejemplo, con el modelo Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    // Si necesitas una relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Si necesitas una relación con el modelo Actividad
     public function actividad()
     {
         return $this->belongsTo(User::class, 'actividad_id');
     }
}
