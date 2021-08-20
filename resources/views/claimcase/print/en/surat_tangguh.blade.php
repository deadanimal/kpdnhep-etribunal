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
			.title {
				text-decoration: underline; 
				font-weight:bold;
			}

			td {
				text-align: justify;
			}
		</style>
	</head>
	<body>
		<div style="padding-top: 150px; margin:30px;">
			<table >
				<tr>
					<td style="width: 60%"></td>
					<td style="width: 40%; text-align: right;">
						{{ $form4->case->case_no }}<br>
						{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}
					</td>
				</tr>
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


						<span class="title">To the Respondent</span><br><br>
						@if($form4->claimCaseOpponent->opponent_address)
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
						@if ($form4->claimCaseOpponent->opponent_address->street_2)
						{{ $form4->claimCaseOpponent->opponent_address->street_2 }},<br>
						@endif
						@if ($form4->claimCaseOpponent->opponent_address->street_3)
						{{ $form4->claimCaseOpponent->opponent_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->postcode }} {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}<br><br>
						@endif
						
						Mr/Mrs,<br><br>
						<span class="title">Claim No. {{ $form4->case->case_no }} </span><br><br>
						We respectfully refer to the above matter.<br><br>
						2. &nbsp;&nbsp;&nbsp; <span style="text-align: justify;">Please be informed that this claim which has been heard on <span style="font-weight: bold">{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} ({{ localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00')))}})</span> and has been adjourned. New hearing date will be held on <span style="font-weight: bold"> @if($form4->form4_next){{ date('d/m/Y', strtotime($form4->form4_next->hearing->hearing_date)) }} ({{ localeDay(date('l', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')))}})</span> at <span style="font-weight: bold"> {{ date('h:i A', strtotime('2000-01-01 '.$form4->form4_next->hearing->hearing_time)) }} </span> at <span style="font-weight: bold">{!! str_replace('<br>', ' ', $form4->form4_next->hearing->hearing_room ? $form4->form4_next->hearing->hearing_room->address : '') !!}@endif</span></span>. 

						<br><br>
						Thank you. <br><br>

						<b><i>"BERKHIDMAT UNTUK NEGARA"</i></b><br><br>

						Sincerely, <br><br>
						<!-- <img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/> -->
						<img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psus->first()->psu->user_id]) }}"/><br>
						<span style="font-weight: bold;text-transform: uppercase;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
						<span class="uppercase">
							@if($form4->psus)
								@if($form4->psus->first()->psu->roleuser->first()->role->name == "ks-hq" || $form4->psus->first()->psu->roleuser->first()->role->name == "ks")
									ASSISTANT SECRETARY
								@else
								{{ $form4->psus->first()->psu->roleuser->first()->role->display_name_en }}
								@endif
							@endif
						</span><br>
						p.p. .Chairman<br>
						The Tribunal for Consumer Claims <br> Malaysia. <br>
						c.c.&nbsp;&nbsp;&nbsp;{{ $form4->case->case_no }}
					</td>
				</tr>
			</table>
		</div>

	</body>
</html>