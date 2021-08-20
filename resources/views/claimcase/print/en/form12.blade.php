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
		.underline {
			text-decoration: underline;
		}
		.watermark {
			padding: 25px;
			background-image: url('{{ url('images/ttpm_watermark.png') }}');
			background-repeat: no-repeat;
			background-position: center center;
		}
	</style>
</head>

<body class="center" style="padding-top: 80px;">

	<div>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>
		<span class='bold uppercase'>Form 12</span><br><br>
		<span class=''>(Regulation 25)</span><br><br>
		<span class='bold uppercase italic'>APPLICATION FOR SETTING ASIDE AWARD</span><br><br>
		<span class='uppercase'>IN TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='top' style="width: 36%">Name of Claimant</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->case->claimant->name }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->case->claimant->username }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>
					{{ $form4->case->claimant_address->street_1 }},
					{{ $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2."," : "" }}
					{{ $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3."," : "" }}
					{{ $form4->case->claimant_address->postcode }}
					{{ $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : '' }},
					{{ $form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : '' }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>Tel. No. </td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $form4->case->claimant_address->is_company == 0 ? $form4->case->claimant_address->phone_home : '-' }}
				  / {{ $form4->case->claimant_address->is_company == 0 ? $form4->case->Claimant_address->phone_mobile : '-' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mail/Fax No.</td>
				<td class='divider'>:</td>
				<td class='lowercase'>
					{{ $form4->case->claimant_address->email }}
				  / {{ $form4->case->claimant_address->phone_fax or '-' }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class=' top' style="width: 36%">Name of Opponent</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->name : '' }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No. / Company Registration No.</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->claimCaseOpponent->opponent->username }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>
					@if($form4->claimCaseOpponent->opponent_address)
					{{ $form4->claimCaseOpponent->opponent_address->street_1 }},
					{{ $form4->claimCaseOpponent->opponent_address->street_2 ? $form4->claimCaseOpponent->opponent_address->street_2."," : "" }}
					{{ $form4->claimCaseOpponent->opponent_address->street_3 ? $form4->claimCaseOpponent->opponent_address->street_3."," : "" }}
					{{ $form4->claimCaseOpponent->opponent_address->postcode }}
					{{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : ''}},
					{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : ''}}
					@endif
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>Tel. No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 0 ? $form4->claimCaseOpponent->opponent_address->phone_home : ($form4->claimCaseOpponent->opponent_address->phone_office ? $form4->claimCaseOpponent->opponent_address->phone_office : '-')) : '' }}
					/ {{ $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 0 ? $form4->claimCaseOpponent->opponent_address->phone_mobile : '-') : '' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mail/Fax No.</td>
				<td class='divider'>:</td>
				<td class='lowercase'>
					{{ $form4->claimCaseOpponent->opponent_address->email }}
				  / {{ $form4->claimCaseOpponent->opponent_address->phone_fax or '-' }}
				</td>
			</tr>
		</table>
	</div>

	<table>
		<tr>
			<td class='top' style="width: 20px;">1.</td>
			<td class="justify">An award has been obtained against me on <span class="bold">{{ $form4->award ? date('j F Y', strtotime($form4->award->award_date." 00:00:00")) : '-' }}</span>.
			</td>
		</tr>
		<tr>
			<td class='top'>2.</td>
			<td>I hereby apply to set aside the award.</td>
		</tr>

	</table>

	<div class='left break'>
		<table class='border'>
			<tr>
				<td class='bold'>
					I was not present at the hearing because :
				</td>
			</tr>
			<tr>
				<td class="justify">
					{!! $form4->form12->absence_reason !!}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					I did not file my defence because :
				</td>
			</tr>
			<tr style="height: 150px; vertical-align: top;">
				<td class="justify">
					{{ $form4->form12->unfiled_reason }}
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
				<td class='center italic no-padding top'>Signature / Right thumbprint<br>of Claimant / Respondent</td>
			</tr>
			<tr>
				<td colspan="3" class="center uppercase bold">
					<br>
					NOTICE TO THE CLAIMANT / RESPONDENT
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p class="center no-padding justify">The Claimant/Respondent has applied to this Tribunal to set aside the award dated <span class="underline">{{ $form4->award ? date('d', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) : '' }}</span>.The date and the time for the hearing of application is as stated below.</p><br>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="center">
					<span class="no-padding center">Hearing Date: 
					@if($form4->form4_next)
					@if($form4->form4_next->hearing)
					<span class="bold">{{ date('d', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')) }}</span>
					@endif
					@endif
					Time: 
					@if($form4->form4_next)
					@if($form4->form4_next->hearing)
					<span class="bold"> {{ date('g.i', strtotime($form4->form4_next->hearing->hearing_date.' '.$form4->form4_next->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->form4_next->hearing->hearing_date.' '.$form4->form4_next->hearing->hearing_time))) }} </span>
					@endif
					@endif
					</span><br>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class='center' style="width: 45%">
					<span class="underline">{{ date('d', strtotime($form4->form12->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->form12->filing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->form12->filing_date.' 00:00:00')) }}</span><br>
					<span>Date of Filing </span><br><br>
					<div class='parent' style="text-align: center;">
						<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
						<span style="margin-left: -25px" class="child">(SEAL)</span>
					</div>
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					{{-- <img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" />--}}<br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psus->first()->psu->name or '' }}</span><br>
						<span class='uppercase'>SECRETARY<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>
	</div>

</body>