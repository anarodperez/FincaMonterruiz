<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Horario extends Model
{
    protected $fillable = [
        'fecha', //de tipo datetime
        'hora',
        'idioma',
        'actividad_id',
    ];

    // Atributo de acceso mutador para almacenar solo la hora
    public function setHoraAttribute($value)
    {
        if (!is_null($value)) {
            // Verifica si la cadena de tiempo contiene segundos
            $format = strpos($value, ':') === false ? 'H:i' : 'H:i:s';
            $this->attributes['hora'] = Carbon::createFromFormat($format, $value)->format('H:i:s');
        }
    }

    public function getHoraAttribute($value)
    {
        // Verifica si la fecha tiene segundos
        $format = strpos($value, ':') === false ? 'H:i' : 'H:i:s';
        return Carbon::parse($value)->format($format);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function getFechasRecurrentes($numFechas = 8)
    {
        $fechas = [];
        $fechaInicio = Carbon::parse($this->fecha );


        $diasSemana = [
            'sunday' => 0,
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
        ];

        $dia_semana = Carbon::parse($this->fecha);

        for ($i = 0; $i < $numFechas; $i++) {
            // Obtén el nombre del día de la semana a partir del campo fecha
            $dia_semana_actual = strtolower($dia_semana->format('l'));

            // Combina la fecha con la hora del horario
            $fechaHora = $fechaInicio->setTimeFromTimeString($this->hora);

            // Si la fecha no es el día actual, agrégala al arreglo
            if (!$fechaHora->isSameDay(Carbon::now())) {
                $fechas[] = $fechaHora;
                $this->guardarHorarioEnDB($fechaHora);
            }

            // Encuentra la próxima ocurrencia del día de la semana
            $proximoDia = $fechaInicio->copy()->next($diasSemana[$dia_semana_actual]);

            // Actualiza la fecha de inicio para el próximo ciclo del bucle
            $fechaInicio = $proximoDia;
        }

        // Verifica si ya existen horarios en la base de datos después de obtener las fechas
        if (!$this->hayHorariosEnDB()) {
            // Si no existen horarios, guárdalos en la base de datos
            foreach ($fechas as $fechaHora) {
                $this->guardarHorarioEnDB($fechaHora);
            }
        }
        return $fechas;
    }

    private function guardarHorarioEnDB($fechaHora)
    {
        // Verifica si ya existe un horario en un rango de tiempo cercano
        $horarioExistente = Horario::whereBetween('fecha', [
            $fechaHora->copy()->subMinute(), // Resta un minuto para considerar un rango cercano
            $fechaHora->copy()->addMinute(), // Suma un minuto para considerar un rango cercano
        ])
            ->where('hora', $this->hora)
            ->first();

        // Si no existe, crea un nuevo modelo de Horario y asigna los valores
        if (!$horarioExistente) {
            $nuevoHorario = new Horario();
            $nuevoHorario->fecha = $fechaHora;
            $nuevoHorario->hora = $this->hora;
            $nuevoHorario->idioma = $this->idioma;
            $nuevoHorario->actividad_id = $this->actividad_id;

            // Guarda el nuevo horario en la base de datos
            $nuevoHorario->save();
        }
    }

    private function hayHorariosEnDB()
    {
        // Verifica si ya existen horarios en la base de datos
        return Horario::where('actividad_id', $this->actividad_id)->exists();
    }

    // public function getColorAttribute()
    // {
    //     // Lógica para asignar un color basado en la actividad
    //     // Puedes personalizar esto según tus necesidades
    //     $colores = [
    //         'Visita al viñedo 3' => '#ff0000',
    //         'Actividad 2' => '#00ff00',
    //         // Agrega más actividades y colores según sea necesario
    //     ];

    //     return $colores[$this->id] ?? '#000000';  // Color predeterminado si no se encuentra el nombre de la actividad
    // }




}
