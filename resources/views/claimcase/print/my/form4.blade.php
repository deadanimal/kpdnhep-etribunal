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
		.indent {
			text-indent: 15px;
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
		<span class='bold uppercase'>AKTA PERLINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PERLINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 4</span><br>
		<span class=''>(Peraturan 18)</span><br><br>
		<span class='bold uppercase italic'>NOTIS PENDENGARAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>@if($form4->hearing->hearing_room) {{ $form4->hearing->hearing_room->venue->hearing_venue }} @else {{ $form4->case->branch->state->state_name }} @endif</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">ANTARA</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $form4->case->claimant_address->name }}<br>
					{{ $form4->case->claimant_address->nationality_country_id == 129 ? 'No. KP: '.$form4->case->claimant_address->identification_no : 'No. Pasport: '.$form4->case->claimant_address->identification_no }}

					@if($form4->case->extra_claimant)
					/
					<br><br>
					{{ $form4->case->extra_claimant->name }}<br>
					{{ $form4->case->extra_claimant->nationality_country_id == 129 ? 'No. KP: '.$form4->case->extra_claimant->identification_no : 'No. Pasport: '.$form4->case->extra_claimant->identification_no  }}
					@endif
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					@if ($form4->claimCaseOpponent->opponent_address)

					{{ $form4->claimCaseOpponent->opponent_address->name }}<br>
					@if($form4->claimCaseOpponent->opponent_address->is_company == 1)
					( {{ $form4->claimCaseOpponent->opponent_address->identification_no }} )
					@else
					{{ $form4->claimCaseOpponent->opponent_address->nationality_country_id == 129 ? 'No. KP: '.$form4->claimCaseOpponent->opponent_address->identification_no : 'No. Pasport: '.$form4->claimCaseOpponent->opponent_address->identification_no }}
					@endif

					@endif
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>AMBIL PERHATIAN bahawa tuntutan di atas akan didengar pada </span>
			<span class='bold'>
				
				{{ date('j', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00'))).')' }} </span>

			<span>pada jam </span>
			<span class='bold'>{{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }}</span>

			<span>di (Alamat tempat pendengaran) :- </span><br><br>

			<div style="margin-left: 50px;" class="justify">
			<span class='bold' >		
				Tribunal Tuntutan Pengguna Malaysia,<br>
				{!! $form4->hearing->hearing_room ? str_replace(',', ', ', $form4->hearing->hearing_room->address) : '-' !!}.
			</span><br><br>
			</div>
		</div>

		<span class="center bold uppercase">SILA BAWA SEMUA SAKSI, DOKUMEN, REKOD, ATAU BENDA UNTUK MENYOKONG TUNTUTAN/PEMBELAAN DAN TUNTUTAN BALAS ANDA</span><br><br>

		<div class='left'>
		<span>Bertarikh pada</span> <span class='bold'>{{ $form4->created_at->format('d').' '.localeMonth($form4->created_at->format('F')).' '.$form4->created_at->format('Y') }}</span><br>
		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					<div class='parent' style="text-align: center;">
						<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
						<span style="margin-left: -45px" class="child">(METERAI)</span>
					</div>
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu->user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psu->name }}</span><br>
						<span class='uppercase'>
							SETIAUSAHA
							<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA
						</span>
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
					<span class="bold uppercase"><u>NOTA MUSTAHAK KEPADA PIHAK YANG MENUNTUT</u></span><br><br>

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
					<span>Pihak Yang Menuntut hendaklah menyerah Borang 1 kepada Penentang dengan :-</span><br>
					<table>
						<tr>
							<td class='top' style="padding-left: 0px;">(i)</td>
							<td>pos berdaftar Akuan Terima (A.T); atau</td>
						</tr>
						<tr>
							<td class='top' style="padding-left: 0px;">(ii)</td>
							<td>memberikannya kepada Penentang sendiri, dengan serta-merta.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class='top' style="width: 10%;">2.</td>
				<td>
					Kad A.T. hendaklah dibawa semasa pendengaran.
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
					<span class="bold uppercase"><u>NOTA MUSTAHAK KEPADA PENENTANG</u></span><br><br>

					<span class="uppercase">
						{{ $form4->claimCaseOpponent->opponent_address->name }}<br>
						{{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
						{!! $form4->claimCaseOpponent->opponent_address->street_2 ? $form4->claimCaseOpponent->opponent_address->street_2.',<br>' : '' !!}
						{!! $form4->claimCaseOpponent->opponent_address->street_3 ? $form4->claimCaseOpponent->opponent_address->street_3.',<br>' : '' !!}
						{{ $form4->claimCaseOpponent->opponent_address->postcode }}
						{{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},<br>
						{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}.
					</span>
				</td>
			</tr>
			<tr>
				<td class='top'></td>
				<td>
					<span>Penentang yang adalah syarikat atau perniagaan hanya boleh diwakili oleh :-</span><br>
					<table>
						<tr>
							<td class='top' style="padding-left: 0px;">(i)</td>
							<td>seorang pekerja yang bergaji sepenuh masa dan membawa surat memberi kuasa (authorization letter);</td>
						</tr>
						<tr>
							<td class='top' style="padding-left: 0px;">(ii)</td>
							<td>pengarah, tuan punya atau pekongsi dan membawa salinan Borang 49 atau butir-butir perniagaan, mengikut mana-mana yang berkenaan.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>

		<hr style="border: 2px solid black;">

	</div>

</body>