<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsMelakaSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '04%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * melaka
             */
            /*
             * === MELAKA TENGAH
             */
            ['ddsa_code' => '040101', 'name' => 'Alai', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040102', 'name' => 'Ayer Molek', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040103', 'name' => 'Bachang', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040104', 'name' => 'Balai Panjang', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040105', 'name' => 'Batu Berendam', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040106', 'name' => 'Bertam', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040107', 'name' => 'Bukit Baru', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040108', 'name' => 'Bukit Katil', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040109', 'name' => 'Bukit Lintang', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040110', 'name' => 'Bukit Piatu', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040111', 'name' => 'Bukit Rambai', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040112', 'name' => 'Cheng', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040113', 'name' => 'Duyong', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040114', 'name' => 'Ujong Pasir', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040115', 'name' => 'Kandang', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040116', 'name' => 'Klebang Besar', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040117', 'name' => 'Klebang Kechil', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040118', 'name' => 'Krubong', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040119', 'name' => 'Padang Semabok', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040120', 'name' => 'Padang Temu', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040121', 'name' => 'Paya Rumput', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040122', 'name' => 'Pringgit', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040123', 'name' => 'Pernu', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040124', 'name' => 'Semabok', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040125', 'name' => 'Sungai Udang', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040126', 'name' => 'Tangga Batu', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040127', 'name' => 'Tanjong Keling', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040128', 'name' => 'Tanjong Minyak', 'level' => 1, 'district_id' => '0401'],
            ['ddsa_code' => '040129', 'name' => 'Telok Mas', 'level' => 1, 'district_id' => '0401'],

            ['ddsa_code' => '040140', 'name' => 'Bandar Bukit Baru', 'level' => 2, 'district_id' => '0401'],
            ['ddsa_code' => '040141', 'name' => 'Bandar Melaka', 'level' => 2, 'district_id' => '0401'],

            ['ddsa_code' => '040170', 'name' => 'Pekan Ayer Molek', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040171', 'name' => 'Pekan Batu Berendam', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040172', 'name' => 'Pekan Bukit Rambai', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040173', 'name' => 'Pekan Kandang', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040174', 'name' => 'Pekan Klebang', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040175', 'name' => 'Pekan Paya Rumput', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040176', 'name' => 'Pekan Sungai Udang', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040177', 'name' => 'Pekan Tangga Batu', 'level' => 3, 'district_id' => '0401'],
            ['ddsa_code' => '040178', 'name' => 'Pekan Tanjong Kling', 'level' => 3, 'district_id' => '0401'],
            /*
             * === JASIN
             */
            ['ddsa_code' => '040201', 'name' => 'Ayer Panas', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040202', 'name' => 'Batang Malaka', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040203', 'name' => 'Bukit Senggeh', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040204', 'name' => 'Chabau', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040205', 'name' => 'Chin Chin', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040206', 'name' => 'Chohong', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040207', 'name' => 'Jasin', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040208', 'name' => 'Jus', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040209', 'name' => 'Kesang', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040210', 'name' => 'Merlimau', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040211', 'name' => 'Nyalas', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040212', 'name' => 'Rim', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040213', 'name' => 'Sebatu', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040214', 'name' => 'Selandar', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040215', 'name' => 'Sempang', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040216', 'name' => 'Semujok', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040217', 'name' => 'Serkam', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040218', 'name' => 'Sungei Rambai', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040219', 'name' => 'Tedong', 'level' => 1, 'district_id' => '0402'],
            ['ddsa_code' => '040220', 'name' => 'Umbai', 'level' => 1, 'district_id' => '0402'],

            ['ddsa_code' => '040240', 'name' => 'Bandar Jasin', 'level' => 2, 'district_id' => '0402'],
            ['ddsa_code' => '040241', 'name' => 'Bandar Merlimau', 'level' => 2, 'district_id' => '0402'],

            ['ddsa_code' => '040270', 'name' => 'Pekan Asahan', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040271', 'name' => 'Pekan Batang Malaka', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040272', 'name' => 'Pekan Bemban', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040273', 'name' => 'Pekan Chin Chin', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040274', 'name' => 'Pekan Kesang Pajak', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040275', 'name' => 'Pekan Nyalas', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040276', 'name' => 'Pekan Selandar', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040277', 'name' => 'Pekan Sempang Bekoh', 'level' => 3, 'district_id' => '0402'],
            ['ddsa_code' => '040278', 'name' => 'Pekan Sungai Rambai', 'level' => 3, 'district_id' => '0402'],
            /*
             * === ALOR GAJAR
             */
            ['ddsa_code' => '040301', 'name' => "Ayer Pa'abas", 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040302', 'name' => 'Belimbing', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040303', 'name' => 'Beringin', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040304', 'name' => 'Brisu', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040305', 'name' => 'Durian Tunggal', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040306', 'name' => 'Gadek', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040307', 'name' => 'Kelemak', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040308', 'name' => 'Kemuning', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040309', 'name' => 'Kuala Linggi', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040310', 'name' => 'Kuala Sungei Baru', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040311', 'name' => 'Lendu', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040312', 'name' => 'Machap', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040313', 'name' => 'Masjid Tanah', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040314', 'name' => 'Melaka Pindah', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040315', 'name' => 'Melekek', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040316', 'name' => 'Padang Sebang', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040317', 'name' => 'Parit Melana', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040318', 'name' => 'Pegoh', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040319', 'name' => 'Pulau Sebang', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040320', 'name' => 'Ramuan China Besar', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040321', 'name' => 'Ramuan China Kechil', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040322', 'name' => 'Rembia', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040323', 'name' => 'Sungei Baru Hilir', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040324', 'name' => 'Sungei Baru Tengah', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040325', 'name' => 'Sungei Baru Ulu', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040326', 'name' => 'Sungei Buloh', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040327', 'name' => 'Sungei Petai', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040328', 'name' => 'Sungei Siput', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040329', 'name' => 'Taboh Naning', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040330', 'name' => 'Tanjong Rimau', 'level' => 1, 'district_id' => '0403'],
            ['ddsa_code' => '040331', 'name' => 'Tebong', 'level' => 1, 'district_id' => '0403'],

            ['ddsa_code' => '040340', 'name' => 'Bandar Alor Gajah', 'level' => 2, 'district_id' => '0403'],
            ['ddsa_code' => '040341', 'name' => 'Bandar Masjid Tanah', 'level' => 2, 'district_id' => '0403'],
            ['ddsa_code' => '040342', 'name' => 'Bandar Pulau Sebang', 'level' => 2, 'district_id' => '0403'],

            ['ddsa_code' => '040370', 'name' => 'Pekan Durian Tunggal', 'level' => 3, 'district_id' => '0403'],
            ['ddsa_code' => '040371', 'name' => 'Pekan Kuala Sungai BARU', 'level' => 3, 'district_id' => '0403'],
            ['ddsa_code' => '040372', 'name' => 'Pekan Lubok China', 'level' => 3, 'district_id' => '0403'],
            ['ddsa_code' => '040373', 'name' => 'Pekan Rembia', 'level' => 3, 'district_id' => '0403'],
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
