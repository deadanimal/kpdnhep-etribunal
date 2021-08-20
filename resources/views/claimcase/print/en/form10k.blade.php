<head>
	<style>
		table {
			width: 100%;
			margin-top: 18px;
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
		.indent {
			text-indent: 15px;
		}
		.justify {
			text-align: justify !important;
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

	<div>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>
		
		<span class='bold uppercase'>Form 10</span><br><br>
		<span class=''>(Subregulation 23(5))</span><br><br>
		<span class='bold uppercase italic'>AWARD AFTER HEARING</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
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
			<p class="justify indent">
				This action has been called on <span class="bold uppercase">{{ $form4_before ? date('h', strtotime($form4_before->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4_before->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4_before->hearing->hearing_date.' 00:00:00')) : '' }}</span> before <span class="bold uppercase">{{ $form4_before ? ($form4_before->president->ttpm_data->president->salutation ? $form4_before->president->ttpm_data->president->salutation->salutation_en : '').' '.$form4_before->president->name : '' }}</span> and the decision was read by <span class="bold uppercase">{{ $form4->president ? ($form4->president->ttpm_data->president->salutation ? $form4->president->ttpm_data->president->salutation->salutation_en : '').' '.$form4->president->name : '' }}</span> on <span class="bold uppercase"> {{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} </span> at <span class="bold uppercase">{{ $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span> in the presence of the Claimant and the Respondent, the Tribunal hereby orders:
			</p>

			<p class="bold justify" style="padding: 0 25px;">{!! nl2br($form4->award->award_description) !!}</p><br><br>

			<span>Dated the </span><span class='bold'>{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					<div class='parent' style="text-align: center;">
						<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
						<span style="margin-left: -25px" class="child">(SEAL)</span>
					</div>
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					{{-- <img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" />--}}<br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>

</body>