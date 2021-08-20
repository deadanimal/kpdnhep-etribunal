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
		<span class='bold uppercase'>AKTA PERLINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PERLINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 3</span><br><br>
		<span class=''>(Peraturan 13)</span><br><br>
		<span class='bold uppercase italic'>PEMBELAAN KEPADA TUNTUTAN BALAS</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $claim->venue ? $claim->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">{{ $claim->claimant_address->name }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">{{ $claim->claimant_address->identification_no }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
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
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_home : '-' }}
				  / {{ $claim->claimant_address->is_company == 0 ? $claim->claimant_address->phone_mobile : '-' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel/No. Faks</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>
					{{ $claim->claimant_address->email }}>
				  /	{{ $claim->claimant_address->phone_fax or '-' }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->name : '' }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase top' colspan="4">{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->identification_no : '' }}</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
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
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_home : $claim_case_opponent->opponent_address->phone_office ? $claim_case_opponent->opponent->phone_office : '-') : '' }}
				   / {{ $claim_case_opponent->opponent_address ? ($claim_case_opponent->opponent_address->is_company == 0 ? $claim_case_opponent->opponent_address->phone_mobile : '-') : '' }}
				</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel/No. Faks</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>
					{{ $claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->email : ''}}
				  /	{{ $claim_case_opponent->opponent_address->phone_fax or '-' }}
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Pembelaan Kepada Tuntutan Balas :<br>
					Sila nyatakan pernyataan pembelaan tuntutan balas (sekiranya ada) dengan terperinci disini.<br>
					(**Rujukan kepada lampiran tidak akan diproses)
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
				<td class='center italic no-padding top'>Tarikh</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Tandatangan / Cap ibu jari kanan<br>Pihak Yang Menuntut</td>
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
				<td class='center italic no-padding top'>Tarikh Pemfailan</td>
				<td style="width: 20%"></td>
				<td class='center no-padding'>
					<span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
					<span class='uppercase'>SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<div class='parent' style="text-align: center;">
			<img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
			<span style="margin-left: -45px" class="child">(METERAI)</span>
		</div>
	</div>

	<div class='left break watermark'>

		<span class='bold uppercase'>ARAHAN KEPADA PIHAK YANG MENUNTUT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td class="justify">Jika anda mengakui tuntutan balas Penentang, anda hendaklah menyatakan dalam ruang yang disediakan untuk pembelaan kepada tuntutan balas itu bahawa anda mengakui tuntutan balas itu.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td class="justify">Jika anda mempertikaikan tuntutan balas itu, pembelaan anda kepada tuntutan balas itu hendaklah mengandungi butir-butir tentang mengapa anda mempertikaikan tuntutan balas itu.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td class="justify">Anda hendaklah menandatangani Borang 3 sendiri dan memfailkannya dalam 4 salinan di Pejabat Pendaftaran Tribunal. Pejabat Pendaftaran akan meletakkan meterai Tribunal pada 4 salinan itu dan mengembalikan dua salinan kepada anda.</td>
			</tr>
		</table>
	</div>

</body>