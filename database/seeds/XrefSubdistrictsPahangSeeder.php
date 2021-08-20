<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsPahangSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '06%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * pahang
             */
            /*
             * === BENTONG
             */
            ['ddsa_code' => '060101', 'name' => 'Bentong', 'level' => 1, 'district_id' => '0601'],
            ['ddsa_code' => '060102', 'name' => 'Sabai', 'level' => 1, 'district_id' => '0601'],
            ['ddsa_code' => '060103', 'name' => 'Pelangai', 'level' => 1, 'district_id' => '0601'],

            ['ddsa_code' => '060140', 'name' => 'Bandar Bentong', 'level' => 2, 'district_id' => '0601'],
            ['ddsa_code' => '060141', 'name' => 'Bandar Karak', 'level' => 2, 'district_id' => '0601'],

            ['ddsa_code' => '060171', 'name' => 'Pekan Telemong', 'level' => 3, 'district_id' => '0601'],
            /*
             * === CAMERON HIGHLANDS
             */
            ['ddsa_code' => '060201', 'name' => 'Hulu Telom', 'level' => 1, 'district_id' => '0602'],
            ['ddsa_code' => '060202', 'name' => 'Ringlet', 'level' => 1, 'district_id' => '0602'],
            ['ddsa_code' => '060203', 'name' => 'Tanah Rata', 'level' => 1, 'district_id' => '0602'],

            ['ddsa_code' => '060240', 'name' => 'Bandar Tanah Rata', 'level' => 2, 'district_id' => '0602'],

            ['ddsa_code' => '060270', 'name' => 'Pekan Berinchang', 'level' => 3, 'district_id' => '0602'],
            ['ddsa_code' => '060271', 'name' => 'Pekan Lubok Tamang', 'level' => 3, 'district_id' => '0602'],
            ['ddsa_code' => '060272', 'name' => 'Pekan Ringlet', 'level' => 3, 'district_id' => '0602'],
            /*
             * === JERANTUT
             */
            ['ddsa_code' => '060301', 'name' => 'Burau', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060302', 'name' => 'Ulu Cheka', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060303', 'name' => 'Ulu Tembeling', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060304', 'name' => 'Kelola', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060305', 'name' => 'Kuala Tembeling', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060306', 'name' => 'Pedah', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060307', 'name' => 'Pulau Tawar', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060308', 'name' => 'Tebing Tinggi', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060309', 'name' => 'Teh', 'level' => 1, 'district_id' => '0603'],
            ['ddsa_code' => '060310', 'name' => 'Tembeling', 'level' => 1, 'district_id' => '0603'],

            ['ddsa_code' => '060340', 'name' => 'Bandar Jerantut', 'level' => 2, 'district_id' => '0603'],

            ['ddsa_code' => '060370', 'name' => 'Pekan Kuala Tembeling', 'level' => 3, 'district_id' => '0603'],
            ['ddsa_code' => '060371', 'name' => 'Pekan Jeransang', 'level' => 3, 'district_id' => '0603'],
            /*
             * === KUANTAN
             */
            ['ddsa_code' => '060401', 'name' => 'Beserah', 'level' => 1, 'district_id' => '0604'],
            ['ddsa_code' => '060402', 'name' => 'Ulu Lepar', 'level' => 1, 'district_id' => '0604'],
            ['ddsa_code' => '060403', 'name' => 'Ulu Kuantan', 'level' => 1, 'district_id' => '0604'],
            ['ddsa_code' => '060404', 'name' => 'Kuala Kuantan', 'level' => 1, 'district_id' => '0604'],
            ['ddsa_code' => '060405', 'name' => 'Penor', 'level' => 1, 'district_id' => '0604'],
            ['ddsa_code' => '060406', 'name' => 'Sungai Karang', 'level' => 1, 'district_id' => '0604'],

            ['ddsa_code' => '060440', 'name' => 'Bandar Gambang', 'level' => 2, 'district_id' => '0604'],
            ['ddsa_code' => '060441', 'name' => 'Bandar Kuantan', 'level' => 2, 'district_id' => '0604'],

            ['ddsa_code' => '060470', 'name' => 'Pekan Beserah', 'level' => 3, 'district_id' => '0604'],
            ['ddsa_code' => '060471', 'name' => 'Pekan Tanjng Lumpur', 'level' => 3, 'district_id' => '0604'],
            /*
             * === LIPIS
             */
            ['ddsa_code' => '060501', 'name' => 'Batu Yon', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060502', 'name' => 'Budu', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060503', 'name' => 'Cheka', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060504', 'name' => 'Gua', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060510', 'name' => 'Ulu Jelai', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060505', 'name' => 'Kechau', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060506', 'name' => 'Kuala Lipis', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060507', 'name' => 'Penjom', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060508', 'name' => 'Tanjung Besar', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060509', 'name' => 'Telang', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060540', 'name' => 'Bandar Kuala Lipis', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060541', 'name' => 'Benta', 'level' => 1, 'district_id' => '0605'],
            ['ddsa_code' => '060542', 'name' => 'Padang Tengku', 'level' => 1, 'district_id' => '0605'],

            ['ddsa_code' => '060572', 'name' => 'Pekan Padang Tengku', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060573', 'name' => 'Pekan Taman Jelai', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060574', 'name' => 'Pekan Penjom', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060575', 'name' => 'Pekan Mela', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060576', 'name' => 'Pekan Kerambit', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060577', 'name' => 'Pekan Rpsb Kg. Pagar', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060578', 'name' => 'Pekan Merapuh', 'level' => 3, 'district_id' => '0605'],
            ['ddsa_code' => '060579', 'name' => 'Pekan Kechau Tui', 'level' => 3, 'district_id' => '0605'],
            /*
             * === PEKAN
             */
            ['ddsa_code' => '060601', 'name' => 'Bebar', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060602', 'name' => 'Ganchong', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060603', 'name' => 'Kuala Pahang', 'level' => 1, 'district_id' => '0606'],
            // ['ddsa_code' => '060604', 'name' => 'Langgar', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060605', 'name' => 'Lepar', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060606', 'name' => 'Pahang Tua', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060607', 'name' => 'Pekan', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060608', 'name' => 'Penyor', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060609', 'name' => 'Pulau Manis', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060610', 'name' => 'Pulau Rusa', 'level' => 1, 'district_id' => '0606'],
            ['ddsa_code' => '060611', 'name' => 'Temai', 'level' => 1, 'district_id' => '0606'],

            ['ddsa_code' => '060640', 'name' => 'Bandar Pekan', 'level' => 2, 'district_id' => '0606'],

            ['ddsa_code' => '060670', 'name' => 'Pekan Kuala Pahang', 'level' => 3, 'district_id' => '0606'],
            ['ddsa_code' => '060671', 'name' => 'Pekan Nenasi', 'level' => 3, 'district_id' => '0606'],
            /*
             * === RAUB
             */
            ['ddsa_code' => '060701', 'name' => 'Batu Talam', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060702', 'name' => 'Dong', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060703', 'name' => 'Gali', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060704', 'name' => 'Hulu Dong', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060705', 'name' => 'Sega', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060706', 'name' => 'Semantan Ulu', 'level' => 1, 'district_id' => '0607'],
            ['ddsa_code' => '060707', 'name' => 'Teras', 'level' => 1, 'district_id' => '0607'],

            ['ddsa_code' => '060740', 'name' => 'Bandar Raub', 'level' => 2, 'district_id' => '0607'],
            ['ddsa_code' => '060741', 'name' => 'Bandar Teras', 'level' => 2, 'district_id' => '0607'],

            ['ddsa_code' => '060770', 'name' => 'Pekan Cheroh', 'level' => 3, 'district_id' => '0607'],
            ['ddsa_code' => '060771', 'name' => 'Pekan Dong', 'level' => 3, 'district_id' => '0607'],
            ['ddsa_code' => '060772', 'name' => 'Pekan Tranum', 'level' => 3, 'district_id' => '0607'],
            /*
             * === TEMERLOH
             */
            ['ddsa_code' => '060801', 'name' => 'Bangau', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060802', 'name' => 'Jenderak', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060803', 'name' => 'Kerdau', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060804', 'name' => 'Lebak', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060805', 'name' => 'Lipat Kijang', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060806', 'name' => 'Mentakab', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060807', 'name' => 'Perak', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060808', 'name' => 'Sanggang', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060809', 'name' => 'Semantan', 'level' => 1, 'district_id' => '0608'],
            ['ddsa_code' => '060810', 'name' => 'Songsang', 'level' => 1, 'district_id' => '0608'],

            ['ddsa_code' => '060840', 'name' => 'Bandar Mentakab', 'level' => 2, 'district_id' => '0608'],
            ['ddsa_code' => '060841', 'name' => 'Bandar Temerloh', 'level' => 2, 'district_id' => '0608'],

            ['ddsa_code' => '060871', 'name' => 'Pekan Kerdau', 'level' => 3, 'district_id' => '0608'],
            ['ddsa_code' => '060872', 'name' => 'Pekan Kuala Kerau', 'level' => 3, 'district_id' => '0608'],
            ['ddsa_code' => '060873', 'name' => 'Lanchang', 'level' => 1, 'district_id' => '0608'], // kenapa dia bukan pekan?
            /*
             * === ROMPIN
             */
            ['ddsa_code' => '060901', 'name' => 'Endau', 'level' => 1, 'district_id' => '0609'],
            ['ddsa_code' => '060902', 'name' => 'Keratong', 'level' => 1, 'district_id' => '0609'],
            ['ddsa_code' => '060903', 'name' => 'Pontian', 'level' => 1, 'district_id' => '0609'],
            ['ddsa_code' => '060904', 'name' => 'Rompin', 'level' => 1, 'district_id' => '0609'],
            ['ddsa_code' => '060905', 'name' => 'Tioman', 'level' => 1, 'district_id' => '0609'],

            ['ddsa_code' => '060941', 'name' => 'Bandar Rompin I', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060942', 'name' => 'Bandar Rompin Ii', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060943', 'name' => 'Bandar Rompin Iii', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060944', 'name' => 'Bandar Rompin Iv', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060945', 'name' => 'Bandar Pontian', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060946', 'name' => 'Bandar Endau', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060947', 'name' => 'Bandar Muadzam Shah I', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060948', 'name' => 'Bandar Muadzam Shah II', 'level' => 2, 'district_id' => '0609'],
            ['ddsa_code' => '060949', 'name' => 'Bandar Tioman', 'level' => 2, 'district_id' => '0609'],

            ['ddsa_code' => '060970', 'name' => 'Pekan Kuala Rompin', 'level' => 3, 'district_id' => '0609'],
            ['ddsa_code' => '060971', 'name' => 'Pekan Tioman', 'level' => 3, 'district_id' => '0609'],
            /*
             * === MARAN
             */
            ['ddsa_code' => '061001', 'name' => 'Bukit Segumpal', 'level' => 1, 'district_id' => '0610'],
            ['ddsa_code' => '061002', 'name' => 'Chenor', 'level' => 1, 'district_id' => '0610'],
            ['ddsa_code' => '061003', 'name' => 'Kertau', 'level' => 1, 'district_id' => '0610'],
            ['ddsa_code' => '061004', 'name' => 'Luit', 'level' => 1, 'district_id' => '0610'],

            ['ddsa_code' => '061040', 'name' => 'Bandar Maran', 'level' => 2, 'district_id' => '0610'],

            ['ddsa_code' => '061070', 'name' => 'Pekan Chenor', 'level' => 3, 'district_id' => '0610'],
            ['ddsa_code' => '061072', 'name' => 'Pekan Sri Jaya', 'level' => 3, 'district_id' => '0610'],
            /*
             * === BERA
             */
            ['ddsa_code' => '061101', 'name' => 'Bera', 'level' => 1, 'district_id' => '0611'],
            ['ddsa_code' => '061102', 'name' => 'Triang', 'level' => 1, 'district_id' => '0611'],

            ['ddsa_code' => '061142', 'name' => 'Bandar Triang', 'level' => 2, 'district_id' => '0611'],

            ['ddsa_code' => '061170', 'name' => 'Pekan Durian Tawar', 'level' => 3, 'district_id' => '0611'],
            ['ddsa_code' => '061174', 'name' => 'Pekan Mengkarak', 'level' => 3, 'district_id' => '0611'],
            ['ddsa_code' => '061175', 'name' => 'Pekan Mengkuang', 'level' => 3, 'district_id' => '0611'],
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
