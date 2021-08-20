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
		.underline {
			text-decoration-line: underline;
  			text-decoration-style: dotted;
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
			max-width:100%;
			white-space:nowrap;
		}
		.absolute-center {
			margin: auto;
			position: absolute;
			top: 0; left: 0; bottom: 0; right: 0;
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

		<span class='bold uppercase'>Form 3</span><br><br>
		<span class=''>(Regulation 13)</span><br><br>
		<span class='bold uppercase italic'>DEFENCE TO COUNTER-CLAIM</span><br><br>
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
				<td class='uppercase' colspan="4">{{ $claim->claimant_address->name }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">{{ $claim->claimant_address->identification_no }}</td>
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
						{{ $claim->claimant_address->postcode ? $claim->claimant_address->postcode : '' }}
						{{ $claim->claimant_address->district ? $claim->claimant_address->district->district  .', '  : '' }}
						{{ $claim->claimant_address->state_id ? $claim->claimant_address->state->state : '' }}
					@endif
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>Telephone No. / H/P No. / Fax No. </td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_home : '-' }}
					/ {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_mobile : '-' }}
					/ {{ $claim->claimant_address->phone_fax or '-' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%' colspan="4">{{ $claim->claimant_address->email }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='top'>Name of Respondent</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">{{ $claim->opponent_address ? $claim->opponent_address->name : ''}}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No. / Company Registration No.</td>
				<td class='divider'>:</td>
				<td class='uppercase top' colspan="4">{{ $claim->opponent_address ? $claim->opponent_address->identification_no : '' }}</td>
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
					{{ $claim_case_opponent->opponent_address->district ? $claim_case_opponent->opponent_address->district->district : '' }},
					{{ $claim_case_opponent->opponent_address->state ? $claim_case_opponent->opponent_address->state->state : '' }}

					@endif
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>Telephone No. / H/P No. / Fax No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_home : $claim_case_opponent->opponent_address->phone_office ? $claim_case_opponent->opponent->phone_office : '-') : '' }}
					/ {{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_mobile : '-') : '' }}
					/ {{ $claim_case_opponent->opponent_address->phone_fax or '-' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%' colspan="4">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->email : '' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Defence to Counter-Claim :
				</td>
			</tr>
			<tr style="height: 250px; vertical-align: top;">
				<td>
					{{ $claim_case_opponent->form2->form3->defence_counterclaim_statement }}
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
				<td class='center italic no-padding top'>Signature/Right thumbprint <br>of Claimant</td>
			</tr>
		</table>

		<table style="margin-top: 100px;">
			<tr>
				<td class='center no-padding' style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim->form1->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim_case_opponent->form2->form3->filing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->filing_date.' 00:00:00')) }}</td>
				<td style="width: 20%"></td>
				<td class='center no-padding' style="width: 40%; position: relative; ">
					................................................
					<img class="absolute-center" style="width: 200px; bottom: 200%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $claim->psu_user_id]) }}" />
				</td>
			</tr>
			<tr>
				<td class='center italic no-padding top'>Date of Filing</td>
				<td style="width: 20%"></td>
				<td class='center no-padding'>
					<span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
					<span class='uppercase'>{{ $claim->psu->roleuser->first()->role->display_name_en }}<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<div class='parent' style="text-align: center;">
			<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
			<span style="margin-left: -25px" class="child">(SEAL)</span>
		</div>
	</div>

	<div class='left break watermark'>

		<span class='bold uppercase'>INSTRUCTIONS TO THE CLAIMANT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td class="justify">If you admit the Respondent's counter-claim you shall state in the column provided for defence to counter-claim that you admit the counter-claim.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td class="justify">If you dispute the counter-claim, your defence to the counter-claim shall contain particulars as to why you dispute the counter-claim.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td class="justify">You shall sign Form 3 personally and file in 4 copies in the Tribunal's Registry. The filing fee is RM5.00. The Registry will put the seal of the Tribunal on the 4 copies and return to you two copies.</td>
			</tr>
		</table>
	</div>

</body>