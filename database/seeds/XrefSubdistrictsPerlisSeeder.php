<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsPerlisSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $district = MasterDistrict::where('ddsa_code', '0900')->first();

        $data_seeds = [
            /*
             * perlis
             */
            ['ddsa_code' => '090001', 'name' => 'Abi', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090002', 'name' => 'Arau', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090003', 'name' => 'Berseri', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090004', 'name' => 'Chuping', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090005', 'name' => 'Utan Aji', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090006', 'name' => 'Jejawi', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090007', 'name' => 'Kayang', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090008', 'name' => 'Kechor', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090009', 'name' => 'Kuala Perlis', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090010', 'name' => 'Kurong Anai', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090011', 'name' => 'Kurong Batang', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090012', 'name' => 'Ngolang', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090013', 'name' => 'Oran', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090014', 'name' => 'Padang Pauh', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090015', 'name' => 'Padang Siding', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090016', 'name' => 'Paya', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090017', 'name' => 'Sanglang', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090018', 'name' => 'Sena', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090019', 'name' => 'Seriap', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090020', 'name' => 'Sungai Adam', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090021', 'name' => 'Titi Tinggi', 'level' => 1, 'district_id' => $district->district_id],
            ['ddsa_code' => '090022', 'name' => 'Wang Bintong', 'level' => 1, 'district_id' => $district->district_id],

            ['ddsa_code' => '090040', 'name' => 'Bandar Arau', 'level' => 2, 'district_id' => $district->district_id],
            ['ddsa_code' => '090041', 'name' => 'Bandar Kangar', 'level' => 2, 'district_id' => $district->district_id],

            ['ddsa_code' => '090070', 'name' => 'Pekan Kuala Perlis', 'level' => 3, 'district_id' => $district->district_id],
            ['ddsa_code' => '090072', 'name' => 'Pekan Kaki Bukit', 'level' => 3, 'district_id' => $district->district_id],
        ];

        foreach ($data_seeds as $seed) {
            MasterSubdistrict::create($seed);
        }
    }

    /**
     * Reverts the database seeder.
     */
    public function down(): void
    {
        // Remove your data
    }
}
