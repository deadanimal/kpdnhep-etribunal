<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsTerengganuSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '11%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * terengganu
             */
            /*
             * === BESUT
             */
            ['ddsa_code' => '110101', 'name' => 'Bukit Kenak', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110102', 'name' => 'Bukit Puteri', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110105', 'name' => 'Hulu Besut', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110107', 'name' => 'Jabi', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110108', 'name' => 'Kampong Raja', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110109', 'name' => 'Keluang', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110110', 'name' => 'Kerandang', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110111', 'name' => 'Kuala Besut', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110112', 'name' => 'Kubang Bemban', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110113', 'name' => 'Lubuk Kawah', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110115', 'name' => 'Pasir Akar', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110116', 'name' => 'Pelagat', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110117', 'name' => 'Pengkalan Nangka', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110118', 'name' => 'Pulau Perhentian', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110120', 'name' => 'Tembila', 'level' => 1, 'district_id' => '1101'],
            ['ddsa_code' => '110121', 'name' => 'Tenang', 'level' => 1, 'district_id' => '1101'],

            ['ddsa_code' => '110170', 'name' => 'Pekan Jertih', 'level' => 3, 'district_id' => '1101'],
            ['ddsa_code' => '110171', 'name' => 'Pekan Kampung Raja', 'level' => 3, 'district_id' => '1101'],
            ['ddsa_code' => '110172', 'name' => 'Pekan Kuala Besut', 'level' => 3, 'district_id' => '1101'],
            /*
             * === DUNGUN
             */
            ['ddsa_code' => '110202', 'name' => 'Kuala Abang', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110201', 'name' => 'Besul', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110203', 'name' => 'Hulu Paka', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110204', 'name' => 'Jengai', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110205', 'name' => 'Jerangau', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110206', 'name' => 'Kuala Dungun', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110207', 'name' => 'Kuala Paka', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110208', 'name' => 'Kumpal', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110209', 'name' => 'Pasir Raja', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110210', 'name' => 'Rasau', 'level' => 1, 'district_id' => '1102'],
            ['ddsa_code' => '110211', 'name' => 'Sura', 'level' => 1, 'district_id' => '1102'],

            ['ddsa_code' => '110240', 'name' => 'Bandar Dungun', 'level' => 2, 'district_id' => '1102'],

            ['ddsa_code' => '110270', 'name' => 'Pekan Kuala Paka', 'level' => 3, 'district_id' => '1102'],
            /*
             * === KEMAMAN
             */
            ['ddsa_code' => '110301', 'name' => 'Bandi', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110302', 'name' => 'Banggul', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110303', 'name' => 'Binjai', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110304', 'name' => 'Cukai', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110305', 'name' => 'Hulu Cukai', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110306', 'name' => 'Hulu Jabur', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110307', 'name' => 'Kemasik', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110308', 'name' => 'Kerteh', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110309', 'name' => 'Kijal', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110310', 'name' => 'Pasir Semut', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110311', 'name' => 'Tebak', 'level' => 1, 'district_id' => '1103'],
            ['ddsa_code' => '110312', 'name' => 'Teluk Kalung', 'level' => 1, 'district_id' => '1103'],

            ['ddsa_code' => '110340', 'name' => 'Bandar Cukai', 'level' => 2, 'district_id' => '1103'],

            ['ddsa_code' => '110370', 'name' => 'Pekan Air Jernih', 'level' => 3, 'district_id' => '1103'],
            ['ddsa_code' => '110371', 'name' => 'Pekan Air Putih', 'level' => 3, 'district_id' => '1103'],
            ['ddsa_code' => '110372', 'name' => 'Pekan Kemasik', 'level' => 3, 'district_id' => '1103'],
            ['ddsa_code' => '110373', 'name' => 'Pekan Kijal', 'level' => 3, 'district_id' => '1103'],
            /*
             * === KUALA TERENGGANU
             */
            ['ddsa_code' => '110402', 'name' => 'Atas Tol', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110403', 'name' => 'Batu Buruk', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110404', 'name' => 'Batu Rakit', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110405', 'name' => 'Belara', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110406', 'name' => 'Bukit Besar', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110408', 'name' => 'Cabang Tiga', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110409', 'name' => 'Ceneriang', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110410', 'name' => 'Gelugur Kedai', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110411', 'name' => 'Gelugur Raja', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110413', 'name' => 'Kepung', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110414', 'name' => 'Kuala Ibai', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110415', 'name' => 'Kuala Nerus', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110416', 'name' => 'Kubang Parit', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110417', 'name' => 'Losong', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110418', 'name' => 'Manir', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110429', 'name' => 'Paluh', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110421', 'name' => 'Pengadang Buluh', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110422', 'name' => 'Pulau-pulau', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110423', 'name' => 'Pulau Redang', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110424', 'name' => 'Rengas', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110425', 'name' => 'Serada', 'level' => 1, 'district_id' => '1104'],
            ['ddsa_code' => '110426', 'name' => 'Tok Jamal', 'level' => 1, 'district_id' => '1104'],

            ['ddsa_code' => '110440', 'name' => 'Bandar Kuala Terengganu', 'level' => 2, 'district_id' => '1104'],

            ['ddsa_code' => '110471', 'name' => 'Pekan Cabang Tiga', 'level' => 3, 'district_id' => '1104'],
            /*
             * === HULU TERENGGANU
             */
            ['ddsa_code' => '110501', 'name' => 'Hulu Berang', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110502', 'name' => 'Hulu Telemung', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110503', 'name' => 'Hulu Terengganu', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110504', 'name' => 'Jenagur', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110505', 'name' => 'Kuala Berang', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110506', 'name' => 'Kuala Telemung', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110507', 'name' => 'Penghulu Diman', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110508', 'name' => 'Tanggul', 'level' => 1, 'district_id' => '1105'],
            ['ddsa_code' => '110509', 'name' => 'Tersat', 'level' => 1, 'district_id' => '1105'],

            ['ddsa_code' => '110570', 'name' => 'Pekan Kuala Berang', 'level' => 3, 'district_id' => '1105'],
            /*
             * === MARANG
             */
            ['ddsa_code' => '110601', 'name' => 'Jerung', 'level' => 1, 'district_id' => '1106'],
            ['ddsa_code' => '110602', 'name' => 'Mercang', 'level' => 1, 'district_id' => '1106'],
            ['ddsa_code' => '110603', 'name' => 'Pulau Kerengga', 'level' => 1, 'district_id' => '1106'],
            ['ddsa_code' => '110604', 'name' => 'Rusila', 'level' => 1, 'district_id' => '1106'],
            ['ddsa_code' => '110605', 'name' => 'Alur Limbat', 'level' => 1, 'district_id' => '1106'],
            ['ddsa_code' => '110606', 'name' => 'Bukit Payung', 'level' => 1, 'district_id' => '1106'],

            ['ddsa_code' => '110670', 'name' => 'Pekan Marang', 'level' => 3, 'district_id' => '1106'],
            ['ddsa_code' => '110671', 'name' => 'Pekan Bukit Payung', 'level' => 3, 'district_id' => '1106'],
            /*
             * === SETIU
             */
            ['ddsa_code' => '110701', 'name' => 'Caluk', 'level' => 1, 'district_id' => '1107'],
            ['ddsa_code' => '110702', 'name' => 'Guntung', 'level' => 1, 'district_id' => '1107'],
            ['ddsa_code' => '110703', 'name' => 'Hulu Nerus', 'level' => 1, 'district_id' => '1107'],
            ['ddsa_code' => '110704', 'name' => 'Merang', 'level' => 1, 'district_id' => '1107'],
            ['ddsa_code' => '110707', 'name' => 'Tasik', 'level' => 1, 'district_id' => '1107'],
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
