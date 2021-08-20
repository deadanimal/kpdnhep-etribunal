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
			line-height: 25px;
		}
		span, a, p, h1, h2 {
			font-family: serif !important;
		}
		span, a, p {
			font-size: 19px;
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

	<div>
		<span class='bold uppercase'>CONSUMER PROTECTION ACT 1999</span><br><br>
		<span class='bold uppercase'>CONSUMER PROTECTION (THE TRIBUNAL FOR CONSUMER CLAIMS)</span><br>
		<span class='bold uppercase'>REGULATIONS 1999</span><br><br>

		<span class='bold uppercase'>Form 11</span><br><br>
		<span class=''>(Regulation 24)</span><br><br>
		<span class='bold uppercase italic'>SUMMONS TO WITNESS</span><br><br>
		<span class='uppercase'>IN THE TRIBUNAL FOR CONSUMER CLAIMS</span><br><br>
		<span class='uppercase'>AT </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->hearing->hearing_room ? $user_witness->form11->form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>IN THE STATE </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>CLAIM NO: </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">BETWEEN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $user_witness->form11->form4->case->claimant->name }}<br>
					{{ $user_witness->form11->form4->case->claimant->type == 1 ? 'IC: '.$user_witness->form11->form4->case->claimant->username : $user_witness->form11->form4->case->claimant->username }}

					@if($user_witness->form11->form4->case->extra_claimant)
					/
					<br><br>
					{{ $user_witness->form11->form4->case->extra_claimant->name }}<br>
					{{ $user_witness->form11->form4->case->extra_claimant->nationality_country_id == 129 ? 'NRIC: '.$user_witness->form11->form4->case->extra_claimant->identification_no : 'Passport No.: '.$user_witness->form11->form4->case->extra_claimant->identification_no  }}
					@endif
				</td>
				<td class='camelcase'>Claimant</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">AND</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $user_witness->form11->form4->claimCaseOpponent->opponent->name }}<br>
					{{ $user_witness->form11->form4->claimCaseOpponent->opponent->type == 1 ? 'IC: '.$user_witness->form11->form4->claimCaseOpponent->opponent->username : $user_witness->form11->form4->case->opponent->username }}
				</td>
				<td class='camelcase'>Respondent</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>

			<span>To</span><br>
			<div style="padding: 0px 50px;">
				<span class="bold justify">
					{{ $user_witness->name }}
					({{ $user_witness->type == 1 ? 'IC: '.$user_witness->identification_no : $user_witness->identification_no }})<br>
					{!! nl2br($user_witness->address) !!}
				</span><br><br><br>
			</div>
			<div class="justify">
				<span >
					You are heareby summoned to appear before the Tribunal at 

					<span class='bold camelcase'>{!! $user_witness->form11->form4->hearing->hearing_room ? $user_witness->form11->form4->hearing->hearing_room->hearing_room.', '.str_replace('<br>', ' ', $user_witness->form11->form4->hearing->hearing_room->address) : '-' !!}</span>. 

					on the <span class='bold'>{{ $user_witness->form11->form4->hearing ? date('j', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00')).' day of '.localeMonth(date('F', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</span> 

					at <span class='bold'>{{ $user_witness->form11->form4->hearing ? date('g.i', strtotime($user_witness->form11->form4->hearing->hearing_date.' '.$user_witness->form11->form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($user_witness->form11->form4->hearing->hearing_date.' '.$user_witness->form11->form4->hearing->hearing_time))) : '-' }}</span> to give statement on behalf of Claimant/Respondent and also to bring with you and produce <span class='bold'> {{ $user_witness->document_desc }} </span> at the time and place aforesaid. 

				</span><br><br>
			</div>

			<span>Dated the </span><span class='bold'>{{ date('h', strtotime($user_witness->created_at))}} </span> day of <span class='bold'> {{ localeMonth(date('F', strtotime($user_witness->created_at))).' '.date('Y', strtotime($user_witness->created_at)) }}</span><br>

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
					<img class="absolute-center" style="width: 200px; bottom: 50%; z-index: -1;" src="{{ route('general-getsignature', ['ttpm_user_id' => $user_witness->psu_user_id]) }}" /><br>
					<div style="margin-top: 50px;">
						<span class='bold uppercase top'>{{ $user_witness->psu ? $user_witness->psu->name : '' }}</span><br>
						<span class='uppercase'>SECRETARY<br> TRIBUNAL FOR CONSUMER CLAIMS<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>

</body>