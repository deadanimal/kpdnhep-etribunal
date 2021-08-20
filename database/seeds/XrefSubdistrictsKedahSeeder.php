<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsKedahSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '02%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * kedah
             */
            /*
             * === KOTA SETAR
             */
            ['ddsa_code' => '020101', 'name' => 'Alor Malai', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020103', 'name' => 'Anak Bukit', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020107', 'name' => 'Derga', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020109', 'name' => 'Gunong', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020112', 'name' => 'Kangkong', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020115', 'name' => 'Kubang Rotan', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020116', 'name' => 'Langgar', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020117', 'name' => 'Lengkuas', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020118', 'name' => 'Lepai', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020120', 'name' => 'Limbong', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020122', 'name' => 'Padang Hang', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020123', 'name' => 'Padang Lalang', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020124', 'name' => 'Pengkalan Kundor', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020126', 'name' => 'Sala Kechil', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020127', 'name' => 'Sungai Baharu', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020128', 'name' => 'Tajar', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020129', 'name' => 'Tebengau', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020130', 'name' => 'Telaga Mas', 'level' => 1, 'district_id' => '0201'],
            ['ddsa_code' => '020131', 'name' => 'Titi Gajah', 'level' => 1, 'district_id' => '0201'],

            ['ddsa_code' => '020140', 'name' => 'Bandar Alor Setar', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020141', 'name' => 'Bandar Anak Bukit', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020143', 'name' => 'Bandar Kuala Kedah', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020147', 'name' => 'Bandar Alor Merah', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020148', 'name' => 'Bandar Bukit Pinang', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020149', 'name' => 'Bandar Langgar', 'level' => 2, 'district_id' => '0201'],
            ['ddsa_code' => '020150', 'name' => 'Bandar Simpang Empat', 'level' => 2, 'district_id' => '0201'],

            ['ddsa_code' => '020170', 'name' => 'Pekan Alor Janggus', 'level' => 3, 'district_id' => '0201'],
            ['ddsa_code' => '020172', 'name' => 'Pekan Kota Sarang SEMUT', 'level' => 3, 'district_id' => '0201'],
            ['ddsa_code' => '020175', 'name' => 'Pekan Gunung', 'level' => 3, 'district_id' => '0201'],
            /*
             * === KUBANG PASU
             */
            ['ddsa_code' => '020201', 'name' => 'Ah', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020202', 'name' => 'Binjal', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020203', 'name' => 'Gelong', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020204', 'name' => 'Bukit Tinggi', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020205', 'name' => 'Husba', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020206', 'name' => 'Jeram', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020207', 'name' => 'Jerlun', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020208', 'name' => 'Jitra', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020209', 'name' => 'Kepelu', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020210', 'name' => 'Kubang Pasu', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020211', 'name' => 'Malau', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020212', 'name' => 'Naga', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020213', 'name' => 'Padang Perahu', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020214', 'name' => 'Pelubang', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020215', 'name' => 'Pering', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020216', 'name' => 'Putat', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020217', 'name' => 'Sanglang', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020218', 'name' => 'Sungai Laka', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020219', 'name' => 'Temin', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020220', 'name' => 'Tunjang', 'level' => 1, 'district_id' => '0202'],
            ['ddsa_code' => '020221', 'name' => 'Wang Tepus', 'level' => 1, 'district_id' => '0202'],

            ['ddsa_code' => '020240', 'name' => 'Bandar Changlun', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020241', 'name' => 'Bandar Jitra', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020242', 'name' => 'Bandar Kodiang', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020243', 'name' => 'Bandar Tunjang', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020244', 'name' => 'Bandar Bandar Darulaman', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020245', 'name' => 'Bandar Padang Sera', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020246', 'name' => 'Bandar Kepala Batas', 'level' => 2, 'district_id' => '0202'],
            ['ddsa_code' => '020247', 'name' => 'Bandar Bukit Kayu HITAM', 'level' => 2, 'district_id' => '0202'],

            ['ddsa_code' => '020270', 'name' => 'Pekan Ayer Hitam', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020276', 'name' => 'Pekan Kuala Sanglang', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020281', 'name' => 'Pekan Sanglang', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020289', 'name' => 'Pekan Kerpan', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020290', 'name' => 'Pekan Sintok', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020291', 'name' => 'Pekan Napoh', 'level' => 3, 'district_id' => '0202'],
            ['ddsa_code' => '020292', 'name' => 'Pekan Sungai Korok', 'level' => 3, 'district_id' => '0202'],
            /*
             * === PADANG TERAP
             */
            ['ddsa_code' => '020302', 'name' => 'Batang Tunggang Kanan', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020301', 'name' => 'Batang Tunggang Kiri', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020303', 'name' => 'Belimbing Kanan', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020304', 'name' => 'Belimbing Kiri', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020305', 'name' => 'Kurong Hitam', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020306', 'name' => 'Padang Ternak', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020307', 'name' => 'Padang Terap Kanan', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020308', 'name' => 'Padang Terap Kiri', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020309', 'name' => 'Pedu', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020310', 'name' => 'Tekai', 'level' => 1, 'district_id' => '0203'],
            ['ddsa_code' => '020311', 'name' => 'Tolak', 'level' => 1, 'district_id' => '0203'],

            ['ddsa_code' => '020340', 'name' => 'Bandar Kuala Nerang', 'level' => 2, 'district_id' => '0203'],

            ['ddsa_code' => '020370', 'name' => 'Pekan Naka', 'level' => 3, 'district_id' => '0203'],
            ['ddsa_code' => '020371', 'name' => 'Pekan Durian Burung', 'level' => 3, 'district_id' => '0203'],
            ['ddsa_code' => '020372', 'name' => 'Pekan Lubok Merbau', 'level' => 3, 'district_id' => '0203'],
            ['ddsa_code' => '020373', 'name' => 'Pekan Bukit Tembaga', 'level' => 3, 'district_id' => '0203'],
            ['ddsa_code' => '020374', 'name' => 'Pekan Padang Sanai', 'level' => 3, 'district_id' => '0203'],
            ['ddsa_code' => '020375', 'name' => 'Pekan Kampung Tanjung', 'level' => 3, 'district_id' => '0203'],
            /*
             * === LANGKAWI
             */
            ['ddsa_code' => '020402', 'name' => 'Ayer Hangat', 'level' => 1, 'district_id' => '0204'],
            ['ddsa_code' => '020401', 'name' => 'Bohor', 'level' => 1, 'district_id' => '0204'],
            ['ddsa_code' => '020403', 'name' => 'Kedawang', 'level' => 1, 'district_id' => '0204'],
            ['ddsa_code' => '020404', 'name' => 'Kuah', 'level' => 1, 'district_id' => '0204'],
            ['ddsa_code' => '020405', 'name' => 'Padang Masirat', 'level' => 1, 'district_id' => '0204'],
            ['ddsa_code' => '020406', 'name' => 'Ulu Melaka', 'level' => 1, 'district_id' => '0204'],

            ['ddsa_code' => '020440', 'name' => 'Bandar Kuah', 'level' => 2, 'district_id' => '0204'],
            ['ddsa_code' => '020442', 'name' => 'Bandar Padang Lalang', 'level' => 2, 'district_id' => '0204'],

            ['ddsa_code' => '020472', 'name' => 'Pekan Telok Datai', 'level' => 3, 'district_id' => '0204'],
            /*
             * === KUALA MUDA - data tiada dalam sddsa. retrive from statistics.gov.my
             */
            ['ddsa_code' => '020501', 'name' => 'Bujang', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020502', 'name' => 'Bukit Meriam', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020503', 'name' => 'Gurun', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020504', 'name' => 'Haji Kudong', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020505', 'name' => 'Kota', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020506', 'name' => 'Kuala', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020507', 'name' => 'Merbok', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020508', 'name' => 'Pekula', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020509', 'name' => 'Pinang Tunggal', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020510', 'name' => 'Rantau Panjang', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020511', 'name' => 'Semeling', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020512', 'name' => 'Sidam Kiri', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020513', 'name' => 'Simpor', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020514', 'name' => 'Sungai Pasir', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020515', 'name' => 'Sungai Petani', 'level' => 1, 'district_id' => '0205'],
            ['ddsa_code' => '020516', 'name' => 'Teloi Kiri', 'level' => 1, 'district_id' => '0205'],
            /*
             * === YAN
             */
            ['ddsa_code' => '020602', 'name' => 'Dulang', 'level' => 1, 'district_id' => '0206'],
            ['ddsa_code' => '020601', 'name' => 'Sala Besar', 'level' => 1, 'district_id' => '0206'],
            ['ddsa_code' => '020603', 'name' => 'Singkir', 'level' => 1, 'district_id' => '0206'],
            ['ddsa_code' => '020604', 'name' => 'Sungai Daun', 'level' => 1, 'district_id' => '0206'],
            ['ddsa_code' => '020605', 'name' => 'Yan', 'level' => 1, 'district_id' => '0206'],

            ['ddsa_code' => '020640', 'name' => 'Bandar Guar Chempedak', 'level' => 2, 'district_id' => '0206'],
            ['ddsa_code' => '020641', 'name' => 'Bandar Yan', 'level' => 2, 'district_id' => '0206'],

            ['ddsa_code' => '020671', 'name' => 'Pekan Simpang Tiga Sungai Limau', 'level' => 3, 'district_id' => '0206'],
            ['ddsa_code' => '020672', 'name' => 'Pekan Sungai Limau Dalam', 'level' => 3, 'district_id' => '0206'],
            ['ddsa_code' => '020674', 'name' => 'Pekan Teroi', 'level' => 3, 'district_id' => '0206'],
            ['ddsa_code' => '020675', 'name' => 'Pekan Singkir', 'level' => 3, 'district_id' => '0206'],
            /*
             * === SIK
             */
            ['ddsa_code' => '020702', 'name' => 'Jeneri', 'level' => 1, 'district_id' => '0207'],
            ['ddsa_code' => '020701', 'name' => 'Sik', 'level' => 1, 'district_id' => '0207'],
            ['ddsa_code' => '020703', 'name' => 'Sok', 'level' => 1, 'district_id' => '0207'],

            ['ddsa_code' => '020740', 'name' => 'Bandar Sik', 'level' => 2, 'district_id' => '0207'],

            ['ddsa_code' => '020770', 'name' => 'Pekan Batu Lama Sik', 'level' => 3, 'district_id' => '0207'],
            ['ddsa_code' => '020773', 'name' => 'Pekan Gulau', 'level' => 3, 'district_id' => '0207'],
            ['ddsa_code' => '020774', 'name' => 'Pekan Gajah Puteh', 'level' => 3, 'district_id' => '0207'],
            ['ddsa_code' => '020775', 'name' => 'Pekan Charok Padang', 'level' => 3, 'district_id' => '0207'],
            /*
             * === BALING
             */
            ['ddsa_code' => '020801', 'name' => 'Bakai', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020802', 'name' => 'Baling', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020803', 'name' => 'Bongor', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020804', 'name' => 'Kupang', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020805', 'name' => 'Pulai', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020806', 'name' => 'Siong', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020807', 'name' => 'Tawar', 'level' => 1, 'district_id' => '0208'],
            ['ddsa_code' => '020808', 'name' => 'Teloi Kanan', 'level' => 1, 'district_id' => '0208'],

            ['ddsa_code' => '020840', 'name' => 'Bandar Baling', 'level' => 2, 'district_id' => '0208'],
            ['ddsa_code' => '020841', 'name' => 'Bandar Kuala Ketil', 'level' => 2, 'district_id' => '0208'],
            ['ddsa_code' => '020842', 'name' => 'Bandar Kupang', 'level' => 2, 'district_id' => '0208'],

            ['ddsa_code' => '020872', 'name' => 'Pekan Kampung Baru Kejai', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020874', 'name' => 'Pekan Pulai', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020875', 'name' => 'Pekan Tawar', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020876', 'name' => 'Pekan Kuala Pegang', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020878', 'name' => 'Pekan Parit Panjang', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020879', 'name' => 'Pekan Kampung Lalang', 'level' => 3, 'district_id' => '0208'],
            ['ddsa_code' => '020880', 'name' => 'Pekan Malau', 'level' => 3, 'district_id' => '0208'],
            /*
             * === KULIM
             */
            ['ddsa_code' => '020902', 'name' => 'Bagan Sena', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020901', 'name' => 'Junjong', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020903', 'name' => 'Karangan', 'level' => 1, 'district_id' => '0209'],
            // ['ddsa_code' => '020904', 'name' => 'Keladi', 'level' => 1, 'district_id' => '0209'], // deprecated?
            ['ddsa_code' => '020905', 'name' => 'Kulim', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020906', 'name' => 'Lunas', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020907', 'name' => 'Mahang', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020908', 'name' => 'Naga Lilit', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020909', 'name' => 'Padang China', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020910', 'name' => 'Padang Meha', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020911', 'name' => 'Sedim', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020912', 'name' => 'Sidam Kanan', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020913', 'name' => 'Sungai Seluang', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020914', 'name' => 'Sungai Ular', 'level' => 1, 'district_id' => '0209'],
            ['ddsa_code' => '020915', 'name' => 'Terap', 'level' => 1, 'district_id' => '0209'],

            ['ddsa_code' => '020940', 'name' => 'Bandar Kulim', 'level' => 2, 'district_id' => '0209'],
            ['ddsa_code' => '020941', 'name' => 'Bandar Lunas', 'level' => 2, 'district_id' => '0209'],
            ['ddsa_code' => '020942', 'name' => 'Bandar Padang Serai', 'level' => 2, 'district_id' => '0209'],

            ['ddsa_code' => '020970', 'name' => 'Pekan Junjong', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020971', 'name' => 'Pekan Karangan', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020972', 'name' => 'Pekan Labu Besar', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020973', 'name' => 'Pekan Mahang', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020974', 'name' => 'Pekan Merbau Pulas', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020975', 'name' => 'Pekan Sungai Karangan', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020976', 'name' => 'Pekan Sungai Kob', 'level' => 3, 'district_id' => '0209'],
            ['ddsa_code' => '020977', 'name' => 'Pekan Padang Meha', 'level' => 3, 'district_id' => '0209'],
            /*
             * === BANDAR BAHARU
             */
            ['ddsa_code' => '021001', 'name' => 'Bagan Semak', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021002', 'name' => 'Kuala Selama', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021003', 'name' => 'Permatang Pasir', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021004', 'name' => 'Relau', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021005', 'name' => 'Serdang', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021006', 'name' => 'Sungai Batu', 'level' => 1, 'district_id' => '0210'],
            ['ddsa_code' => '021007', 'name' => 'Sungai Kechil', 'level' => 1, 'district_id' => '0210'],

            ['ddsa_code' => '021040', 'name' => 'Bandar Bandar Baharu', 'level' => 2, 'district_id' => '0210'],
            ['ddsa_code' => '021041', 'name' => 'Bandar Serdang', 'level' => 2, 'district_id' => '0210'],

            ['ddsa_code' => '021070', 'name' => 'Pekan Lubuk Buntar', 'level' => 3, 'district_id' => '0210'],
            ['ddsa_code' => '021071', 'name' => 'Pekan Selama', 'level' => 3, 'district_id' => '0210'],
            ['ddsa_code' => '021072', 'name' => 'Pekan Sungai Kecil Illir', 'level' => 3, 'district_id' => '0210'],
            ['ddsa_code' => '021073', 'name' => 'Pekan Relau', 'level' => 3, 'district_id' => '0210'],
            /*
             * === PENDANG
             */
            ['ddsa_code' => '021102', 'name' => 'Ayer Puteh', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021101', 'name' => 'Bukit Raya', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021103', 'name' => 'Guar Kepayang', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021104', 'name' => 'Padang Kerbau', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021105', 'name' => 'Padang Peliang', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021106', 'name' => 'Padang Pusing', 'level' => 1, 'district_id' => '0211'],
            ['ddsa_code' => '021108', 'name' => 'Tobiar', 'level' => 1, 'district_id' => '0211'],

            ['ddsa_code' => '021140', 'name' => 'Bandar Pedang', 'level' => 2, 'district_id' => '0211'],

            ['ddsa_code' => '021170', 'name' => 'Pekan Bukit Jenun', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021171', 'name' => 'Pekan Kubur Panjang', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021172', 'name' => 'Pekan Tanah Merah', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021173', 'name' => 'Pekan Tokai', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021174', 'name' => 'Pekan Kobah', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021175', 'name' => 'Pekan Kampung Baru', 'level' => 3, 'district_id' => '0211'],
            ['ddsa_code' => '021176', 'name' => 'Pekan Sungai Tiang', 'level' => 3, 'district_id' => '0211'],
            /*
             * === POKOK SENA
             */
            ['ddsa_code' => '021201', 'name' => 'Derang', 'level' => 1, 'district_id' => '0212'],
            ['ddsa_code' => '021202', 'name' => 'Lesong', 'level' => 1, 'district_id' => '0212'],
            ['ddsa_code' => '021203', 'name' => 'Tualang', 'level' => 1, 'district_id' => '0212'],
            ['ddsa_code' => '021206', 'name' => 'Bukit Lada', 'level' => 1, 'district_id' => '0212'],

            ['ddsa_code' => '021240', 'name' => 'Bandar Pokok Sena', 'level' => 2, 'district_id' => '0212'],

            ['ddsa_code' => '021270', 'name' => 'Pekan Kebun 500', 'level' => 3, 'district_id' => '0212'],
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
