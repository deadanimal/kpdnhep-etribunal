<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsJohorSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '01%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * johor
             */
            /*
             * === batu pahat
             */
            ['ddsa_code' => '010101', 'name' => 'Bagan', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010102', 'name' => 'Chaah Bahru', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010103', 'name' => 'Kampong Bahru', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010104', 'name' => 'Linau', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010105', 'name' => 'Lubok', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010106', 'name' => 'Minyak Beku', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010107', 'name' => 'Peserai', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010108', 'name' => 'Simpang Kanan', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010109', 'name' => 'Simpang Kiri', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010110', 'name' => 'Sri Gading', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010111', 'name' => 'Sri Medan', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010112', 'name' => 'Sungai Kluang', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010113', 'name' => 'Sungai Punggor', 'level' => 1, 'district_id' => '0101'],
            ['ddsa_code' => '010114', 'name' => 'Tanjong Sembrong', 'level' => 1, 'district_id' => '0101'],

            ['ddsa_code' => '010140', 'name' => 'Bandar Ayer Htam', 'level' => 2, 'district_id' => '0101'],
            ['ddsa_code' => '010141', 'name' => 'Bandar Bandar Penggaram', 'level' => 2, 'district_id' => '0101'],
            ['ddsa_code' => '010142', 'name' => 'Bandar Rengit', 'level' => 2, 'district_id' => '0101'],
            ['ddsa_code' => '010143', 'name' => 'Bandar Senggarang', 'level' => 2, 'district_id' => '0101'],
            ['ddsa_code' => '010144', 'name' => 'Bandar Yong Peng', 'level' => 2, 'district_id' => '0101'],
            /*
             * === johor bahru
             */
            ['ddsa_code' => '010201', 'name' => 'Jelutong', 'level' => 1, 'district_id' => '0102'],
            ['ddsa_code' => '010202', 'name' => 'Plentong', 'level' => 1, 'district_id' => '0102'],
            ['ddsa_code' => '010203', 'name' => 'Pulai', 'level' => 1, 'district_id' => '0102'],
            ['ddsa_code' => '010206', 'name' => 'Sungai Tiram', 'level' => 1, 'district_id' => '0102'],
            ['ddsa_code' => '010207', 'name' => 'Tanjung Kupang', 'level' => 1, 'district_id' => '0102'],
            ['ddsa_code' => '010208', 'name' => 'Tebrau', 'level' => 1, 'district_id' => '0102'],

            ['ddsa_code' => '010240', 'name' => 'Bandar Johor Bahru', 'level' => 2, 'district_id' => '0102'],
            /*
             * === kluang
             */
            ['ddsa_code' => '010301', 'name' => 'Ulu Benut', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010302', 'name' => 'Kahang', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010303', 'name' => 'Kluang', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010304', 'name' => 'Layang-layang', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010305', 'name' => 'Machap', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010306', 'name' => 'Niyor', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010307', 'name' => 'Paloh', 'level' => 1, 'district_id' => '0103'],
            ['ddsa_code' => '010308', 'name' => 'Rengam', 'level' => 1, 'district_id' => '0103'],

            ['ddsa_code' => '010340', 'name' => 'Bandar Kluang', 'level' => 2, 'district_id' => '0103'],
            ['ddsa_code' => '010341', 'name' => 'Bandar Paloh', 'level' => 2, 'district_id' => '0103'],
            ['ddsa_code' => '010342', 'name' => 'Bandar Rengam', 'level' => 2, 'district_id' => '0103'],
            /*
             * === kota tinggi
             */
            ['ddsa_code' => '010401', 'name' => 'Ulu Sungai Johor', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010402', 'name' => 'Ulu Sungai Selidi BESAR', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010403', 'name' => 'Johor Lama', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010404', 'name' => 'Kambau', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010405', 'name' => 'Kota Tinggi', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010406', 'name' => 'Pantai Timur', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010407', 'name' => 'Penggerang', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010408', 'name' => 'Selidi Besar', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010409', 'name' => 'Selidi Kechil', 'level' => 1, 'district_id' => '0104'],
            ['ddsa_code' => '010410', 'name' => 'Tanjung Surat', 'level' => 1, 'district_id' => '0104'],

            ['ddsa_code' => '010440', 'name' => 'Bandar Kota Tinggi', 'level' => 2, 'district_id' => '0104'],
            /*
             * === mersing
             */
            ['ddsa_code' => '010501', 'name' => 'Jemaluang', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010502', 'name' => 'Lenggor', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010503', 'name' => 'Mersing', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010504', 'name' => 'Padang Endau', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010505', 'name' => 'Penyabong', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010506', 'name' => 'Pulau Aur', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010507', 'name' => 'Pulau Babi', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010508', 'name' => 'Pulau Pemanggil', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010509', 'name' => 'Pulau Sibu', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010510', 'name' => 'Pulau Tinggi', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010511', 'name' => 'Sembrong', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010512', 'name' => 'Tenggaroh', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010513', 'name' => 'Tenglu', 'level' => 1, 'district_id' => '0105'],
            ['ddsa_code' => '010514', 'name' => 'Triang', 'level' => 1, 'district_id' => '0105'],

            ['ddsa_code' => '010540', 'name' => 'Bandar Jemaluang', 'level' => 2, 'district_id' => '0105'],
            ['ddsa_code' => '010541', 'name' => 'Bandar Mersing', 'level' => 2, 'district_id' => '0105'],
            ['ddsa_code' => '010542', 'name' => 'Bandar Mersing Kanan', 'level' => 2, 'district_id' => '0105'],
            ['ddsa_code' => '010543', 'name' => 'Bandar Padang Endau', 'level' => 2, 'district_id' => '0105'],
            /*
             * === muar
             */
            ['ddsa_code' => '010601', 'name' => 'Ayer Hitam', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010602', 'name' => 'Bandar', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010603', 'name' => 'Bukit Kepong', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010606', 'name' => 'Jalan Bakri', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010607', 'name' => 'Jorak', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010610', 'name' => 'Lenga', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010611', 'name' => 'Parit Bakar', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010612', 'name' => 'Parit Jawa', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010614', 'name' => 'Sri Meranti', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010615', 'name' => 'Sungai Balang', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010616', 'name' => 'Sungai Raya & Kampung Bukit Pasir', 'level' => 1, 'district_id' => '0106'],
            ['ddsa_code' => '010617', 'name' => 'Sungai Terap', 'level' => 1, 'district_id' => '0106'],

            ['ddsa_code' => '010640', 'name' => 'Bandar Bandar Maharani', 'level' => 2, 'district_id' => '0106'],
            ['ddsa_code' => '010641', 'name' => 'Bandar Bukit Kepong', 'level' => 2, 'district_id' => '0106'],
            ['ddsa_code' => '010642', 'name' => 'Bandar Panchor', 'level' => 2, 'district_id' => '0106'],
            ['ddsa_code' => '010643', 'name' => 'Bandar Parit Jawa', 'level' => 2, 'district_id' => '0106'],

            ['ddsa_code' => '010670', 'name' => 'Pekan Bukit Pasir', 'level' => 3, 'district_id' => '0106'],
            /*
             * === pontian
             */
            ['ddsa_code' => '010701', 'name' => 'Ayer Baloi', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010702', 'name' => 'Air Masin', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010703', 'name' => 'Api-api', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010704', 'name' => 'Benut', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010705', 'name' => 'Jeram Batu', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010706', 'name' => 'Pengkalan Raja', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010707', 'name' => 'Pontian', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010708', 'name' => 'Rimba Terjun', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010709', 'name' => 'Serkat', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010710', 'name' => 'Sungai Karang', 'level' => 1, 'district_id' => '0107'],
            ['ddsa_code' => '010711', 'name' => 'Sungei Pinggan', 'level' => 1, 'district_id' => '0107'],

            ['ddsa_code' => '010740', 'name' => 'Bandar Benut', 'level' => 2, 'district_id' => '0107'],
            ['ddsa_code' => '010741', 'name' => 'Bandar Pontian Kechil', 'level' => 2, 'district_id' => '0107'],

            ['ddsa_code' => '010770', 'name' => 'Pekan Pekan Nenas', 'level' => 3, 'district_id' => '0107'],
            /*
             * === segamat
             */
            ['ddsa_code' => '010801', 'name' => 'Bekok', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010802', 'name' => 'Buloh Kasap', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010803', 'name' => 'Chaah', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010804', 'name' => 'Gemas', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010805', 'name' => 'Gemereh', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010806', 'name' => 'Jabi', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010807', 'name' => 'Jementah', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010808', 'name' => 'Labis', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010809', 'name' => 'Pogoh', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010810', 'name' => 'Sermin', 'level' => 1, 'district_id' => '0108'],
            ['ddsa_code' => '010811', 'name' => 'Sungai Segamat', 'level' => 1, 'district_id' => '0108'],

            ['ddsa_code' => '010840', 'name' => 'Bandar Batu Anam', 'level' => 2, 'district_id' => '0108'],
            ['ddsa_code' => '010841', 'name' => 'Bandar Bekok', 'level' => 2, 'district_id' => '0108'],
            ['ddsa_code' => '010842', 'name' => 'Bandar Buloh Kasap', 'level' => 2, 'district_id' => '0108'],
            ['ddsa_code' => '010843', 'name' => 'Bandar Jementah', 'level' => 2, 'district_id' => '0108'],
            ['ddsa_code' => '010844', 'name' => 'Bandar Labis', 'level' => 2, 'district_id' => '0108'],
            ['ddsa_code' => '010845', 'name' => 'Bandar Segamat', 'level' => 2, 'district_id' => '0108'],

            ['ddsa_code' => '010870', 'name' => 'Pekan Gemas Bahru', 'level' => 3, 'district_id' => '0108'],
            /*
             * === kulaijaya // upgrade from kulai since 2008 - http://www.utusan.com.my/utusan/info.asp?y=2008&dt=0622&pub=Utusan_Malaysia&sec=Johor&pg=wj_01.htm
             */
            ['ddsa_code' => '010901', 'name' => 'Kulai', 'level' => 1, 'district_id' => '0109'],
            ['ddsa_code' => '010902', 'name' => 'Senai', 'level' => 1, 'district_id' => '0109'],
            ['ddsa_code' => '010903', 'name' => 'Sedenak', 'level' => 1, 'district_id' => '0109'],
            ['ddsa_code' => '010904', 'name' => 'Bukit Batu', 'level' => 1, 'district_id' => '0109'],

            ['ddsa_code' => '010940', 'name' => 'Bandar Kulai', 'level' => 2, 'district_id' => '0109'],
            /*
             * === ledang // upgrade since 2008
             */
            ['ddsa_code' => '011001', 'name' => 'Tangkak', 'level' => 1, 'district_id' => '0110'],
            ['ddsa_code' => '011002', 'name' => 'Bukit Serampang', 'level' => 1, 'district_id' => '0110'],
            ['ddsa_code' => '011003', 'name' => 'Gersik', 'level' => 1, 'district_id' => '0110'],
            ['ddsa_code' => '011004', 'name' => 'Serom', 'level' => 1, 'district_id' => '0110'],
            ['ddsa_code' => '011005', 'name' => 'Kundang', 'level' => 1, 'district_id' => '0110'],
            ['ddsa_code' => '011006', 'name' => 'Kesang', 'level' => 1, 'district_id' => '0110'],

            ['ddsa_code' => '011040', 'name' => 'Bandar Bukit Kangkar', 'level' => 2, 'district_id' => '0110'],
            ['ddsa_code' => '011041', 'name' => 'Bandar Parit Bunga', 'level' => 2, 'district_id' => '0110'],
            ['ddsa_code' => '011042', 'name' => 'Bandar Serom', 'level' => 2, 'district_id' => '0110'],
            ['ddsa_code' => '011043', 'name' => 'Bandar Sungai Mati', 'level' => 2, 'district_id' => '0110'],
            ['ddsa_code' => '011044', 'name' => 'Bandar Tangkak', 'level' => 2, 'district_id' => '0110'],

            ['ddsa_code' => '011070', 'name' => 'Pekan Grisek', 'level' => 3, 'district_id' => '0110'],
        ];

        foreach ($data_seeds as $seed) {
            $seed['district_id'] = $districts[$seed['district_id']];
            MasterSubdistrict::create($seed);
        }
    }

    /**
     * Reverts the database seeder.
     */
    public function down()
    {
        // Remove your data
    }
}
