<html>
	<head>
		<style type="text/css">
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
		<div style="padding-top: 150px; margin:25px;">
			<table>
				<tr>
					<td style="width: 60%"></td>
					<td style="width: 40%; text-align: right;">
						{{ $form4->case->case_no }}<br>
						{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->case->claimant->name }}</span><br>
						@if($form4->case->claimant_address->address_mailing_street_1)
							<span style="text-transform: uppercase;">
							{!! $form4->case->claimant_address->address_mailing_street_1 ? $form4->case->claimant_address->address_mailing_street_1.',<br>' : "" !!}
								{!! $form4->case->claimant_address->address_mailing_street_2 ? $form4->case->claimant_address->address_mailing_street_2 .',<br>' : "" !!}
								{!! $form4->case->claimant_address->address_mailing_street_3 ? $form4->case->claimant_address->address_mailing_street_3 .',<br>' : "" !!}
								{{ $form4->case->claimant_address->address_mailing_postcode ? $form4->case->claimant_address->address_mailing_postcode : "" }}
								{!! $form4->case->claimant_address->address_mailing_district_id ? $form4->case->claimant_address->districtmailing->district .',<br>' : "" !!}
								{{ $form4->case->claimant_address->address_mailing_state_id ? $form4->case->claimant_address->statemailing->state : "" }}
						</span>
						@else
							<span style="text-transform: uppercase;">
							{!! $form4->case->claimant_address->street_1 ? $form4->case->claimant_address->street_1.',<br>' : "" !!}
								{!! $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2.',<br>' : "" !!}
								{!! $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3.',<br>' : "" !!}
								{{ $form4->case->claimant_address->postcode ? $form4->case->claimant_address->address_postcode : '' }}
								{!! $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district.',<br>' : '' !!}
								{{ $form4->case->claimant_address->state_id ? $form4->case->claimant_address->state->state : '' }}
						</span>
						@endif
						<br><br>

						Tuan/Puan,<br><br>
						<span class="title">Claimant No. {{ $form4->case->case_no }} </span><br><br>
						<span>Reference is made to the above matter.</span><br><br>
						<span class="justify">2. &nbsp;&nbsp;&nbsp;The claim which has been fixed for hearing on <span class="bold"> {{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} ({{ localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00')))}})</span> at <span class="bold"> {{ date('h:i A', strtotime('2000-01-01 '.$form4->hearing->hearing_time)) }}</span> at {{ $form4->hearing->hearing_room ? (str_replace("<br>", " ", $form4->hearing->hearing_room->address)) : '' }}, is<span style="font-weight: bold">cancelled</span> for result <span class="bold" style="text-transform: lowercase;">{{ $form4->hearing_position_reason ? $form4->hearing_position_reason->hearing_position_reason_en : '' }}</span></span>.

						<br><br>
						Thank you. <br><br>

						<b><i>"BERKHIDMAT UNTUK NEGARA"</i></b><br><br>

						Sincerely, <br><br>
						<!-- <img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/> -->
						<img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psus->first()->psu->user_id]) }}"/>
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
						</span><br>
						p.p. Chairman<br>
						The Tribunal for Consumer Claims <br> Malaysia. <br><br>
					</td>
				</tr>
			</table>
		</div>
		<div style="page-break-before: always; margin:25px;">
			
			c.c.<br><br>
			@if($form4->claimCaseOpponent->opponent_address)
			<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>
			{{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
			@if ($form4->claimCaseOpponent->opponent_address->street_2)
			{{ $form4->claimCaseOpponent->opponent_address->street_2 }},<br>
			@endif
			@if ($form4->claimCaseOpponent->opponent_address->street_3)
			{{ $form4->claimCaseOpponent->opponent_address->street_3 }},<br>
			@endif
			<span style="text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->postcode }} {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},</span><br>
			{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}<br>
			@endif
		</div>

	</body>
</html>