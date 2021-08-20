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
		<div style="margin:25px;">
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
						<span class="title">To the Claimant</span><br><br>
						<span style="font-weight: bold">{{ $form4->case->claimant->name }}</span><br>
						{{ $form4->case->claimant_address->street_1 }},<br>
						@if ($form4->case->claimant_address->street_2)
						{{ $form4->case->claimant_address->street_1 }},<br>
						@if ($form4->case->claimant_address->street_3)
						{{ $form4->case->claimant_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->case->claimant_address->postcode }} {{ $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : '' }},</span><br>
						{{ $form4->case->claimant_address ? $form4->case->claimant_address->state->state : '' }}<br><br>

						Mr/Mrs,<br><br>
						<span style="font-weight: bold">Claim No. {{ $form4->case->case_no }} </span><br><br>
						Hereby attached a copy of the Tribunal's award for your actions as follows:
						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px">Mr/Mrs are required to submit this award as soon as possible against the Respondent / Claimant by way of a registered post or by hand.</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px">The proof of delivery of the award shall be kept by you for the purpose of enforcing this award.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"  style="padding-top: 20px;">
						<span class="title">To the Opponent</span><br><br>
						@if($form4->claimCaseOpponent->opponent_address)
						<span style="font-weight: bold">{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->street_1 }},<br>
						@if ($form4->claimCaseOpponent->opponent_address->street_2)
						{{ $form4->claimCaseOpponent->opponent_address->street_2 }},<br>
						@if ($form4->claimCaseOpponent->opponent_address->street_3)
						{{ $form4->claimCaseOpponent->opponent_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->claimCaseOpponent->opponent_address->postcode }} {{ $form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '' }},</span><br>
						{{ $form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '' }}<br><br>
						@endif
						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px"">Mr/Mrs must comply with this award within 14 days from the date the award was received by Mr/Mrs or to comply with this award within the timeframe set forth in the award.</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px"">If Mr/Mrs fail to comply with this award within 14 days from the date the award was received by Mr/Mrs or to comply with this award within the timeframe specified in the award, it shall be a criminal offense under <span style="font-weight: bold">Section 117 of the Consumer Protection Act (APP) 1999</span> as follows:

									<table>
										<tr>
											<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(a)</td>
											<td style="padding-top: 10px""><span class="title">Section 117(1) APP 1999</span><br>
												<span style="text-decoration: underline;">First Offence</span> - A fine not exceeding RM5,000 or imprisonment for not more than 2 years or both.
											</td>
										</tr>
										<tr>
											<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(b)</td>
											<td style="padding-top: 10px""><span class="title">Section 117(2) APP 1999</span><br>
												<span style="text-decoration: underline;">Continuous Offenses</span> - In addition to penalties under section 117 (1) above, a fine not exceeding RM1,000 for each day or part of the day during which the offense continues after conviction.
											</td>
										</tr>
									</table>


								</td>
							</tr>
							@if($form4->award->award_type != 9 || $form4->award->award_type != 10)
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(3)</td>
								<td style="padding-top: 10px"">If Mr/Mrs disagree with this award, Mr/Mrs may disregard this award by filing an application in Form 12 within thirty days after the award is received</td>
							</tr>
							@endif
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2"  style="padding-top: 20px;">
						<span class="title">To the Claimant</span><br><br>
						<span style="font-weight: bold">{{ $form4->case->claimant->name }}</span><br>
						{{ $form4->case->claimant_address->street_1 }},<br>
						@if ($form4->case->claimant_address->street_2)
						{{ $form4->case->claimant_address->street_1 }},<br>
						@if ($form4->case->claimant_address->street_3)
						{{ $form4->case->claimant_address->street_3 }},<br>
						@endif
						<span style="font-weight: bold">{{ $form4->case->claimant_address->postcode }} {{ $form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : '' }},</span><br>
						{{ $form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : '' }}<br><br>

						If the Claimant / Respondent fails to comply with this award after 14 days from the date the award was received or failed to comply with this award within the timeframe specified in the award, Mr/Mrs may:-

						<table>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(1)</td>
								<td style="padding-top: 10px"">make a complaint to <span style="font-weight: bold">Director,  Bahagian Penguatkuasa, Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, Aras 3 (Menara), Tingkat 17, Menara MRCB,Jalan Majlis, Seksyen 14,  40622  Shah Alam  , Selangor</span> so that action may be taken to prosecute the Claimant / Respondent in Court under section 117 of the Consumer Protection Act 1999;</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(2)</td>
								<td style="padding-top: 10px"">a copy of the complaint shall be sent to <span style="font-weight: bold">Head Section (Assistant Secretary),  Tribunal Tuntutan Pengguna Malaysia, Pejabat Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna Selangor,Tingkat 17, Menara MRCB,Jalan Majlis, Seksyen 14,  40622  Shah Alam  , Selangor</span> for information; or</td>
							</tr>
							<tr>
								<td width="10%" style="text-align: center; vertical-align: top; padding-top: 10px"">(3)</td>
								<td style="padding-top: 10px"">mr/mrs may also elect to enforce the award yourself under section 116 (1) (b) of the Consumer Protection Act 1999 at <span style="font-weight: bold">Mahkamah Magistrate Court Shah Alam</span>;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						Thank you. <br><br>
						<span style="font-weight: bold; font-style: italic;">" BERKHIDMAT UNTUK NEGARA " </span><br><br>

						I who am following orders, <br>
						<img width="200px" height="150px" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu_user_id]) }}"/>
						<br>
						<span style="font-weight: bold;">({{ $form4->psus ? $form4->psus->first()->psu->name : '' }})</span><br>
						{{ $form4->psu->roleuser->first()->role->display_name_en }}<br>
						b.p. Secretary<br>
						The Tribunal for Consumer Claims <br> Malaysia. <br>
						s.k {{ $form4->case->case_no }}
					</td>
				</tr>
			</table>
		</div>

	</body>
</html>