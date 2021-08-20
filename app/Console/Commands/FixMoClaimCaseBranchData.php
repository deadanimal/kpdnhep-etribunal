<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\StopNotice;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixMoClaimCaseBranchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixmoclaimcasebranchdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix multi oppo claim case branch data';

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
        for ($i = 1; $i <= 220000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = ClaimCaseOpponent::with('claimCase')
                ->whereBetween('id', [$i, ($i + 50)])
                ->get();

            foreach ($data as $datum) {
                $datum->branch_id = $datum->claimCase->branch_id;
                $datum->transfer_branch_id = $datum->claimCase->transfer_branch_id;
                $datum->save();
                echo '.';
            }
        }
    }
}
