<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use Illuminate\Console\Command;

class FixIsFinished extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixisfinished';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix multi oppoenent data';

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
        for ($i = 1; $i <= 200000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $oppos = ClaimCase::whereBetween('claim_case_id', [$i, ($i + 50)])
                ->where('case_status_id', 8)
                ->where('is_finished', 0)
                ->get();

            foreach ($oppos as $oppo) {
                $oppo->update(
                    [ 'is_finished' => 1 ]
                );

                echo '.';
            }
        }
    }
}
