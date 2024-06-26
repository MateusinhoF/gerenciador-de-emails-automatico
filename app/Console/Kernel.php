<?php

namespace App\Console;

use App\Console\Commands\EnviarCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        EnviarCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
//        $schedule->command('emails:enviar')->everyMinute();
        $schedule->command('enviar:email')->dailyAt('12:00');
        $schedule->command('enviar:whatsapp')->dailyAt('12:00');
        $schedule->command('enviar:sms')->dailyAt('12:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
