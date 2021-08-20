<head>
    <style>
        table {
            width: 100%;
            margin-top: 20px;
        }

        td, th {
            font-family: serif !important;
            padding: 10px;
            font-size: 18px;
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

        .parent {
            position: relative;
        }

        .child {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
    </style>
</head>

<body class="center">

<div class='watermark'>
    <span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
    <span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
    <span class='bold uppercase'>REGULATIONS 1999</span><br><br>

    <span class='bold uppercase'>FORM 2</span><br>
    <span class=''>(Regulation 9)</span><br><br>
    <span class='bold uppercase italic'>STATEMENT OF DEFENCE AND COUNTER-CLAIM</span><br><br>
    <span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
    <span class='uppercase'>AT </span>
    <span class='bold uppercase'>{{ $claim->venue ? $claim->venue->hearing_venue : '-' }}</span><br>
    <span class='uppercase'>IN THE STATE </span>
    <span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
    <span class='uppercase'> MALAYSIA</span><br>
    <span class='uppercase'>CLAIM NO: </span>
    <span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

    <table class='border'>
        <tr>
            <td class='top'>Name of Claimant</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->claimant_address->name }}</td>
        </tr>
        <tr>
            <td class='camelcase top'>Identity Card No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->claimant_address->identification_no }}</td>
        </tr>
        <tr>
            <td class='camelcase top'>Address</td>
            <td class='divider'>:</td>
            <td class='uppercase' colspan="4">
                @if($claim->claimant_address->address_mailing_street_1)
                    {{ $claim->claimant_address->address_mailing_street_1 ? $claim->claimant_address->address_mailing_street_1 .', ' : "" }}
                    {{ $claim->claimant_address->address_mailing_street_2 ? $claim->claimant_address->address_mailing_street_2 .', ' : "" }}
                    {{ $claim->claimant_address->address_mailing_street_3 ? $claim->claimant_address->address_mailing_street_3 .', ' : "" }}
                    {{ $claim->claimant_address->address_mailing_postcode ? $claim->claimant_address->address_mailing_postcode : "" }}
                    {{ $claim->claimant_address->address_mailing_district_id ? $claim->claimant_address->districtmailing->district .', ' : "" }}
                    {{ $claim->claimant_address->address_mailing_state_id ? $claim->claimant_address->statemailing->state : "" }}
                @else
                    {{ $claim->claimant_address->street_1 ? $claim->claimant_address->street_1 .', ' : "" }}
                    {{ $claim->claimant_address->street_2 ? $claim->claimant_address->street_2 .', ' : "" }}
                    {{ $claim->claimant_address->street_3 ? $claim->claimant_address->street_3 .', '  : "" }}
                    {{ $claim->claimant_address->postcode ? $claim->claimant_address->address_postcode : '' }}
                    {{ $claim->claimant_address->subdistrict ? $claim->claimant_address->subdistrict->name : ($claim->claimant_address->district ? $claim->claimant_address->district->district : '') }},
                    {{ $claim->claimant_address->state_id ? $claim->claimant_address->state->state : '' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class='camelcase top'>Telephone No. / H/P No. / Fax No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>
                {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_home : '-' }}
                / {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_mobile : '-' }}
                / {{ $claim->claimant_address->phone_fax or '-' }}
            </td>
        </tr>
        <tr>
            <td class='top' style='width: 35%'>Email</td>
            <td class='divider'>:</td>
            <td class='lowercase'>{{ $claim->claimant_address->email }}</td>
        </tr>
    </table>

    <table class='border'>
        <tr>
            <td class='top'>Name of Respondent</td>
            <td class='divider'>:</td>
            <td class='uppercase'
                colspan="4">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->name : ''}}</td>
        </tr>
        <tr>
            <td class='camelcase top'>Identity Card No. / Company Registration No.</td>
            <td class='divider'>:</td>
            <td class='uppercase top'
                colspan="4">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->identification_no : '' }}</td>
        </tr>
        <tr>
            <td class='camelcase top'>Address</td>
            <td class='divider'>:</td>
            <td class='uppercase' colspan="4">
                @if($claim_case_opponent->opponent_address)

                    {{ $claim_case_opponent->opponent_address->street_1 }},
                    {{ $claim_case_opponent->opponent_address->street_2 ? $claim_case_opponent->opponent_address->street_2."," : "" }}
                    {{ $claim_case_opponent->opponent_address->street_3 ? $claim_case_opponent->opponent_address->street_3."," : "" }}
                    {{ $claim_case_opponent->opponent_address->postcode }}
                    {{ $claim_case_opponent->opponent_address->subdistrict ? $claim_case_opponent->opponent_address->subdistrict->name : ($claim_case_opponent->opponent_address->district ? $claim_case_opponent->opponent_address->district->district : '') }},
                    {{ $claim_case_opponent->opponent_address->state ? $claim_case_opponent->opponent_address->state->state : '' }}

                @endif
            </td>
        </tr>
        <tr>
            <td class='camelcase top'>Telephone No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_home : ($claim_case_opponent->opponent_address->phone_office ? $claim_case_opponent->opponent_address->phone_office : '-')) : '' }}</td>
            <td class='camelcase fit top'>H/P No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_mobile : '-') : '' }}</td>
        </tr>
        <tr>
            <td class='top' style='width: 35%'>Email</td>
            <td class='divider'>:</td>
            <td class='lowercase'
                style='width: 30%'>{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->email : '' }}</td>
            <td class='camelcase fit top' style='width: 10%'>Fax No.</td>
            <td class='divider'>:</td>
            <td class='uppercase' style='width: 25%'>{{ $claim_case_opponent->opponent_address->phone_fax or '-' }}</td>
        </tr>
    </table>
</div>

<div class='left break watermark'>

    <table class='border'>
        <tr>
            <td class='bold'>
                Statement of defence :
            </td>
        </tr>
        <tr style="height: 150px; vertical-align: top;">
            <td>
                {!! strlen($claim_case_opponent->form2->defence_statement) > 300 ? mb_substr($claim_case_opponent->form2->defence_statement, 0, 300).'... (Please refer Appendix A)' : $claim_case_opponent->form2->defence_statement !!}
            </td>
        </tr>
    </table>

    <table class='border'>
        <tr>
            <td class='bold'>
                Counter-claim :
            </td>
        </tr>
        <tr style="height: 150px; vertical-align: top;">
            <td>
                {{ $claim_case_opponent->form2->counterclaim ? $claim_case_opponent->form2->counterclaim->counterclaim_statement : '- None -' }}
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
            <td class='center italic no-padding top'>Date</td>
            <td style="width: 20%"></td>
            <td class='center italic no-padding top'>Signature / Right thumbprint of <br>Respondent</td>
        </tr>
    </table>

    <table style="margin-top: 100px;">
        <tr>
            <td class='center no-padding'
                style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim_case_opponent->form2->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim_case_opponent->form2->filing_date.' 00:00:00'))).' '.date('Y', strtotime($claim_case_opponent->form2->filing_date.' 00:00:00')) }}</td>
            <td style="width: 20%"></td>
            <td class='center no-padding' style="width: 40%; position: relative; ">
                .................................................
                <img class="absolute-center" style="width: 200px; bottom: 200%; z-index: -1;"
                     src="{{ route('general-getsignature', ['ttpm_user_id' => $claim->psu_user_id]) }}"/>
            </td>
        </tr>
        <tr>
            <td class='center italic no-padding top'>Date of Filing</td>
            <td style="width: 20%"></td>
            <td class='center no-padding'>
                <span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
                <span class='uppercase'>{{ $claim->psu->roleuser->first()->role->display_name_en }} <br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
            </td>
        </tr>
    </table>

    <div class='parent' style="text-align: center;">
        <img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px'/>
        <span style="margin-left: -25px" class="child">(SEAL)</span>
    </div>
</div>

<div class='left break watermark'>
    <span class='bold uppercase'>INSTRUCTIONS TO THE RESPONDENT :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;">1.</td>
            <td class="justify">If you admit the Claimant's claim you may state in the column provided for the statement
                of defence that you admit the claim.
            </td>
        </tr>
        <tr>
            <td class='top'>2.</td>
            <td class="justify">If you dispute the claim, your statement of defence shall contain particulars as to why
                you dispute the claim.
            </td>
        </tr>
        <tr>
            <td class='top'>3.</td>
            <td class="justify">If you have any counter-claim, you shall state you counter-claim with particulars in the
                column provided.
            </td>
        </tr>
        <tr>
            <td class='top'>4.</td>
            <td class="justify">If the column provided is insufficient, please continue on a separate sheet of paper and
                write " see overleaf ". Any separate sheet of paper used should be attached to this Form.
            </td>
        </tr>
        <tr>
            <td class='top'>5.</td>
            <td class="justify">You shall file your defence (and counter-claim if any) within the time limit, otherwise
                an award will be made in favour of the Claimant.
            </td>
        </tr>
        <tr>
            <td class='top'>6.</td>
            <td class="justify">You shall sign Form 2 personally and file in 3 copies in the Tribunal's Registry. In the
                case of a corporate body, this Form shall be signed by a director, manager, secretary or other similar
                officer. The filing fee is RM5.00. The Registry will put the seal of the Tribunal on the 3 copies and
                return to you two copies.
            </td>
        </tr>
        <tr>
            <td class='top'></td>
            <td>
                <br><br><br><br>
                <span class="camelcase">Please Return To :-</span><br><br><br>

                <span class="italic camelcase">Section Head,</span><br>
                <span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
                <span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
                <span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
                <span class="italic">{{ $claim->branch->branch_postcode }}</span>
                <span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
                <span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
                <span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
                <span class="italic">Fax: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
                <span class="italic">Toll Free Line: 1800-88-9811</span><br>
                <span class="italic">Email: </span><span
                        class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
            </td>
        </tr>
    </table>
</div>

<div class='left break watermark'>

    <div class="center">
        <h1 style="text-decoration: underline;">e-Tribunal System</h1><br><br><br><br><br>

        <table class="border" style="margin: 20px 10%; width: 80%;">
            <tr>
                <td class='camelcase' style="width: 30%">Claim No.</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $claim->case_no }}</td>
            </tr>
            <tr>
                <td class='camelcase'>Hearing Date</td>
                <td class='divider'>:</td>
                <td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
            </tr>
            <tr>
                <td class='camelcase'>Hearing Time</td>
                <td class='divider'>:</td>
                <td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
            </tr>
            <tr>
                <td class='camelcase'>Form 2 Receipt No.</td>
                <td class='divider'>:</td>
                <td>{{ $claim_case_opponent->form2->payment ? $claim_case_opponent->form2->payment->receipt_no : '-' }}</td>
            </tr>
        </table>
    </div>

    <br><br>

    <p class="justify">Thank you for dealing with the Tribunal for Consumer Claims Malaysia. Please keep this document
        as a reference.
</div>

<div class='left break watermark'>
    <div class="center">
        <h1 style="text-decoration: underline;">Appendix A</h1><br><br><br><br><br>

        <table class='border'>
            <tr>
                <td class='bold'>
                    Full particular of statement of defence:
                </td>
            </tr>
            <tr style="height: 150px; vertical-align: top;">
                <td>
                    {!! nl2br($claim_case_opponent->form2->defence_statement) !!}
                </td>
            </tr>
        </table>
    </div>
</div>

</body>