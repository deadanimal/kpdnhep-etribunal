<html>
<head>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
        }

        td, th {
            font-family: serif !important;
            padding: 10px;
            font-size: 19px;
            line-height: 23px;
        }

        span, a, p, h1, h2 {
            font-family: serif !important;
        }

        span, a, p {
            font-size: 19px;
            line-height: 23px;
        }

        p {
            text-indent: 30px;
        }

        .justify {
            text-align: justify;
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

        .title {
            text-decoration: underline;
            font-weight: bold;
        }

        td {
            text-align: justify;
        }
    </style>
</head>
<body>
<?php
$locale = App::getLocale();
$address_lang = 'address_' . $locale;
?>
<div style="margin: 30px;padding-top: 150px">
    <table>
        <tr>
            <td style="width: 60%"></td>
            <td style="width: 40%; text-align: right;">
                {{ $form4->case->case_no }}<br>
                {{ date('d', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 20px;">
                <span class="title">Kepada Pihak Penentang</span><br><br>

                @if ($form4->claimCaseOpponent->opponent_address)
                    <span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->name }}</span>
                    <br>
                    {{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
                    @if ($form4->claimCaseOpponent->opponent_address->street_2)
                        {{ $form4->claimCaseOpponent->opponent_address->street_2 }},<br>
                    @endif
                    @if ($form4->claimCaseOpponent->opponent_address->street_3)
                        {{ $form4->claimCaseOpponent->opponent_address->street_3 }},<br>
                    @endif
                    <span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->postcode }} {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},</span>
                    <br>
                    {{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}
                    <br><br>

                @endif
                <br><br>
                Tuan/Puan,<br><br>
                <span style="font-weight: bold">No. Tuntutan {{ $form4->case->case_no }} </span><br><br>
                Bersama-sama dengan ini dilampirkan satu salinan award Tribunal untuk tindakan tuan/puan seperti
                berikut:

                <table>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(1)</td>
                        <td style="padding-top: 5px">Tuan/puan hendaklah mematuhi award ini dalam
                            masa {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_my) : 'hari' }}
                            daripada tarikh award ini diterima oleh tuan/puan atau hendaklah mematuhi award ini mengikut
                            tempoh masa yang telah ditetapkan di dalam award.
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(2)</td>
                        <td style="padding-top: 5px">Kegagalan tuan/puan mematuhi award ini dalam
                            masa {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_my) : 'hari' }}
                            dari tarikh award ini diterima oleh tuan / puan atau dalam masa yang telah ditetapkan dalam
                            award, adalah menjadi suatu kesalahan jenayah di bawah <span style="font-weight: bold">Seksyen 117 Akta Pelindungan Pengguna (APP) 1999</span>
                            seperti peruntukan yang berikut:

                            <table>
                                <tr>
                                    <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">
                                        (a)
                                    </td>
                                    <td style="padding-top: 5px"><span class="title">Seksyen 117(1) APP 1999</span><br>
                                        <span style="text-decoration: underline;">Kesalahan Pertama</span> - Denda tidak
                                        melebihi RM10,000 atau penjara selama tempoh tidak melebihi 2 tahun atau
                                        kedua-duanya.
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">
                                        (b)
                                    </td>
                                    <td style="padding-top: 5px"><span class="title">Seksyen 117(2) APP 1999</span><br>
                                        <span style="text-decoration: underline;">Kesalahan Yang Berterusan</span> -
                                        Sebagai tambahan kepada penalti di bawah seksyen 117 (1) di atas, didenda tidak 
										kurang daripada satu ratus ringgit dan tidak melebihi lima ribu ringgit bagi 
										setiap hari atau sebahagian hari selama kesalahan itu berterusan selepas sabitan.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if($form4->award->award_type != 9 && $form4->award->award_type != 10)
                        <tr>
                            <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(3)</td>
                            <td style="padding-top: 5px">Jika tuan/puan mempertikaikan award ini, tuan/puan boleh
                                mengetepikan award ini dengan memfailkan permohonan dalam Borang 12 dalam masa tiga
                                puluh hari selepas award diterima.
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="page-break-before: always; margin:30px;">
    <table>
        <tr>
            <td colspan="2">
                <span class="title">Kepada Pihak yang Menuntut</span><br><br>
                <span style="font-weight: bold; text-transform: uppercase;">{{ $form4->case->claimant->name }}</span><br>
                @if($form4->case->claimant_address->address_mailing_street_1)
                    {!! $form4->case->claimant_address->address_mailing_street_1 ? $form4->case->claimant_address->address_mailing_street_1.',<br>' : "" !!}
                    {!! $form4->case->claimant_address->address_mailing_street_2 ? $form4->case->claimant_address->address_mailing_street_2 .',<br>' : "" !!}
                    {!! $form4->case->claimant_address->address_mailing_street_3 ? $form4->case->claimant_address->address_mailing_street_3 .',<br>' : "" !!}
                    <span style="font-weight: bold; text-transform: uppercase;">
							{{ $form4->case->claimant_address->address_mailing_postcode ? $form4->case->claimant_address->address_mailing_postcode : "" }}
                        {!! $form4->case->claimant_address->address_mailing_district_id ? $form4->case->claimant_address->districtmailing->district .',<br>' : "" !!}
						</span>
                    {{ $form4->case->claimant_address->address_mailing_state_id ? $form4->case->claimant_address->statemailing->state : "" }}
                @else
                    {!! $form4->case->claimant_address->street_1 ? $form4->case->claimant_address->street_1.',<br>' : "" !!}
                    {!! $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2.',<br>' : "" !!}
                    {!! $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3.',<br>' : "" !!}
                    <span style="font-weight: bold; text-transform: uppercase;">
							{{ $form4->case->claimant_address->postcode ? $form4->case->claimant_address->postcode : '' }}
                        {!! $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district.',<br>' : '' !!}
						</span>
                    {{ $form4->case->claimant_address->state_id ? $form4->case->claimant_address->state->state : '' }}
                @endif
                <br><br>
                Jika Penentang gagal mematuhi award ini selepas
                tempoh {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_my) : 'hari' }}
                dari tarikh award ini di terima atau gagal mematuhi award ini mengikut tempoh masa yang telah ditetapkan
                dalam award, tuan / puan boleh:-

                <table>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(1)</td>
                        <td style="padding-top: 5px">
                            membuat aduan kepada
                            <span style="font-weight: bold">
                                {{$form4->letter_branch_address_id != null
                                    ? $form4->letterBranchAddress->address_my
                                    : (
                                        ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address : $form4->case->transfer_branch->branch_address) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2 : $form4->case->transfer_branch->branch_address2) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3 : $form4->case->transfer_branch->branch_address3) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_postcode : $form4->case->transfer_branch->branch_postcode) . ' '
                                        . ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->district->district : $form4->case->transfer_branch->district->district)) . ' '
                                        . ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state))
                                    )}}
                            </span>
                            supaya tindakan boleh diambil untuk mendakwa Penentang di Mahkamah di bawah
                            seksyen 117 Akta Pelindungan Pengguna 1999;
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(2)</td>
                        <td style="padding-top: 5px">sesalinan aduan tersebut hendaklah dihantarkan kepada
                            <span style="font-weight: bold">
                                Ketua Seksyen (Penolong Setiausaha),
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address : $form4->case->transfer_branch->branch_address}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2 : $form4->case->transfer_branch->branch_address2}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3 : $form4->case->transfer_branch->branch_address3}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_postcode : $form4->case->transfer_branch->branch_postcode}}
                                {{ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->district->district : $form4->case->transfer_branch->district->district)) }}
                                {{ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state)) }}
                            </span>
                            untuk makluman; atau
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(3)</td>
                        <td style="padding-top: 5px">tuan / puan juga boleh memilih untuk menguatkuasakan award dengan
                            sendiri di bawah seksyen 116(1)(b) Akta Perlindungan Pengguna 1999 di
                            <span style="font-weight: bold">
                                {{$form4->letter_court_id != null
                                    ? $form4->letterCourt->court_name
                                    : ($locale == 'my'
                                        ? 'Mahkamah Majistret '
                                        : 'Magistrate Court ')
                                    . ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state))}}
                            </span>;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                Sekian, terima kasih. <br><br>
                <span style="font-weight: bold; font-style: italic;">" BERKHIDMAT UNTUK NEGARA " </span><br><br>

                Saya yang menjalankan amanah, <br>
            <!-- img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/ -->
                <img width="150px" height="100px"
                     src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psus->first()->psu->user_id]) }}"/>
                <br>
                <span style="font-weight: bold;text-transform: uppercase;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
                <span class="uppercase">
						@if($form4->psus)
                        @if($form4->psus->first()->psu->roleuser->first()->role->name == "ks-hq" || $form4->psus->first()->psu->roleuser->first()->role->name == "ks")
                            Penolong Setiausaha
                        @else
                            {{ $form4->psus->first()->psu->roleuser->first()->role->display_name_my }}
                        @endif
                    @endif
					</span><br>
                b.p. Pengerusi<br>
                Tribunal Tuntutan Pengguna <br> Malaysia. <br>
                s.k {{ $form4->case->case_no }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>