<html>
	<head>
		<style type="text/css">
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
		<div style="margin:30px; margin-top: 150px;">
			<table>
				<tr>
					<td style="width: 80%"></td>
					<td style="width: 20%"></td>
				</tr>
				<tr>
					<td style="width: 80%"></td>
					<td style="width: 20%">{{ date('d/m/Y') }}</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="title">Kepada Pihak yang Menuntut</span><br><br>
						<span style="font-weight: bold">{{ $form4->case->claimant->name }}</span><br>
						{{ $form4->case->claimant->public_data->address_mailing_street_1 }},<br>
						@if ($form4->case->claimant->public_data->address_mailing_street_2)
						{{ $form4->case->claimant->public_data->address_mailing_street_2 }},<br>
						@if ($form4->case->claimant->public_data->address_mailing_street_3)
						{{ $form4->case->claimant->public_data->address_mailing_street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->case->claimant->public_data->address_mailing_postcode }} {{ $form4->case->claimant->public_data->mailing_district->district }},</span><br>
						{{ $form4->case->claimant->public_data->mailing_state->state }}<br><br>

						Tuan/Puan,<br><br>
						<span style="font-weight: bold">No. Tuntutan {{ $form4->case->case_no }} </span><br><br>
						Bersama-sama ini dilampirkan satu salinan award Tribunal untuk tindakan tuan/puan seperti berikut:

						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px">Tuan / puan dikehendaki menyerahkan award ini secepat mungkin ke atas Penentang / Pihak Yang Menuntut dengan cara pos berdaftar akuan terima atau dengan tangan.</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px">Bukti penyerahan award tersebut hendaklah di simpan oleh tuan / puan bagi tujuan penguatkuasaan award ini.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"  style="padding-top: 20px;">
						<span class="title">Kepada Pihak Penentang</span><br><br>
						<span style="font-weight: bold">{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>
						{{ $form4->claimCaseOpponent->opponent->public_data->address_mailing_street_1 }},<br>
						@if ($form4->claimCaseOpponent->opponent->public_data->address_mailing_street_2)
						{{ $form4->claimCaseOpponent->opponent->public_data->address_mailing_street_2 }},<br>
						@if ($form4->claimCaseOpponent->opponent->public_data->address_mailing_street_3)
						{{ $form4->claimCaseOpponent->opponent->public_data->address_mailing_street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->claimCaseOpponent->opponent->public_data->address_mailing_postcode }} {{ $form4->claimCaseOpponent->opponent->public_data->mailing_district->district }},</span><br>
						{{ $form4->claimCaseOpponent->opponent->public_data->mailing_state->state }}<br><br>

						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px"">Tuan/puan hendaklah mematuhi award ini dalam masa 14 hari daripada tarikh award ini di terima oleh tuan/puan atau hendaklah mematuhi award ini mengikut tempoh masa yang telah ditetapkan di dalam award.</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px"">Jika tuan/puan gagal mematuhi award ini dalam masa 14 hari daripada tarikh award ini di terima oleh tuan / puan atau hendaklah mematuhi award ini mengikut tempoh masa yang telah ditetapkan di dalam award, adalah menjadi suatu kesalahan jenayah di bawah <span style="font-weight: bold">Seksyen 117 Akta Perlindungan Pengguna (APP) 1999</span> seperti berikut:

									<table>
										<tr>
											<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(a)</td>
											<td style="padding-top: 10px""><span class="title">Seksyen 117(1) APP 1999</span><br>
												<span style="text-decoration: underline;">Kesalahan Pertama</span> - Denda tidak melebihi RM10,000 atau penjara selama tempoh tidak melebihi 2 tahun atau kedua-duanya.
											</td>
										</tr>
										<tr>
											<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(b)</td>
											<td style="padding-top: 10px""><span class="title">Seksyen 117(2) APP 1999</span><br>
												<span style="text-decoration: underline;">Kesalahan Yang Berterusan</span> - Sebagai tambahan kepada penalti di bawah seksyen 117 (1) di atas, didenda tidak kurang daripada satu ratus ringgit dan tidak melebihi lima ribu ringgit bagi setiap hari atau sebahagian hari selama kesalahan itu berterusan selepas sabitan.
											</td>
										</tr>
									</table>


								</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(3)</td>
								<td style="padding-top: 10px"">Jika tuan/puan mempertikaikan award ini, tuan/puan boleh mengetepikan award ini dengan memfailkan permohonan dalam Borang 12 dalam masa tiga puluh (30) hari selepas award diterima.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"  style="padding-top: 20px;">
						<span class="title">Kepada Pihak yang Menuntut</span><br><br>
						<span style="font-weight: bold">{{ $form4->case->claimant->name }}</span><br>
						{{ $form4->case->claimant->public_data->address_mailing_street_1 }},<br>
						@if ($form4->case->claimant->public_data->address_mailing_street_2)
						{{ $form4->case->claimant->public_data->address_mailing_street_2 }},<br>
						@if ($form4->case->claimant->public_data->address_mailing_street_3)
						{{ $form4->case->claimant->public_data->address_mailing_street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->case->claimant->public_data->address_mailing_postcode }} {{ $form4->case->claimant->public_data->mailing_district->district }},</span><br>
						{{ $form4->case->claimant->public_data->mailing_state->state }}<br><br>

						Jika Pihak Yang Menuntut / Penentang gagal mematuhi award ini selepas tempoh 14 hari dari tarikh award ini di terima atau gagal mematuhi award ini mengikut tempoh masa yang telah ditetapkan di dalam award, tuan / puan boleh:-

						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px"">membuat aduan kepada <span style="font-weight: bold">Pengarah,  Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri, Koperasi dan Kepenggunaan, Aras 3 (Menara), Tingkat 17, Menara MRCB, Jalan Majlis, Seksyen 14, 40622  Shah Alam, Selangor</span> supaya tindakan boleh diambil untuk mendakwa Pihak Yang Menuntut / Penentang di Mahkamah di bawah seksyen 117 Akta Pelindungan Pengguna 1999;</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px"">sesalinan aduan tersebut hendaklah dihantarkan kepada <span style="font-weight: bold">Ketua Seksyen (Penolong Setiausaha),  Tribunal Tuntutan Pengguna Malaysia, Pejabat Perdagangan Dalam Negeri, Koperasi Dan Kepenggunaan Selangor, Tingkat 17, Menara MRCB, Jalan Majlis, Seksyen 14, 40622 Shah Alam, Selangor</span> untuk makluman; atau</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(3)</td>
								<td style="padding-top: 10px"">tuan / puan juga boleh memilih untuk menguatkuasakan award dengan sendiri di bawah seksyen 116(1)(b) Akta Perlindungan Pengguna 1999 di <span style="font-weight: bold">Mahkamah Magistrate Court Shah Alam</span>;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						Sekian, terima kasih. <br><br>
						<span style="font-weight: bold; font-style: italic;">" BERKHIDMAT UNTUK NEGARA " </span><br><br>

						Saya yang menjalankan amanah, <br>
						<img width="200px" height="150px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/>
						<br>
						<span style="font-weight: bold;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
						Penolong Setiausaha<br>
						b.p. Setiausaha<br>
						Tribunal Tuntutan Pengguna <br> Malaysia. <br>
						s.k {{ $form4->case->case_no }}
					</td>
				</tr>
			</table>
		</div>
		<div style="page-break-before: always; margin:30px;">
		</div>
	</body>
</html>