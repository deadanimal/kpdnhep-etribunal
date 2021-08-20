<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute perlulah diterima.',
    'active_url'           => ':attribute bukan URL yang sah',
    'after'                => ':attribute hendaklah tarikh selepas :date.',
    'after_or_equal'       => ':attribute hendaklah tarkih yang sama atau selepas :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandungi huruf, nombor dan sempang.',
    'alpha_num'            => ':attribute hanya boleh mengandungi huruf dan nombor.',
    'array'                => ':attribute hendaklah suatu senarai.',
    'before'               => ':attribute hendaklah tarikh sebelum :date.',
    'before_or_equal'      => ':attribute hendaklah tarikh yang sama atau sebelum :date.',
    'between'              => [
        'numeric' => ':attribute hendaklah di antara :min dan :max.',
        'file'    => ':attribute hendaklah di antara :min dan :max kilobytes.',
        'string'  => ':attribute hendaklah di antara :min dan :max aksara.',
        'array'   => ':attribute hendaklah di antara :min dan :max item.',
    ],
    'boolean'              => 'Ruang :attribute hendaklah sama ada betul atau salah.',
    'confirmed'            => 'Pengesahan :attribute tidak sepadan.',
    'date'                 => ':attribute bukan tarikh yang sah.',
    'date_format'          => ':attribute tidak sepadan dengan format :format.',
    'different'            => ':attribute dan :other hendaklah berbeza.',
    'digits'               => ':attribute hendaklah :digits digit.',
    'digits_between'       => ':attribute hendaklah di antara :min dan :max digit.',
    'dimensions'           => ':attribute mempunyai dimensi imej yang tidak sah.',
    'distinct'             => 'Ruang :attribute mempunyai nilai yang sama.',
    'email'                => ':attribute hendaklah emel yang sah.',
    'exists'               => 'Ruang :attribute yang terpilih tidak sah.',
    'file'                 => ':attribute hendaklah dalam format fail.',
    'filled'               => 'Ruang :attribute hendaklah mempunyai nilai.',
    'image'                => ':attributehendaklah dalam format imej.',
    'in'                   => 'Ruang :attribute yang terpilih adalah tidak sah.',
    'in_array'             => 'Ruang :attribute tidak wujud dalam :other.',
    'integer'              => ':attribute hendaklah dalam format integer.',
    'ip'                   => ':attribute hendaklah dalam format alamat IP yang sah.',
    'ipv4'                 => ':attribute hendaklah dalam format alamat IPv4 yang sah.',
    'ipv6'                 => ':attribute hendaklah dalam format alamat IPv6 yang sah.',
    'json'                 => ':attribute hendaklah dalam format JSON string yang sah.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh melebihi :max.',
        'file'    => ':attribute tidak boleh melebihi :max kilobyte.',
        'string'  => ':attribute tidak boleh melebihi :max aksara.',
        'array'   => ':attribute tidak boleh melebihi :max item.',
    ],
    'mimes'                => ':attribute hendaklah dalam format fail jenis: :values.',
    'mimetypes'            => ':attribute hendaklah dalam format fail jenis: :values.',
    'min'                  => [
        'numeric' => ':attribute hendaklah sekurang-kurangnya :min.',
        'file'    => ':attribute hendaklah sekurang-kurangnya :min kilobyte.',
        'string'  => ':attribute hendaklah sekurang-kurangnya :min aksara.',
        'array'   => ':attributehendaklah sekurang-kurangnya :min item.',
    ],
    'not_in'               => ':attribute yang terpilih tidak sah.',
    'numeric'              => ':attribute hendaklah dalam format nombor.',
    'present'              => 'Ruang :attribute hendaklah wujud.',
    'regex'                => 'Format :attribute tidak sah.',
    'required'             => 'Ruang :attribute perlu diisi.',
    'required_if'          => 'Ruang :attribute perlu diisi apabila nilai :other adalah :value.',
    'required_unless'      => 'Ruang :attribute perlu diisi melainkan jika nilai :other adalah :values.',
    'required_with'        => 'Ruang :attribute perlu diisi apabila nilai :values wujud.',
    'required_with_all'    => 'Ruang :attribute perlu diisi apabila nilai :values wujud.',
    'required_without'     => 'Ruang :attribute perlu diisi apabila nilai :values tidak wujud.',
    'required_without_all' => 'Ruang :attribute perlu diisi apabila tiada nilai :values yang wujud.',
    'same'                 => 'Ruang :attribute dan :other hendaklah sepadan.',
    'size'                 => [
        'numeric' => ':attribute hendaklah :size.',
        'file'    => ':attribute hendaklah mempunyai :size kilobyte.',
        'string'  => ':attribute hendaklah mempunyai :size aksara.',
        'array'   => ':attribute hendaklah mempunyai :size item.',
    ],
    'string'               => ':attribute hendaklah dalam format string.',
    'timezone'             => ':attribute hendaklah zon yang sah.',
    'unique'               => ':attribute telah diambil.',
    'uploaded'             => ':attribute tidak berjaya dimuat naik.',
    'url'                  => 'Format :attribute tidak sah.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'username' => 'Nama Pengguna',
        'password' => 'Kata Laluan',
        'repeat_password' => 'Ulangan Kata Laluan',
        'email' => 'Emel',
        'password_confirmation' => 'Pengesahan Kata Laluan',
        'address_street_1' => 'Alamat',
        'address_street_2' => 'Alamat 2',
        'address_street_3' => 'Alamat 3',
        'address_mailing_street_1' => 'Alamat Menyurat',
        'address_mailing_street_2' => 'Alamat Menyurat 2',
        'address_mailing_street_3' => 'Alamat Menyurat 3',
        'address_postcode' => 'Poskod',
        'address_state_id' => 'Negeri',
        'address_district_id' => 'Daerah',
        'phone_home' => 'No. Telefon Rumah',
        'phone_mobile' => 'No. Telefon Bimbit',
        'phone_office' => 'No. Telefon Pejabat',
        'phone_fax' => 'No. Faks',
        'race' => 'Bangsa',
        'occupation' => 'Pekerjaan',
        'country' => 'Negara',
        'identification_no' => 'No. Kad Pengenalan',
        'name' => 'Nama',

        'claimant_identification_no' => 'No. Identiti Pihak Yang Menuntut',
        'claimant_name' => 'Nama Pihak yang Menuntut',
        'claimant_street1' => 'Alamat 1',
        'claimant_postcode' => 'Poskod',
        'claimant_phone_mobile' => 'No. Telefon Bimbit',
        'claimant_phone_home' => 'No. Telefon Rumah',
        'claimant_email' => 'Emel',

        'branch_name' => 'Nama Cawangan',
        'branch_code' => 'Kod Cawangan',
        'branch_address' => 'Alamat Cawangan 1',
        'branch_address2' => 'Alamat Cawangan 2',
        'branch_address3' => 'Alamat Cawangan 3',
        'branch_postcode' => 'Poskod Cawangan',
        'branch_office_phone' => 'Telefon Pejabat Cawangan',
        'branch_email' => 'Emel Cawangan',

        'opponent_identification_no' => 'No. Identity Penentang',
        'opponent_name' => 'Nama Penentang',
        'opponent_street1' => 'Alamat',
        'opponent_postcode' => 'Poskod',
        'opponent_phone_home' => 'No. Telefon Rumah',
        'opponent_phone_mobile' => 'No. Telefon Bimbit',
        'opponent_phone_office' => 'No. Telefon Pejabat',
        'opponent_email' => 'Emel',
        'defence_statement' => 'Pernyataan Pembelaan',

        'representative_name' => 'Nama Wakil Syarikat',
        'representative_identification_no' => 'No. Kad Pengenalan',
        'representative_phone_mobile' => 'No. Telefon Bimbit',

        'user_type_id' => 'Jenis Pengguna',
        'display_name' => 'Nama Paparan',
        'description' => 'Butiran',
        'role_type' => 'Jenis Peranan',
        'nationality_country_id' => 'Kewarganegaraan',
        'company_no' => 'No. Pendaftaran Syarikat',
        'claim_amount' => 'Jumlah Tuntutan',
        'case_name' => 'Nama Mahkamah',
        'payment_postalorder' => 'Bayaran Wang Pos',
        'document_desc' => 'Butiran Dokumen',
        'total_counterclaim' => 'Jumlah Tuntutan Balas',
        'counterclaim_desc' => 'Keterangan Tuntutan Balas',
        'inquiry_msg' => 'Mesej Pertanyaan',
        'absence_reason' => 'Sebab Tidak Hadir',
        'complaints' => 'Aduan',
        'court_details' => 'Maklumat Mahkamah',
        'title_en' => 'Tajuk (Bahasa Inggeris)',
        'title_my' => 'Tajuk (Bahasa Malaysia)',
        'description_en' => 'Pengumuman (Bahasa Inggeris)',
        'description_my' => 'Pengumuman (Bahasa Malaysia)',
        'journal_desc' => 'Maklumat Jurnal',
        'branch_emel' => 'Emel Cawangan',
        'classification_en' => 'Klasifikasi (Bahasa Inggeris)',
        'classification_my' => 'Klasifikasi (Bahasa Malaysia)',
        'rcy_id' => 'Kod Klasifikasi',
        'category_en' => 'Kategori (Bahasa Inggeris)',
        'category_my' => 'Kategori (Bahasa Malaysia)',
        'category_code' => 'Kod Kategori',
        'hearing_room' => 'Bilik Pendengaran',
        'address' => 'Alamat',
        'hearing_venue' => 'Tempat Pendengaran',
        'occupation_en' => 'Pekerjaan (Bahasa Inggeris)',
        'occupation_my' => 'Pekerjaan (Bahasa Melayu)',
        'offence_description_en' => 'Kesalahan (Bahasa Inggeris)',
        'offence_description_my' => 'Kesalahan (Bahasa Melayu)',
        'offence_code' => 'Kod Kesalahan',
        'organization' => 'Organisasi',
        'org_address' => 'Alamat',
        'address1' => 'Alamat',
        'org_postcode' => 'Poskod',
        'org_office_phone' => 'No. Telefon Pejabat',
        'stop_reason_en' => 'Sebab Notis Henti (Bahasa Inggeris)',
        'stop_reason_my' => 'Sebab Notis Henti (Bahasa Melayu)',
        'stop_method_en' => 'Kaedah Notis Henti (Bahasa Inggeris)',
        'stop_method_my' => 'Kaedah Notis Henti (Bahasa Melayu)',
        'method_en' => 'Kaedah (Bahasa Inggeris)',
        'method_my' => 'Kaedah (Bahasa Melayu)',
        'code' => 'Kod',
        'salutation_en' => 'Panggilan (Bahasa Inggeris)',
        'salutation_my' => 'Panggilan (Bahasa Melayu)',
        'reason_en' => 'Tujuan (Bahasa Inggeris)',
        'reason_my' => 'Tujuan (Bahasa Melayu)',
        'term_en' => 'Tempoh (Bahasa Inggeris)',
        'term_my' => 'Tempoh (Bahasa Melayu)',
        'postcode' => 'Poskod',
        'court_name' => 'Nama Mahkamah',
        'designation_en' => 'Jawatan (Bahasa Inggeris)',
        'designation_my' => 'Jawatan (Bahasa Melayu)',
        'copy_address' => 'Alamat berlainan',
        'address_mailing_postcode' => 'Poskod',
        'type_en' => 'Jenis (Bahasa Inggeris)',
        'type_my' => 'Jenis (Bahasa Melayu)',
        'display_name_en' => 'Nama Paparan (Bahasa Inggeris)',
        'display_name_my' => 'Nama Paparan (Bahasa Melayu)',
        'receipt_no' => 'No Resit',
        'inquiry_feedback_msg' => 'Ulasan Maklum Balas',
        'extra_claimant_identification_no' => 'No. Kad Pengenalan Pihak Yang Menuntut Tambahan',
        'extra_claimant_nationality' => 'Kewarganegaraan Pihak Yang Menuntut Tambahan',
        'extra_claimant_relationship' => 'Hubungan Pihak Yang Menuntut Tambahan',
        'extra_claimant_name' => 'Name Pihak Yang Menuntut Tambahan',
        '' => '',
        '' => '',
        '' => '',
    ],

];
