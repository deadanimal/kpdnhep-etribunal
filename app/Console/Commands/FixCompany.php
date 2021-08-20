<?php

namespace App\Console\Commands;

use App\SupportModel\UserClaimCase;
use App\User;
use App\UserPublic;
use App\UserPublicCompany;
use App\UserPublicIndividual;
use Illuminate\Console\Command;

class FixCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixcompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix company post patch data that wrongly done. Base from UserController@fixCompany';

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
        $companies = UserPublic::with('user','user.userClaimCase')
            ->where('user_public_type_id', 2)
            ->whereHas('user.userClaimCase', function($q) {
                $q->where('is_company', 0);
            })
            ->limit(500)
            ->get();

        foreach ($companies as $k => $company) {
            echo 'user_id: ' . $company->user_id;

            // get user_claim_case is_company flag
            $userClaimCase = UserClaimCase::where([
                'user_id' => $company->user_id,
                'is_company' => 0
            ])->first();

            if (!$userClaimCase) {
                echo ' - claim_case_non_company' . PHP_EOL;
                continue;
            }

            // get public_individual data
            $userPublicIndividual = UserPublicIndividual::where('user_id', $company->user_id)->first();

            if (!$userPublicIndividual) {
                echo ' - user_non_individual' . PHP_EOL;
                continue;
            }

            // create if not have
            UserPublicCompany::firstOrCreate(['user_id' => $company->user_id],
                [
                    'user_id' => $company->user_id,
                    'company_no' => $company->user->username,
                    'representative_phone_mobile' => $userPublicIndividual->phone_mobile,
                    'created_at' => $userPublicIndividual->created_at,
                    'updated_at' => $userPublicIndividual->updated_at,
                ]);

            // update user_claim_case is_company flag
            UserClaimCase::where(['user_id' => $company->user_id, 'is_company' => 0])
                ->update(['is_company' => 1]);

            echo ' - success' . PHP_EOL;
        }
    }
}
