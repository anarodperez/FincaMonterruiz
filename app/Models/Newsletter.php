<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'contenido', 'enviado', 'selected'];
    protected $dates = ['fecha_envio'];


    public function isEnviado()
    {
        return $this->enviado;
    }
}
