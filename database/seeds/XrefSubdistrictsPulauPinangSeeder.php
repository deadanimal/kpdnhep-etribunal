<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsPulauPinangSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '07%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * pulau pinang
             */
            /*
             * === SEBERANG PRAI TENGAH
             */
            ['ddsa_code' => '070101', 'name' => 'Mukim 1', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070102', 'name' => 'Mukim 2', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070103', 'name' => 'Mukim 3', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070104', 'name' => 'Mukim 4', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070105', 'name' => 'Mukim 5', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070106', 'name' => 'Mukim 6', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070107', 'name' => 'Mukim 7', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070108', 'name' => 'Mukim 8', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070109', 'name' => 'Mukim 9', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070110', 'name' => 'Mukim 10', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070111', 'name' => 'Mukim 11', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070112', 'name' => 'Mukim 12', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070113', 'name' => 'Mukim 13', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070114', 'name' => 'Mukim 14', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070115', 'name' => 'Mukim 15', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070116', 'name' => 'Mukim 16', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070117', 'name' => 'Mukim 17', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070118', 'name' => 'Mukim 18', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070129', 'name' => 'Mukim 19', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070120', 'name' => 'Mukim 20', 'level' => 1, 'district_id' => '0701'],
            ['ddsa_code' => '070121', 'name' => 'Mukim 21', 'level' => 1, 'district_id' => '0701'],

            ['ddsa_code' => '070140', 'name' => 'Bandar Bukit Mertajam', 'level' => 2, 'district_id' => '0701'],
            ['ddsa_code' => '070141', 'name' => 'Bandar Prai', 'level' => 2, 'district_id' => '0701'],
            /*
             * === SEBERANG PRAI UTARA
             */
            ['ddsa_code' => '070201', 'name' => 'Mukim 1', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070202', 'name' => 'Mukim 2', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070203', 'name' => 'Mukim 3', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070204', 'name' => 'Mukim 4', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070205', 'name' => 'Mukim 5', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070206', 'name' => 'Mukim 6', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070207', 'name' => 'Mukim 7', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070208', 'name' => 'Mukim 8', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070209', 'name' => 'Mukim 9', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070210', 'name' => 'Mukim 10', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070211', 'name' => 'Mukim 11', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070212', 'name' => 'Mukim 12', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070213', 'name' => 'Mukim 13', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070214', 'name' => 'Mukim 14', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070215', 'name' => 'Mukim 15', 'level' => 1, 'district_id' => '0702'],
            ['ddsa_code' => '070216', 'name' => 'Mukim 16', 'level' => 1, 'district_id' => '0702'],

            ['ddsa_code' => '070240', 'name' => 'Bandar Butterworth', 'level' => 2, 'district_id' => '0702'],
            ['ddsa_code' => '070241', 'name' => 'Bandar Kepala Batas', 'level' => 2, 'district_id' => '0702'],
            /*
             * === SEBERANG PRAI SELATAN
             */
            ['ddsa_code' => '070301', 'name' => 'Mukim 1', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070302', 'name' => 'Mukim 2', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070303', 'name' => 'Mukim 3', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070304', 'name' => 'Mukim 4', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070305', 'name' => 'Mukim 5', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070306', 'name' => 'Mukim 6', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070307', 'name' => 'Mukim 7', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070308', 'name' => 'Mukim 8', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070309', 'name' => 'Mukim 9', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070310', 'name' => 'Mukim 10', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070311', 'name' => 'Mukim 11', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070312', 'name' => 'Mukim 12', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070313', 'name' => 'Mukim 13', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070314', 'name' => 'Mukim 14', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070315', 'name' => 'Mukim 15', 'level' => 1, 'district_id' => '0703'],
            ['ddsa_code' => '070316', 'name' => 'Mukim 16', 'level' => 1, 'district_id' => '0703'],

            ['ddsa_code' => '070340', 'name' => 'Bandar Nibong Tebal', 'level' => 2, 'district_id' => '0703'],
            ['ddsa_code' => '070341', 'name' => 'Bandar Sungai Bakap', 'level' => 2, 'district_id' => '0703'],
            /*
             * === TIMUR LAUT
             */
            ['ddsa_code' => '070401', 'name' => 'Mukim 13', 'level' => 1, 'district_id' => '0704'],
            ['ddsa_code' => '070402', 'name' => 'Mukim 14', 'level' => 1, 'district_id' => '0704'],
            ['ddsa_code' => '070404', 'name' => 'Mukim 16', 'level' => 1, 'district_id' => '0704'],
            ['ddsa_code' => '070405', 'name' => 'Mukim 17', 'level' => 1, 'district_id' => '0704'],
            ['ddsa_code' => '070406', 'name' => 'Mukim 18', 'level' => 1, 'district_id' => '0704'],

            ['ddsa_code' => '070440', 'name' => 'Bandar Ayer Itam', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070441', 'name' => 'Bandar Batu Ferringgi', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070442', 'name' => 'Bandar Bukit Bendera', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070443', 'name' => 'Bandar Glugor', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070444', 'name' => 'Bandar George Town', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070445', 'name' => 'Bandar Jelutong', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070446', 'name' => 'Bandar Tanjong Bungah', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070447', 'name' => 'Bandar Tanjong Tokong', 'level' => 2, 'district_id' => '0704'],
            ['ddsa_code' => '070448', 'name' => 'Bandar Tanjong Pinang', 'level' => 2, 'district_id' => '0704'],
            /*
             * === BARAT DAYA
             */
            ['ddsa_code' => '070501', 'name' => 'Mukim 1', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070502', 'name' => 'Mukim 2', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070503', 'name' => 'Mukim 3', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070504', 'name' => 'Mukim 4', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070505', 'name' => 'Mukim 5', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070506', 'name' => 'Mukim 6', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070507', 'name' => 'Mukim 7', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070508', 'name' => 'Mukim 8', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070509', 'name' => 'Mukim 9', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070510', 'name' => 'Mukim 10', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070511', 'name' => 'Mukim 11', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070512', 'name' => 'Mukim 12', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070513', 'name' => 'Mukim A', 'level' => 1, 'district_id' => '0705'], // serius shit? clash with mukim A, mukim B
            ['ddsa_code' => '070514', 'name' => 'Mukim B', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070515', 'name' => 'Mukim C', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070516', 'name' => 'Mukim D', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070517', 'name' => 'Mukim E', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070518', 'name' => 'Mukim F', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070519', 'name' => 'Mukim G', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070520', 'name' => 'Mukim H', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070521', 'name' => 'Mukim I', 'level' => 1, 'district_id' => '0705'],
            ['ddsa_code' => '070522', 'name' => 'Mukim J', 'level' => 1, 'district_id' => '0705'],

            ['ddsa_code' => '070540', 'name' => 'Bandar Balik Pulau', 'level' => 2, 'district_id' => '0705'],
            ['ddsa_code' => '070541', 'name' => 'Bandar Bayan Lepas', 'level' => 2, 'district_id' => '0705'],
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
