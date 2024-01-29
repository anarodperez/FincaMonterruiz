<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\NewsletterSchedule;
use Illuminate\Support\Facades\Artisan;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
{
    $schedule->call(function () {
        $config = NewsletterSchedule::first();
        if ($config) {
            // Obtener el día y la hora actuales
            $currentDay = now()->format('l');
            $currentTime = now()->format('H:i');

            // Obtener la hora programada para el envío
            $scheduledTime = date('H:i', strtotime($config->execution_time));

            // Ejecutar la tarea si coinciden el día y la hora exacta
            if ($currentDay == $config->day_of_week && $currentTime == $scheduledTime) {
                Artisan::call('newsletter:send');
            }
        }
    })->everyMinute();
}


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
