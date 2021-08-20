<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use Illuminate\Console\Command;

class FixMultiOpponentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixmultiopponentdata';

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
                ->whereNotNull('opponent_user_id') // data oppo
                ->whereNotNull('opponent_address_id') // data oppo
                ->get();

            foreach ($oppos as $oppo) {
                // check if cc_id have been fixed
                $cc_oppo = ClaimCaseOpponent::where('claim_case_id', $oppo->claim_case_id)->first();

                if (!$cc_oppo) {
                    ClaimCaseOpponent::create([
                        'claim_case_id' => $oppo->claim_case_id,
                        'opponent_user_id' => $oppo->opponent_user_id,
                        'opponent_address_id' => $oppo->opponent_address_id,
                        'status_id' => $oppo->case_status_id == 8 ? 2 : 1,
                    ]);
                    echo '.';
                } else {
                    echo '-';
                }
            }
        }
    }
}
