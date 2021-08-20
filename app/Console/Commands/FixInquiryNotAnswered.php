<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Inquiry;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixInquiryNotAnswered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixinquirynotanswered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix inquiry that not answered';

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
//        for ($i = 1; $i <= 33000; $i += 100) {
//            echo 'i: ' . $i . ' - ' . ($i + 100) . PHP_EOL;
            $data = Inquiry::whereIn('inquiry_form_status_id', [9,10])
                ->whereYear('created_at', '<=', 2019)
                ->get();

            foreach ($data as $datum) {
                echo $datum->inquiry_id;

                $datum->update([
                    'inquiry_feedback_id' => 3, // rujuk ke cawangan berdekatan
                    'inquiry_form_status_id' => 11, // telah dijawab
                   'inquiry_feedback_msg' => "Sila rujuk cawangan berdekatan
TTPM Putrajaya
Tribunal Tuntutan Pengguna Malaysia
Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Putrajaya
Aras 5, Podium 2, No. 13 Persiaran Perdana,Presint 2, Pusat Pentadbiran Kerajaan Persekutuan
62623 PUTRAJAYA WILAYAH PERSEKUTUAN PUTRAJAYA
Emel: ttpmputrajaya@kpdnhep.gov.my
No. Telefon Pejabat: 03-88825822",
                    'processed_by_user_id' => null, // entah
                    'processed_at' => '2020-01-01 00:00:00', // entah
                ]);

                echo '.';
            }
//        }
    }
}
