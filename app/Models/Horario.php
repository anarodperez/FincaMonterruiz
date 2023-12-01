<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Horario extends Model
{
    protected $fillable = [
        'dia_semana',
        'hora',
        'idioma',
        'actividad_id',
    ];

 // Atributo de acceso mutador para almacenar solo la hora
 public function setHoraAttribute($value)
{
    if (!is_null($value)) {
        // Verifica si la cadena de tiempo contiene segundos
        $format = (strpos($value, ':') === false) ? 'H:i' : 'H:i:s';
        $this->attributes['hora'] = Carbon::createFromFormat($format, $value)->format('H:i:s');
    }
}

public function getHoraAttribute($value)
{
    // Verifica si la fecha tiene segundos
    $format = (strpos($value, ':') === false) ? 'H:i' : 'H:i:s';
    return Carbon::parse($value)->format($format);
}

 public function actividad()
 {
     return $this->belongsTo(Actividad::class);
 }

 public function getFechasRecurrentes($numFechas = 36)
 {
     $fechas = [];
     $fechaInicio = Carbon::now();
     $diasSemana = [
         'domingo' => 0,
         'lunes' => 1,
         'martes' => 2,
         'miércoles' => 3,
         'jueves' => 4,
         'viernes' => 5,
         'sábado' => 6,
     ];

     for ($i = 0; $i < $numFechas; $i++) {
         // Encuentra la próxima ocurrencia del día de la semana
         $proximoDia = $fechaInicio->copy()->next($diasSemana[$this->dia_semana]);

         // Combina la fecha con la hora del horario
         $fechaHora = $proximoDia->setTimeFromTimeString($this->hora);

         // Agrega la fecha al arreglo
         $fechas[] = $fechaHora;

         $fechaInicio = $proximoDia;
     }

     return $fechas;
 }

 public function getColorAttribute()
    {
        // Lógica para asignar un color basado en la actividad
        // Puedes personalizar esto según tus necesidades
        $colores = [
            'Visita al viñedo 3' => '#ff0000',
            'Actividad 2' => '#00ff00',
            // Agrega más actividades y colores según sea necesario
        ];
        return $colores[$this->actividad->nombre] ?? '#000000'; // Color predeterminado si no se encuentra el nombre de la actividad
    }
}
