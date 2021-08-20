<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form1;
use App\CaseModel\Inquiry;
use App\MasterModel\MasterState;
use App\Models\Runner;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixRunnerCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixrunnercounter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix runner counter';

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
        foreach (MasterState::all() as $state) {
            Runner::updateOrCreate(
                [
                    'rule_1' => 'INQUIRY',
                    'rule_2' => $state->code,
                    'rule_3' => date('Y')
                ],
                [
                    'runner' => $state->next_inquiry_no
                ]);

            Runner::updateOrCreate(
                [
                    'rule_1' => 'TTPM',
                    'rule_2' => $state->code,
                    'rule_3' => date('Y')
                ],
                [
                    'runner' => $state->next_claim_no
                ]);

            Runner::updateOrCreate(
                [
                    'rule_1' => 'B1',
                    'rule_2' => $state->code,
                    'rule_3' => date('Y')
                ],
                [
                    'runner' => $state->next_b1_no
                ]);

            echo '.';
        }

        $payment = Payment::where('receipt_no', 'like', 'T20%')
            ->orderBy('updated_at', 'desc')
            ->first();

        Runner::updateOrCreate(
            [
                'rule_1' => 'T',
            ],
            [
                'runner' => (int) substr($payment->receipt_no, -6)
            ]
        );
    }
}
