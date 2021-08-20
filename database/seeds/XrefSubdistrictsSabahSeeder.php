<?php

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Seeder;

class XrefSubdistrictsSabahSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run()
    {
        $districts = MasterDistrict::where('ddsa_code', 'like', '12%')->get()->pluck('district_id', 'ddsa_code');

        $data_seeds = [
            /*
             * sabah http://www.sabah.gov.my/pd.trn/mukim.html
             */
            /*
             * === KOTA KINABALU
             */
            ['ddsa_code' => '120101', 'name' => 'Inanam', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120102', 'name' => 'Kepayan', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120103', 'name' => 'Likas', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120104', 'name' => 'Lok Kawi', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120105', 'name' => 'Menggatal', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120106', 'name' => 'Sepanggar', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120107', 'name' => 'Tanjung Aru', 'level' => 1, 'district_id' => '1201'],
            ['ddsa_code' => '120108', 'name' => 'Telipok', 'level' => 1, 'district_id' => '1201'],
            /*
             * === PAPAR
             */
            ['ddsa_code' => '120201', 'name' => '-', 'level' => 1, 'district_id' => '1202'],
            /*
             * === KOTA BELUD
             */
            ['ddsa_code' => '120301', 'name' => '-', 'level' => 1, 'district_id' => '1203'],
            /*
             * === TUARAN
             */
            ['ddsa_code' => '120401', 'name' => 'Berungis', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120402', 'name' => 'Indai', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120403', 'name' => 'Lembah', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120404', 'name' => 'Mengkabong', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120405', 'name' => 'Nabalu', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120406', 'name' => 'Pantai', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120407', 'name' => 'Pekan', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120408', 'name' => 'Serusop', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120409', 'name' => 'Tambalang', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120410', 'name' => 'Tengah', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120411', 'name' => 'Ulu', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120412', 'name' => 'Mangkaladoi', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120413', 'name' => 'Tenghilan', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120414', 'name' => 'Topokon', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120415', 'name' => 'Tuaran Bandar', 'level' => 1, 'district_id' => '1204'],
            ['ddsa_code' => '120416', 'name' => 'Tamparuli', 'level' => 1, 'district_id' => '1204'],
            /*
             * === KUDAT
             */
            ['ddsa_code' => '120501', 'name' => '-', 'level' => 1, 'district_id' => '1205'],
            /*
             * === RANAU
             */
            ['ddsa_code' => '120601', 'name' => '-', 'level' => 1, 'district_id' => '1206'],
            /*
             * === SANDAKAN
             */
            ['ddsa_code' => '120701', 'name' => '-', 'level' => 1, 'district_id' => '1207'],
            /*
             * === LABUK & SUGUT
             */
            ['ddsa_code' => '120801', 'name' => '-', 'level' => 1, 'district_id' => '1208'],
            /*
             * === KINABATANGAN
             */
            ['ddsa_code' => '120901', 'name' => '-', 'level' => 1, 'district_id' => '1209'],
            /*
             * === TAWAU
             */
            ['ddsa_code' => '121001', 'name' => '-', 'level' => 1, 'district_id' => '1210'],
            /*
             * === LAHAD DATU
             */
            ['ddsa_code' => '121101', 'name' => '-', 'level' => 1, 'district_id' => '1211'],
            /*
             * === SEMPORNA
             */
            ['ddsa_code' => '121201', 'name' => '-', 'level' => 1, 'district_id' => '1212'],
            /*
             * === KENINGAU
             */
            ['ddsa_code' => '121301', 'name' => '-', 'level' => 1, 'district_id' => '1213'],
            /*
             * === TAMBUNAN
             */
            ['ddsa_code' => '121401', 'name' => '-', 'level' => 1, 'district_id' => '1214'],
            /*
             * === PENSIANGAN
             */
            ['ddsa_code' => '121501', 'name' => '-', 'level' => 1, 'district_id' => '1215'],
            /*
             * === TENOM
             */
            ['ddsa_code' => '121601', 'name' => '-', 'level' => 1, 'district_id' => '1216'],
            /*
             * === BEAUFORT
             */
            ['ddsa_code' => '121701', 'name' => 'Membakut', 'level' => 1, 'district_id' => '1217'],
            /*
             * === KUALA PENYU
             */
            ['ddsa_code' => '121801', 'name' => '-', 'level' => 1, 'district_id' => '1218'],
            /*
             * === SIPITANG
             */
            ['ddsa_code' => '121901', 'name' => '-', 'level' => 1, 'district_id' => '1219'],
            /*
             * === PENAMPANG
             */
            ['ddsa_code' => '122101', 'name' => 'Donggongon', 'level' => 1, 'district_id' => '1221'], //?
            /*
             * === KOTA MARUDU
             */
            ['ddsa_code' => '122201', 'name' => '-', 'level' => 1, 'district_id' => '1222'],
            /*
             * === PITAS
             */
            ['ddsa_code' => '122301', 'name' => '-', 'level' => 1, 'district_id' => '1223'],
            /*
             * === KUNAK
             */
            ['ddsa_code' => '122401', 'name' => '-', 'level' => 1, 'district_id' => '1224'],
            /*
             * === TONGOD
             */
            ['ddsa_code' => '122501', 'name' => '-', 'level' => 1, 'district_id' => '1225'],
            /*
             * === PUTATAN
             */
            ['ddsa_code' => '122601', 'name' => '-', 'level' => 1, 'district_id' => '1226'],
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
