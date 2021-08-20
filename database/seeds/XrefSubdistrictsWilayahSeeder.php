<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsWilayahSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '14%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            ['ddsa_code' => '140101', 'name' => 'Ampang', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140102', 'name' => 'Batu', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140103', 'name' => 'Cheras', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140104', 'name' => 'Ulu Kelang', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140105', 'name' => 'Kuala Lumpur', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140106', 'name' => 'Petaling', 'level' => 1, 'district_id' => '1401'],
            ['ddsa_code' => '140107', 'name' => 'Setapak', 'level' => 1, 'district_id' => '1401'],

            ['ddsa_code' => '140144', 'name' => 'Bandar Kuala Lumpur', 'level' => 2, 'district_id' => '1401'],
            ['ddsa_code' => '140155', 'name' => 'Bandar Petaling Jaya', 'level' => 2, 'district_id' => '1401'],
            ['ddsa_code' => '140166', 'name' => 'Bandar Bandar Baharu Sungai Besi', 'level' => 2, 'district_id' => '1401'],

            ['ddsa_code' => '140170', 'name' => 'Pekan Batu', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140171', 'name' => 'Pekan Batu Caves', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140172', 'name' => 'Pekan Kepong', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140173', 'name' => 'Pekan Kuala Pauh', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140174', 'name' => 'Pekan Petaling', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140175', 'name' => 'Pekan Salak South', 'level' => 3, 'district_id' => '1401'],
            ['ddsa_code' => '140176', 'name' => 'Pekan Sungai Penchala', 'level' => 3, 'district_id' => '1401'],
        ];

        foreach ($data_seeds as $seed) {
            $seed['district_id'] = $districts[$seed['district_id']];
            MasterSubdistrict::create($seed);
        }

        $districts = MasterDistrict::where('ddsa_code', 'like', '16%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            ['ddsa_code' => '160140', 'name' => 'Bandar Putrajaya', 'level' => 1, 'district_id' => '1601'],
        ];

        foreach ($data_seeds as $seed) {
            $seed['district_id'] = $districts[$seed['district_id']];
            MasterSubdistrict::create($seed);
        }

        $districts = MasterDistrict::where('ddsa_code', 'like', '15%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            ['ddsa_code' => '150101', 'name' => 'Labuan', 'level' => 1, 'district_id' => '1501'],
        ];

        foreach ($data_seeds as $seed) {
            $seed['district_id'] = $districts[$seed['district_id']];
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
