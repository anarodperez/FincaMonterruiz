<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSchedule extends Model
{
    use HasFactory;

    protected $table = 'newsletter_schedule';

    protected $fillable = [
        'day_of_week',
        'execution_time',
    ];
}
