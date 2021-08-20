<head>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
        }

        td, th {
            font-family: serif !important;
            padding: 10px;
            font-size: 14px;
            line-height: 25px;

        }

        span, a, p, h1, h2 {
            font-family: serif !important;
        }

        span, a, p {
            font-size: 18px;
            line-height: 25px;

        }

        p {
            text-indent: 30px;
        }

        .justify {
            text-align: justify;
        }

        .bold {
            font-weight: bold;
        }

        .border {
            border: 1px solid black;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .lowercase {
            text-transform: lowercase;
        }

        .italic {
            font-style: italic;
        }

        .camelcase {
            text-transform: capitalize;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .break {
            page-break-before: always;
            margin-top: 25px;
        }

        .divider {
            width: 5px;
            vertical-align: top;
        }

        .no-padding {
            padding: 0px;
        }

        .fit {
            max-width: 100%;
            white-space: nowrap;
        }

        .absolute-center {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        .top {
            vertical-align: top;
        }

        .watermark {
            padding: 25px;
            background-image: url('{{ url('images/ttpm_watermark.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
        }

        .parent {
            position: relative;
        }

        .child {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="center">

<div class='watermark'>
    <span class='bold uppercase'>AKTA PERLINDUNGAN PENGGUNA 1999</span><br><br>
    <span class='bold uppercase'>PERATURAN-PERATURAN PERLINDUNGAN PENGGUNA</span><br>
    <span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>
    <span class='uppercase'>JADUAL KEDUA</span><br><br>
    <span class='uppercase'>BORANG-BORANG</span><br><br>
    <span class=''>(Peraturan 4)</span><br><br>
    <span class='bold uppercase'>Borang 1</span><br><br>
    <span class=''>(Peraturan 5)</span><br><br>
    <span class='bold uppercase italic'>PERNYATAAN TUNTUTAN</span><br><br>
    <span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
    <span class='uppercase'>DI </span>
    <span class='bold uppercase'>{{ $claim->venue ? $claim->venue->hearing_venue : '-' }}</span><br>
    <span class='uppercase'>DI NEGERI </span>
    <span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
    <span class='uppercase'> MALAYSIA</span><br>
    <span class='uppercase'>TUNTUTAN NO: </span>
    <span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

    <table class='border'>
        <tr>
            <td class='camelcase top'>Nama Pihak Yang Menuntut</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->claimant_address->name }}</td>
        </tr>
        <tr>
            <td class='camelcase top'>No. Kad Pengenalan</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->claimant_address->identification_no }}</td>
        </tr>
        @if($extraOpponent)
            <tr>
                <td class='top'>Nama Pihak Yang Menuntut 2</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $claim->extraClaimant->name }}</td>
            </tr>
            <tr>
                <td class='camelcase top'>No. Kad Pengenalan</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $claim->extraClaimant->identification_no }}</td>
            </tr>
        @endif
        <tr>
            <td class='camelcase top'>Alamat</td>
            <td class='divider'>:</td>
            <td class='uppercase'>
                {{ $claim->claimant_address->street_1 }},
                {{ $claim->claimant_address->street_2 ? $claim->claimant_address->street_2."," : "" }}
                {{ $claim->claimant_address->street_3 ? $claim->claimant_address->street_3."," : "" }}
                {{ $claim->claimant_address->postcode }}
                {{ $claim->claimant_address->subdistrict ? $claim->claimant_address->subdistrict->name : ($claim->claimant_address->district ? $claim->claimant_address->district->district : '') }},
                {{ $claim->claimant_address->state ? $claim->claimant_address->state->state : '' }}
            </td>
        </tr>
        <tr>
            <td class='camelcase top'>No. Tel. / No. HP. / No. Faks</td>
            <td class='divider'>:</td>
            <td class='uppercase'>
                {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_home : '-' }}
                / {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_mobile : '-' }}
                / {{ $claim->claimant_address->phone_fax or '-' }}
            </td>
            <td class='camelcase fit top'></td>
            <td class='divider'>:</td>
            <td class='uppercase'></td>
        </tr>
        <tr>
            <td class='top' style='width: 35%'>E-mel</td>
            <td class='divider'>:</td>
            <td class='lowercase'>{{ $claim->claimant_address->email }}</td>
        </tr>
    </table>

    @foreach($claim->multiOpponents as $cco)
        <table class='border'>
            <tr>
                <td class='camelcase top'>Nama Penentang</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $cco->opponent_address ? $cco->opponent_address->name : '' }}</td>
            </tr>
            <tr>
                <td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $cco->opponent_address ? $cco->opponent_address->identification_no : '' }}</td>
            </tr>
            <tr>
                <td class='camelcase top'>Alamat</td>
                <td class='divider'>:</td>
                <td class='uppercase'>
                    @if($cco->opponent_address)
                        {{ $cco->opponent_address->street_1 }},
                        {{ $cco->opponent_address->street_2 ? $cco->opponent_address->street_2."," : "" }}
                        {{ $cco->opponent_address->street_3 ? $cco->opponent_address->street_3."," : "" }}
                        {{ $cco->opponent_address->postcode }}
                        {{ $cco->opponent_address->subdistrict ? $cco->opponent_address->subdistrict->name : ($cco->opponent_address->district ? $cco->opponent_address->district->district : '') }},
                        {{ $cco->opponent_address->state ? $cco->opponent_address->state->state : '' }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class='camelcase top'>No. Tel. / No. HP. / No. Faks</td>
                <td class='divider'>:</td>
                <td class='uppercase'>
                    {{ $cco->opponent_address ? ($cco->opponent_address->is_company == 0 ? $cco->opponent_address->phone_home : ($cco->opponent_address->phone_office ? $cco->opponent_address->phone_office : '-')) : '' }}
                    / {{ $cco->opponent_address ? ($cco->opponent_address->is_company == 0 ? $cco->opponent_address->phone_mobile : '-') : '' }}
                    / {{ $cco->opponent_address->phone_fax or '-' }}
                </td>
            </tr>
            <tr>
                <td class='top' style='width: 35%'>E-mel</td>
                <td class='divider'>:</td>
                <td class='lowercase'>{{ $cco->opponent_address ? $cco->opponent_address->email : '' }}</td>
            </tr>
        </table>
    @endforeach
</div>

<div class='left break watermark'>
    <span class='camelcase'>Pernyataan :</span>
    <table class='border'>
        <tr>
            <td>
                Tuntutan Pihak Yang Menuntut ialah untuk jumlah
                <span class='bold'>RM{{ number_format($claim->form1->claim_amount, 2, '.', ',') }}</span>
            </td>
        </tr>
    </table>

    <table class='border'>
        <tr>
            <td class='bold'>
                Butir-butir tuntutan :
            </td>
        </tr>
        <tr style="height: 150px; vertical-align: top;">
            <td>
                Tarikh Transaksi / Pembelian
                : {{ $claim->form1->purchased_date ? date('d/m/Y', strtotime($claim->form1->purchased_date.' 00:00:00')) : '-' }}
                <br>
                Telah membeli / menggunakan : {{ $claim->form1->purchased_item_name or '-'}} <br>
                Model / Jenama : {{ $claim->form1->purchased_item_brand or '-' }} <br>
                Jumlah Bayaran : RM {{ $claim->form1->purchased_amount or '-'}} <br>
                Saya tidak berpuas hati kerana : <br>
                {!! strlen($claim->form1->claim_details) > 300 ? mb_substr($claim->form1->claim_details, 0, 300).'... (Sila Rujuk Lampiran A)' : $claim->form1->claim_details !!}
            </td>
        </tr>
    </table>

    <table style="margin-top: 100px;">
        <tr>
            <td class='center no-padding' style="width: 40%">................................................</td>
            <td style="width: 20%"></td>
            <td class='center no-padding' style="width: 40%">................................................</td>
        </tr>
        <tr>
            <td class='center italic no-padding top'>Tarikh</td>
            <td style="width: 20%"></td>
            <td class='center italic no-padding top'>Tandatangan / Cap ibu jari kanan Pihak Yang Menuntut</td>
        </tr>
    </table>

    <table style="margin-top: 100px;">
        <tr>
            <td class='center no-padding'
                    style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim->form1->processed_at)).' '.localeMonth(date('F', strtotime($claim->form1->processed_at))).' '.date('Y', strtotime($claim->form1->processed_at)) }}</td>
            <td style="width: 20%"></td>
            <td class='center no-padding' style="width: 40%; position: relative; ">
                ................................................
                <img class="absolute-center" style="width: 200px; bottom: 200%; z-index: -1;"
                     src="{{ route('general-getsignature', ['ttpm_user_id' => $claim->psu_user_id]) }}"/>
            </td>
        </tr>
        <tr>
            <td class='center italic no-padding top'>Tarikh Pemfailan</td>
            <td style="width: 20%"></td>
            <td class='center no-padding'>
                <span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
                <span class='uppercase'>{{ $claim->psu->roleuser->first()->role->display_name_my }}<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span><br>
            </td>
        </tr>
    </table>

    <div class='parent' style="text-align: center;">
        <img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px'/>
        <span style="margin-left: -45px" class="child">(METERAI)</span>
    </div>
</div>

<div class='left break watermark'>
    <span class='bold uppercase'>KEPADA PENENTANG :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;"></td>
            <td class="justify">Jika anda mempertikaikan tuntutan Pihak Yang Menuntut, anda hendaklah memfailkan
                pertanyaan pembelaan anda dalam Borang 2 ("Pernyataan pembelaan") dalam masa empat belas hari selepas
                penyerahan pernyataan tuntutan.
            </td>
        </tr>
    </table>

    <br><br>

    <span class='bold uppercase'>ARAHAN KEPADA PIHAK YANG MENUNTUT :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;">1.</td>
            <td class="justify">Pihak Yang Menuntut hendaklah mengisi nama penuhnya dan nombor kad pengenalannya dalam
                ruang yang disediakan.
            </td>
        </tr>
        <tr>
            <td class='top'>2.</td>
            <td class="justify">Pihak Yang Menuntut hendaklah mengisi nama penuh Penentang dan alamatnya yang terakhir
                diketahui dalam ruang yang disediakan.
            </td>
        </tr>
        <tr>
            <td class='top'>3.</td>
            <td class="justify">Pihak Yang Menuntut hendaklah menyatakan amaun tepat yang dituntut dalam ruang yang
                disediakan. Amaun yang dituntut itu tidak boleh melebihi RM50,000.00. Jika amaun itu melebihi
                RM50,000.00 maka tuntutan itu hendaklah difaikan di Mahkamah Majistret Kelas Satu.
            </td>
        </tr>
        <tr>
            <td class='top'>4.</td>
            <td class="justify">Pihak Yang Menuntut hendaklah menyatakan butir-butir tuntutannya dalam ruang yang
                disediakan. Butir-butir itu hendaklah menyatakan tarikh yang berkaitan dan bagaimana tuntutan itu telah
                berbangkit atau apakah asas tuntutan itu.
            </td>
        </tr>
        <tr>
            <td class='top'>5.</td>
            <td class="justify">Jika ruang yang disediakan tidak mencukupi, sila gunakan helaian kertas yang berasingan
                dan tuliskan "sila lihat muka sebelah". Apa-apa helaian kertas yang digunakan hendaklah dilampirkan
                bersama Borang ini.
            </td>
        </tr>
        <tr>
            <td class='top'>6.</td>
            <td class="justify">Setelah mengisikan butir-butir, Pihak Yang Menuntut hendaklah menandatangani Borang ini
                sendiri.
            </td>
        </tr>
        <tr>
            <td class='top'>7.</td>
            <td class="justify">Setelah menyiapkan Borang ini, Pihak Yang Menuntut hendaklah memfailkan Borang ini dalam
                4 salinan di Pejabat Pendaftaran Tribunal. Pihak Yang Menuntut hendaklah membayar fi pemfailan sebanyak
                RM5.00. Pejabat Pendaftaran akan meletakkan meterai Tribunal pada 4 salinan itu. Dua salinan Borang ini
                akan dikembalikan kepada Pihak Yang Menuntut.
            </td>
        </tr>
        <tr>
            <td class='top'>8.</td>
            <td class="justify">
                Anda tidak boleh diwakili oleh peguam pada pendengaran itu.<br><br>
                <!-- div class='border' style="padding: 10px">
                    <span class='bold uppercase'>NOTA MUSTAHAK KEPADA PIHAK YANG MENUNTUT :</span>

                    <table>
                        <tr>
                            <td class='top' style="width: 20px;">1.</td>
                            <td class="justify">
                                Pihak Yang Menuntut hendaklah menyerahkan Borang 1 kepada Penentang dengan -<br>
                                <table>
                                    <tr>
                                        <td class='top' style="padding-left: 0px;">(i)</td>
                                        <td>Pos berdaftar Akuan Terima (A.T); atau</td>
                                    </tr>
                                    <tr>
                                        <td class='top' style="padding-left: 0px;">(ii)</td>
                                        <td>memberikannya kepada Penentang sendiri, dengan serta-merta.</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class='top'>2.</td>
                            <td>
                                Kad A.T. hendaklah dibawa semasa pendengaran.
                            </td>
                        </tr>
                    </table>
                </div -->
            </td>
        </tr>
    </table>
</div>

<div class='left break watermark'>
    <span class='bold uppercase'>ARAHAN KEPADA PENENTANG :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;">1.</td>
            <td class="justify">Apabila anda menerima Borang ini yang dimeteraikan dengan meterai Tribunal, anda adalah
                didakwa oleh Pihak Yang Menuntut.
            </td>
        </tr>
        <tr>
            <td class='top'>2.</td>
            <td class="justify">Jika anda mempertikaikan tuntutan itu anda hendaklah menyatakan pembelaan anda, dengan
                butir-butir, dalam Borang 2.
            </td>
        </tr>
        <tr>
            <td class='top'>3.</td>
            <td class="justify">Anda hendaklah memfailkan pernyataan pembelaan anda di Pejabat Pendaftaran Tribunal.
            </td>
        </tr>
        <tr>
            <td class='top'>4.</td>
            <td class="justify">Jika anda gagal memfailkan pembelaan anda dalam masa yang ditetapkan atau jika anda
                gagal hadir di hadapan Tribunal pada tarikh pendengaran, maka Tribunal akan membuat award dengan memihak
                kepada Pihak Yang Menuntut.
            </td>
        </tr>
        <tr>
            <td class='top'>5.</td>
            <td class="justify">Anda tidak boleh diwakili oleh peguam pada pendengaran itu.</td>
        </tr>
        <tr>
            <td class='top'>6.</td>
            <td class="justify">Anda dikehendaki menyerahkan Borang 2 kepada Pihak Yang Menuntut.</td>
        </tr>
        <tr>
            <td class='top'></td>
            <td>
                <br><br><br><br>
                <span class="camelcase">Sila Kembalikan Ke :-</span><br><br><br>

                <span class="italic camelcase">Ketua Seksyen,</span><br>
                <span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
                <span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
                <span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
                <span class="italic">{{ $claim->branch->branch_postcode }}</span>
                <span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
                <span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
                <span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
                <span class="italic">Faks: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
                <span class="italic">Talian Bebas Tol: 1800-88-9811</span><br>
                <span class="italic">E-mel: </span><span
                        class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
            </td>
        </tr>
    </table>
</div>

<div class='left break watermark'>

    <div class="center">
        <h1 style="text-decoration: underline;">Sistem e-Tribunal</h1><br><br><br><br><br>

        <table class="border" style="margin: 20px 10%; width: 80%;">
            <tr>
                <td class='camelcase' style="width: 30%">No. Tuntutan</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $claim->case_no }}</td>
            </tr>
            <tr>
                <td class='camelcase'>Tarikh Pendengaran</td>
                <td class='divider'>:</td>
                <td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
            </tr>
            <tr>
                <td class='camelcase'>Masa Pendengaran</td>
                <td class='divider'>:</td>
                <td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
            </tr>
            <tr>
                <td class='camelcase'>No. Resit Borang 1</td>
                <td class='divider'>:</td>
                <td>{{ $claim->form1->payment ? $claim->form1->payment->receipt_no : '-' }}</td>
            </tr>
        </table>
    </div>

    <br><br>

    <p class="justify">Terima kasih kerana berurusan dengan Tribunal Tuntutan Pengguna Malaysia. Sila simpan dokumen ini
        sebagai rujukan.</p>
</div>

<div class='left break watermark'>

    <div class="center">
        <h1 style="text-decoration: underline;">Lampiran A</h1><br><br><br><br><br>

        <table class='border'>
            <tr>
                <td class='bold'>
                    Keterangan pernyataan tuntutan:
                </td>
            </tr>
            <tr style="height: 150px; vertical-align: top;">
                <td>
                    {!! nl2br($claim->form1->claim_details) !!}
                </td>
            </tr>
        </table>
    </div>

    <br><br>

    <p class="justify">Terima kasih kerana berurusan dengan Tribunal Tuntutan Pengguna Malaysia. Sila simpan dokumen ini sebagai rujukan.</p>
</div>

</body>
