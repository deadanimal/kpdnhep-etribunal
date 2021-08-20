<head>
	<style>
		table {
			width: 100%;
			margin-top: 20px;
		}
		td, th {
			font-family: serif !important;
			padding: 10px;
			font-size: 20px;
			line-height: 25px;
		}
		span, a, p, h1, h2 {
			font-family: serif !important;
		}
		span, a, p {
			font-size: 20px;
			line-height: 25px;
		}
		p {
			text-indent: 30px;
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

	<!-- form 1 -->
	<div class='watermark'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>
		<span class='uppercase'>JADUAL KEDUA</span><br><br>
		<span class='uppercase'>BORANG-BORANG</span><br><br>
		<span class=''>(Peraturan 4)</span><br><br>
		<span class='bold uppercase'>Borang 1</span><br><br>
		<span class=''>(Peraturan 5)</span><br><br>
		<span class='bold uppercase italic'>PENYATAAN TUNTUTAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">**********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->claimant_address->street_1 }},
					{{ $claim->claimant_address->street_2 ? $claim->claimant_address->street_2."," : "" }}
					{{ $claim->claimant_address->street_3 ? $claim->claimant_address->street_3."," : "" }}
					{{ $claim->claimant_address->postcode }}
					{{ $claim->claimant_address->district->district }},
					{{ $claim->claimant_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">**********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->opponent_address->street_1 }},
					{{ $claim->opponent_address->street_2 ? $claim->opponent_address->street_2."," : "" }}
					{{ $claim->opponent_address->street_3 ? $claim->opponent_address->street_3."," : "" }}
					{{ $claim->opponent_address->postcode }}
					{{ $claim->opponent_address->district->district }},
					{{ $claim->opponent_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='camelcase'>Penyataan :</span>
		<table class='border'>
			<tr>
				<td>
					Tuntutan Pihak Yang Menuntut ialah untuk jumlah
					<span class='bold'>RM{{ number_format($claim->form1->claim_amount, 2, '.', ',') }}</span>
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					Butir-butir tuntutan :
				</td>
			</tr>
			<tr style="height: 150px; vertical-align: top;">
				<td>
					{{ $claim->form1->claim_details }}
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
				<td class='center italic no-padding top'>Tandatangan / Cap ibu jari kanan Pihak Yang Menuntut</td>
			</tr>
		</table>

		<table style="margin-top: 100px;">
			<tr>
				<td class='center no-padding' style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim->form1->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form1->filing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->filing_date.' 00:00:00')) }}</td>
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
					<span class='uppercase'>PENOLONG SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(METERAI)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>KEPADA PENENTANG :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;"></td>
				<td>Jika anda mempertikaikan tuntutan pihak yang menuntut, anda hendaklah memfailkan pertanyaan pembelaan anda dalam Borang 2 pada atau sebelum <span class='underline'>{{ date('j', strtotime($claim->form1->matured_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form1->matured_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->matured_date.' 00:00:00')) }}</span></td>
			</tr>
		</table>

		<br><br>

		<span class='bold uppercase'>ARAHAN KEPADA PIHAK YANG MENUNTUT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>Pihak yang menuntut hendaklah mengisi nama penuhnya dan nombor kad pengenalannya dalam ruang yang disediakan.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>Pihak yang menuntut hendaklah mengisi nama penuh penentang dan alamatnya yang terakhir diketahui dalam ruang yang disediakan.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>Pihak yang menuntut hendaklah menyatakan amaun tepat yang dituntut dalam ruang yang disediakan. Amaun yang dituntut itu tidak boleh melebihi RM50,000.00. Jika amaun itu melebihi RM50,000.00 maka tuntutan itu hendaklah difaikan di Mahkamah Majistret Kelas Satu.</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>Pihak yang menuntut hendaklah menyatakan butir-butir tuntutannya dalam ruang yang disediakan. Butir-butir itu hendaklah menyatakan tarikh yang berkaitan dan bagaimana tuntutan itu telah berbangkit atau apakah asas tuntutan itu.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>Jika ruang yang disediakan tidak mencukupi, sila gunakan helaian kertas yang berasingan dan tuliskan "sila lihat muka sebelah". Apa-apa helaian kertas yang digunakan hendaklah dilampirkan bersama Borang ini.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>Setelah mengisikan butir-butir, pihak yang menuntut hendaklah menandatangani Borang ini sendiri.</td>
			</tr>
			<tr>
				<td class='top'>7.</td>
				<td>Setelah menyiapkan Borang ini, pihak yang menuntut hendaklah memfailkan Borang ini dalam 4 salinan di Pejabat Pendaftaran Tribunal. Pihak yang menuntut hendaklah membayar fi pemfailan sebanyak RM5.00. Pejabat Pendaftaran akan meletakkan meterai Tribunal pada 4 salinan itu. Dua salinan Borang ini akan dikembalikan kepada pihak yang menuntut.</td>
			</tr>
			<tr>
				<td class='top'>8.</td>
				<td>
					Anda tidak boleh diwakili oleh peguam pada pendengaran itu.<br><br>
					<div class='border' style="padding: 10px">
						<span class='bold uppercase'>NOTA MUSTAHAK KEPADA PIHAK YANG MENUNTUT :</span>

						<table>
							<tr>
								<td class='top' style="width: 20px;">1.</td>
								<td>
									Pihak Yang Menuntut hendaklah menyerahkan Borang 1 kepada Penentang dengan -<br>
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
								<td class='top'>2.</td>
								<td>
									Kad A.T. hendaklah dibawa semasa pendengaran.
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>ARAHAN KEPADA PENENTANG :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>Apabila anda menerima Borang ini yang dimeteraikan dengan meterai Tribunal, anda adalah didakwa oleh pihak yang menuntut.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>Jika anda mempertikaikan tuntutan itu anda hendaklah menyatakan pembelaan anda, dengan butir-butir, dalam Borang 2.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>Anda hendaklah memfailkan pernyataan pembelaan anda di Pejabat Pendaftaran Tribunal</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>Jika anda gagal memfailkan pembelaan anda dalam masa yang ditetapkan atau jika anda gagal hadir di hadapan Tribunal pada tarikh pendengaran, maka Tribunal akan membuat award dengan memihak kepada pihak yang menuntut.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>Anda tidak boleh diwakili oleh peguam pada pendengaran itu.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>Anda dikehendaki menyerahkan Borang 2 kepada Pihak Yang Menuntut.</td>
			</tr>
			<tr>
				<td class='top'></td>
				<td>
					<br><br><br><br>
					<span class="camelcase">Sila Kembalikan Ke :-</span><br><br><br>

					<span class="italic camelcase">Ketua Seksyen,</span><br>
					<span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
					<span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
					<span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
					<span class="italic">{{ $claim->branch->branch_postcode }}</span>
					<span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
					<span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
					<span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
					<span class="italic">Faks: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
					<span class="italic">Talian Bebas Tol: 1800-88-9811</span><br>
					<span class="italic">E-mel: </span><span class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<div class="center">
			<h1 style="text-decoration: underline;">Sistem e-Tribunal</h1><br><br><br><br><br>

			<table class="border" style="margin: 20px 10%; width: 80%;">
				<tr>
					<td class='camelcase' style="width: 30%">No. Tuntutan</td>
					<td class='divider'>:</td>
					<td class='uppercase'>{{ $claim->case_no }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Tarikh Pendengaran</td>
					<td class='divider'>:</td>
					<td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Masa Pendengaran</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>No. Resit Borang 1</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form1->payment->receipt_no }}</td>
				</tr>
			</table>
		</div>

		<br><br>

		<p>Terima kasih kerana berurusan dengan Tribunal Tuntutan Pengguna Malaysia. Sila simpan dokumen ini sebagai rujukan.</p>
	</div>
	<!-- end form 1 -->

	<!-- form 2 -->
	@if($claim->form1->form2)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 2</span><br>
		<span class=''>(Peraturan 9)</span><br><br>
		<span class='bold uppercase italic'>PENYATAAN PEMBELAAN DAN TUNTUTAN BALAS</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->claimant_address->street_1 }},
					{{ $claim->claimant_address->street_2 ? $claim->claimant_address->street_2."," : "" }}
					{{ $claim->claimant_address->street_3 ? $claim->claimant_address->street_3."," : "" }}
					{{ $claim->claimant_address->postcode }}
					{{ $claim->claimant_address->district->district }},
					{{ $claim->claimant_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->opponent_address->street_1 }},
					{{ $claim->opponent_address->street_2 ? $claim->opponent_address->street_2."," : "" }}
					{{ $claim->opponent_address->street_3 ? $claim->opponent_address->street_3."," : "" }}
					{{ $claim->opponent_address->postcode }}
					{{ $claim->opponent_address->district->district }},
					{{ $claim->opponent_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Penyataan pembelaan :
				</td>
			</tr>
			<tr style="height: 150px; vertical-align: top;">
				<td>
					{{ $claim->form1->form2->defence_statement }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					Tuntutan balas :
				</td>
			</tr>
			<tr style="height: 150px; vertical-align: top;">
				<td>
					{{ $claim->form1->form2->counterclaim ? $claim->form1->form2->counterclaim->counterclaim_statement : '- Tiada -' }}
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
				<td class='center italic no-padding top'>Tandatangan / Cap ibu jari kanan Penentang</td>
			</tr>
		</table>

		<table style="margin-top: 100px;">
			<tr>
				<td class='center no-padding' style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim->form1->form2->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form1->form2->filing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->form2->filing_date.' 00:00:00')) }}</td>
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
					<span class='uppercase'>PENOLONG SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(METERAI)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>ARAHAN KEPADA PENENTANG :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>Jika anda mengakui tuntutan pihak yang menuntut, anda bolehlah menyatakan dalam ruang yang disediakan untuk pertanyaan pembelaan bahawa anda mengakui tuntutan itu.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>Jika anda mempertikaikan tuntutan itu, pernyataan pembelaan anda hendaklah mengandungi butir-butir tentang mengapa anda mempertikaikan tuntutan itu.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>Jika anda mempunyai apa-apa tuntutan balas, anda hendaklah  menyatakan tuntutan balas anda dengan butir-butir dalam ruang yang disediakan.</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>Jika ruang yang disediakan tidak mencukupi, sila gunakan helaian kertas yang berasingan dan tuliskan "sila lihat muka surat sebelah". Apa-apa helaian kertas yang digunakan hendaklah dilampirkan bersama Borang ini.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>Anda hendaklah memfailkan pembelaan anda (dan tuntutan balas jika ada ) dalam had masa, jika tidak award akan dibuat dengan memihak kepada pihak yang menuntut.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>Anda hendaklah menandatangani Borang 2 sendiri dan  memfailkannya dalam 4 salinan di Pejabat Pendaftaran Tribunal . Dalam hal suatu pertubuhan perbadanan, Borang ini hendaklah ditandatangani oleh seorang pengarah, pengurus, setiausaha atau pegawai lain seumpamanya. Fi pemfailan ialah sebanyak RM5.00.  Pejabat Pendaftaran akan meletakkan meterai Tribunal pada  4 salinan itu dan mengembalikan dua salinan kepada anda.</td>
			</tr>
			<tr>
				<td class='top'></td>
				<td>
					<br><br><br><br>
					<span class="camelcase">Sila Kembalikan Ke :-</span><br><br><br>

					<span class="italic camelcase">Ketua Seksyen,</span><br>
					<span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
					<span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
					<span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
					<span class="italic">{{ $claim->branch->branch_postcode }}</span>
					<span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
					<span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
					<span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
					<span class="italic">Faks: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
					<span class="italic">Talian Bebas Tol: 1800-88-9811</span><br>
					<span class="italic">E-mel: </span><span class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<div class="center">
			<h1 style="text-decoration: underline;">Sistem e-Tribunal</h1><br><br><br><br><br>

			<table class="border" style="margin: 20px 10%; width: 80%;">
				<tr>
					<td class='camelcase' style="width: 30%">No. Tuntutan</td>
					<td class='divider'>:</td>
					<td class='uppercase'>{{ $claim->case_no }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Tarikh Pendengaran</td>
					<td class='divider'>:</td>
					<td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Masa Pendengaran</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>No. Resit Borang 2</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form1->form2->payment->receipt_no }}</td>
				</tr>
			</table>
		</div>

		<br><br>

		<p>Terima kasih kerana berurusan dengan Tribunal Tuntutan Pengguna Malaysia. Sila simpan dokumen ini sebagai rujukan.</p>
	</div>
	@endif
	<!-- end form 2 -->

	<!-- form 3 -->
	@if($claim->form1->form2)
	@if($claim->form1->form2->form3)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 3</span><br><br>
		<span class=''>(Peraturan 13)</span><br><br>
		<span class='bold uppercase italic'>PEMBELAAN KEPADA TUNTUTAN BALAS</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ****** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->claimant_address->street_1 }},
					{{ $claim->claimant_address->street_2 ? $claim->claimant_address->street_2."," : "" }}
					{{ $claim->claimant_address->street_3 ? $claim->claimant_address->street_3."," : "" }}
					{{ $claim->claimant_address->postcode }}
					{{ $claim->claimant_address->district->district }},
					{{ $claim->claimant_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ****** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">
					{{ $claim->opponent_address->street_1 }},
					{{ $claim->opponent_address->street_2 ? $claim->opponent_address->street_2."," : "" }}
					{{ $claim->opponent_address->street_3 ? $claim->opponent_address->street_3."," : "" }}
					{{ $claim->opponent_address->postcode }}
					{{ $claim->opponent_address->district->district }},
					{{ $claim->opponent_address->state->state }}
				</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Tel.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>No. HP.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mel</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>No. Faks</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Pembelaan kepada tuntutan balan :
				</td>
			</tr>
			<tr style="height: 250px; vertical-align: top;">
				<td>
					{{ $claim->form1->form2->form3->defence_counterclaim_statement }}
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
				<td class='center italic no-padding top'>Tandatangan / Cap ibu jari kanan Pihak Yang Menuntut</td>
			</tr>
		</table>

		<table style="margin-top: 100px;">
			<tr>
				<td class='center no-padding' style="width: 40%; text-decoration: underline;">{{ date('j', strtotime($claim->form1->filing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form1->form2->form3->filing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->filing_date.' 00:00:00')) }}</td>
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
					<span class='uppercase'>PENOLONG SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(METERAI)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<span class='bold uppercase'>ARAHAN KEPADA PIHAK YANG MENUNTUT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>Jika anda mengakui tuntutan balas penentang, anda hendaklah menyatakan dalam ruang yang disediakan untuk pembelaan kepada tuntutan balas itu bahawa anda mengakui tuntutan balas itu.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>Jika anda mempertikaikan tuntutan balas itu, pembelaan anda kepada tuntutan balas itu hendaklah mengandungi butir-butir tentang mengapa anda mempertikaikan tuntutan balas itu.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>Anda hendaklah menandatangani Borang 3 sendiri dan memfailkannya dalam 4 Salinan di Pejabat Pendaftaran Tribunal. Pejabat Pendaftaran akan meletakkan meterai Tribunal pada 4 salinan itu dan mengembalikan dua salinan kepada anda.</td>
			</tr>
		</table>
	</div>
	@endif
	@endif

	<!-- end form 3 -->

	<!-- form 4 -->
	@if(count($claim->form4) > 0)
	@foreach($claim->form4 as $form4)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 4</span><br>
		<span class=''>(Peraturan 18)</span><br><br>
		<span class='bold uppercase italic'>NOTIS PENDENGARAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ****** *********<br>
					***********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ****** *********<br>
					***********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>AMBIL PERHATIAN bahawa tuntutan di atas akan didengar pada </span>
			<span class='bold'>{{ date('j', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00'))).')' }} </span>

			<span>pada jam </span>
			<span class='bold'>{{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }}</span>

			<span>di (Alamat tempat pendengaran) :- </span><br><br>

			<span class='bold'>
				{{ $form4->hearing->hearing_room->hearing_room }},<br>
				{!! str_replace(',', ', ', $form4->hearing->hearing_room->address) !!}.
			</span><br><br>
		</div>

		<span class="center bold uppercase">SILA BAWA SEMUA SAKSI, DOKUMEN, REKOD, ATAU BENDA UNTUK MENYOKONG TUNTUTAN/PEMBELAAN DAN TUNTUTAN BALAS ANDA</span><br><br>

		<div class='left'>
		Bertarikh pada <span class='bold'>{{ date('h').' '.localeMonth(date('F')).' '.date('Y') }}</span><br>
		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu->user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psu->name }}</span><br>
						<span class='uppercase'>PENOLONG SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
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
						{{ $form4->case->claimant->name }}<br>
						{{ $form4->case->claimant_address->street_1 }},<br>
						{!! $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2.',<br>' : '' !!}
						{!! $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3.',<br>' : '' !!}
						{{ $form4->case->claimant_address->postcode }}
						{{ $form4->case->claimant_address->district->district }},<br>
						{{ $form4->case->claimant_address->state->state }}.
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
						{{ $form4->case->opponent->name }}<br>
						{{ $form4->case->opponent_address->street_1 }},<br>
						{!! $form4->case->opponent_address->street_2 ? $form4->case->opponent_address->street_2.',<br>' : '' !!}
						{!! $form4->case->opponent_address->street_3 ? $form4->case->opponent_address->street_3.',<br>' : '' !!}
						{{ $form4->case->opponent_address->postcode }}
						{{ $form4->case->opponent_address->district->district }},<br>
						{{ $form4->case->opponent_address->state->state }}.
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
							<td>seorang pekerja yang bergaji sepenuh masa dan membawa surat memberi kuasa (authorize letter);</td>
						</tr>
						<tr>
							<td class='top' style="padding-left: 0px;">(ii)</td>
							<td>pengarah, tuan punya atau pekongsi dan membawa salinan Borang 49 atau butir-butir perniagaan yang mana berkenaan.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>

		<hr style="border: 2px solid black;">

	</div>

	<!-- check for award -->
	@if($form4->award)

	<!-- form 5 -->
	@if($form4->award->award_type == 5)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 5</span><br><br>
		<span class=''>(Peraturan 19)</span><br><br>
		<span class='bold uppercase italic'>AWARD BAGI PIHAK YANG MENUNTUT JIKA<br>PENENTANG TIDAK MEMFAILKAN PERNYATAAN PEMBELAAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>Pernyataan tuntutan (Borang 1) telah diserahkan kepada penentang dan penentang telah gagal untuk memfailkan pembelaannya dalam masa yang ditetapkan, Tribunal dengan ini membuat award yang berikut:</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 5 -->

	<!-- form 6 -->
	@if($form4->award->award_type == 6)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 6</span><br><br>
		<span class=''>(Peraturan 20)</span><br><br>
		<span class='bold uppercase italic'>AWARD JIKA RESPONDEN MENGAKUI TUNTUTAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>Penentang telah mengakui tuntutan, Tribunal dengan ini memerintahkan</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 6 -->

	<!-- form 7 -->
	@if($form4->award->award_type == 7)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 7</span><br><br>
		<span class=''>(Subperaturan 21(2))</span><br><br>
		<span class='bold uppercase italic'>AWARD BAGI PENENTANG<br>JIKA PIHAK YANG MENUNTUT TIDAK HADIR</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>Tindakan ini telah pada hari ini dipanggil untuk pendengaran di hadapan <span class="uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> dengan kehadiran penentang, dan tanpa kehadiran pihak yang menuntut, Tribunal dengan ini memerintahkan:</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 7 -->

	<!-- form 8 -->
	@if($form4->award->award_type == 8)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 8</span><br><br>
		<span class=''>(Subperaturan 21(5))</span><br><br>
		<span class='bold uppercase italic'>AWARD BAGI PIHAK YANG MENUNTUT<br>JIKA PENENTANG TIDAK HADIR</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				Tindakan ini telah di dengar di hadapan <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> pada <b>{{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</b> dengan kehadiran Pihak Yang Menuntut, dan tanpa kehadiran Penentang, Tribunal dengan ini memerintahkan:
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 8 -->

	<!-- form 9 -->
	@if($form4->award->award_type == 9)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 9</span><br><br>
		<span class=''>(Subperaturan 22(2))</span><br><br>
		<span class='bold uppercase italic'>AWARD DENGAN PERSETUJUAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				Tindakan ini telah di dengar di hadapan <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> pada <b>{{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</b> dengan kehadiran pihak yang menuntut dan penentang, dan kedua-dua pihak telah bersetuju, Tribunal dengan ini memerintahkan:
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 9 -->

	<!-- form 10 -->
	@if($form4->award->award_type == 10)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 10</span><br><br>
		<span class=''>(Subperaturan 23(5))</span><br><br>
		<span class='bold uppercase italic'>AWARD SELEPAS PENDENGARAN</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
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
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				Tindakan ini telah didengar di hadapan <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> pada <b>{{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</b> dengan kehadiran pihak yang menuntut dan penentang, Tribunal dengan ini memerintahkan: Bagi B10B
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Bertarikh pada <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDEN<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>
	@endif
	<!-- end form 10 -->

	@endif
	<!-- end check for award -->


	@endforeach
	@endif
	<!-- end form 4 -->

	<!-- form 12 -->
	@if(count($claim->form12) > 0)
	<div class='watermark break'>
		<span class='bold uppercase'>AKTA PELINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PELINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>
		<span class='bold uppercase'>Borang 12</span><br><br>
		<span class=''>(Peraturan 25)</span><br><br>
		<span class='bold uppercase italic'>PERMOHONAN UNTUK MENGETEPIKAN AWARD</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Pihak Yang Menuntut</td>
				<td class='divider'>:</td>
				<td class='uppercase'>***** ********* *******</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan</td>
				<td class='divider'>:</td>
				<td class='uppercase'>*******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $form4->case->claimant_address->street_1 }},
					{{ $form4->case->claimant_address->street_2 ? $form4->case->claimant_address->street_2."," : "" }}
					{{ $form4->case->claimant_address->street_3 ? $form4->case->claimant_address->street_3."," : "" }}
					{{ $form4->case->claimant_address->postcode }}
					{{ $form4->case->claimant_address->district->district }},
					{{ $form4->case->claimant_address->state->state }}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Nama Penentang</td>
				<td class='divider'>:</td>
				<td class='uppercase'>***** ********* *******</td>
			</tr>
			<tr>
				<td class='camelcase top'>No. Kad Pengenalan / No Pendaftaran Syarikat / Perniagaan</td>
				<td class='divider'>:</td>
				<td class='uppercase'>*******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Alamat</td>
				<td class='divider'>:</td>
				<td class='uppercase'>
					{{ $form4->case->opponent_address->street_1 }},
					{{ $form4->case->opponent_address->street_2 ? $form4->case->opponent_address->street_2."," : "" }}
					{{ $form4->case->opponent_address->street_3 ? $form4->case->opponent_address->street_3."," : "" }}
					{{ $form4->case->opponent_address->postcode }}
					{{ $form4->case->opponent_address->district->district }},
					{{ $form4->case->opponent_address->state->state }}
				</td>
			</tr>
		</table>
	</div>

	<table>
		<tr>
			<td class='top' style="width: 20px;">1.</td>
			<td>Suatu Award telah diperoleh terhadap saya pada {{ date('j F Y', strtotime($form4->award->award_date." 00:00:00")) }}.
			</td>
		</tr>
		<tr>
			<td class='top'>2.</td>
			<td>Saya dengan ini memohon untuk mengetepikan award itu.</td>
		</tr>

	</table>

	<div class='left break watermark'>
		<span class='camelcase'>Saya tidak hadir di pendengaran kerana :</span>
		<table class='border'>
			<tr>
				<td>
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
				<td>
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
				<td colspan="3">
					<span class="center uppercase bold no-padding">NOTIS KEPADA PIHAK YANG MENUNTUT/PENENTANG</span><br><br>
					<span class="center no-padding">Pihak Yang Menuntut / Penentang telah memohon kepada Tribunal ini untuk mengetepikan award bertarikh <span class="underline">{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span>.Tarikh dan masa pendengaran permohonan itu adalah sebagaimana yang dinyatakan di bawah ini.</span><br>
					<span>Tarikh pendengaran: {{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} Masa : {{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }} @if(date("H", strtotime($form4->hearing->hearing_date." ".$form4->hearing->hearing_time)) < 12) pagi @else tengah hari @endif</span>
				</td>
			</tr>
		</table>


		<table>
			<tr>
				<td class='center' style="width: 45%">
					(METERAI)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psus ? $form4->psus->first()->psu->name : '' }}</span><br>
						<span class='uppercase'>PENOLONG SETIAUSAHA<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>
	</div>

	@endif
	<!-- end form 12 -->
</body>