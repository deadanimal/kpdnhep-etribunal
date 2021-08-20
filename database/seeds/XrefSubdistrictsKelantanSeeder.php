<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsKelantanSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '03%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * kelantan
             */
            /*
             * === BACHOK
             */
            ['ddsa_code' => '030101', 'name' => 'Alor Bakat', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030102', 'name' => 'Backhok', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030103', 'name' => 'Bator', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030104', 'name' => 'Chap', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030105', 'name' => 'Cherang Hangus', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030106', 'name' => 'Gajah Mati', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030107', 'name' => 'Gunong', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030108', 'name' => 'Kuau', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030109', 'name' => 'Kemasin', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030110', 'name' => 'Kubang Telaga', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030111', 'name' => 'Kuchelong', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030112', 'name' => 'Lubok Tembesu', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030113', 'name' => 'Mak Lipah', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030114', 'name' => 'Melawi', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030115', 'name' => 'Nipah', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030116', 'name' => 'Pak Pura', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030117', 'name' => 'Pauh Sembilan', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030118', 'name' => 'Paya Mengkuang', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030119', 'name' => 'Perupok', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030120', 'name' => 'Repek', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030121', 'name' => 'Rusa', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030122', 'name' => 'Senak', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030123', 'name' => 'Serdang', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030124', 'name' => 'Takang', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030125', 'name' => 'Tanjong', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030126', 'name' => 'Tanjong Jering', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030127', 'name' => 'Tanjong Pauh', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030128', 'name' => 'Telok Mesira', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030129', 'name' => 'Telong', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030130', 'name' => 'Temu Ranggas', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030131', 'name' => 'Tepus', 'level' => 1, 'district_id' => '0301'],
            ['ddsa_code' => '030132', 'name' => 'Tualang Salak', 'level' => 1, 'district_id' => '0301'],

            ['ddsa_code' => '030140', 'name' => 'Bandar Bachok', 'level' => 2, 'district_id' => '0301'],

            ['ddsa_code' => '030170', 'name' => 'Pekan Jelawat', 'level' => 3, 'district_id' => '0301'],
            /*
             * === KOTA BHARU
             */
            ['ddsa_code' => '030201', 'name' => 'Aur Duri', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030202', 'name' => 'Badak Mati', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030203', 'name' => 'Badak', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030204', 'name' => 'Badang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030205', 'name' => 'Banggu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030206', 'name' => 'Banggol', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030207', 'name' => 'Baung', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030208', 'name' => 'Bayang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030209', 'name' => 'Bechah Mulong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030210', 'name' => 'Beta Hulu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030211', 'name' => 'Beta Hilir', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030212', 'name' => 'Beting', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030213', 'name' => 'Biah', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030214', 'name' => 'Binjai', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030215', 'name' => 'Buloh Poh', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030216', 'name' => 'Bunut Payong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030217', 'name' => 'But', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030218', 'name' => 'Chekli', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030219', 'name' => 'Chekok', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030220', 'name' => 'Che Latiff', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030221', 'name' => 'Chicha', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030222', 'name' => 'Dal', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030223', 'name' => 'Demit', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030224', 'name' => 'Duson Rendah', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030225', 'name' => 'Guntong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030226', 'name' => 'Jelutong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030227', 'name' => 'Kadok', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030228', 'name' => 'Karang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030229', 'name' => 'Kampong Sireh', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030230', 'name' => 'Kedai Buloh', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030231', 'name' => 'Kijang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030232', 'name' => 'Kemubu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030233', 'name' => 'Kemumin', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030234', 'name' => 'Kenali', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030235', 'name' => 'Ketereh Barat', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030236', 'name' => 'Ketereh Timor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030237', 'name' => 'Koh', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030238', 'name' => 'Kota', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030239', 'name' => 'Langgar', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030240', 'name' => 'Lembu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030241', 'name' => 'Lubok Jambu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030242', 'name' => 'Lubok Pukol', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030243', 'name' => 'Lundang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030244', 'name' => 'Lundang Paku', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030245', 'name' => 'Mahang Barat', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030246', 'name' => 'Mahang Timor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030247', 'name' => 'Mentuan', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030248', 'name' => 'Melor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030249', 'name' => 'Padang Bongor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030250', 'name' => 'Padang Enggang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030251', 'name' => 'Padang Garong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030252', 'name' => 'Padang Leban', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030253', 'name' => 'Padang Raja', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030254', 'name' => 'Padang Sakar', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030255', 'name' => 'Padang Tengah', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030256', 'name' => 'Panchor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030257', 'name' => 'Pangkal Pisang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030258', 'name' => 'Parit', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030259', 'name' => 'Pasir Ha', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030260', 'name' => 'Pasir Mas', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030261', 'name' => 'Patek', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030262', 'name' => 'Pauh', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030263', 'name' => 'Paya', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030264', 'name' => 'Pendek', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030265', 'name' => 'Pangkalan Chepa', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030266', 'name' => 'Peringat', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030267', 'name' => 'Perol', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030268', 'name' => 'Pintu Gang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030269', 'name' => 'Pulau', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030270', 'name' => 'Pulau Belanga', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030271', 'name' => 'Pulau Gajah', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030272', 'name' => 'Pulau Kundor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030273', 'name' => 'Pulau Panjang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030274', 'name' => 'Pulau Pisang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030275', 'name' => 'Sabak', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030276', 'name' => 'Salor', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030277', 'name' => 'Semut Api', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030278', 'name' => 'Sering', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030279', 'name' => 'Seterpa', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030280', 'name' => 'Tangjong Chat', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030281', 'name' => 'Tapang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030282', 'name' => 'Tebing Tinggi', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030283', 'name' => 'Telok', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030284', 'name' => 'Telok Bharu', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030285', 'name' => 'Telok Kitang', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030286', 'name' => 'Tiong', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030287', 'name' => 'Tok Ku', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030288', 'name' => 'Wakaf Stan', 'level' => 1, 'district_id' => '0302'],
            ['ddsa_code' => '030289', 'name' => 'Wakaf Siku', 'level' => 1, 'district_id' => '0302'],

            ['ddsa_code' => '030290', 'name' => 'Bandar Kota Bharu', 'level' => 2, 'district_id' => '0302'],
            ['ddsa_code' => '030291', 'name' => 'Bandar Baru Kubang KERIAN', 'level' => 2, 'district_id' => '0302'],

            ['ddsa_code' => '030295', 'name' => 'Pekan Mulong', 'level' => 3, 'district_id' => '0302'],
            /*
             * === MACHANG
             */
            ['ddsa_code' => '030301', 'name' => 'Bagan', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030302', 'name' => 'Bakar', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030303', 'name' => 'Dewan', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030304', 'name' => 'Gading Galoh', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030305', 'name' => 'Jakar', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030306', 'name' => 'Joh', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030307', 'name' => 'Kelaweh', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030308', 'name' => 'Kerawang', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030309', 'name' => 'Kerilla', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030310', 'name' => 'Kuala Kerak', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030311', 'name' => 'Labok', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030312', 'name' => 'Limau Hantu', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030313', 'name' => 'Machang', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030314', 'name' => 'Padang Kemunchut', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030315', 'name' => 'Pek', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030316', 'name' => 'Pemanok', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030317', 'name' => 'Pulau Chondong', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030318', 'name' => 'Raja', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030319', 'name' => 'Tengah', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030320', 'name' => 'Tok Bok', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030321', 'name' => 'Ulu Sat', 'level' => 1, 'district_id' => '0303'],
            ['ddsa_code' => '030340', 'name' => 'Bandar Machang', 'level' => 1, 'district_id' => '0303'],

            ['ddsa_code' => '030371', 'name' => 'Pekan Temangan', 'level' => 1, 'district_id' => '0303'],
            /*
             * === PASIR MAS
             */
            ['ddsa_code' => '030401', 'name' => 'Alor Buloh', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030402', 'name' => 'Alor Pasir', 'level' => 1, 'district_id' => '0304'], // via statistic.gov.my
            ['ddsa_code' => '030403', 'name' => 'Apa-apa', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030404', 'name' => 'Apam', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030405', 'name' => 'Bakong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030406', 'name' => 'Bechah Menerong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030407', 'name' => 'Bechah Palas', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030408', 'name' => 'Bechah Semak', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030409', 'name' => 'Bukit Tuku', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030410', 'name' => 'Chetok', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030411', 'name' => 'Gelam', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030412', 'name' => 'Gua', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030413', 'name' => 'Gual Nering', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030414', 'name' => 'Gual Periok', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030415', 'name' => 'Jabo', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030416', 'name' => 'Jejawi', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030417', 'name' => 'Kangkong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030418', 'name' => 'Kala', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030419', 'name' => 'Kasa', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030420', 'name' => 'Kedondong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030421', 'name' => 'Kenak', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030422', 'name' => 'Kerasak', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030423', 'name' => 'Kiat', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030424', 'name' => 'Kuala Lemal', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030425', 'name' => 'Kubang Batang', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030426', 'name' => 'Kubang Bemban', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030427', 'name' => 'Kubang Gatal', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030428', 'name' => 'Kubang Gendang', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030429', 'name' => 'Kubang Ketam', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030430', 'name' => 'Kubang Sepat', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030431', 'name' => 'Kubang Terap', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030432', 'name' => 'Lalang', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030433', 'name' => 'Lubok Anching', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030434', 'name' => 'Lubok Gong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030435', 'name' => 'Lubok Kawah', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030436', 'name' => 'Lubok Tapah', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030437', 'name' => 'Lubok Setol', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030438', 'name' => 'Meranti', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030439', 'name' => 'Padang Embon', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030440', 'name' => 'Paloh', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030441', 'name' => 'Rantau Panjang', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030442', 'name' => 'Sakar', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030443', 'name' => 'Tasik Berangan', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030444', 'name' => 'Teliar', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030445', 'name' => 'Tedong', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030446', 'name' => 'Tok Sangkot', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030447', 'name' => 'Tok Uban', 'level' => 1, 'district_id' => '0304'],
            ['ddsa_code' => '030448', 'name' => 'Kuala Kelar', 'level' => 1, 'district_id' => '0304'],

            ['ddsa_code' => '030450', 'name' => 'Bandar Pasir Mas', 'level' => 2, 'district_id' => '0304'],

            ['ddsa_code' => '030470', 'name' => 'Pekan Rantau Panjang', 'level' => 3, 'district_id' => '0304'],
            /*
             * === PASIR PUTEH
             */
            ['ddsa_code' => '030501', 'name' => 'Banggol Setol', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030502', 'name' => 'Batu Sebutir', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030503', 'name' => 'Berangan', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030504', 'name' => 'Bukit Abal Barat', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030505', 'name' => 'Bukit Abal Timor', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030506', 'name' => 'Bukit Merbau', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030507', 'name' => 'Bukit Tanah', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030508', 'name' => 'Cherang Ruku', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030509', 'name' => 'Changgai', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030510', 'name' => 'Gong Datok Barat', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030511', 'name' => 'Gong Datok Timor', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030512', 'name' => 'Gong Chapa', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030513', 'name' => 'Gong Chengal', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030514', 'name' => 'Gong Garu', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030515', 'name' => 'Gong Kulim', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030516', 'name' => 'Gong Nangka', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030517', 'name' => 'Gong Pachat', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030518', 'name' => 'Jeram', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030519', 'name' => 'Jerus', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030520', 'name' => 'Kandis', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030521', 'name' => 'Kampong Wakaf', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030522', 'name' => 'Kolam Tembusu', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030523', 'name' => 'Merbol', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030524', 'name' => 'Merkang', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030525', 'name' => 'Padang Pak Amat', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030526', 'name' => 'Pasir Puteh', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030527', 'name' => 'Pangkalan', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030528', 'name' => 'Permatang Sungkai', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030529', 'name' => 'Seligi', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030530', 'name' => 'Selinsing', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030531', 'name' => 'Semerak', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030532', 'name' => 'Tasik', 'level' => 1, 'district_id' => '0305'],
            ['ddsa_code' => '030533', 'name' => 'Telipok', 'level' => 1, 'district_id' => '0305'],

            ['ddsa_code' => '030540', 'name' => 'Bandar Pasir Puteh', 'level' => 2, 'district_id' => '0305'],

            ['ddsa_code' => '030570', 'name' => 'Pekan Selinsing', 'level' => 3, 'district_id' => '0305'],
            /*
             * === TANAH MERAH
             */
            ['ddsa_code' => '030601', 'name' => 'Batang Merbau', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030603', 'name' => 'Bendang Nyior', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030604', 'name' => 'Bukit Durian', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030605', 'name' => 'Ulu Kusial', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030606', 'name' => 'Jedok', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030609', 'name' => 'Kuala Paku', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030610', 'name' => 'Lawang', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030611', 'name' => 'Maka', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030612', 'name' => 'Nibong', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030613', 'name' => 'Pasir Ganda', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030614', 'name' => 'Rambai', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030615', 'name' => 'Sokor', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030616', 'name' => 'Tanah Merah', 'level' => 1, 'district_id' => '0306'],
            ['ddsa_code' => '030617', 'name' => 'Tebing Tinggi', 'level' => 1, 'district_id' => '0306'],

            ['ddsa_code' => '030640', 'name' => 'Bandar Tanah Merah', 'level' => 2, 'district_id' => '0306'],
            /*
             * === TUMPAT
             */
            ['ddsa_code' => '030701', 'name' => 'Bechah Resak', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030702', 'name' => 'Bunohan', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030703', 'name' => 'Bunut Sarang Burong', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030704', 'name' => 'Chenderong Batu', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030705', 'name' => 'Cherang Melintang', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030706', 'name' => 'Geting', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030707', 'name' => 'Jal', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030708', 'name' => 'Kampong Laut', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030709', 'name' => 'Kelaboran', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030710', 'name' => 'Ketil', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030711', 'name' => 'Kok Keli', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030712', 'name' => 'Kutang', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030713', 'name' => 'Mak Neralang', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030714', 'name' => 'Morak', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030715', 'name' => 'Pasir Pekan', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030716', 'name' => 'Palekbang', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030717', 'name' => 'Periok', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030718', 'name' => 'Pulau Besar', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030719', 'name' => 'Selehong Selatan', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030720', 'name' => 'Selehong Utara', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030721', 'name' => 'Simpangan', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030722', 'name' => 'Sungai Pinang', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030723', 'name' => 'Tabar', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030724', 'name' => 'Talak', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030725', 'name' => 'Telok Rejuna', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030726', 'name' => 'Tujoh', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030727', 'name' => 'Tumpat', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030728', 'name' => 'Wakaf Bharu', 'level' => 1, 'district_id' => '0307'],
            ['ddsa_code' => '030729', 'name' => 'Wakaf Delima', 'level' => 1, 'district_id' => '0307'],

            ['ddsa_code' => '030740', 'name' => 'Bandar Tumpat', 'level' => 2, 'district_id' => '0307'],
            /*
             * === GUA MUSANG
             */
            ['ddsa_code' => '030801', 'name' => 'Batu Papan', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030802', 'name' => 'Gua Musang', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030803', 'name' => 'Ulu Nenggiri', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030804', 'name' => 'Ketil', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030805', 'name' => 'Kuala Sungai', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030806', 'name' => 'Limau Kasturi', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030807', 'name' => 'Pulai', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030808', 'name' => 'Relai', 'level' => 1, 'district_id' => '0308'],
            ['ddsa_code' => '030809', 'name' => 'Renok', 'level' => 1, 'district_id' => '0308'],

            ['ddsa_code' => '030840', 'name' => 'Bandar Gua Musang', 'level' => 2, 'district_id' => '0308'],
            /*
             * === 0309 MISSING SUBDISTRICT
             */
            /*
             * === KUALA KRAI
             */
            ['ddsa_code' => '031001', 'name' => 'Batu Mengkebang', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031002', 'name' => 'Enggong', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031003', 'name' => 'Gajah', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031004', 'name' => 'Kandek', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031005', 'name' => 'Kenor', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031006', 'name' => 'Kuala Geris', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031007', 'name' => 'Kuala Krai', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031008', 'name' => 'Kuala Nal', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031009', 'name' => 'Kuala Pahi', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031010', 'name' => 'Kuala Pergau', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031011', 'name' => 'Kuala Stong', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031012', 'name' => 'Mambong', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031013', 'name' => 'Manek Urai', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031014', 'name' => 'Manjor', 'level' => 1, 'district_id' => '0310'],
            ['ddsa_code' => '031015', 'name' => 'Telekong', 'level' => 1, 'district_id' => '0310'],

            ['ddsa_code' => '031040', 'name' => 'Bandar Kuala Krai', 'level' => 2, 'district_id' => '0310'],
            /*
             * === JELI
             */
            ['ddsa_code' => '031101', 'name' => 'Belimbing', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031102', 'name' => 'Bunga Tanjong', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031103', 'name' => 'Jeli', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031104', 'name' => 'Jeli Tepi Sungai', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031105', 'name' => 'Kalai', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031106', 'name' => 'Kuala Balah', 'level' => 1, 'district_id' => '0311'],
            ['ddsa_code' => '031107', 'name' => 'Lubok Bongor', 'level' => 1, 'district_id' => '0311'],
            /*
             * === KECIL LOJING
             */
            ['ddsa_code' => '031201', 'name' => 'Balar', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031202', 'name' => 'Kuala Betis', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031203', 'name' => 'Blau', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031204', 'name' => 'Hau', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031205', 'name' => 'Hendrop', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031206', 'name' => 'Sigar', 'level' => 1, 'district_id' => '0312'],
            ['ddsa_code' => '031207', 'name' => 'Tuel', 'level' => 1, 'district_id' => '0312'],
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
