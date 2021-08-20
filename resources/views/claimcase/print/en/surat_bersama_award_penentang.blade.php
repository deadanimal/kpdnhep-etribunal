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
<div style="margin:30px;padding-top: 150px;">
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
                <span class="title">To the Respondent</span><br><br>
                @if($form4->claimCaseOpponent->opponent_address)
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

                Mr/Mrs,<br><br>
                <span style="font-weight: bold">Claim No. {{ $form4->case->case_no }}</span><br><br>
                Hereby attached a copy of the Tribunal's award for your actions as follows:
                <table>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(1)</td>
                        <td style="padding-top: 5px">You must comply with this award
                            within {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_en) : 'days' }}
                            from the date the award was received or to comply with this award within the period set
                            forth in the award.
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(2)</td>
                        <td style="padding-top: 5px">If you fail to comply with this award
                            within {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_en) : 'days' }}
                            from the date the award was received or to comply with this award within the specified
                            period in the award, it shall be a criminal offense under <span style="font-weight: bold">Section 117 of the Consumer Protection Act (CPA) 1999</span>
                            as follows:
                            <table>
                                <tr>
                                    <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">
                                        (a)
                                    </td>
                                    <td style="padding-top: 5px"><span class="title">Section 117(1) CPA 1999</span><br>
                                        <span style="text-decoration: underline;">First Offence</span> - Fine not
                                        exceeding RM10,000 or imprisonment for a term not more than two (2) years or to
                                        both.
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">
                                        (b)
                                    </td>
                                    <td style="padding-top: 5px"><span class="title">Section 117(2) CPA 1999</span><br>
                                        <span style="text-decoration: underline;">Continuing Offences</span> - In
                                        addition to penalties under section 117 (1) above, a fine not exceeding RM1,000
                                        for each day or part of the day during which the offense continues after
                                        conviction.
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                    @if($form4->award->award_type != 9 && $form4->award->award_type != 10 )
                        <tr>
                            <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(3)</td>
                            <td style="padding-top: 5px">If you disagree with this award, you may set aside this award
                                by filing an application in Form 12 within thirty days after the award is received
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="page-break-before: always; margin: 30px;">
    <table>
        <tr>
            <td colspan="2">
                <span class="title">To the Claimant</span><br><br>
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
                If the Respondent fails to comply with this award
                after {{ $form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14 }} {{ $form4->award->term ? strtolower($form4->award->term->term_en) : 'days' }}
                from the date the award was received or failed to comply with this award within the specified period in
                the award, you may:-

                <table>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(1)</td>
                        <td style="padding-top: 5px">lodge a complaint to the
                            <span style="font-weight: bold">
                                {{$form4->letter_branch_address_id != null
                                    ? $form4->letterBranchAddress->address_en
                                    : (
                                        ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address_en : $form4->case->transfer_branch->branch_address_en) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2_en : $form4->case->transfer_branch->branch_address2_en) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3_en : $form4->case->transfer_branch->branch_address3_en) . ', '
                                        . ($form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_postcode : $form4->case->transfer_branch->branch_postcode) . ' '
                                        . ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->district->district : $form4->case->transfer_branch->district->district)) . ' '
                                        . ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state))
                                    )}}
                            </span>
                            so that action may be taken to prosecute the Respondent in Court under section 117 of the
                            Consumer Protection Act 1999;
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(2)</td>
                        <td style="padding-top: 5px">a copy of the complaint shall be sent to
                            <span style="font-weight: bold">
                                Section Head (Assistant Secretary),
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address : $form4->case->transfer_branch->branch_address}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2 : $form4->case->transfer_branch->branch_address2}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3 : $form4->case->transfer_branch->branch_address3}},
                                {{$form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_postcode : $form4->case->transfer_branch->branch_postcode}}
                                {{ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->district->district : $form4->case->transfer_branch->district->district)) }}
                                {{ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state)) }}
                            </span>
                            for acknowledgement; or
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" style="text-align: center; vertical-align: top; padding-top: 5px">(3)</td>
                        <td style="padding-top: 5px">you may also opt to enforce the award yourself under section 116
                            (1) (b) of the Consumer Protection Act 1999 at
                            <span style="font-weight: bold">
                                {{$form4->letter_court_id != null
                                    ? ($form4->letterCourt->court_name_en != null ? $form4->letterCourt->court_name_en : $form4->letterCourt->court_name)
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
                <br>
                Thank you. <br><br>

                <b><i>"BERKHIDMAT UNTUK NEGARA"</i></b><br><br>

                Sincerely, <br><br>

            <!-- img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/ -->
                <img width="150px" height="100px"
                     src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psus->first()->psu->user_id]) }}"/>
                <br>
                <span style="font-weight: bold;text-transform: uppercase;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
                <span>
						@if($form4->psus)
                        @if($form4->psus->first()->psu->roleuser->first()->role->name == "ks-hq" || $form4->psus->first()->psu->roleuser->first()->role->name == "ks")
                            Assistant Secretary
                        @else
                            {{ $form4->psus->first()->psu->roleuser->first()->role->display_name_en }}
                        @endif
                    @endif
					</span>
                <br>
                p.p. Chairman<br>
                The Tribunal For Consumer Claims <br> Malaysia. <br>
                c.c {{ $form4->case->case_no }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>