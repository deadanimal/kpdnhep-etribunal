<?php

namespace App\Console\Commands;

use App\CaseModel\Form1;
use App\User;
use Illuminate\Console\Command;

class FixForm1IsOnlineFiling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixform1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix form1 is online filing';

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
        $ttpmUsers = User::select('user_id')
            ->where('user_type_id')
            ->pluck('user_id', 'user_id');

        Form1::select(['form1_id', 'created_by_user_id', 'is_online_filing'])
            ->whereNotNull('created_by_user_id')
            ->chunk(100, function ($forms) use ($ttpmUsers) {
                foreach ($forms as $form) {
                    echo $form->form1_id;

                    if (!isset($ttpmUsers[$form->created_by_user_id])){
                        $form->is_online_filing = 1;
                        $form->save();
                    }

                    echo '- ';
                }
            });
    }
}
