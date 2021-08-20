<?php

namespace App\Console\Commands;

use App\Helpers\GetCurrentAgeHelper;
use App\SupportModel\UserClaimCase;
use Illuminate\Console\Command;

class FixUserClaimCaseAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix age';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        UserClaimCase::where('is_company', 0)
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    echo $user->user_claimcase_id;

                    if (strlen(preg_replace("/\D/", '', $user->identification_no)) == 14) {
                        $user->age = GetCurrentAgeHelper::calc(substr($user->identification_no, 0, 6), $user->created_at->format('Y-m-d'));
                        $user->save();
                    }

                    echo '- ';
                }
            });
    }
}
