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

        .underline {
            text-decoration-line: underline;
            text-decoration-style: dotted;
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
    <span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
    <span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
    <span class='bold uppercase'>REGULATIONS 1999</span><br><br>
    <span class='uppercase'>SECOND SCHEDULE</span><br><br>
    <span class='uppercase'>FORMS</span><br><br>
    <span class=''>(Regulation 4)</span><br><br>
    <span class='bold uppercase'>FORM 1</span><br><br>
    <span class=''>(Regulation 5)</span><br><br>
    <span class='bold uppercase italic'>STATMENT OF CLAIM</span><br><br>
    <span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
    <span class='uppercase'>AT </span>
    <span class='bold uppercase'>{{ $claim->venue ? $claim->venue->hearing_venue : '-' }}</span><br>
    <span class='uppercase'>IN THE STATE </span>
    <span class='bold uppercase'>{{ $claim->branch->state->state_name }}</span>
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
        @if($extraOpponent)
        <tr>
            <td class='top'>Name of Claimant 2</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->extraClaimant->name }}</td>
        </tr>
        <tr>
            <td class='camelcase top'>Identity Card No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>{{ $claim->extraClaimant->identification_no }}</td>
        </tr>
        @endif
        <tr>
            <td class='camelcase top'>Address</td>
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
            <td class='camelcase top'>Tel. No.</td>
            <td class='divider'>:</td>
            <td class='uppercase'>
                {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_home : '-' }}
                / {{ $claim->Claimant_address->is_company == 0 ? $claim->Claimant_address->phone_mobile : '-' }}
            </td>
        </tr>
        <tr>
            <td class='top' style='width: 35%'>E-mail/Fax No.</td>
            <td class='divider'>:</td>
            <td class='lowercase'>
                {{ $claim->claimant_address->email }}
                / {{ $claim->claimant_address->phone_fax or '-' }}
            </td>
        </tr>
    </table>

    @foreach($claim->multiOpponents as $cco)
        <table class='border'>
            <tr>
                <td class='top'>Name of Respondent</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $cco->opponent_address ? $cco->opponent_address->name : ''}}</td>
            </tr>
            <tr>
                <td class='camelcase top'>Identity Card No.</td>
                <td class='divider'>:</td>
                <td class='uppercase'>{{ $cco->opponent_address ? $cco->opponent_address->identification_no : ''}}</td>
            </tr>
            <tr>
                <td class='camelcase top'>Address</td>
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
                <td class='camelcase top'>Tel. No.</td>
                <td class='divider'>:</td>
                <td class='uppercase'>
                    {{ $cco->opponent_address ? ($cco->opponent_address->is_company == 0 ? $cco->opponent_address->phone_home : ($cco->opponent_address->phone_office ? $cco->opponent_address->phone_office : '-')) : '' }}
                    / {{ $cco->opponent_address ? ($cco->opponent_address->is_company == 0 ? $cco->opponent_address->phone_mobile : '-') : '' }}
                </td>
            </tr>
            <tr>
                <td class='top' style='width: 35%'>E-mail/Fax No.</td>
                <td class='divider'>:</td>
                <td class='lowercase'>
                    {{ $cco->opponent_address->email }}
                    / {{ $cco->opponent_address->phone_fax or '-' }}
                </td>
            </tr>
        </table>
    @endforeach
</div>

<div class='left break watermark'>
    <span class='camelcase'>Statement :</span>
    <table class='border'>
        <tr>
            <td>
                Claimant's claim is for a sum of
                <span class='bold'>RM{{ number_format($claim->form1->claim_amount, 2, '.', ',') }}</span>
            </td>
        </tr>
    </table>

    <table class='border'>
        <tr>
            <td class='bold'>
                Particular of claim :
            </td>
        </tr>
        <tr style="height: 150px; vertical-align: top;">
            <td>
                Date of Transaction/Purchase
                : {{ $claim->form1->purchased_date ? date('d/m/Y', strtotime($claim->form1->purchased_date.' 00:00:00')) : '-' }}
                <br>
                Purchased / Used : {{ $claim->form1->purchased_item_name or '-'}} <br>
                Model / Brand : {{ $claim->form1->purchased_item_brand or '-' }} <br>
                Purchase Price : RM {{ $claim->form1->purchased_amount or '-'}} <br>
                Total of Claims : <br>
                {!! strlen($claim->form1->claim_details) > 300 ? mb_substr($claim->form1->claim_details, 0, 300).'... (Please refer Appendix A)' : $claim->form1->claim_details !!}
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
            <td class='center italic no-padding top'>Signature / Right thumbprint <br> of Claimant</td>
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
            <td class='center italic no-padding top'>Date of Filing</td>
            <td style="width: 20%"></td>
            <td class='center no-padding'>
                <span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
                <span class='uppercase'>Secretary<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
            </td>
        </tr>
    </table>

    <div class='parent' style="text-align: center;">
        <img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px'/>
        <span style="margin-left: -25px" class="child">(SEAL)</span>
    </div>
</div>

<div class='left break watermark'>
    <span class='bold uppercase'>TO THE RESPONDENT :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;"></td>
            <td class="justify">If you dispute the Claimant's claim, you shall file in your statement of defence in Form
                2 (the "Statement of defence") within fourteen (14) days after the service of the statement of claim.
            </td>
        </tr>
    </table>

    <br><br>

    <span class='bold uppercase'>INSTRUCTIONS TO CLAIMANT :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;">1.</td>
            <td class="justify">The Claimant shall fill in his name in full and his identity card number in the column
                provided.
            </td>
        </tr>
        <tr>
            <td class='top'>2.</td>
            <td class="justify">The Claimant shall fill the name of the Respondent in full and his last known address in
                the column provided.
            </td>
        </tr>
        <tr>
            <td class='top'>3.</td>
            <td class="justify">The Claimant shall state the exact amount claimed in the column provided. The amount
                claimed should not exceed RM50,000.00. If the amount exceeds RM50,000.00 then the claim shall be filed
                in the First Class Magistrate's Court.
            </td>
        </tr>
        <tr>
            <td class='top'>4.</td>
            <td class="justify">The Claimant shall state the particulars of his claim in the column provided. The
                particulars shall state the relevant date and how the claim has arisen or what is the basis of the
                claim.
            </td>
        </tr>
        <tr>
            <td class='top'>5.</td>
            <td class="justify">If the column provided is insufficient, please continue on a separate sheet of paper and
                write "see overleaf". Any separate sheet of paper used should be attached to this Form.
            </td>
        </tr>
        <tr>
            <td class='top'>6.</td>
            <td class="justify">Having filled in the particulars, the Claimant shall sign this Form personally.</td>
        </tr>
        <tr>
            <td class='top'>7.</td>
            <td class="justify">Having completed this Form, the Claimant shall file this Form in 4 copies in the
                Tribunal's Registry. The Claimant shall pay a filing fee of RM5.00. The Registry will put the seal of
                the Tribunal on the 4 copies. Two copies of this Form shall be returned to the Claimant.
            </td>
        </tr>
        <tr>
            <td class='top'>8.</td>
            <td class="justify">
                You cannot be represented by a lawyer at the hearing.<br><br>
                <!-- div class='border' style="padding: 10px">
                    <span class='bold uppercase'>IMPORTANT NOTE TO CLAIMANT :</span>

                    <table>
                        <tr>
                            <td class='top' style="width: 20px;">1.</td>
                            <td class="justify">
                                A Claimant must submit Form 1 to the Respondent with -<br>
                                <table>
                                    <tr>
                                        <td class='top' style="padding-left: 0px;">(i)</td>
                                        <td>Advise of Receipt Registered Post (A.R); or</td>
                                    </tr>
                                    <tr>
                                        <td class='top' style="padding-left: 0px;">(ii)</td>
                                        <td>giving it to the Respondents themselves, immediately.</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class='top'>2.</td>
                            <td>
                                A.R card to be taken during the hearing.
                            </td>
                        </tr>
                    </table>
                </div -->
            </td>
        </tr>
    </table>
</div>

<div class='left break watermark'>
    <span class='bold uppercase'>INSTRUCTIONS TO RESPONDENT :</span><br>

    <table>
        <tr>
            <td class='top' style="width: 20px;">1.</td>
            <td class="justify">When you receive this Form sealed with the seal of the Tribunal, you are being sued by
                the Claimant.
            </td>
        </tr>
        <tr>
            <td class='top'>2.</td>
            <td class="justify">If you dispute the claim you shall state your defence, with particulars, in Form 2.</td>
        </tr>
        <tr>
            <td class='top'>3.</td>
            <td class="justify">You shall file in your statement of defence in the Tribunal's Registry.</td>
        </tr>
        <tr>
            <td class='top'>4.</td>
            <td class="justify">If you fail to file in your defence within the prescribed time or if you fail to appear
                before the Tribunal on the hearing date, the Tribunal will make an award in favour on the Claimant.
            </td>
        </tr>
        <tr>
            <td class='top'>5.</td>
            <td class="justify">You cannot be represented by a lawyer at the hearing.</td>
        </tr>
        <tr>
            <td class='top'>6.</td>
            <td class="justify">You are required to deliver Form 2 to the Claimant.</td>
        </tr>
        <tr>
            <td class='top'></td>
            <td>
                <br><br><br><br>
                <span class="camelcase">Please Return To :-</span><br><br><br>

                <span class="italic camelcase">Secretary,</span><br>
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
                <td class='camelcase'>Form 1 Receipt No.</td>
                <td class='divider'>:</td>
                <td>{{ $claim->form1->payment ? $claim->form1->payment->receipt_no : '-' }}</td>
            </tr>
        </table>
    </div>

    <br><br>

    <p class="justify">Thank you for dealing with the Tribunal for Consumer Claims Malaysia. Please keep this document
        as a reference.</p>
</div>

<div class='left break watermark'>

    <div class="center">
        <h1 style="text-decoration: underline;">Appendix A</h1><br><br><br><br><br>

        <table class='border'>
            <tr>
                <td class='bold'>
                    Full particular of claim statement detail:
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

    <p class="justify">Thank you for dealing with the Tribunal for Consumer Claims Malaysia. Please keep this document
        as a reference.</p>
</div>

</body>
