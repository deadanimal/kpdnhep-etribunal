<?php

use App\MasterModel\MasterBranchAddress;
use Illuminate\Database\Seeder;

class MasterBranchAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_seeds = [
            // johor
            ['state_id' => 1,
                'branch_name' => 'Johor Bahru',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Johor, Aras 17 & 17A, Menara Ansar, Jalan Trus, 80000 Johor Bahru, Johor.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Johor, Aras 17 & 17A, Menara Ansar, Jalan Trus, 80000 Johor Bahru, Johor.'
            ],
            ['state_id' => 1,
                'branch_name' => 'Batu Pahat',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Batu Pahat,Aras 6, Wisma Sin Long, 83000 Batu Pahat, Johor.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Batu Pahat,Aras 6, Wisma Sin Long, 83000 Batu Pahat, Johor.'
            ],
            ['state_id' => 1,
                'branch_name' => 'Kluang',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kluang, Tingkat 1, Bangunan Pesekutuan Km. 4, Jalan Batu Pahat, 86000 Kluang, Johor.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kluang, Tingkat 1, Bangunan Pesekutuan Km. 4, Jalan Batu Pahat, 86000 Kluang, Johor.'
            ],
            ['state_id' => 1,
                'branch_name' => 'Muar',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Muar, No. 134-10, Tingkat  1, Bangunan Hokkein Association, Jln Salleh, 84000 Muar, Johor.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Muar, No. 134-10, Tingkat  1, Bangunan Hokkein Association, Jln Salleh, 84000 Muar, Johor.'
            ],
            // kedah
            ['state_id' => 2,
                'branch_name' => 'Alor Setar',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Kedah, Aras G, Zon C, Wisma Persekutuan, Pusat Pentadbiran Kerajaan Persekutuan, Bandar Muadzam Shah, 06550 Alor Setar, Kedah.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Kedah, Aras G, Zon C, Wisma Persekutuan, Pusat Pentadbiran Kerajaan Persekutuan, Bandar Muadzam Shah, 06550 Alor Setar, Kedah.'
            ],
            ['state_id' => 2,
                'branch_name' => 'Sungai Petani',
                'address_my' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Sungai Petani, Tingkat 2, Wisma Ria, Kampung Ayer Mendidih, 08000 Sungai Petani, Kedah.',
                'address_en' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Sungai Petani, Tingkat 2, Wisma Ria, Kampung Ayer Mendidih, 08000 Sungai Petani, Kedah.'
            ],
            ['state_id' => 2,
                'branch_name' => 'Kulim',
                'address_my' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kulim, 97, Lorong Kota Kenari 5/1, Taman Kenari, 09000 Kulim, Kedah.',
                'address_en' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kulim, 97, Lorong Kota Kenari 5/1, Taman Kenari, 09000 Kulim, Kedah.'
            ],
            ['state_id' => 2,
                'branch_name' => 'Langkawi',
                'address_my' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Langkawi, Langkawi Mall, Lot 120 & 122, Persiaran Bunga Raya, 07000 Langkawi, Kedah.',
                'address_en' => 'Ketua Cawangan, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Langkawi, Langkawi Mall, Lot 120 & 122, Persiaran Bunga Raya, 07000 Langkawi, Kedah.'
            ],
            // kelantan
            ['state_id' => 3,
                'branch_name' => 'Kota Bharu',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri dan Hal-Ehwal Pengguna, Tingkat Bawah, Menara Perbadanan, Jalan Tengku Petra Semerak, 15000 Kota Bharu, Kelantan.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri dan Hal-Ehwal Pengguna, Tingkat Bawah, Menara Perbadanan, Jalan Tengku Petra Semerak, 15000 Kota Bharu, Kelantan.'
            ],
            // melaka
            ['state_id' => 4,
                'branch_name' => 'Ayer Keroh',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Melaka, Aras 6, Wisma Persekutuan, Jalan MITC, Hang Tuah Jaya, 75450 Melaka.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Melaka, Aras 6, Wisma Persekutuan, Jalan MITC, Hang Tuah Jaya, 75450 Melaka.'
            ],
            // negeri sembilan
            ['state_id' => 5,
                'branch_name' => 'Seremban',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Sembilan, No. D9, Tingkat Bawah - Tingkat 1, Bangunan Akhma, Persiaran Utama S2-1, Seremban 2, 70300 Seremban, Negeri Sembilan.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Sembilan, No. D9, Tingkat Bawah - Tingkat 1, Bangunan Akhma, Persiaran Utama S2-1, Seremban 2, 70300 Seremban, Negeri Sembilan.'
            ],
            // pahang
            ['state_id' => 6,
                'branch_name' => 'Kuantan',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Pahang, Blok C, Kompleks Wisma Belia, Indera Mahkota, 25200 Kuantan, Pahang.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Pahang, Blok C, Kompleks Wisma Belia, Indera Mahkota, 25200 Kuantan, Pahang.'
            ],
            ['state_id' => 6,
                'branch_name' => 'Temerloh',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Temerloh, No. 2 Jalan Pak Sako 3, Bandar Sri Semantan, 28000, Temerloh, Pahang.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Temerloh, No. 2 Jalan Pak Sako 3, Bandar Sri Semantan, 28000, Temerloh, Pahang.'
            ],
            // perak
            ['state_id' => 7,
                'branch_name' => 'Ipoh',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Perak,Tingkat 1, Blok A, Bangunan Persekutuan Ipoh, Jalan Dato\' Seri Ahmad Said, 30450 Ipoh, Perak.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Perak,Tingkat 1, Blok A, Bangunan Persekutuan Ipoh, Jalan Dato\' Seri Ahmad Said, 30450 Ipoh, Perak.'
            ],
            // perlis
            ['state_id' => 8,
                'branch_name' => 'Kangar',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Perlis,Tingkat Bawah,  Bangunan Persekutuan, Persiaran Jubli Emas, 01000 Kangar, Perlis.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Perlis,Tingkat Bawah,  Bangunan Persekutuan, Persiaran Jubli Emas, 01000 Kangar, Perlis.'
            ],
            // pulau pinang
            ['state_id' => 9,
                'branch_name' => 'Georgetown',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Pulau Pinang, Tingkat 8, Bangunan Tuanku Syed Putra, Lebuh Downing,10300 Georgetown,Pulau Pinang.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Pulau Pinang, Tingkat 8, Bangunan Tuanku Syed Putra, Lebuh Downing,10300 Georgetown,Pulau Pinang.'
            ],
            ['state_id' => 9,
                'branch_name' => 'Seberang Perai Tengah',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Seberang Perai Tengah, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Unit 5,Tingkat 1, Kompleks Sempilai Jaya, Jalan Sempilai,13700 Seberang Perai Tengah, Pulau Pinang.',
                'address_en' => 'Chief Enforcement Officer Cawangan Seberang Perai Tengah, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Unit 5,Tingkat 1, Kompleks Sempilai Jaya, Jalan Sempilai,13700 Seberang Perai Tengah, Pulau Pinang.'
            ],
            ['state_id' => 9,
                'branch_name' => 'Seberang Perai Utara',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Seberang Perai Utara, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, No.96 & 98, Persiaran Seksyen 4/9, Bandar Putra Bertam,13200 Kepala Batas, Pulau Pinang.',
                'address_en' => 'Chief Enforcement Officer Cawangan Seberang Perai Utara, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, No.96 & 98, Persiaran Seksyen 4/9, Bandar Putra Bertam,13200 Kepala Batas, Pulau Pinang.'
            ],
            // sabah
            ['state_id' => 10,
                'branch_name' => 'Kota Kinabalu',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Sabah , Blok A, Aras 4, Kompleks Pentadbiran Kerajaan Persekutuan Sabah, Jalan UMS, 88450 Kota Kinabalu, Sabah.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Sabah , Blok A, Aras 4, Kompleks Pentadbiran Kerajaan Persekutuan Sabah, Jalan UMS, 88450 Kota Kinabalu, Sabah.'
            ],
            ['state_id' => 10,
                'branch_name' => 'Tawau',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Tawau, Tingkat 1, Wisma Persekutuan, Jalan Dunlop, Bandar Sabindo, 91000 Tawau, Sabah.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Tawau, Tingkat 1, Wisma Persekutuan, Jalan Dunlop, Bandar Sabindo, 91000 Tawau, Sabah.'
            ],
            ['state_id' => 10,
                'branch_name' => 'Sandakan',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Sandakan, Tingkat 1, Wisma Persekutuan Sandakan, Batu 7, Jalan Labuk, W.D.T. 11, 90500 Sandakan, Sabah.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Sandakan, Tingkat 1, Wisma Persekutuan Sandakan, Batu 7, Jalan Labuk, W.D.T. 11, 90500 Sandakan, Sabah.'
            ],
            // sarawak
            ['state_id' => 11,
                'branch_name' => 'Kuching',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Sarawak, No.41-51, Jalan Tun Jugah, 93350 Kuching, Sarawak.',
                'address_en' => 'Chief Enforcement Officer Negeri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Negeri Sarawak, No.41-51, Jalan Tun Jugah, 93350 Kuching, Sarawak.'
            ],
            ['state_id' => 11,
                'branch_name' => 'Miri',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Miri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Miri, Tingkat 5 & 6, Wisma Yu Lan, Jalan Brooke, 98000 Miri, Sarawak.',
                'address_en' => 'Chief Enforcement Officer Cawangan Miri, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Miri, Tingkat 5 & 6, Wisma Yu Lan, Jalan Brooke, 98000 Miri, Sarawak.'
            ],
            ['state_id' => 11,
                'branch_name' => 'Sibu',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Sibu, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Sibu,  Tingkat 1, Wisma Persekutuan Blok 3, Persiaran Brooke, 96000 Sibu, Sarawak.',
                'address_en' => 'Chief Enforcement Officer Cawangan Sibu, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Sibu,  Tingkat 1, Wisma Persekutuan Blok 3, Persiaran Brooke, 96000 Sibu, Sarawak.'
            ],
            ['state_id' => 11,
                'branch_name' => 'Bintulu',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Bintulu , Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Bintulu, Lot 2141, Bintulu Town District, Jalan Tun Razak, 97000 Bintulu, Sarawak.',
                'address_en' => 'Chief Enforcement Officer Cawangan Bintulu , Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna Cawangan Bintulu, Lot 2141, Bintulu Town District, Jalan Tun Razak, 97000 Bintulu, Sarawak.'
            ],
            ['state_id' => 11,
                'branch_name' => 'Limbang',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Limbang, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Lot 1987, Jalan Buang Siol, 98700 Limbang , Sarawak.',
                'address_en' => 'Chief Enforcement Officer Cawangan Limbang, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Lot 1987, Jalan Buang Siol, 98700 Limbang , Sarawak.'
            ],
            ['state_id' => 11,
                'branch_name' => 'Lawas',
                'address_my' => 'Ketua Pegawai Penguatkuasa Cawangan Lawas, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Tingkat 3, Wisma Persekutuan Lawas, Jalan Gaya, 98850 Lawas, Sarawak.',
                'address_en' => 'Chief Enforcement Officer Cawangan Lawas, Kementerian Perdagangan Dalam Negeri dan Hal Ehwal Pengguna, Tingkat 3, Wisma Persekutuan Lawas, Jalan Gaya, 98850 Lawas, Sarawak.'
            ],
            // selangor
            ['state_id' => 12,
                'branch_name' => 'Shah Alam',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Seksyen Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Selangor,  Tingkat 20, Menara Bank Rakyat Shah Alam, Jalan Majlis, Seksyen 14, 40622 Shah Alam, Selangor.',
                'address_en' => 'Chief Enforcement Officer, Seksyen Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Selangor,  Tingkat 20, Menara Bank Rakyat Shah Alam, Jalan Majlis, Seksyen 14, 40622 Shah Alam, Selangor.'
            ],
            // terengganu
            ['state_id' => 13,
                'branch_name' => 'Kuala Terengganu',
                'address_my' => 'Ketua Pegawai Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Terengganu, Lot 3657, Jalan Sultan Sulaiman, 20000 Kuala Terengganu.',
                'address_en' => 'Ketua Pegawai Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Negeri Terengganu, Lot 3657, Jalan Sultan Sulaiman, 20000 Kuala Terengganu.'
            ],
            ['state_id' => 13,
                'branch_name' => 'Kemaman',
                'address_my' => 'Ketua Pegawai Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kemaman, Lot. 5631, Km. 2, Jalan Ayer Puteh, 23000 Kemaman, Terengganu.',
                'address_en' => 'Ketua Pegawai Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Cawangan Kemaman, Lot. 5631, Km. 2, Jalan Ayer Puteh, 23000 Kemaman, Terengganu.'
            ],
            // wpkl
            ['state_id' => 14,
                'branch_name' => 'Kuala Lumpur',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Seksyen Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Wilayah Persekutuan Kuala Lumpur, Tingkat 26, Sunway Putra Tower, 100, Jalan Putra, 50622 Kuala Lumpur.',
                'address_en' => 'Chief Enforcement Officer, Seksyen Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Wilayah Persekutuan Kuala Lumpur, Tingkat 26, Sunway Putra Tower, 100, Jalan Putra, 50622 Kuala Lumpur.'
            ],
            // wpl
            ['state_id' => 15,
                'branch_name' => 'WP Labuan',
                'address_my' => 'Ketua Pegawai Penguatkuasa Negeri,Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, 15B, Tingkat 15, Blok 4, Kompleks Ujana Kewangan, 87000 W.P Labuan.',
                'address_en' => 'Chief Enforcement Officer Negeri,Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, 15B, Tingkat 15, Blok 4, Kompleks Ujana Kewangan, 87000 W.P Labuan.'
            ],
            // wppj
            ['state_id' => 16,
                'branch_name' => 'Putrajaya',
                'address_my' => 'Ketua Pegawai Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, No. 13, Persiaran Perdana, Presint 2, Pusat Pentadbiran Kerajaan Persekutuan, 62623 W.P Putrajaya.',
                'address_en' => 'Chief Enforcement Officer, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, No. 13, Persiaran Perdana, Presint 2, Pusat Pentadbiran Kerajaan Persekutuan, 62623 W.P Putrajaya.'
            ],
        ];

        foreach ($data_seeds as $seed) {
            $mba = MasterBranchAddress::create($seed);

            dump($mba);
        }
    }
}
