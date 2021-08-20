<?php

namespace App\Console\Commands;

use App\PaymentModel\PaymentFPX;
use App\Repositories\FpxRepository;
use Illuminate\Console\Command;

class FpxAeRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fpxaerequest';

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
        // get all payment fpx that is null in status
        $payment_fpxs = PaymentFPX::with('payment')
            ->where('fpx_status_id', null)
            ->orWhereIn('fpx_status_id',['09', '99'])
//            ->where('payment_fpx_id', 10118)
//            ->limit(1)
            ->get();

        foreach ($payment_fpxs as $payment_fpx) {
            FpxRepository::indirect($payment_fpx);
        }
    }
}

