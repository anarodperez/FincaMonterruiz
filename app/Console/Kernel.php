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
                //Obtener el dia y la hora Actuales:
                $currentDay = now()->format('l');
                $currentTime = now()->format('H:i:s');

                //Obtener la Hora Programada para el Envío:
                $scheduledTime = date('H:i:s', strtotime($config->execution_time));

                //Estableces una ventana de tiempo de +/- 1 minuto alrededor de la hora programada para permitir cierta flexibilidad
                $startTime = date('H:i:s', strtotime($scheduledTime . ' -1 minute'));
                $endTime = date('H:i:s', strtotime($scheduledTime . ' +1 minute'));

                // Ejecutar la Tarea si coinciden el día y la hora
                if ($currentDay == $config->day_of_week && $currentTime >= $startTime && $currentTime <= $endTime) {
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
