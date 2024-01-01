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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}
