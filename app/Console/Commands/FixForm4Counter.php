<?php

namespace App\Console\Commands;

use App\CaseModel\Form4;
use Illuminate\Console\Command;

class FixForm4Counter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixform4counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix form 4 counter';

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
        // get companies from user_public
        for ($i = 1; $i <= 150000; $i++) {
            $form4s = Form4::where('claim_case_id', $i)
                ->whereNotIn('id', [])
                ->orderBy('form4_id')
                ->get();

            foreach ($form4s as $j => $form4) {
                $form4->counter = $j+1;
                $form4->save();
                echo '.';
            }
        }
    }
}
