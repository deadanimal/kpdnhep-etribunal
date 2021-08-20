<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use App\CaseModel\StopNotice;
use App\HearingModel\Award;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixTwinLanguangeAwardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixtwinlanguageawarddata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix twin languange award data';

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
        for ($i = 1; $i <= 45000; $i += 50) {
            echo PHP_EOL . 'i: ' . $i . ' - ' . ($i + 50);
            $data = Award::whereBetween('award_id', [$i, ($i + 50)])
                ->whereNull('award_description_en')
                ->get();

            foreach ($data as $datum) {
                $datum->award_description_en = $datum->award_description;
                $datum->save();
                echo '.';
            }
        }
    }
}
