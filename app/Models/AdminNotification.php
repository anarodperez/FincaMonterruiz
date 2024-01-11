<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = ['nuevos_usuarios_count', 'nuevos_reservas_count','nuevos_valoraciones_count' ];
}
