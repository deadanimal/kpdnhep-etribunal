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
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>

		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $stop_notice->case->branch->branch_name  or ''}}</span><br>
		<span class='uppercase'>IN THE STATE</span>
		<span class='bold uppercase'>{{ $stop_notice->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $stop_notice->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $stop_notice->case->claimant_address->name }}<br>
					{{ $stop_notice->case->claimant_address->nationality_country_id == 129 ? 'NRIC: '.$stop_notice->case->claimant_address->identification_no : 'Passport No.: '.$stop_notice->case->claimant_address->identification_no }}

					@if($stop_notice->case->extra_claimant)
					/
					<br><br>
					{{ $stop_notice->case->extra_claimant->name }}<br>
					{{ $stop_notice->case->extra_claimant->nationality_country_id == 129 ? 'NRIC: '.$stop_notice->case->extra_claimant->identification_no : 'Passport No.: '.$stop_notice->case->extra_claimant->identification_no  }}
					@endif
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					@if($stop_notice->multiOpponents->opponent_address)
					
					{{ $stop_notice->multiOpponents->opponent_address->name }}<br>

					@if($stop_notice->multiOpponents->opponent_address->is_company == 1)
					( {{ $stop_notice->multiOpponents->opponent_address->identification_no }} )
					@else
					{{ $stop_notice->multiOpponents->opponent_address->nationality_country_id == 129 ? 'NRIC: '.$stop_notice->multiOpponents->opponent_address->identification_no : 'Passport No.: '.$stop_notice->multiOpponents->opponent_address->identification_no }}
					@endif

					@endif
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<span class="center bold uppercase">NOTICE OF DISCONTINUANCE </span><br><br>

		<div class='left'>
		<span>Please be noted that Claimant have been stopped any actions towards the Opponent.</span><br><br><br><br>
		
		</div>

		<table>
			<tr>
				<td class='left top' style="width: 45%">
					<span>Dated</span> <span class='bold'>{{ date('d').' '.localeMonth(date('F')).' '.date('Y') }}</span>
				</td>
				<td style="width: 10%"></td>
				<td class='center top' style="width: 45%;">
					................................................<br>
					(Signature of the Claimant)<br><br>
					<div class="left">
						Name: <span class="bold uppercase">{{$stop_notice->case->claimant->name}}</span><br>
						I.C No. : <span class="bold uppercase">{{$stop_notice->case->claimant->username}}</span>
					</div>
					<br>
				</td>
			</tr>
			<tr>
				<td class='left top' style="width: 45%">
					Kepada :
					(1) Setiausaha,<br>
					{{$stop_notice->case->branch->branch_address  or ''}}<br>
					@if( $stop_notice->case->branch->branch_address2 )
					{{$stop_notice->case->branch->branch_address2  or ''}}<br>
					@endif
					@if( $stop_notice->case->branch->branch_address2 )
					{{$stop_notice->case->branch->branch_address3  or ''}}<br>
					@endif
					{{$stop_notice->case->branch->branch_poscode  or ''}} {{ $stop_notice->case->branch->district ? ($stop_notice->case->branch->district->district) : ''}} {{ $stop_notice->case->branch->state ? ($stop_notice->case->branch->state->state ) : ''}}.
				</td>
				<td style="width: 10%"></td>
				<td class='left top' style="width: 45%;">
					(2) 
					<b>{{$stop_notice->case->opponent->name  or ''}}</b><br>

					@if($stop_notice->multiOpponents->opponent_address)
					{{$stop_notice->multiOpponents->opponent_address->street_1 }},<br>
					@endif
					@if( $stop_notice->multiOpponents->opponent_address->street_2 )
					{{$stop_notice->multiOpponents->opponent_address->street_2 }},<br>
					@endif
					@if( $stop_notice->multiOpponents->opponent_address->street_3 )
					{{$stop_notice->multiOpponents->opponent_address->street_3 }},<br>
					@endif
					{{$stop_notice->multiOpponents->opponent_address->postcode }},<br>
					@if( $stop_notice->multiOpponents->opponent_address->district )
					{{ $stop_notice->multiOpponents->opponent_address->district->district  }},<br>
					@endif
					@if( $stop_notice->multiOpponents->opponent_address->state )
					{{ $stop_notice->multiOpponents->opponent_address->state ? $stop_notice->multiOpponents->opponent_address->state->state : '' }}.<br>
					@endif
				</td>
			</tr>
			<tr>
				<td class="center"><small>(Address of applicable Consumer Claims Tribunal)</small></td>
				<td></td>
				<td class="center"><small>(Name &amp; Opponent Address)</small></td>
			</tr>
		</table>

	</div>

</body>