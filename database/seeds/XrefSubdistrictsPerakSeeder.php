<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsPerakSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '08%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
            * perak
            */
            /*
             * === BATANG PADANG
             */
            ['ddsa_code' => '080101', 'name' => 'Batang Padang', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080102', 'name' => 'Bidor', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080103', 'name' => 'Chenderiang', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080104', 'name' => 'Hulu Bernam Barat', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080105', 'name' => 'Hulu Bernam Timor', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080106', 'name' => 'Slim', 'level' => 1, 'district_id' => '0801'],
            ['ddsa_code' => '080107', 'name' => 'Sungkai', 'level' => 1, 'district_id' => '0801'],

            ['ddsa_code' => '080140', 'name' => 'Bandar Bidor', 'level' => 2, 'district_id' => '0801'],
            ['ddsa_code' => '080141', 'name' => 'Bandar Chenderian', 'level' => 2, 'district_id' => '0801'],
            ['ddsa_code' => '080142', 'name' => 'Bandar Sungkai', 'level' => 2, 'district_id' => '0801'],
            ['ddsa_code' => '080143', 'name' => 'Bandar Tanjong Malim', 'level' => 2, 'district_id' => '0801'],
            ['ddsa_code' => '080144', 'name' => 'Bandar Tapah', 'level' => 2, 'district_id' => '0801'],
            ['ddsa_code' => '080145', 'name' => 'Bandar Temoh', 'level' => 2, 'district_id' => '0801'],

            ['ddsa_code' => '080170', 'name' => 'Pekan Ayer Kuning', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080171', 'name' => 'Pekan Banir', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080172', 'name' => 'Pekan Bantang', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080173', 'name' => 'Pekan Bikam', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080174', 'name' => 'Pekan Slim', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080175', 'name' => 'Pekan Sungai Lesong', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080176', 'name' => 'Pekan Tapah Road', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080177', 'name' => 'Pekan Temoh Station', 'level' => 3, 'district_id' => '0801'],
            ['ddsa_code' => '080178', 'name' => 'Pekan Terolak', 'level' => 3, 'district_id' => '0801'],
            /*
             * === MANJUNG (DINDING)
             */
            ['ddsa_code' => '080201', 'name' => 'Beruas', 'level' => 1, 'district_id' => '0802'],
            ['ddsa_code' => '080202', 'name' => 'Lekir', 'level' => 1, 'district_id' => '0802'],
            ['ddsa_code' => '080203', 'name' => 'Lumut', 'level' => 1, 'district_id' => '0802'],
            ['ddsa_code' => '080204', 'name' => 'Pengkalan Baharu', 'level' => 1, 'district_id' => '0802'],
            ['ddsa_code' => '080205', 'name' => 'Sitiawan', 'level' => 1, 'district_id' => '0802'],

            ['ddsa_code' => '080240', 'name' => 'Bandar Lumut', 'level' => 2, 'district_id' => '0802'],

            ['ddsa_code' => '080270', 'name' => 'Pekan Ayer Tawar', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080271', 'name' => 'Pekan Beruas', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080272', 'name' => 'Pekan Changkat Keruing', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080273', 'name' => 'Pekan Damar Laut', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080274', 'name' => 'Pekan Kampong Baharu', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080275', 'name' => 'Pekan Kampong Koh', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080276', 'name' => 'Pekan Kampong Sitiawan', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080277', 'name' => 'Pekan Pangkor', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080278', 'name' => 'Pekan Pantai Remis', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080279', 'name' => 'Pekan Pasir Bogak', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080280', 'name' => 'Pekan Gurney', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080281', 'name' => 'Pekan Pangkalan Baharu', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080282', 'name' => 'Pekan Segari', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080283', 'name' => 'Pekan Sitiawan', 'level' => 3, 'district_id' => '0802'],
            ['ddsa_code' => '080284', 'name' => 'Pekan Sungai Pinang KECHIL', 'level' => 3, 'district_id' => '0802'],
            /*
             * === KINTA
             */
            ['ddsa_code' => '080301', 'name' => 'Belanja', 'level' => 1, 'district_id' => '0803'],
            ['ddsa_code' => '080302', 'name' => 'Hulu Kinta', 'level' => 1, 'district_id' => '0803'],
            ['ddsa_code' => '080304', 'name' => 'Sungai Raia', 'level' => 1, 'district_id' => '0803'],
            ['ddsa_code' => '080305', 'name' => 'Sungai Terap', 'level' => 1, 'district_id' => '0803'],
            ['ddsa_code' => '080306', 'name' => 'Tanjong Tualang', 'level' => 1, 'district_id' => '0803'],

            ['ddsa_code' => '080340', 'name' => 'Bandar Batu Gajah', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080341', 'name' => 'Bandar Chemor', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080343', 'name' => 'Bandar Ipoh (u)', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080344', 'name' => 'Bandar Ipoh (s)', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080345', 'name' => 'Bandar Jelapang', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080347', 'name' => 'Bandar Lahat', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080348', 'name' => 'Bandar Mengelembu', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080349', 'name' => 'Bandar Papan', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080351', 'name' => 'Bandar Pusing', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080352', 'name' => 'Bandar Seputeh', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080353', 'name' => 'Bandar Sungai Raya', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080354', 'name' => 'Bandar Tambun', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080355', 'name' => 'Bandar Tanjong Rambutan', 'level' => 2, 'district_id' => '0803'],
            ['ddsa_code' => '080356', 'name' => 'Bandar Teronoh', 'level' => 2, 'district_id' => '0803'],

            ['ddsa_code' => '080370', 'name' => 'Pekan Kanthan', 'level' => 3, 'district_id' => '0803'],
            ['ddsa_code' => '080373', 'name' => 'Pekan Simpang Pulai', 'level' => 3, 'district_id' => '0803'],
            ['ddsa_code' => '080374', 'name' => 'Pekan Tanjong Tualang', 'level' => 3, 'district_id' => '0803'],
            /*
             * === KERIAN
             */
            ['ddsa_code' => '080401', 'name' => 'Bagan Serai', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080402', 'name' => 'Bagan Tiang', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080403', 'name' => 'Beriah', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080404', 'name' => 'Gunong Semanggol', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080405', 'name' => 'Kuala Kurau', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080406', 'name' => 'Parit Buntar', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080407', 'name' => 'Selinsing', 'level' => 1, 'district_id' => '0804'],
            ['ddsa_code' => '080408', 'name' => 'Tanjong Piandang', 'level' => 1, 'district_id' => '0804'],

            ['ddsa_code' => '080440', 'name' => 'Bandar Bagan Serai', 'level' => 2, 'district_id' => '0804'],
            ['ddsa_code' => '080441', 'name' => 'Bandar Kuala Kurau', 'level' => 2, 'district_id' => '0804'],
            ['ddsa_code' => '080442', 'name' => 'Bandar Parit Buntar', 'level' => 2, 'district_id' => '0804'],

            ['ddsa_code' => '080470', 'name' => 'Pekan Bukit Merah', 'level' => 3, 'district_id' => '0804'],
            ['ddsa_code' => '080471', 'name' => 'Pekan Jalan Baru', 'level' => 3, 'district_id' => '0804'],
            ['ddsa_code' => '080473', 'name' => 'Pekan Simpang Lima', 'level' => 3, 'district_id' => '0804'],
            ['ddsa_code' => '080474', 'name' => 'Pekan Sungai Gedong', 'level' => 3, 'district_id' => '0804'],
            ['ddsa_code' => '080475', 'name' => 'Pekan Tanjong Piandang', 'level' => 3, 'district_id' => '0804'],
            /*
             * === KUALA KANGSAR
             */
            ['ddsa_code' => '080501', 'name' => 'Chengar Galah', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080502', 'name' => 'Kampong Buaya', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080503', 'name' => 'Kota Lama Kanan', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080504', 'name' => 'Kota Lama Kiri', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080505', 'name' => 'Lubok Merbau', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080506', 'name' => 'Pulau Kamiri', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080507', 'name' => 'Saiong', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080508', 'name' => 'Senggang', 'level' => 1, 'district_id' => '0805'],
            ['ddsa_code' => '080509', 'name' => 'Sungai Siput', 'level' => 1, 'district_id' => '0805'],

            ['ddsa_code' => '080540', 'name' => 'Bandar Kuala Kangsar', 'level' => 2, 'district_id' => '0805'],
            ['ddsa_code' => '080541', 'name' => 'Bandar Sungai Siput', 'level' => 2, 'district_id' => '0805'],

            ['ddsa_code' => '080570', 'name' => 'Pekan Gunong Pondok', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080571', 'name' => 'Pekan Jerlun', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080572', 'name' => 'Pekan Karai', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080573', 'name' => 'Pekan Kati', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080574', 'name' => 'Pekan Lubok Merbau', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080575', 'name' => 'Pekan Manong', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080576', 'name' => 'Pekan Padang Rengas', 'level' => 3, 'district_id' => '0805'],
            ['ddsa_code' => '080577', 'name' => 'Pekan Salak', 'level' => 3, 'district_id' => '0805'],
            /*
             * === LARUT DAN MATANG
             */
            ['ddsa_code' => '080601', 'name' => 'Asam Kumbang', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080602', 'name' => 'Batu Kurau', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080603', 'name' => 'Bukit Gantang', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080604', 'name' => 'Jebong', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080605', 'name' => 'Kamunting', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080606', 'name' => 'Pengkalan Aor', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080607', 'name' => 'Simpang', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080608', 'name' => 'Sungai Limau', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080609', 'name' => 'Sungai Tinggi', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080610', 'name' => 'Terong', 'level' => 1, 'district_id' => '0806'],
            ['ddsa_code' => '080611', 'name' => 'Tupai', 'level' => 1, 'district_id' => '0806'],

            ['ddsa_code' => '080640', 'name' => 'Bandar Kamunting', 'level' => 2, 'district_id' => '0806'],
            ['ddsa_code' => '080641', 'name' => 'Bandar Kuala Sepetang', 'level' => 2, 'district_id' => '0806'],
            ['ddsa_code' => '080642', 'name' => 'Bandar Matang', 'level' => 2, 'district_id' => '0806'],
            ['ddsa_code' => '080643', 'name' => 'Bandar Taiping', 'level' => 2, 'district_id' => '0806'],

            ['ddsa_code' => '080670', 'name' => 'Pekan Batu Kurau', 'level' => 3, 'district_id' => '0806'],
            ['ddsa_code' => '080671', 'name' => 'Pekan Changkat Jering', 'level' => 3, 'district_id' => '0806'],
            ['ddsa_code' => '080672', 'name' => 'Pekan Pondok Tanjong', 'level' => 3, 'district_id' => '0806'],
            ['ddsa_code' => '080673', 'name' => 'Pekan Simpang', 'level' => 3, 'district_id' => '0806'],
            ['ddsa_code' => '080674', 'name' => 'Pekan Terung', 'level' => 3, 'district_id' => '0806'],
            /*
             * === HILIR PERAK
             */
            ['ddsa_code' => '080701', 'name' => 'Bagan Datuk', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080702', 'name' => 'Changkat Jong', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080703', 'name' => 'Durian Sebatang', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080704', 'name' => 'Hutan Melintang', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080705', 'name' => 'Labu Kubong', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080706', 'name' => 'Rungkup', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080707', 'name' => 'Sungai Durian', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080708', 'name' => 'Sungai Manik', 'level' => 1, 'district_id' => '0807'],
            ['ddsa_code' => '080709', 'name' => 'Telok Baru', 'level' => 1, 'district_id' => '0807'],

            ['ddsa_code' => '080740', 'name' => 'Bandar Teluk Intan', 'level' => 2, 'district_id' => '0807'],

            ['ddsa_code' => '080770', 'name' => 'Pekan Bagan Datuk', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080771', 'name' => 'Pekan Batak Rabit', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080772', 'name' => 'Pekan Batu Dua PULOH', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080773', 'name' => 'Pekan Chikus', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080774', 'name' => 'Pekan Degong', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080775', 'name' => 'Pekan Hutan Melintang', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080776', 'name' => 'Pekan Jendarata', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080777', 'name' => 'Pekan Kampung Sungai HAJI MOHAMED', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080778', 'name' => 'Pekan Langkap', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080779', 'name' => 'Pekan Selekoh', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080780', 'name' => 'Pekan Simpang Empat', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080781', 'name' => 'Pekan Simpant Tiga (RUNGKUP)', 'level' => 3, 'district_id' => '0807'],
            ['ddsa_code' => '080782', 'name' => 'Pekan Sungai Sumun', 'level' => 3, 'district_id' => '0807'],
            /*
             * === ULU PERAK
             */
            ['ddsa_code' => '080801', 'name' => 'Belukar Semang', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080802', 'name' => 'Belum', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080803', 'name' => 'Durian Pipit', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080804', 'name' => 'Grik', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080805', 'name' => 'Kenering', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080806', 'name' => 'Kerunai', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080807', 'name' => 'Pengkalan Hulu', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080808', 'name' => 'Lenggong', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080809', 'name' => 'Temelong', 'level' => 1, 'district_id' => '0808'],
            ['ddsa_code' => '080810', 'name' => 'Temengor', 'level' => 1, 'district_id' => '0808'],

            ['ddsa_code' => '080840', 'name' => 'Bandar Gerik', 'level' => 2, 'district_id' => '0808'],
            ['ddsa_code' => '080841', 'name' => 'Bandar Kelian Intan', 'level' => 2, 'district_id' => '0808'],
            ['ddsa_code' => '080842', 'name' => 'Bandar Pengkalan Hulu', 'level' => 2, 'district_id' => '0808'],
            ['ddsa_code' => '080843', 'name' => 'Bandar Lawn', 'level' => 2, 'district_id' => '0808'],
            ['ddsa_code' => '080844', 'name' => 'Bandar Lenggong', 'level' => 2, 'district_id' => '0808'],
            /*
             * === SELAMA
             */
            ['ddsa_code' => '080901', 'name' => 'Hulu Ijok', 'level' => 1, 'district_id' => '0809'],
            ['ddsa_code' => '080902', 'name' => 'Hulu Selama', 'level' => 1, 'district_id' => '0809'],
            ['ddsa_code' => '080903', 'name' => 'Selama', 'level' => 1, 'district_id' => '0809'],

            ['ddsa_code' => '080940', 'name' => 'Bandar Selama', 'level' => 2, 'district_id' => '0809'],

            ['ddsa_code' => '080970', 'name' => 'Pekan Rantau Panjang', 'level' => 3, 'district_id' => '0809'],
            ['ddsa_code' => '080971', 'name' => 'Pekan Sungai Bayur', 'level' => 3, 'district_id' => '0809'],
            /*
             * === PERAK TENGAH
             */
            ['ddsa_code' => '081001', 'name' => 'Bandar', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081002', 'name' => 'Belanja', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081003', 'name' => 'Bota', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081004', 'name' => 'Jaya Baru', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081005', 'name' => 'Kampong Gajah', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081006', 'name' => 'Kota Setia', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081007', 'name' => 'Lambor Kanan', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081008', 'name' => 'Lambor Kiri', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081009', 'name' => 'Layang Layang', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081010', 'name' => 'Pasir Panjang Hulu', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081011', 'name' => 'Pasir Salak', 'level' => 1, 'district_id' => '0810'],
            ['ddsa_code' => '081012', 'name' => 'Pulau Tiga', 'level' => 1, 'district_id' => '0810'],

            ['ddsa_code' => '081040', 'name' => 'Bandar Bandar Seri ISKANDAR', 'level' => 2, 'district_id' => '0810'],

            ['ddsa_code' => '081070', 'name' => 'Pekan Bota Kanan', 'level' => 3, 'district_id' => '0810'],
            ['ddsa_code' => '081071', 'name' => 'Pekan Kampong Buloh AKAR', 'level' => 3, 'district_id' => '0810'],
            ['ddsa_code' => '081072', 'name' => 'Pekan Kota Setia', 'level' => 3, 'district_id' => '0810'],
            ['ddsa_code' => '081073', 'name' => 'Pekan Parit', 'level' => 3, 'district_id' => '0810'],
            ['ddsa_code' => '081074', 'name' => 'Pekan Tanjong Belanja', 'level' => 3, 'district_id' => '0810'],
            /*
             * === KAMPAR
             */
            ['ddsa_code' => '081101', 'name' => 'Kampar', 'level' => 1, 'district_id' => '0811'],
            ['ddsa_code' => '081102', 'name' => 'Teja', 'level' => 1, 'district_id' => '0811'],

            ['ddsa_code' => '081140', 'name' => 'Bandar Gopeng', 'level' => 2, 'district_id' => '0811'],
            ['ddsa_code' => '081141', 'name' => 'Bandar Kampar', 'level' => 2, 'district_id' => '0811'],

            ['ddsa_code' => '081170', 'name' => 'Pekan Kota Baharu', 'level' => 3, 'district_id' => '0811'],
            ['ddsa_code' => '081171', 'name' => 'Pekan Malim Nawar', 'level' => 3, 'district_id' => '0811'],
            /*
             * === MUALLIM
             */
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
