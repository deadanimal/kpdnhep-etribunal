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
		<div style="margin:30px; padding-top: 150px">
			<table>
				<tr>
					<td style="width: 60%"></td>
					<td style="width: 40%; text-align: right;">
						{{ $stop_notice->case->case_no }}<br>
						{{ date('d').' '.localeMonth(date('F')).' '.date('Y') }}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="title">To The Claimant</span><br><br>
						<span style="font-weight: bold; text-transform: uppercase;">{{ $stop_notice->case->claimant_address->name }}</span><br>
						@if($stop_notice->case->claimant_address->address_mailing_street_1)
							<span style="text-transform: uppercase;">
							{!! $stop_notice->case->claimant_address->address_mailing_street_1 ? $stop_notice->case->claimant_address->address_mailing_street_1.',<br>' : "" !!}
								{!! $stop_notice->case->claimant_address->address_mailing_street_2 ? $stop_notice->case->claimant_address->address_mailing_street_2 .',<br>' : "" !!}
								{!! $stop_notice->case->claimant_address->address_mailing_street_3 ? $stop_notice->case->claimant_address->address_mailing_street_3 .',<br>' : "" !!}
							<span style="font-weight: bold; text-transform: uppercase;">
								{{ $stop_notice->case->claimant_address->address_mailing_postcode ? $stop_notice->case->claimant_address->address_mailing_postcode : "" }}
								{!! $stop_notice->case->claimant_address->address_mailing_district_id ? $stop_notice->case->claimant_address->districtmailing->district .',<br>' : "" !!}
							</span>
							{{ $stop_notice->case->claimant_address->address_mailing_state_id ? $stop_notice->case->claimant_address->statemailing->state : "" }}
						</span>
						@else
							<span style="text-transform: uppercase;">
							{!! $stop_notice->case->claimant_address->street_1 ? $stop_notice->case->claimant_address->street_1.',<br>' : "" !!}
								{!! $stop_notice->case->claimant_address->street_2 ? $stop_notice->case->claimant_address->street_2.',<br>' : "" !!}
								{!! $stop_notice->case->claimant_address->street_3 ? $stop_notice->case->claimant_address->street_3.',<br>' : "" !!}
							<span style="font-weight: bold; text-transform: uppercase;">
								{{ $stop_notice->case->claimant_address->postcode ? $stop_notice->case->claimant_address->postcode : '' }}
								{!! $stop_notice->case->claimant_address->district ? $stop_notice->case->claimant_address->district->district.',<br>' : '' !!}
							</span>
							{{ $stop_notice->case->claimant_address->state_id ? $stop_notice->case->claimant_address->state->state : '' }}
						</span>
						@endif
						<br><br>
						<span class="title">To The Opponent</span><br><br>
						@if($stop_notice->multiOpponents->opponent_address)

						<span style="font-weight: bold; text-transform: uppercase;">{{ $stop_notice->multiOpponents->opponent_address->name }}</span><br>
						{{ $stop_notice->multiOpponents->opponent_address->street_1 }},<br>
						@if ($stop_notice->multiOpponents->opponent_address->street_2)
						{{ $stop_notice->multiOpponents->opponent_address->street_2 }},<br>
						@endif
						@if ($stop_notice->multiOpponents->opponent_address->street_3)
						{{ $stop_notice->multiOpponents->opponent_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold; text-transform: uppercase;">{{ $stop_notice->multiOpponents->opponent_address->postcode }} {{ $stop_notice->multiOpponents->opponent_address->district ? $stop_notice->multiOpponents->opponent_address->district->district : ''}},</span><br>
						{{ $stop_notice->multiOpponents->opponent_address->state ? $stop_notice->multiOpponents->opponent_address->state->state : ''}}<br><br>

						@endif

						Mr/Mrs,<br><br>
						<span class="title">Claim No. {{ $stop_notice->case->case_no }} </span><br><br>
						We refer to the Claimant dated at {{ date('d', strtotime($stop_notice->stop_notice_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($stop_notice->stop_notice_date.' 00:00:00'))).' '.date('Y', strtotime($stop_notice->stop_notice_date.' 00:00:00')) }} which states that the claim against the opponent is withdrawn / dismissed entirely. Accordingly, the claim @if($hearing_date)set at <span class="bold">{{ date('d', strtotime($hearing_date)).' '.localeMonth(date('F', strtotime($hearing_date))).' '.date('Y', strtotime($hearing_date)) }} ({{ localeDay(date('l', strtotime($hearing_date))) }})</span>@endif is <span class="title">cancelled</span>.<br><br>

						<br><br>
						Thank you. <br><br>

						<img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $stop_notice->psu_user_id]) }}"/>
						<br>
						<span style="font-weight: bold;text-transform: uppercase;">({{ $stop_notice->processed_by ? $stop_notice->processed_by->name : '' }})</span><br>
						<span class="uppercase">
							@if ($stop_notice->processed_by)
								@if($stop_notice->processed_by->roleuser->first()->role->name == "ks-hq" || $stop_notice->processed_by->roleuser->first()->role->name == "ks")
									Assistant Secretary
								@else
								{{ $stop_notice->processed_by->roleuser->first()->role->display_name_my }}
								@endif
							@endif
						</span><br>
						o.b. Chairman<br>
						The Tribunal for Consumer Claims <br> Malaysia.
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>