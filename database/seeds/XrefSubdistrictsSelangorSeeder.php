<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsSelangorSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '10%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * selangor
             */
            /*
             * === KLANG
             */
            ['ddsa_code' => '100101', 'name' => 'Kapar', 'level' => 1, 'district_id' => '1001'],
            ['ddsa_code' => '100102', 'name' => 'Klang', 'level' => 1, 'district_id' => '1001'],
            ['ddsa_code' => '100140', 'name' => 'Bandar Klang', 'level' => 1, 'district_id' => '1001'],

            ['ddsa_code' => '100141', 'name' => 'Bandar Port Swettenham', 'level' => 2, 'district_id' => '1001'],
            ['ddsa_code' => '100142', 'name' => 'Bandar Sultan Sulaiman', 'level' => 2, 'district_id' => '1001'],
            ['ddsa_code' => '100143', 'name' => 'Bandar Shah Alam', 'level' => 2, 'district_id' => '1001'],

            ['ddsa_code' => '100170', 'name' => 'Pekan Bukit Kemuning', 'level' => 3, 'district_id' => '1001'],
            ['ddsa_code' => '100171', 'name' => 'Pekan Kapar', 'level' => 3, 'district_id' => '1001'],
            ['ddsa_code' => '100172', 'name' => 'Pekan Meru', 'level' => 3, 'district_id' => '1001'],
            ['ddsa_code' => '100173', 'name' => 'Pekan Telok Menegun', 'level' => 3, 'district_id' => '1001'],
            ['ddsa_code' => '100174', 'name' => 'Pekan Batu Empat', 'level' => 3, 'district_id' => '1001'],
            ['ddsa_code' => '100175', 'name' => 'Pekan Pandamaran', 'level' => 3, 'district_id' => '1001'],
            /*
             * === KUALA LANGAT
             */
            ['ddsa_code' => '100201', 'name' => 'Bandar', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100202', 'name' => 'Batu', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100203', 'name' => 'Jugra', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100204', 'name' => 'Kelanang', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100205', 'name' => 'Morib', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100206', 'name' => 'Tanjong Duabelas', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100207', 'name' => 'Telok Panglima Garang', 'level' => 1, 'district_id' => '1002'],
            ['ddsa_code' => '100240', 'name' => 'Bandar Banting', 'level' => 1, 'district_id' => '1002'],

            ['ddsa_code' => '100241', 'name' => 'Bandar Jenjarom', 'level' => 2, 'district_id' => '1002'],
            ['ddsa_code' => '100242', 'name' => 'Bandar Sijangkang', 'level' => 2, 'district_id' => '1002'],
            ['ddsa_code' => '100243', 'name' => 'Bandar Tanjong Sepat', 'level' => 2, 'district_id' => '1002'],
            ['ddsa_code' => '100244', 'name' => 'Bandar Telok Panglima GARANG', 'level' => 2, 'district_id' => '1002'],

            ['ddsa_code' => '100270', 'name' => 'Pekan Batu', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100271', 'name' => 'Pekan Bukit Changgang', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100272', 'name' => 'Pekan Chodoi', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100273', 'name' => 'Pekan Jenjarom', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100274', 'name' => 'Pekan Kanchong', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100275', 'name' => 'Pekan Kanchong Darat', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100276', 'name' => 'Pekan Kelanang Batu ENAM', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100277', 'name' => 'Pekan Morib', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100278', 'name' => 'Pekan Sijangkang', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100279', 'name' => 'Pekan Permatang Pasir', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100280', 'name' => 'Pekan Simpang Morib', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100281', 'name' => 'Pekan Sungai Manggis', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100282', 'name' => 'Pekan Sungai Raba', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100283', 'name' => 'Pekan Tanjong Duabelas', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100284', 'name' => 'Pekan Telok Datok', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100286', 'name' => 'Pekan Tongkah', 'level' => 3, 'district_id' => '1002'],
            ['ddsa_code' => '100287', 'name' => 'Pekan Telok', 'level' => 3, 'district_id' => '1002'],
            /*
             * === 1003 ??? // deprecated?
             */
            /*
             * === KUALA SELANGOR
             */
            ['ddsa_code' => '100401', 'name' => 'Api-api', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100405', 'name' => 'Ijok', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100406', 'name' => 'Jeram', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100407', 'name' => 'Kuala Selangor', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100408', 'name' => 'Pasangan', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100409', 'name' => 'Tanjong Karang', 'level' => 1, 'district_id' => '1004'],
            ['ddsa_code' => '100410', 'name' => 'Bestari Jaya', 'level' => 1, 'district_id' => '1004'],

            ['ddsa_code' => '100440', 'name' => 'Bandar Kuala Selangor', 'level' => 2, 'district_id' => '1004'],
            ['ddsa_code' => '100441', 'name' => 'Bandar Tanjong Karang', 'level' => 2, 'district_id' => '1004'],

            ['ddsa_code' => '100470', 'name' => 'Pekan Asam Jawa', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100472', 'name' => 'Pekan Bukit Rotan', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100473', 'name' => 'Pekan Jeram', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100474', 'name' => 'Pekan Kampong Kuantan', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100475', 'name' => 'Pekan Kuala Sungai BULOH', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100476', 'name' => 'Pekan Pasir Penampang', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100477', 'name' => 'Pekan Simpang Tiga', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100478', 'name' => 'Pekan Tanjong Karang', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100479', 'name' => 'Pekan Bukti Belimbing', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100480', 'name' => 'Pekan Bukit Talang', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100481', 'name' => 'Pekan Kambung Baru HULU TIRAM BURUK', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100482', 'name' => 'Pekan Parti Mahang', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100483', 'name' => 'Pekan Simpang Tiga IJOK', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100484', 'name' => 'Pekan Sungai Sembilang', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100485', 'name' => 'Pekan Taman Pkns', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100488', 'name' => 'Pekan Tambak Jawa', 'level' => 3, 'district_id' => '1004'],
            ['ddsa_code' => '100491', 'name' => 'Pekan Bestari Jaya', 'level' => 3, 'district_id' => '1004'],
            /*
             * === SABAK BERNAM
             */
            ['ddsa_code' => '100501', 'name' => 'Bagan Nakhoda Omar', 'level' => 1, 'district_id' => '1005'],
            ['ddsa_code' => '100502', 'name' => 'Pancang Bedena', 'level' => 1, 'district_id' => '1005'],
            ['ddsa_code' => '100503', 'name' => 'Pasir Panjang', 'level' => 1, 'district_id' => '1005'],
            ['ddsa_code' => '100504', 'name' => 'Sabak', 'level' => 1, 'district_id' => '1005'],
            ['ddsa_code' => '100505', 'name' => 'Sungai Panjang', 'level' => 1, 'district_id' => '1005'],

            ['ddsa_code' => '100570', 'name' => 'Pekan Bagan Terap', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100571', 'name' => 'Pekan Parit Enam', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100572', 'name' => 'Pekan Parit Sembilan', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100573', 'name' => 'Pekan Sekinchan', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100575', 'name' => 'Pekan Sabak', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100576', 'name' => 'Pekan Sungai Air TAWAR', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100577', 'name' => 'Pekan Sungai Sepintas', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100578', 'name' => 'Pekan Bagan Nakhoda OMAR', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100579', 'name' => 'Pekan Parit Baru', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100580', 'name' => 'Pekan Pasir Panjang', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100581', 'name' => 'Pekan Sekinchan Site A', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100582', 'name' => 'Pekan Sungai Besar', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100583', 'name' => 'Pekan Sungai Haji DORANI', 'level' => 3, 'district_id' => '1005'],
            ['ddsa_code' => '100584', 'name' => 'Pekan Sungai Nibong', 'level' => 3, 'district_id' => '1005'],
            /*
             * === ULU LANGAT
             */
            ['ddsa_code' => '100601', 'name' => 'Beranang', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100602', 'name' => 'Cheras', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100603', 'name' => 'Ampang', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100604', 'name' => 'Hulu Langat', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100605', 'name' => 'Hulu Semenyih', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100606', 'name' => 'Kajang', 'level' => 1, 'district_id' => '1006'],
            ['ddsa_code' => '100607', 'name' => 'Semenyih', 'level' => 1, 'district_id' => '1006'],

            ['ddsa_code' => '100640', 'name' => 'Bandar Cheras', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100641', 'name' => 'Bandar Ulu Langat', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100642', 'name' => 'Bandar Kajang', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100643', 'name' => 'Bandar Semenyih', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100644', 'name' => 'Bandar Ampang', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100645', 'name' => 'Bandar Balakong', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100646', 'name' => 'Bandar Batu 9, CHERAS', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100648', 'name' => 'Bandar Batu 18, SEMENYIH', 'level' => 2, 'district_id' => '1006'],
            ['ddsa_code' => '100649', 'name' => 'Bandar Batu 26, BERANANG', 'level' => 2, 'district_id' => '1006'],

            ['ddsa_code' => '100671', 'name' => 'Pekan Beranang', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100673', 'name' => 'Pekan Kacau', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100675', 'name' => 'Pekan Tarun', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100676', 'name' => 'Pekan Bangi Lama', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100678', 'name' => 'Pekan Batu 23, SUNGAI LALANG', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100679', 'name' => 'Pekan Batu 26, BERANANG', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100680', 'name' => 'Pekan Bukit Sungai RAYA', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100681', 'name' => 'Pekan Cheras', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100682', 'name' => 'Pekan Desa Raya', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100683', 'name' => 'Pekan Dusun Tua ULU LANGAT', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100684', 'name' => 'Pekan Kajang', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100685', 'name' => 'Pekan Kampong Pasir, BATU 14, SEMENYIH', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100686', 'name' => 'Pekan Kampong Sungai TANGKAS', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100687', 'name' => 'Pekan Rumah Murah SUNGAI LUI', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100688', 'name' => 'Pekan Semenyih', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100689', 'name' => 'Pekan Simpang Balak', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100690', 'name' => 'Pekan Sri Nanding', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100691', 'name' => 'Pekan Sungai Kembong BERANANG', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100692', 'name' => 'Pekan Sungai Lui', 'level' => 3, 'district_id' => '1006'],
            ['ddsa_code' => '100693', 'name' => 'Pekan Sungai Makau', 'level' => 3, 'district_id' => '1006'],
            /*
             * === ULU SELANGOR
             */
            ['ddsa_code' => '100701', 'name' => 'Batang Kali', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100702', 'name' => 'Buluh Telor', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100703', 'name' => 'Ampang Pechah', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100704', 'name' => 'Ulu Bernam', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100705', 'name' => 'Ulu Yam', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100706', 'name' => 'Kalumpang', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100707', 'name' => 'Kerling', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100708', 'name' => 'Kuala Kalumpang', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100709', 'name' => 'Peretak', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100710', 'name' => 'Rasa', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100711', 'name' => 'Serendah', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100712', 'name' => 'Sungai Gumut', 'level' => 1, 'district_id' => '1007'],
            ['ddsa_code' => '100713', 'name' => 'Sungai Tinggi', 'level' => 1, 'district_id' => '1007'],

            ['ddsa_code' => '100740', 'name' => 'Bandar Ulu Yam', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100741', 'name' => 'Bandar Ulu Yam BAHARU', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100742', 'name' => 'Bandar Kalumpang', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100743', 'name' => 'Bandar Kuala Kubu BAHARU', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100744', 'name' => 'Bandar Rasa', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100745', 'name' => 'Bandar Serendah', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100746', 'name' => 'Bandar Batang Kali', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100747', 'name' => 'Bandar Ulu Bernam I', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100748', 'name' => 'Bandar Ulu Bernam II', 'level' => 2, 'district_id' => '1007'],
            ['ddsa_code' => '100749', 'name' => 'Bandar Sungai Chik', 'level' => 2, 'district_id' => '1007'],

            ['ddsa_code' => '100770', 'name' => 'Pekan Kerling', 'level' => 3, 'district_id' => '1007'],
            ['ddsa_code' => '100771', 'name' => 'Pekan Peretak', 'level' => 3, 'district_id' => '1007'],
            ['ddsa_code' => '100772', 'name' => 'Pekan Simpang Sungai CHOH', 'level' => 3, 'district_id' => '1007'],
            /*
             * === PETALING
             */
            ['ddsa_code' => '100802', 'name' => 'Bukit Raja', 'level' => 1, 'district_id' => '1008'],
            ['ddsa_code' => '100801', 'name' => 'Damansara', 'level' => 1, 'district_id' => '1008'],
            ['ddsa_code' => '100803', 'name' => 'Petaling', 'level' => 1, 'district_id' => '1008'],
            ['ddsa_code' => '100804', 'name' => 'Sungai Buloh', 'level' => 1, 'district_id' => '1008'],

            ['ddsa_code' => '100840', 'name' => 'Bandar Petaling Jaya', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100841', 'name' => 'Bandar Shah Alam', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100842', 'name' => 'Bandar Damansara', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100843', 'name' => 'Bandar Glenmarie', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100844', 'name' => 'Bandar Petaling Jaya SELATAN', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100845', 'name' => 'Bandar Saujana', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100846', 'name' => 'Bandar Sri Damansara', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100847', 'name' => 'Bandar Subang Jaya', 'level' => 2, 'district_id' => '1008'],
            ['ddsa_code' => '100848', 'name' => 'Bandar Sunway', 'level' => 2, 'district_id' => '1008'],

            ['ddsa_code' => '100870', 'name' => 'Pekan Batu Tiga', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100871', 'name' => 'Pekan Merbau Sempak', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100872', 'name' => 'Pekan Puchong', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100874', 'name' => 'Pekan Serdang', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100875', 'name' => 'Pekan Sungai Buloh', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100876', 'name' => 'Pekan Sungai Penchala', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100877', 'name' => 'Pekan Cempaka', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100878', 'name' => 'Pekan Country Height', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100879', 'name' => 'Pekan Desa Puchong', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100880', 'name' => 'Pekan Hicom', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100881', 'name' => 'Pekan Kayu Ara', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100882', 'name' => 'Pekan Kinrara', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100884', 'name' => 'Pekan Baru Hicom', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100885', 'name' => 'Pekan Baru Subang', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100886', 'name' => 'Pekan Baru Sungai BESI', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100887', 'name' => 'Pekan Baru Sungai BULOH', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100888', 'name' => 'Pekan Baru Penaga', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100889', 'name' => 'Pekan Puchong Jaya', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100890', 'name' => 'Pekan Puchong Perdana', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100891', 'name' => 'Pekan Subang', 'level' => 3, 'district_id' => '1008'],
            ['ddsa_code' => '100892', 'name' => 'Pekan Subang Jaya', 'level' => 3, 'district_id' => '1008'],
            /*
            /*
             * === GOMBAK
             */
            ['ddsa_code' => '100902', 'name' => 'Ulu Kelang', 'level' => 1, 'district_id' => '1009'],
            ['ddsa_code' => '100903', 'name' => 'Rawang', 'level' => 1, 'district_id' => '1009'],
            ['ddsa_code' => '100904', 'name' => 'Setapak', 'level' => 1, 'district_id' => '1009'],

            ['ddsa_code' => '100940', 'name' => 'Bandar Batu Arang', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100942', 'name' => 'Bandar Rawang', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100943', 'name' => 'Bandar Gombak Setia', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100944', 'name' => 'Bandar Ulu Kelang', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100945', 'name' => 'Bandar Kepong', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100946', 'name' => 'Bandar Kundang', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100947', 'name' => 'Bandar Selayang', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100948', 'name' => 'Bandar Sungai Buloh', 'level' => 2, 'district_id' => '1009'],
            ['ddsa_code' => '100949', 'name' => 'Bandar Sungai Pusu', 'level' => 2, 'district_id' => '1009'],

            ['ddsa_code' => '100972', 'name' => 'Pekan Batu 20', 'level' => 3, 'district_id' => '1009'],
            ['ddsa_code' => '100973', 'name' => 'Pekan Kuang', 'level' => 3, 'district_id' => '1009'],
            ['ddsa_code' => '100974', 'name' => 'Pekan Mimaland', 'level' => 3, 'district_id' => '1009'],
            ['ddsa_code' => '100975', 'name' => 'Pekan Pengkalan Kundang', 'level' => 3, 'district_id' => '1009'],
            ['ddsa_code' => '100976', 'name' => 'Pekan Sungai Buloh', 'level' => 3, 'district_id' => '1009'],
            ['ddsa_code' => '100977', 'name' => 'Pekan Templer', 'level' => 3, 'district_id' => '1009'],
            /*
             * === SEPANG
             */
            ['ddsa_code' => '101001', 'name' => 'Dengkil', 'level' => 1, 'district_id' => '1010'],
            ['ddsa_code' => '101003', 'name' => 'Sepang', 'level' => 1, 'district_id' => '1010'],

            ['ddsa_code' => '101040', 'name' => 'Bandar Sepang', 'level' => 2, 'district_id' => '1010'],
            ['ddsa_code' => '101041', 'name' => 'Bandar Baru Bangi', 'level' => 2, 'district_id' => '1010'],
            ['ddsa_code' => '101042', 'name' => 'Bandar Baru Salak TINGGI', 'level' => 2, 'district_id' => '1010'],
            ['ddsa_code' => '101043', 'name' => 'Bandar Lapangan Terbang ANTARABANGSA SEPANG', 'level' => 2, 'district_id' => '1010'],
            ['ddsa_code' => '101044', 'name' => 'Bandar Sungai Merab', 'level' => 2, 'district_id' => '1010'],

            ['ddsa_code' => '101070', 'name' => 'Pekan Dengkil', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101071', 'name' => 'Pekan Salak', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101072', 'name' => 'Pekan Sungai Pelek', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101074', 'name' => 'Pekan Batu 1 SEPANG', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101075', 'name' => 'Pekan Bukit Bisa', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101076', 'name' => 'Pekan Bukit Prang', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101077', 'name' => 'Pekan Dato Bakar BAGINDA', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101078', 'name' => 'Pekan Baru Salak TINGGI', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101079', 'name' => 'Pekan Sungai Merab', 'level' => 3, 'district_id' => '1010'],
            ['ddsa_code' => '101080', 'name' => 'Pekan Tanjung Mas', 'level' => 3, 'district_id' => '1010'],
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
