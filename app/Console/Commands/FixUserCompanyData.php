<?php

namespace App\Console\Commands;

use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixUserCompanyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixusercompanydata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix user company data';

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
        for ($i = 1; $i <= 240000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $user_public_data = UserPublic::with('user', 'company', 'individual')
                ->whereBetween('user_public_id', [$i, ($i + 50)])
                ->where('user_public_type_id', 2) // company
                ->get();

            foreach ($user_public_data as $user_public_datum) {
                if (!$user_public_datum->company) {

                    // only proceed if have data individual.
                    if ($user_public_datum->individual) {
                        // check if company number have been used
                        $user_public_company = UserPublicCompany::where('company_no', $user_public_datum->individual->identification_no)->first();

                        if ($user_public_company) {
                            echo 'upc been exist ' . $user_public_company->user_public_company_id . ' company_no ' . $user_public_datum->individual->identification_no . ' ' . PHP_EOL;
                            continue;
                        }

                        // create user_public_company data
                        UserPublicCompany::create([
                            'user_id' => $user_public_datum->user_id,
                            'company_no' => $user_public_datum->individual->identification_no,
                            'representative_name' => $user_public_datum->individual->identification_no,
                            'representative_identification_no' => $user_public_datum->individual->identification_no,
                            'representative_phone_home' => $user_public_datum->individual->phone_home,
                            'representative_phone_mobile' => $user_public_datum->individual->phone_mobile,
                        ]);
                    } else {
                        echo 'empty data - ' . $user_public_datum->user_public_id . PHP_EOL;
                    }

                    echo '.';
                } else {
                    echo '.';
                }
            }
        }
    }
}
