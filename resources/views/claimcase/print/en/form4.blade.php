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

    <span class='bold uppercase'>Form 4</span><br>
    <span class=''>(Regulation 18)</span><br><br>
    <span class='bold uppercase italic'>NOTICE OF HEARING</span><br><br>
    <span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
    <span class='uppercase'>AT </span>
    <span class='bold uppercase'>@if($form4->hearing->hearing_room) {{ $form4->hearing->hearing_room->venue->hearing_venue }} @else {{ $form4->case->branch->state->state_name }} @endif</span><br>
    <span class='uppercase'>IN THE STATE</span>
    <span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
    <span class='uppercase'> MALAYSIA</span><br>
    <span class='uppercase'>CLAIM NO: </span>
    <span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

    <table>
        <tr>
            <td class='center uppercase' colspan="2">BETWEEN</td>
        </tr>
        <tr>
            <td class='bold uppercase no-padding' style="width: 70%">
                {{ $form4->case->claimant_address->name }}<br>
                {{ $form4->case->claimant_address->nationality_country_id == 129 ? 'NRIC: '.$form4->case->claimant_address->identification_no : 'Passport No.: '.$form4->case->claimant_address->identification_no }}

                @if($form4->case->extra_claimant)
                    /
                    <br><br>
                    {{ $form4->case->extra_claimant->name }}<br>
                    {{ $form4->case->extra_claimant->nationality_country_id == 129 ? 'NRIC: '.$form4->case->extra_claimant->identification_no : 'Passport No.: '.$form4->case->extra_claimant->identification_no  }}
                @endif
            </td>
            <td class='camelcase'>Claimant</td>
        </tr>
        <tr>
            <td class='center uppercase' colspan="2">AND</td>
        </tr>
        <tr>
            <td class='bold uppercase no-padding' style="width: 70%">
                @if($form4->claimCaseOpponent->opponent_address)

                    {{ $form4->claimCaseOpponent->opponent_address->name }}<br>
                    @if($form4->claimCaseOpponent->opponent_address->is_company == 1)
                        ( {{ $form4->claimCaseOpponent->opponent_address->identification_no }} )
                    @else
                        {{ $form4->claimCaseOpponent->opponent_address->nationality_country_id == 129 ? 'NRIC: '.$form4->claimCaseOpponent->opponent_address->identification_no : 'Passport No.: '.$form4->claimCaseOpponent->opponent_address->identification_no }}
                    @endif

                @endif
            </td>
            <td class='camelcase'>Respondent</td>
        </tr>
    </table>

    <br><br>

    <div class='left'>
        <span>PLEASE NOTE that the above claims will be heard at </span>
        <span class='bold'>
				
				{{ date('j', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00'))).')' }} </span>

        <span>at </span>
        <span class='bold'>{{ date('h:i A', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)) }}</span>

        <span>at (Address of place of hearing): :- </span><br><br>

			<div style="margin-left: 50px;" class="justify">
			<span class='bold' >	
				Tribunal Tuntutan Pengguna Malaysia
				(Tribunal for Consumer Claims Malaysia), <br>
				{!! $form4->hearing->hearing_room ? str_replace(',', ', ', $form4->hearing->hearing_room->address) : '-' !!}.
			</span><br><br>
        </div>
    </div>

    <span class="center bold uppercase">PLEASE BRING ALL WITNESSES, DOCUMENTS, RECORDS, OR SUPPORTING ITEMS TO SUPPORT YOUR DEFENSE CLAIM AND COUNTERCLAIM.</span><br><br>

    <div class='left'>
        <span>Dated</span> <span class='bold'>{{ $form4->created_at->format('d').' '.localeMonth($form4->created_at->format('F')).' '.$form4->created_at->format('Y') }}</span><br>
    </div>

    <table>
        <tr>
            <td class='center' style="width: 45%">
                <div class='parent' style="text-align: center;">
                    <img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px'/>
                    <span style="margin-left: -25px" class="child">(SEAL)</span>
                </div>
            </td>
            <td style="width: 10%"></td>
            <td class='center' style="width: 45%; position: relative;">
                <img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;"
                     src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu->user_id]) }}"/><br>
                <div style="margin-top: 50px;">
                    <span class='bold uppercase top'>{{ $form4->psu->name }}</span><br>
                    <span class='uppercase'>
							@if($form4->psu->roleuser->first()->role->name == "ks-hq" || $form4->psu->roleuser->first()->role->name == "ks")
                            ASSISTANT SECRETARY
                        @else
                            {{ $form4->psu->roleuser->first()->role->display_name_en }}
                        @endif
							<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
                </div>
            </td>
        </tr>
    </table>

</div>

<div class='left break watermark'>
    <hr style="border: 2px solid black;">

    <br>
    <table>
        <tr>
            <td class='top'></td>
            <td>
                <span class="bold uppercase"><u>IMPORTANT NOTE TO CLAIMANT :</u></span><br><br>

                <span class="uppercase">
                        {{ $form4->case->claimant_address->name }}<br>
						@if($form4->case->claimant_address->address_mailing_street_1)
                        {!! $form4->case->claimant_address->address_mailing_street_1 ? $form4->case->claimant_address->address_mailing_street_1.',<br>' : "" !!}
                        {!! $form4->case->claimant_address->address_mailing_street_2 ? $form4->case->claimant_address->address_mailing_street_2 .',<br>' : "" !!}
                        {!! $form4->case->claimant_address->address_mailing_street_3 ? $form4->case->claimant_address->address_mailing_street_3 .',<br>' : "" !!}
							{{ $form4->case->claimant_address->address_mailing_postcode ? $form4->case->claimant_address->address_mailing_postcode : "" }}
                            {!! $form4->case->claimant_address->address_mailing_district_id ? $form4->case->claimant_address->districtmailing->district .',<br>' : "" !!}
                        {{ $form4->case->claimant_address->address_mailing_state_id ? $form4->case->claimant_address->statemailing->state : "" }}
                    @else
                        {!! $form4->case->claimant_address->street_1 ? $form4->case->claimant_address->street_1.',<br>' : "" !!}
                        {!! $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2.',<br>' : "" !!}
                        {!! $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3.',<br>' : "" !!}
							{{ $form4->case->claimant_address->postcode ? $form4->case->claimant_address->postcode : '' }}
                            {!! $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district.',<br>' : '' !!}
                        {{ $form4->case->claimant_address->state_id ? $form4->case->claimant_address->state->state : '' }}
                    @endif
				</span>
            </td>
        </tr>
        <tr>
            <td class='top'>1.</td>
            <td>
                <span>A Claimant must submit Form 1 to the Respondent with :-</span><br>
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
            <td class='top' style="width: 10%;">2.</td>
            <td>
                A.R card to be taken during the hearing.
            </td>
        </tr>
    </table>
    <br>

    <hr style="border: 2px solid black;">

    <br><br>

    <hr style="border: 2px solid black;">

    <br>
    <table>
        <tr>
            <td class='top'></td>
            <td>
                <span class="bold uppercase"><u>IMPORTANT NOTE TO RESPONDENT</u></span><br><br>

                <span class="uppercase">
						@if($form4->claimCaseOpponent->opponent_address)
                        {{ $form4->claimCaseOpponent->opponent_address->name }}<br>
                        {{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
                        {!! $form4->claimCaseOpponent->opponent_address->street_2 ? $form4->claimCaseOpponent->opponent_address->street_2.',<br>' : '' !!}
                        {!! $form4->claimCaseOpponent->opponent_address->street_3 ? $form4->claimCaseOpponent->opponent_address->street_3.',<br>' : '' !!}
                        {{ $form4->claimCaseOpponent->opponent_address->postcode }}
                        {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }}
                        ,<br>
                        {{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}.
                    @endif
					</span>
            </td>
        </tr>
        <tr>
            <td class='top'></td>
            <td>
                <span>Respondent of company or business can only be represented by :-</span><br>
                <table>
                    <tr>
                        <td class='top' style="padding-left: 0px;">(i)</td>
                        <td>a full-time salaried employees and with a letter of authority (authorization letter);</td>
                    </tr>
                    <tr>
                        <td class='top' style="padding-left: 0px;">(ii)</td>
                        <td>director, owner or partner and bring a copy of Form 49 or the details of any relevant
                            company/business.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>

    <hr style="border: 2px solid black;">

</div>

</body>
