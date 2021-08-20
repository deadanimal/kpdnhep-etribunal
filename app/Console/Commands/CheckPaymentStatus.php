<?php

namespace App\Console\Commands;

use App\CaseModel\Form1;
use App\CaseModel\Form2;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:checkpaymentstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to check payment status and reset to draft when delay more than 14 days.';

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
        self::form1();

        self::form2();
    }

    public static function form1()
    {
        echo PHP_EOL . 'FORM1 START' . PHP_EOL;

        $forms = Form1::where('form_status_id', 14)
            ->orWhere('form_status_id', 15)
            ->get();

        foreach ($forms as $form) {
            if ($form->created_at->diff(Carbon::now())->days > 14 && (!$form->payment_id || $form->payment->payment_status_id != 4)) {
                $form->form_status_id = 13;
                $form->save();

                echo 'D';
            }

            echo '.';
        }
    }

    public static function form2()
    {
        echo PHP_EOL . 'FORM2 START' . PHP_EOL;

        $forms = Form2::where('form_status_id', 19)
            ->orWhere('form_status_id', 20)
            ->get();

        foreach ($forms as $form) {
            if ($form->created_at->diff(Carbon::now())->days > 14 && (!$form->payment_id || $form->payment->payment_status_id != 4)) {
                $form->form_status_id = 18;
                $form->save();

                echo 'D';
            }

            echo '.';
        }
    }
}

