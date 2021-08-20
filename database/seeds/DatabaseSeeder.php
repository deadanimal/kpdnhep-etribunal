<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(XrefSubdistrictsJohorSeeder::class);
//        $this->call(XrefSubdistrictsKedahSeeder::class);
//        $this->call(XrefSubdistrictsPahangSeeder::class);
//        $this->call(XrefSubdistrictsPerakSeeder::class);
//        $this->call(XrefSubdistrictsPerlisSeeder::class);
//        $this->call(XrefSubdistrictsPulauPinangSeeder::class);
//        $this->call(XrefSubdistrictsSabahSeeder::class);
//        $this->call(XrefSubdistrictsSarawakSeeder::class);
//        $this->call(XrefSubdistrictsSelangorSeeder::class);
//        $this->call(XrefSubdistrictsTerengganuSeeder::class);
//        $this->call(XrefSubdistrictsWilayahSeeder::class);

        $this->call(XrefSubdistrictsKelantanSeeder::class);
        $this->call(XrefSubdistrictsMelakaSeeder::class);
        $this->call(XrefSubdistrictsNegeriSembilanSeeder::class);

//        $this->call(MasterPostcodesTableSeeder::class);
//        $this->call(MasterBranchAddressTableSeeder::class);
    }
}
