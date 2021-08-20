<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsNegeriSembilanSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '05%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * negeri sembilan
             */
            /*
             * === JELEBU
             */
            ['ddsa_code' => '050101', 'name' => 'Gelami Lemi', 'level' => 1, 'district_id' => '0501'],
            ['ddsa_code' => '050102', 'name' => 'Kenaboi', 'level' => 1, 'district_id' => '0501'],
            ['ddsa_code' => '050103', 'name' => 'Kuala Kelawang', 'level' => 1, 'district_id' => '0501'],
            ['ddsa_code' => '050104', 'name' => 'Peradong', 'level' => 1, 'district_id' => '0501'],
            ['ddsa_code' => '050105', 'name' => 'Pertang', 'level' => 1, 'district_id' => '0501'],
            ['ddsa_code' => '050106', 'name' => 'Teriang Hilir', 'level' => 1, 'district_id' => '0501'],

            ['ddsa_code' => '050140', 'name' => 'Bandar Kuala Kelawang', 'level' => 2, 'district_id' => '0501'],

            ['ddsa_code' => '050170', 'name' => 'Pekan Kuala Kelawang', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050171', 'name' => 'Pekan Pertang', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050172', 'name' => 'Pekan Titi', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050173', 'name' => 'Pekan Simpang Durian', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050174', 'name' => 'Pekan Simpang Pertang', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050175', 'name' => 'Pekan Petaling', 'level' => 3, 'district_id' => '0501'],
            ['ddsa_code' => '050176', 'name' => 'Pekan Sungai Muntoh', 'level' => 3, 'district_id' => '0501'],
            /*
             * === KUALA PILAH
             */
            ['ddsa_code' => '050201', 'name' => 'Ampang Tinggi', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050202', 'name' => 'Ulu Jempol', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050203', 'name' => 'Ulu Muar', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050204', 'name' => 'Johol', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050205', 'name' => 'Juasseh', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050206', 'name' => 'Kepis', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050207', 'name' => 'Langkap', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050208', 'name' => 'Parit Tinggi', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050209', 'name' => 'Pilah', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050210', 'name' => 'Sri Menanti', 'level' => 1, 'district_id' => '0502'],
            ['ddsa_code' => '050211', 'name' => 'Terachi', 'level' => 1, 'district_id' => '0502'],

            ['ddsa_code' => '050240', 'name' => 'Bandar Kuala Pilah', 'level' => 2, 'district_id' => '0502'],

            ['ddsa_code' => '050270', 'name' => 'Pekan Dangi', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050271', 'name' => 'Pekan Gunung Pasir', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050272', 'name' => 'Pekan Johol', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050273', 'name' => 'Pekan Parit Tinggi', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050274', 'name' => 'Pekan Senaling', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050275', 'name' => 'Pekan Tanjong Ipoh', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050276', 'name' => 'Pekan Juasseh', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050277', 'name' => 'Pekan Bukit Gelugor', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050278', 'name' => 'Pekan Melang', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050279', 'name' => 'Pekan Ar Mawang', 'level' => 3, 'district_id' => '0502'],
            ['ddsa_code' => '050280', 'name' => 'Pekan Dangi Baru', 'level' => 3, 'district_id' => '0502'],
            /*
             * === PORT DICKSON
             */
            ['ddsa_code' => '050301', 'name' => 'Jimah', 'level' => 1, 'district_id' => '0503'],
            ['ddsa_code' => '050303', 'name' => 'Linggi', 'level' => 1, 'district_id' => '0503'],
            ['ddsa_code' => '050304', 'name' => 'Port Dickson', 'level' => 1, 'district_id' => '0503'],
            ['ddsa_code' => '050305', 'name' => 'Si Rusa', 'level' => 1, 'district_id' => '0503'],

            ['ddsa_code' => '050340', 'name' => 'Bandar Port Dickson', 'level' => 2, 'district_id' => '0503'],
            ['ddsa_code' => '050341', 'name' => 'Bandar Teluk Kemang', 'level' => 2, 'district_id' => '0503'],

            ['ddsa_code' => '050370', 'name' => 'Pekan Lukut', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050371', 'name' => 'Pekan Pasir Panjang', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050372', 'name' => 'Pekan Pengkalan Kempas', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050373', 'name' => 'Pekan Chuah', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050374', 'name' => 'Pekan Port Dickson', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050375', 'name' => 'Pekan Teluk Kemang', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050376', 'name' => 'Pekan Bukit Pelanduk', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050377', 'name' => 'Pekan Linggi', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050378', 'name' => 'Pekan Air Kuning', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050379', 'name' => 'Pekan Sungai Menyala', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050380', 'name' => 'Pekan Bagan Pinang', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050381', 'name' => 'Pekan Tanah Merah UTARA', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050382', 'name' => 'Pekan Tanah Merah SELATAN', 'level' => 3, 'district_id' => '0503'],
            ['ddsa_code' => '050383', 'name' => 'Pekan Jemima', 'level' => 3, 'district_id' => '0503'],
            /*
             * === REMBAU
             */
            ['ddsa_code' => '050401', 'name' => 'Batu Hampar', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050402', 'name' => 'Bongek', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050403', 'name' => 'Chembong', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050404', 'name' => 'Chengkau', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050405', 'name' => 'Gadong', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050406', 'name' => 'Kundor', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050407', 'name' => 'Legong Ilir', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050408', 'name' => 'Legong Ulu', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050409', 'name' => 'Miku', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050410', 'name' => 'Nerasau', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050411', 'name' => 'Pedas', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050412', 'name' => 'Pilin', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050413', 'name' => 'Selemak', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050414', 'name' => 'Semerbok', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050415', 'name' => 'Spri', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050416', 'name' => 'Tanjong Keling', 'level' => 1, 'district_id' => '0504'],
            ['ddsa_code' => '050417', 'name' => 'Titian Bintangor', 'level' => 1, 'district_id' => '0504'],

            ['ddsa_code' => '050440', 'name' => 'Bandar Rembau', 'level' => 2, 'district_id' => '0504'],

            ['ddsa_code' => '050470', 'name' => 'Pekan Kampong Batu', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050471', 'name' => 'Pekan Kota', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050472', 'name' => 'Pekan Lubok China', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050473', 'name' => 'Pekan Pedas', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050474', 'name' => 'Pekan Chembong', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050475', 'name' => 'Pekan Rembau', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050476', 'name' => 'Pekan Chengkau', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050477', 'name' => 'Pekan Seri Kota', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050478', 'name' => 'Pekan Seri Kendong', 'level' => 3, 'district_id' => '0504'],
            ['ddsa_code' => '050479', 'name' => 'Pekan Merbau Sembilan', 'level' => 3, 'district_id' => '0504'],
            /*
             * === SEREMBAN
             */
            ['ddsa_code' => '050501', 'name' => 'Ampangan', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050502', 'name' => 'Labu', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050503', 'name' => 'Lenggeng', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050504', 'name' => 'Pantai', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050505', 'name' => 'Rantau', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050506', 'name' => 'Rasah', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050507', 'name' => 'Seremban', 'level' => 1, 'district_id' => '0505'],
            ['ddsa_code' => '050508', 'name' => 'Setul', 'level' => 1, 'district_id' => '0505'],

            ['ddsa_code' => '050540', 'name' => 'Bandar Seremban', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050541', 'name' => 'Bandar Seremban 3', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050542', 'name' => 'Bandar Seremban Utama', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050543', 'name' => 'Bandar Mantin Utama', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050544', 'name' => 'Bandar Baru Enstek', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050545', 'name' => 'Bandar Baru Kota SRI MAS', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050546', 'name' => 'Bandar Nilai Utama', 'level' => 2, 'district_id' => '0505'],
            ['ddsa_code' => '050547', 'name' => 'Bandar Sri Sendayan', 'level' => 2, 'district_id' => '0505'],

            ['ddsa_code' => '050570', 'name' => 'Pekan Broga', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050571', 'name' => 'Pekan Ulu Beranang', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050572', 'name' => 'Pekan Labu', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050573', 'name' => 'Pekan Lenggeng', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050574', 'name' => 'Pekan Mambau', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050575', 'name' => 'Pekan Nilai', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050576', 'name' => 'Pekan Mantin', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050577', 'name' => 'Pekan Pajam', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050578', 'name' => 'Pekan Rantau', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050579', 'name' => 'Pekan Tiroi', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050580', 'name' => 'Pekan Pancor', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050581', 'name' => 'Pekan Taman Seremban', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050582', 'name' => 'Pekan Rahang Baru', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050583', 'name' => 'Pekan Paroi', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050584', 'name' => 'Pekan Bukit Kepayang', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050585', 'name' => 'Pekan Dusun Setia', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050586', 'name' => 'Pekan Sungai Gadut', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050587', 'name' => 'Pekan Bukti', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050588', 'name' => 'Pekan Sikamat', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050589', 'name' => 'Pekan Setul', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050590', 'name' => 'Pekan Shah Bandar', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050591', 'name' => 'Pekan Ulu Temiang', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050592', 'name' => 'Pekan Paroi Jaya', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050593', 'name' => 'Pekan Rasah Jaya', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050594', 'name' => 'Pekan Senawang', 'level' => 3, 'district_id' => '0505'],
            ['ddsa_code' => '050595', 'name' => 'Pekan Seremban Jaya', 'level' => 3, 'district_id' => '0505'],
            /*
             * === TAMPIN
             */
            ['ddsa_code' => '050601', 'name' => 'Ayer Kuning', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050602', 'name' => 'Gemas', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050603', 'name' => 'Gemencheh', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050604', 'name' => 'Keru', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050605', 'name' => 'Repah', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050606', 'name' => 'Tampin Tengah', 'level' => 1, 'district_id' => '0506'],
            ['ddsa_code' => '050607', 'name' => 'Tebong', 'level' => 1, 'district_id' => '0506'],

            ['ddsa_code' => '050640', 'name' => 'Bandar Gemas', 'level' => 2, 'district_id' => '0506'],
            ['ddsa_code' => '050641', 'name' => 'Bandar Tampin', 'level' => 2, 'district_id' => '0506'],

            ['ddsa_code' => '050670', 'name' => 'Pekan Air Kuning SELATAN', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050671', 'name' => 'Pekan Batang Melaka', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050672', 'name' => 'Pekan Gemenchech Bahru', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050673', 'name' => 'Pekan Repah', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050674', 'name' => 'Pekan Tampin Tengah', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050675', 'name' => 'Pekan Air Kuning', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050676', 'name' => 'Pekan Pasir Besar', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050677', 'name' => 'Pekan Repah Permai', 'level' => 3, 'district_id' => '0506'],
            ['ddsa_code' => '050678', 'name' => 'Pekan Repah Jaya', 'level' => 3, 'district_id' => '0506'],
            /*
             * === JEMPOL
             */
            ['ddsa_code' => '050701', 'name' => 'Jelai', 'level' => 1, 'district_id' => '0507'],
            ['ddsa_code' => '050702', 'name' => 'Kuala Jempol', 'level' => 1, 'district_id' => '0507'],
            ['ddsa_code' => '050703', 'name' => 'Rompin', 'level' => 1, 'district_id' => '0507'],
            ['ddsa_code' => '050704', 'name' => 'Serting Hilir', 'level' => 1, 'district_id' => '0507'],
            ['ddsa_code' => '050705', 'name' => 'Serting Ulu', 'level' => 1, 'district_id' => '0507'],

            ['ddsa_code' => '050740', 'name' => 'Bandar Serting', 'level' => 2, 'district_id' => '0507'],
            ['ddsa_code' => '050741', 'name' => 'Bandar Bahau', 'level' => 2, 'district_id' => '0507'],
            ['ddsa_code' => '050742', 'name' => 'Bandar Seri Jempol', 'level' => 2, 'district_id' => '0507'],

            ['ddsa_code' => '050770', 'name' => 'Pekan Bahau', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050771', 'name' => 'Pekan Batu Kikir', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050772', 'name' => 'Pekan Kuala Jelai', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050773', 'name' => 'Pekan Rompin', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050774', 'name' => 'Pekan Ladang Geddes', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050775', 'name' => 'Pekan Mahsan', 'level' => 3, 'district_id' => '0507'],
            ['ddsa_code' => '050776', 'name' => 'Pekan Serting Tengah', 'level' => 3, 'district_id' => '0507'],
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
