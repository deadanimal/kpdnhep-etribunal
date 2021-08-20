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
						{{ $form4->case->case_no }}<br>
						{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="title">Kepada Pihak yang Menuntut</span><br><br>
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->case->claimant->name }}</span><br>
						{{ $form4->case->claimant_address->street_1 }},<br>
						@if ($form4->case->claimant_address->street_2)
						{{ $form4->case->claimant_address->street_2 }},<br>
						@endif
						@if ($form4->case->claimant_address->street_3)
						{{ $form4->case->claimant_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->case->claimant_address->postcode }} {{ $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : '' }},</span><br>
						{{ $form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : '' }}<br><br>

						<span class="title">Kepada Pihak Penentang</span><br><br>
						@if($form4->claimCaseOpponent->opponent_address)

						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
						@if ($form4->claimCaseOpponent->opponent_address->street_2)
						{{ $form4->claimCaseOpponent->opponent_address->street_2 }},<br>
						@endif
						@if ($form4->claimCaseOpponent->opponent_address->street_3)
						{{ $form4->claimCaseOpponent->opponent_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold; text-transform: uppercase;">{{ $form4->claimCaseOpponent->opponent_address->postcode }} {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : ''}},</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : ''}}<br><br>
						@endif

						Tuan/Puan,<br><br>
						<span class="title">No. Tuntutan {{ $form4->case->case_no }} </span><br><br>
						Dengan hormatnya perkara di atas adalah dirujuk.<br><br>
						2. &nbsp;&nbsp; <span style="text-align: justify;">Dimaklumkan bahawa tuntutan ini yang telah didengar pada <span style="font-weight: bold">{{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} ({{ localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00')))}})</span> ditangguhkan. Tarikh pendengaran baru pada &nbsp; @if($form4->form4_next)<span style="font-weight: bold">{{ date('d/m/Y', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')) }} ({{localeDay(date('l', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')))}})</span> jam <span style="font-weight: bold"> {{ date('h:i A', strtotime('2000-01-01 '.$form4->form4_next->hearing->hearing_time)) }} </span> di <span style="font-weight: bold">{!! str_replace('<br>', ' ', $form4->form4_next->hearing->hearing_room ? $form4->form4_next->hearing->hearing_room->address : '') !!}@endif</span>. </span>

						<br><br>
						Sekian, terima kasih. <br><br>
						<span style="font-weight: bold; font-style: italic;">" BERKHIDMAT UNTUK NEGARA " </span><br><br>

						Saya yang menjalankan amanah, <br>
						<!-- <img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/> -->
						<img width="150px" height="100px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psus->first()->psu->user_id]) }}"/>
						<br>
						<span style="font-weight: bold;text-transform: uppercase;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
						<span class="uppercase">
							@if ($form4->psus)
								@if($form4->psus->first()->psu->roleuser->first()->role->name == "ks-hq" || $form4->psus->first()->psu->roleuser->first()->role->name == "ks")
									Penolong Setiausaha
								@else
								{{ $form4->psus->first()->psu->roleuser->first()->role->display_name_my }}
								@endif
							@endif
						</span><br>
						b.p .Pengerusi<br>
						Tribunal Tuntutan Pengguna <br> Malaysia. <br>
						s.k. &nbsp;&nbsp;&nbsp;{{ $form4->case->case_no }}
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>