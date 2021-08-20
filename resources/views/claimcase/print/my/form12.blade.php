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
		<span class='bold uppercase'>AKTA PERLINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PERLINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>
		<span class='bold uppercase'>Borang 12</span><br><br>
		<span class=''>(Peraturan 25)</span><br><br>
		<span class='bold uppercase italic'>PERMOHONAN UNTUK MENGETEPIKAN AWARD</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top' style="width: 36%">Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->case->claimant->name }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->case->claimant->username }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>
					{{ $form4->case->claimant_address->street_1 }},
					{{ $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2."," : "" }}
					{{ $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3."," : "" }}
					{{ $form4->case->claimant_address->postcode }}
					{{ $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : ''}},
					{{ $form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : '' }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top' style="width: 36%">Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->name : '' }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>{{ $form4->claimCaseOpponent->opponent->username }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase top'>
					@if ($form4->claimCaseOpponent->opponent_address)
					{{ $form4->claimCaseOpponent->opponent_address->street_1 }},
					{{ $form4->claimCaseOpponent->opponent_address->street_2 ? $form4->claimCaseOpponent->opponent_address->street_2."," : "" }}
					{{ $form4->claimCaseOpponent->opponent_address->street_3 ? $form4->claimCaseOpponent->opponent_address->street_3."," : "" }}
					{{ $form4->claimCaseOpponent->opponent_address->postcode }}
					{{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},
					{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : ''}}
					@endif
				</td>
			</tr>
		</table>
	</div>

	<table>
		<tr>
			<td class='top' style="width: 20px;">1.</td>
			<td class="justify">Suatu Award telah diperoleh terhadap saya pada <span class="bold">{{ $form4->award ? date('d', strtotime($form4->award->award_date." 00:00:00")).' '.localeMonth(date('F', strtotime($form4->award->award_date." 00:00:00"))).' '.date('Y', strtotime($form4->award->award_date." 00:00:00")) : '-'}}</span>.
			</td>
		</tr>
		<tr>
			<td class='top'>2.</td>
			<td>Saya dengan ini memohon untuk mengetepikan award itu.</td>
		</tr>

	</table>

	<div class='left break'>
		<table class='border'>
			<tr>
				<td class='bold'>
					Saya tidak hadir di pendengaran kerana :
				</td>
			</tr>
			<tr>
				<td class="justify">
					{{ $form4->form12->absence_reason }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					Saya tidak memfailkan pembelaan saya kerana :
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
				<td class='center italic no-padding top'>Tarikh</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Tandatangan / Cap ibu jari<br>kanan Pihak Yang Menuntut / Penentang</td>
			</tr>
			<tr>
				<td colspan="3" class="center uppercase bold">
					<br>
					NOTIS KEPADA PIHAK YANG MENUNTUT/PENENTANG
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p class="center no-padding justify">Pihak Yang Menuntut / Penentang telah memohon kepada Tribunal ini untuk mengetepikan award bertarikh <span class="underline">{{ $form4->award ? date('d', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) :'-' }}</span>.Tarikh dan masa pendengaran permohonan itu adalah sebagaimana yang dinyatakan di bawah ini.</p><br>
					
				</td>
			</tr>
			<tr>
				<td colspan="3" class="center">
					<span class="no-padding center">Tarikh pendengaran: 
					@if($form4->form4_next)
					@if($form4->form4_next->hearing)
					<span class="bold">{{ date('d', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->form4_next->hearing->hearing_date.' 00:00:00')) }}</span>
					@endif
					@endif
					Masa: 
					@if($form4->form4_next)
					@if($form4->form4_next->hearing)
					<span class="bold"> {{ date('g.i', strtotime($form4->form4_next->hearing->hearing_date.' '.$form4->form4_next->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->form4_next->hearing->hearing_date.' '.$form4->form4_next->hearing->hearing_time))) }} </span>
					@endif
					@endif
					</span><br>
					<!-- <span class="no-padding center">Tarikh pendengaran:<span class="bold"> {{ date('d', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</span> Masa : <span class="bold">{{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }} </span></span> -->
				</td>
			</tr>
		</table>


		<table>
			<tr>
				<td class='center' style="width: 45%">
					<span class="underline">{{ date('d', strtotime($form4->form12->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->form12->filing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->form12->filing_date.' 00:00:00')) }}</span><br>
					<span>Tarikh Pemfailan </span><br><br>
					<div class='parent' style="text-align: center;">
						<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
						<span style="margin-left: -45px" class="child">(METERAI)</span>
					</div>
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					{{-- <img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" />--}}<br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psus->first()->psu->name or '' }}</span><br>
						<span class='uppercase'>{{ $form4->psu->roleuser->first()->role->display_name_my }}<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>
	</div>

</body>