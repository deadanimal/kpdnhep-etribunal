<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\FixCompany',
        'App\Console\Commands\FixForm2Fk',
        'App\Console\Commands\FixForm4Counter',
        'App\Console\Commands\FixUserCompanyData',
        'App\Console\Commands\FixMultiOpponentData',
        'App\Console\Commands\FixMoPaymentData',
        'App\Console\Commands\FixMoStopNoticeData',
        'App\Console\Commands\FixMoClaimCaseBranchData',
        'App\Console\Commands\FixMoForm2Data',
        'App\Console\Commands\FixMoForm4Data',
        'App\Console\Commands\FixTwinLanguangeAwardData',
        'App\Console\Commands\FpxAeRequest',
        'App\Console\Commands\FixIsFinished',
        'App\Console\Commands\FixPaymentCcoidPatch',
        'App\Console\Commands\FixInquiryNotAnswered',

        'App\Console\Commands\FixForm1ProcessedAt',
        'App\Console\Commands\FixForm1Sequence',
        'App\Console\Commands\FixRunnerCounter',
        'App\Console\Commands\FixUserClaimCaseAge',
        'App\Console\Commands\FixForm1IsOnlineFiling',
        'App\Console\Commands\FixForm2IsOnlineFiling',
        'App\Console\Commands\FixForm3IsOnlineFiling',

        'App\Console\Commands\FixPaymentStatus',

        'App\Console\Commands\CheckPaymentStatus',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tribunal:fpxaerequest')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command('tribunal:fixpaymentstatus')
            ->hourly()
            ->withoutOverlapping();

        $schedule->command('tribunal:checkpaymentstatus')
            ->daily()
            ->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
