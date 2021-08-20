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

	<div >
		<span class='bold uppercase'>AKTA PERLINDUNGAN PENGGUNA 1999</span><br><br>
		<span class='bold uppercase'>PERATURAN-PERATURAN PERLINDUNGAN PENGGUNA</span><br>
		<span class='bold uppercase'>(TRIBUNAL TUNTUTAN PENGGUNA) 1999</span><br><br>

		<span class='bold uppercase'>Borang 11</span><br><br>
		<span class=''>(Peraturan 24)</span><br><br>
		<span class='bold uppercase italic'>SAMAN KEPADA SAKSI</span><br><br>
		<span class='uppercase'>DALAM TRIBUNAL TUNTUTAN PENGGUNA</span><br><br>
		<span class='uppercase'>DI </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->hearing->hearing_room ? $user_witness->form11->form4->hearing->hearing_room->venue->hearing_venue : '-' }}</span><br>
		<span class='uppercase'>DI NEGERI </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->case->branch->state->state }}</span>
		<span class='uppercase'> MALAYSIA</span><br>
		<span class='uppercase'>TUNTUTAN NO: </span>
		<span class='bold uppercase'>{{ $user_witness->form11->form4->case->case_no }}</span><br><br>

		<table>
			<tr>
				<td class='center uppercase' colspan="2">ANTARA</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $user_witness->form11->form4->case->claimant->name }}<br>
					{{ $user_witness->form11->form4->case->claimant->type == 1 ? 'KP: '.$user_witness->form11->form4->case->claimant->username : $user_witness->form11->form4->case->claimant->username }}

					@if($user_witness->form11->form4->case->extra_claimant)
					/
					<br><br>
					{{ $user_witness->form11->form4->case->extra_claimant->name }}<br>
					{{ $user_witness->form11->form4->case->extra_claimant->nationality_country_id == 129 ? 'No. KP: '.$user_witness->form11->form4->case->extra_claimant->identification_no : 'No. Pasport: '.$user_witness->form11->form4->case->extra_claimant->identification_no  }}
					@endif
				</td>
				<td class='camelcase'>Pihak Yang Menuntut</td>
			</tr>
			<tr>
				<td class='center uppercase' colspan="2">DAN</td>
			</tr>
			<tr>
				<td class='bold uppercase no-padding' style="width: 70%">
					{{ $user_witness->form11->form4->claimCaseOpponent->opponent->name }}<br>
					{{ $user_witness->form11->form4->claimCaseOpponent->opponent->type == 1 ? 'KP: '.$user_witness->form11->form4->claimCaseOpponent->opponent->username : $user_witness->form11->form4->claimCaseOpponent->opponent->username }}
				</td>
				<td class='camelcase'>Penentang</td>
			</tr>
		</table>

		<br><br>

		<div class='left'>

			<span>Kepada</span><br>
			<div style="padding: 0px 50px;">
				<span class="justify bold">
					{{ $user_witness->name }}
					({{ $user_witness->type == 1 ? 'KP: '.$user_witness->identification_no : $user_witness->identification_no }})<br>
					{!! nl2br($user_witness->address) !!}
				</span><br><br><br>
			</div>

			<div class="justify">
				<span>
					Anda adalah dengan ini disaman supaya hadir di hadapan 

					<span class='bold camelcase'>{!! $user_witness->form11->form4->hearing->hearing_room ? $user_witness->form11->form4->hearing->hearing_room->hearing_room.', '.str_replace(', ,', ', ', str_replace('<br>', ' ', $user_witness->form11->form4->hearing->hearing_room->address)) : '-' !!}</span>. 

					pada <span class='bold'>{{ $user_witness->form11->form4->hearing ? date('j', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00')).' '.localeMonth(date('F', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00'))).' '.date('Y', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00')).' ('.localeDay(date('l', strtotime($user_witness->form11->form4->hearing->hearing_date.' 00:00:00'))).')' : '-' }}</span> 

					pada jam <span class='bold'>{{ $user_witness->form11->form4->hearing ? date('g.i', strtotime($user_witness->form11->form4->hearing->hearing_date.' '.$user_witness->form11->form4->hearing->hearing_time)).' '.localeDaylight(date('a', strtotime($user_witness->form11->form4->hearing->hearing_date.' '.$user_witness->form11->form4->hearing->hearing_time))) : '-' }}</span> 

					untuk memberikan keterangan bagi Pihak Yang Menuntut/Penentang dan untuk membawa bersama-sama anda dan mengemukakan <span class='bold'> {{ $user_witness->document_desc }} </span> pada masa dan di tempat yang disebut terdahulu.

				</span><br><br>
			</div>

			<span>Bertarikh pada </span><span class='bold'>{{ date('h', strtotime($user_witness->created_at)).' '.localeMonth(date('F', strtotime($user_witness->created_at))).' '.date('Y', strtotime($user_witness->created_at)) }}</span><br>
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
						<span class='uppercase'>{{  $user_witness->psu ? $user_witness->psu->roleuser->first()->role->display_name_my : '' }}<br>TRIBUNAL TUNTUTAN PENGGUNA<br>MALAYSIA</span>
					</div>
				</td>
			</tr>
		</table>

	</div>

</body>