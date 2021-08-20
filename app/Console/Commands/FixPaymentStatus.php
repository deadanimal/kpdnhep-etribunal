<?php

namespace App\Console\Commands;

use App\CaseModel\Form1;
use App\CaseModel\Form2;
use Illuminate\Console\Command;

class FixPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixpaymentstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To send fpx ae request to get latest info';

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
        $form1 = Form1::join('payment', 'payment.form_id', '=', 'form1.form1_id')
            ->where('payment.form_no', 1)
            ->whereNotNull('receipt_no')
            ->where('form1.form_status_id', 15)
            ->get();

        foreach($form1 as $f1) {
            $f1->form_status_id = 14;
            $f1->save();

            echo '.';
        }

        $form2 = Form2::join('payment', 'payment.form_id', '=', 'form2.form2_id')
            ->where('payment.form_no', 2)
            ->whereNotNull('receipt_no')
            ->where('form2.form_status_id', 18)
            ->get();

        foreach($form2 as $f2) {
            $f2->form_status_id = 19;
            $f2->save();

            echo '-';
        }
    }
}

