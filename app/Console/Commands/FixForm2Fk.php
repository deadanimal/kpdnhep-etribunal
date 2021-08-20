<?php

namespace App\Console\Commands;

use App\CaseModel\Form1;
use App\CaseModel\Form2;
use Illuminate\Console\Command;

class FixForm2Fk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixform2fk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix form 2 fk to form 1';

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
        for ($i = 1; $i <= 35000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = Form2::whereBetween('form2_id', [$i, ($i + 50)])
                ->whereNull('form1_id')
                ->orderBy('form2_id')
                ->get();

            foreach ($data as $datum) {
                $f1 = Form1::where('form2_id', $datum->form2_id)->first();
                $datum->form1_id = $f1->form1_id;
                $datum->save();
                echo '.';
            }
        }
    }
}
