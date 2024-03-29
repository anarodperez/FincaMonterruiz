<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscriptor extends Model
{
    protected $table = 'suscriptores';
    use HasFactory;
    protected $fillable = ['email'];
}
