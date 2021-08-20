<?php

namespace App\Console\Commands;

use App\CaseModel\StopNotice;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixMoStopNoticeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixmostopnoticedata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix multi oppo stop notice data';

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
        for ($i = 18000; $i <= 20000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = StopNotice::with('case', 'case.multiOpponents')
                ->whereBetween('stop_notice_id', [$i, ($i + 50)])
                ->get();

            foreach ($data as $datum) {
                if ($datum->case->multiOpponents && $datum->case->multiOpponents->count() > 0) {
                    $datum->claim_case_opponent_id = $datum->case->multiOpponents[0]->id;
                    $datum->save();
                    echo '.';
                } else {
                    echo '-';
                }
            }
        }
    }
}
