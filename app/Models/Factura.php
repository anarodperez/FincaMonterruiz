<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'facturas';

    // Definir los campos que se pueden asignar de manera masiva
    protected $fillable = ['reserva_id', 'monto', 'iva', 'monto_total', 'estado', 'fecha_emision', 'fecha_cancelacion', 'precio_adulto_final', 'precio_nino_final'];


    // Indica que los campos de fecha deben ser tratados como instancias de Carbon
    protected $dates = ['fecha_emision', 'fecha_cancelacion'];

    /**
     * Relación con la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function actividad()
{
    return $this->belongsTo(Actividad::class, 'actividad_id');
}

}
