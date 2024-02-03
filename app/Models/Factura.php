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
    protected $fillable = [
        'reserva_id',
        'monto',
        'estado',
        'detalles',
        'fecha_emision',
        'fecha_cancelacion',
    ];

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

    // Aquí puedes añadir más métodos que necesites para la lógica de tu aplicación,
    // como métodos para calcular impuestos, descuentos, etc.
}
