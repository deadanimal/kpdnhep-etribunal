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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>
		<span class='uppercase'>SECOND SCHEDULE</span><br><br>
		<span class='uppercase'>FORM2</span><br><br>
		<span class=''>(Regulation 4)</span><br><br>
		<span class='bold uppercase'>FORM 1</span><br><br>
		<span class=''>(Regulation 5)</span><br><br>
		<span class='bold uppercase italic'>STATMENT OF CLAIM</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Claimant</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">**********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>H/P No</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mail</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Respondent</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">**********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>H/P No</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>E-mail</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='camelcase'>Statement :</span>
		<table class='border'>
			<tr>
				<td>
					Claimant's claim is for a sum of
					<span class='bold'>RM{{ number_format($claim->form1->claim_amount, 2, '.', ',') }}</span>
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					Particular of claim :
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
				<td class='center italic no-padding top'>Date</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Signature / Right thumbprint <br> of claimant</td>
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
				<td class='center italic no-padding top'>Date of filing</td>
				<td style="width: 20%"></td>
				<td class='center no-padding'>
					<span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
					<span class='uppercase'>ASSISTANT SECRETARY<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(SEAL)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>TO THE RESPONDENT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;"></td>
				<td>If you dispute the claimant?s claim, you shall file in your statement of defence in Form 2 on or before <span class='underline'>{{ date('j', strtotime($claim->form1->matured_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form1->matured_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form1->matured_date.' 00:00:00')) }}</span></td>
			</tr>
		</table>

		<br><br>

		<span class='bold uppercase'>INSTRUCTIONS TO CLAIMANT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>The claimant shall fill in his name in full and his identify card number in the column provided.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>The claimant shall fill the name of the respondent in full and his last known address in the column provided.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>The claimant shall state the exact amount claimed in the column provided. The amount claimed should not exceed RM50,000.00. If the amount exceeds RM50,000.00 then the claim shall be filed in the First Class Magistrate's Court.</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>The claimant shall state the particulars of his claim in the column provided. The particulars shall state the relevant date and how the claim has arisen or what is the basis of the claim.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>If the column provided is insufficient, please continue on a separate sheet of paper and write "see overleaf". Any separate sheet of paper used should be attached to this Form.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>Having filled in the particulars, the claimant shall sign this Form personally.</td>
			</tr>
			<tr>
				<td class='top'>7.</td>
				<td>Having completed this Form, the claimant shall file this Form in 4 copies in the Tribunal's Registry. The claimant shall pay a filing fee of RM5.00. The Registry will put the seal of the Tribunal on the 4 copies. Two copies of this Form shall be returned to the claimant.</td>
			</tr>
			<tr>
				<td class='top'>8.</td>
				<td>
					You cannot be represented by a lawyer at the hearing.<br><br>
					<div class='border' style="padding: 10px">
						<span class='bold uppercase'>IMPORTANT NOTE TO CLAIMANT :</span>

						<table>
							<tr>
								<td class='top' style="width: 20px;">1.</td>
								<td>
									A claimant must submit Form 1 to the respondent with -<br>
									<table>
										<tr>
											<td class='top' style="padding-left: 0px;">(i)</td>
											<td>Advise of Receipt Registered Post (A.R); or</td>
										</tr>
										<tr>
											<td class='top' style="padding-left: 0px;">(ii)</td>
											<td>giving it to the Respondents themselves, immediately.</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class='top'>2.</td>
								<td>
									A.R card to be taken during the hearing.
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>INSTRUCTIONS TO RESPONDENT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>When you receive this Form sealed with the seal of the Tribunal, you are being sued by the claimant.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>If you dispute the claim you shall state your defence, with particulars, in Form 2.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>You shall file in your statement of defence in the Tribunal's Registry.</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>If you fail to file in your defence within the prescribed time or if you fail to appear before the Tribunal on the hearing date, the Tribunal will make an award in favour on the claimant.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>You cannot be represented by a lawyer at the hearing.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>You are required to submit Form2 to the claimant.</td>
			</tr>
			<tr>
				<td class='top'></td>
				<td>
					<br><br><br><br>
					<span class="camelcase">Please Return To :-</span><br><br><br>

					<span class="italic camelcase">Section Head,</span><br>
					<span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
					<span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
					<span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
					<span class="italic">{{ $claim->branch->branch_postcode }}</span>
					<span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
					<span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
					<span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
					<span class="italic">Fax: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
					<span class="italic">Toll Free Line: 1800-88-9811</span><br>
					<span class="italic">Email: </span><span class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<div class="center">
			<h1 style="text-decoration: underline;">e-Tribunal System</h1><br><br><br><br><br>

			<table class="border" style="margin: 20px 10%; width: 80%;">
				<tr>
					<td class='camelcase' style="width: 30%">Claim No.</td>
					<td class='divider'>:</td>
					<td class='uppercase'>{{ $claim->case_no }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Hearing Date</td>
					<td class='divider'>:</td>
					<td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Hearing Time</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Form 1 Receipt No.</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form1->payment->receipt_no }}</td>
				</tr>
			</table>
		</div>

		<br><br>

		<p>Thank you for dealing with the Tribunal for Consumer Claims Malaysia. Please keep this document as a reference.</p>
	</div>
	<!-- end form 1 -->

	<!-- form 2 -->
	@if($claim->form1->form2)
	<div class='watermark break'>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>

		<span class='bold uppercase'>FORM 2</span><br>
		<span class=''>(Regulation 9)</span><br><br>
		<span class='bold uppercase italic'>STATEMENT OF DEFENCE AND COUNTER-CLAIM</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Claimant</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>H/P No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Respondent</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******** ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No. / Company Registration No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>H/P No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Statement of defence :
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
					Counter-claim :
				</td>
			</tr>
			<tr style="height: 150px; vertical-align: top;">
				<td>
					{{ $claim->form1->form2->counterclaim ? $claim->form1->form2->counterclaim->counterclaim_statement : '- None -' }}
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
				<td class='center italic no-padding top'>Date</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Signature / Right thumbprint of Claimant</td>
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
				<td class='center italic no-padding top'>Date of filing</td>
				<td style="width: 20%"></td>
				<td class='center no-padding'>
					<span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
					<span class='uppercase'>ASSISTANT SECRETARY <br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(SEAL)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>
		<span class='bold uppercase'>INSTRUCTIONS TO THE RESPONDENT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>If you admit the claimant's claim you may state in the column provided for the statement of defence that you admit the claim.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>If you dispute the claim, your statement of defence shall contain particulars as to why you dispute the claim.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>If you have any counter-claim, you shall state you counter-claim with particulars in the column provided.</td>
			</tr>
			<tr>
				<td class='top'>4.</td>
				<td>If the column provided is insufficient, please continue on a separate sheet of paper and write " see overleaf ". Any separate sheet of paper used should be attached to this Form.</td>
			</tr>
			<tr>
				<td class='top'>5.</td>
				<td>You shall file your defence (and counter-claim if any) within the time limit, otherwise an award will be made in favour of the claimant.</td>
			</tr>
			<tr>
				<td class='top'>6.</td>
				<td>You shall sign Form 2 personally and file in 3 copies in the Tribunal's Registry. In the case of a corporate body, this Form shall be signed by a director, manager, secretary or other similar officer. The filing fee is RM5.00. The Registry will put the seal of the Tribunal on the 3 copies and return to you two copies.</td>
			</tr>
			<tr>
				<td class='top'></td>
				<td>
					<br><br><br><br>
					<span class="camelcase">Please Return To :-</span><br><br><br>

					<span class="italic camelcase">Section Head,</span><br>
					<span class="italic camelcase">{{ $claim->branch->branch_address }},</span><br>
					<span class="italic camelcase">{!! $claim->branch->branch_address2 ? $claim->branch->branch_address2.',<br>' : '' !!}</span>
					<span class="italic camelcase">{!! $claim->branch->branch_address3 ? $claim->branch->branch_address3.',<br>' : '' !!}</span>
					<span class="italic">{{ $claim->branch->branch_postcode }}</span>
					<span class="italic camelcase">{{ $claim->branch->district->district }},</span><br>
					<span class="italic camelcase">{{ $claim->branch->state->state }}</span><br>
					<span class="italic">Tel: {{ $claim->branch->branch_office_phone or '-' }}</span><br>
					<span class="italic">Fax: {{ $claim->branch->branch_office_fax or '-' }}</span><br>
					<span class="italic">Toll Free Line: 1800-88-9811</span><br>
					<span class="italic">Email: </span><span class="italic lowercase">{{ $claim->branch->branch_emel or '-' }}</span><br>
				</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<div class="center">
			<h1 style="text-decoration: underline;">e-Tribunal System</h1><br><br><br><br><br>

			<table class="border" style="margin: 20px 10%; width: 80%;">
				<tr>
					<td class='camelcase' style="width: 30%">Claim No.</td>
					<td class='divider'>:</td>
					<td class='uppercase'>{{ $claim->case_no }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Hearing Date</td>
					<td class='divider'>:</td>
					<td class='camelcase'>{{ $claim->form4->count() > 0 ? date('j', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($claim->form4->first()->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Hearing Time</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form4->count() > 0 ? date('g.i', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($claim->form4->first()->hearing->hearing_date.' '.$claim->form4->first()->hearing->hearing_time))) : '-' }}</td>
				</tr>
				<tr>
					<td class='camelcase'>Form 2 Receipt No.</td>
					<td class='divider'>:</td>
					<td>{{ $claim->form1->form2->payment->receipt_no }}</td>
				</tr>
			</table>
		</div>

		<br><br>

		<p>Thank you for dealing with the Tribunal for Consumer Claims Malaysia. Please keep this document as a reference.
	</div>
	@endif
	<!-- end form 2 -->

	<!-- form 3 -->
	@if($claim->form1->form2)
	@if($claim->form1->form2->form3)
	<div class='watermark break'>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>

		<span class='bold uppercase'>Form 3</span><br><br>
		<span class=''>(Regulation 13)</span><br><br>
		<span class='bold uppercase italic'>DEFENCE TO COUNTER-CLAIM</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $claim->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $claim->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $claim->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Claimant</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******* ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_home : '-' }}</td>
				<td class='camelcase fit top'>H/P No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->claimant->public_data->user_public_type_id == 1 ? $claim->claimant->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->claimant->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->claimant->phone_fax or '-' }}</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Respondent</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">***** ******* ********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No. / Company Registration No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' colspan="4">********</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Telephone No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_home : $claim->opponent->phone_office ? $claim->opponent->phone_office : '-' }}</td>
				<td class='camelcase fit top'>H/P No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>{{ $claim->opponent->public_data->user_public_type_id == 1 ? $claim->opponent->public_data->individual->phone_mobile : '-' }}</td>
			</tr>
			<tr>
				<td class='top' style='width: 35%'>Email</td>
				<td class='divider'>:</td>
				<td class='lowercase' style='width: 30%'>{{ $claim->opponent->email }}</td>
				<td class='camelcase fit top' style='width: 10%'>Fax No.</td>
				<td class='divider'>:</td>
				<td class='uppercase' style='width: 25%'>{{ $claim->opponent->phone_fax or '-' }}</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<table class='border'>
			<tr>
				<td class='bold'>
					Defence to counter-claim :
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
				<td class='center italic no-padding top'>Date</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Signature/Right thumbprint of claimant</td>
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
				<td class='center italic no-padding top'>Date of filing</td>
				<td style="width: 20%"></td>
				<td class='center no-padding'>
					<span class='bold uppercase top'>{{ $claim->psu->name }}</span><br>
					<span class='uppercase'>ASSISTANT SECRETARY<br>TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td class='center no-padding'><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' /></td>
			</tr>
			<tr>
				<td class='center no-padding'>(SEAL)</td>
			</tr>
		</table>
	</div>

	<div class='left break watermark'>

		<span class='bold uppercase'>INSTRUCTIONS TO THE CLAIMANT :</span><br>

		<table>
			<tr>
				<td class='top' style="width: 20px;">1.</td>
				<td>If you admit the respondent's counter-claim you shall state in the column provided for defence to counter-claim that you admit the counter-claim.</td>
			</tr>
			<tr>
				<td class='top'>2.</td>
				<td>If you dispute the counter-claim, your defence to the counter-claim shall contain particulars as to why you dispute the counter-claim.</td>
			</tr>
			<tr>
				<td class='top'>3.</td>
				<td>You shall sign Form 3 personally and file in 4 copies in the Tribunal's Registry. The filing fee is RM5.00. The Registry will put the seal of the Tribunal on the 4 copies and return to you two copies.</td>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 4</span><br>
		<span class=''>(Regulation 18)</span><br><br>
		<span class='bold uppercase italic'>NOTICE OF HEARING</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE</span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ******* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ******* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>PLEASE NOTE that the above claims will be heard at </span>
			<span class='bold'>{{ date('j', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($form4->hearing->hearing_date.' 00:00:00'))).')' }} </span>

			<span>at </span>
			<span class='bold'>{{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }}</span>

			<span>at (Address of place of hearing): :- </span><br><br>

			<span class='bold'>
				{{ $form4->hearing->hearing_room->hearing_room }},<br>
				{!! str_replace(',', ', ', $form4->hearing->hearing_room->address) !!}.
			</span><br><br>
		</div>

		<span class="center bold uppercase">PLEASE BRING ALL WITNESSES, DOCUMENTS, RECORDS, OR SUPPORTING ITEMS TO SUPPORT YOUR DEFENSE CLAIM AND COUNTERCLAIM.</span><br><br>

		<div class='left'>
		Dated <span class='bold'>{{ date('h').' '.localeMonth(date('F')).' '.date('Y') }}</span><br>
		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->psu->user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psu->name }}</span><br>
						<span class='uppercase'>ASSISTANT SECRETARY<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
					<span class="bold uppercase"><u>IMPORTANT NOTE TO CLAIMANT :</u></span><br><br>

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
					<span>A claimant must submit Form 1 to the respondent with :-</span><br>
					<table>
						<tr>
							<td class='top' style="padding-left: 0px;">(i)</td>
							<td>Advise of Receipt Registered Post (A.R); or</td>
						</tr>
						<tr>
							<td class='top' style="padding-left: 0px;">(ii)</td>
							<td>giving it to the Respondents themselves, immediately.</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class='top' style="width: 10%;">2.</td>
				<td>
					A.R card to be taken during the hearing.
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
					<span class="bold uppercase"><u>IMPORTANT NOTE TO RESPONDENT</u></span><br><br>

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
					<span>Respondent of company or business can only be represented by :-</span><br>
					<table>
						<tr>
							<td class='top' style="padding-left: 0px;">(i)</td>
							<td>a full-time salaried employees and with a letter of authority (authorization letter);</td>
						</tr>
						<tr>
							<td class='top' style="padding-left: 0px;">(ii)</td>
							<td>director, owner or partner and bring a copy of Form 49 or the details of any relevant company/business.</td>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 5</span><br><br>
		<span class=''>(Regulation 19)</span><br><br>
		<span class='bold uppercase italic'>AWARD FOR CLAIMANT WHERE<br>RESPONDENT DID NOT FILE STATEMENT OF DEFENCE</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>The statement of claim (Form 1) having been duly served on the respondent and the respondent having failed to file his defence within the stipulated time, the Tribunal hereby makes the following award:</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 6</span><br><br>
		<span class=''>(Regulation 20)</span><br><br>
		<span class='bold uppercase italic'>AWARD WHERE RESPONDENT ADMITS CLAIMS</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>The respondent having admitted the claim, the Tribunal hereby orders</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 7</span><br><br>
		<span class=''>(Subregulation 21(2))</span><br><br>
		<span class='bold uppercase italic'>AWARD FOR RESPONDENT WHERE CLAIMANT IS ABSENT</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE</span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>This action having this day been called on for hearing before {{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_en.' '.$form4->president->name : '' }} in the presence of the respondent, and in the absence of the claimant, the Tribunal hereby orders:</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 8</span><br><br>
		<span class=''>(Subregulation 21(5))</span><br><br>
		<span class='bold uppercase italic'>AWARD FOR CLAIMANT<br>IF RESPONDENT ABSENT</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Opponent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				This action having this day been called on for hearing before <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> on <b>{{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</b> in the presence of the claimant, and in the absence of the respondent, the Tribunal hereby orders: 
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 9</span><br><br>
		<span class=''>(Subregulation 22(2))</span><br><br>
		<span class='bold uppercase italic'>AWARD BY CONSENT</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				This action having this day been called on for hearing before <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> in the presence of the claimant and the respondent, and both parties having consented, the Tribunal hereby orders:
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the<span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FORM CONSUMER CLAIMS<br>MALAYSIA</span>
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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>

		<span class='bold uppercase'>Form 10</span><br><br>
		<span class=''>(Subregulation 23(5))</span><br><br>
		<span class='bold uppercase italic'>AWARD AFTER HEARING</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					***** ********* *******<br>
					********
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>
			<span>
				This action has been called on <b>{{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }}</b> before <span class="bold uppercase">{{ $form4->president ? $form4->president->ttpm_data->president->salutation->salutation_my.' '.$form4->president->name : '' }}</span> in the presence of the claimant and the respondent, the Tribunal hereby orders:
			</span><br><br>

			<span class="bold" style="padding: 0 25px;">{!! $form4->award->award_description !!}</span><br><br>

			Dated the <span class='bold'>{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span><br>

		</div>

		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->president ? $form4->president->name : '' }}</span><br>
						<span class='uppercase'>PRESIDENT<br>THE TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
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
	<div class='watermark'>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION REGULATIONS</span><br>
		<span class='bold uppercase'>(CONSUMER CLAIMS TRIBUNAL) 1999</span><br><br>
		<span class='bold uppercase'>Form 12</span><br><br>
		<span class=''>(Regulation 25)</span><br><br>
		<span class='bold uppercase italic'>APPLICATION FOR AWARD DECLINATION</span><br><br>
		<span class='uppercase'>IN TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $form4->case->branch->branch_name }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $form4->case->case_no }}</span><br><br>

		<table class='border'>
			<tr>
				<td class='camelcase top'>Name of Claimant</td>
				<td class='divider'>:</td>
				<td class='uppercase'>***** ********* *******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>*******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
				<td class='camelcase top'>Name of Opponent</td>
				<td class='divider'>:</td>
				<td class='uppercase'>***** ********* *******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Identity Card No. / Company Registration No.</td>
				<td class='divider'>:</td>
				<td class='uppercase'>*******</td>
			</tr>
			<tr>
				<td class='camelcase top'>Address</td>
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
			<td>An award has been obtained against me on{{ date('j F Y', strtotime($form4->award->award_date." 00:00:00")) }}.
			</td>
		</tr>
		<tr>
			<td class='top'>2.</td>
			<td>2. I hereby apply to decline the award.</td>
		</tr>

	</table>

	<div class='left break watermark'>
		<span class='camelcase'>I was not present at the hearing because :</span>
		<table class='border'>
			<tr>
				<td>
					{!! $form4->form12->absence_reason !!}
				</td>
			</tr>
		</table>

		<table class='border'>
			<tr>
				<td class='bold'>
					I did not file my defence because :
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
				<td class='center italic no-padding top'>Date</td>
				<td style="width: 20%"></td>
				<td class='center italic no-padding top'>Singature / Right thumbprint<br>of Claimant / Respondent</td>
			</tr>
			<tr>
				<td colspan="3">
					<span class="center uppercase bold no-padding">NOTICE TO THE CLAIMANT / RESPONDENT</span><br><br>
					<span class="center no-padding">The claimant/respondent has applied to this Tribunal to decline the award dated <span class="underline">{{ date('h', strtotime($form4->award->award_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->award->award_date.' 00:00:00'))).' '.date('Y', strtotime($form4->award->award_date.' 00:00:00')) }}</span>.The date and the time for the hearing of application is as stated below.</span><br>
					<span>Hearing Date: {{ date('h', strtotime($form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($form4->hearing->hearing_date.' 00:00:00')) }} Time : {{ date('g.i', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($form4->hearing->hearing_date.' '.$form4->hearing->hearing_time))) }} @if(date("H", strtotime($form4->hearing->hearing_date." ".$form4->hearing->hearing_time)) < 12) pagi @else tengah hari @endif</span>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class='center' style="width: 45%">
					(SEAL)<br><img src='{{ url("images/ttpm_seal.jpg") }}' style='width: 150px' />
				</td>
				<td style="width: 10%"></td>
				<td class='center' style="width: 45%; position: relative;">
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $form4->president_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $form4->psus ? $form4->psus->first()->psu->name : '' }}</span><br>
						<span class='uppercase'>ASSISTANT SECRETARY<br>THE TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>
	</div>

	@endif
	<!-- end form 12 -->

</body>