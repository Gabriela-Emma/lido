<?php

namespace App\Console;

use App\Jobs\CalculateDelegationEpochs;
use App\Jobs\CardanoStatsJob;
use App\Jobs\LidoStatsJob;
use App\Jobs\ProcessPendingWithdrawalsJob;
use App\Jobs\RefreshLidoTwitterToken;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('ln:ca-ir')->daily();
        $schedule->command('ln:ca-fr')->weekly();
        $schedule->command('ln:ca-wr')->weekly();
        $schedule->command('ln:ca-cr')->days([1, 3, 5])->at('12:00');

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('01:30');
        $schedule->command('model:prune')->weekly();

        $schedule->job(new ProcessPendingWithdrawalsJob)->everyFiveMinutes();
        $schedule->job(new CalculateDelegationEpochs)->daily();
        $schedule->job(new LidoStatsJob)->everyFifteenMinutes();
        $schedule->job(new CardanoStatsJob)->everyTwoHours();
        $schedule->job(new RefreshLidoTwitterToken)->everyThirtyMinutes();

        $schedule->command('ln:sitemap:generate')->weekly();

        $schedule->command('media-library:delete-old-temporary-uploads')->daily();

        //crawler commands
        $schedule->command('ln:crawl-iohk-blog --lang=en')->daily()->at('05::00');
        $schedule->command('ln:crawl-iohk-blog --lang=ja')->daily()->at('05::00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
