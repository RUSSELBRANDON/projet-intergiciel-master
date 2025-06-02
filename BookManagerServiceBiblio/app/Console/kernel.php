<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Les commandes Artisan de l'application.
     */
    protected $commands = [
        \App\Console\Commands\SendBorrowDueReminders::class,
    ];

    /**
     * Définir le planning des commandes.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('borrows:send-due-reminders')
                 ->daily(); // Exécuter tout les jours
    }

    /**
     * Enregistrer les commandes pour l'application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}