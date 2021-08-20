<?php
$count = 0;
$rep_list=array();

if($form4->attendance){
	if($form4->attendance->representative->count() > 0){
		foreach($form4->attendance->representative as $rep){
			if($rep->is_representing_claimant  == 0  && $rep->is_present){
				$count += 1;
				array_push($rep_list, $rep->name);
				array_push($rep_list, $rep->identification_no);
				array_push($rep_list, $rep->designation->designation_en);
			}	
		}
	}
}
			
?>
<html>
<head>
	<style type="text/css">
		table {
			width: 100%;
			margin-top: 20px;
		}
		td, th {
			font-family: serif !important;
			padding: 10px;
			font-size: 20px;
			line-height: 23px;
		}
		span, a, p, h1, h2 {
			font-family: serif !important;
		}
		span, a, p {
			font-size: 20px;
			line-height: 23px;
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
		.title {
			text-decoration: underline; 
			font-weight:bold;
		}

		.dot {
			text-decoration-line: underline;
			text-decoration-style: dotted;
			font-weight: bold
		}
	</style>
</head>
<body>
	<div style="margin:30px;">
		<table style="padding-top: 70px">
			<tr>
				<td style="font-weight:bold;">PIHAK PENENTANG</td>
				<td style="text-align: right;" class="title">{{ $form4->case->case_no }}</td>
			</tr>
			<tr>
				<td colspan="2" class="title" style="text-align: center;">Perakuan Penerimaan Award</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<span style="text-align: justify;">Bahawa saya .................................................................................................. No. Kad Pengenalan .......................................... jawatan* .................................... dari Syarikat *............................................................. mengaku telah menerima salinan asal award Tribunal Tuntutan Pengguna Malaysia ini pada ....................... <small>(tarikh)</small> jam ...................</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 20px;">Tandatangan: ..............................</td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold; font-style: italic;">*Di mana berkenaan</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<span class="title" >Perakuan Penyerahan Award</span><br>
					<span style="font-style: italic;">(Untuk diisi oleh PSU yang menyerahkan award)</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<span style="text-align: justify;">Bahawa saya ................................................................................................. No. Kad Pengenalan .......................................... mengaku telah menyerahkan salinan asal award Tribunal Tuntutan Pengguna Malaysia ini kepada penama di atas pada ....................... <small>(tarikh)</small> jam ...................</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 20px;">Tandatangan: ..............................</td>
			</tr>
		</table>
		<hr>
		<table>
			<tr>
				<td style="font-weight:bold;">PIHAK YANG MENUNTUT</td>
				<td style="text-align: right;" class="title">{{ $form4->case->case_no }}</td>
			</tr>
			<tr>
				<td colspan="2" class="title" style="text-align: center;">Perakuan Penerimaan Award</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<span style="text-align: justify;">Bahawa saya .................................................................................................. No. Kad Pengenalan .......................................... mengaku telah menerima salinan asal award Tribunal Tuntutan Pengguna Malaysia ini pada ........................ <small>(tarikh)</small> jam .....................</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 20px;">Tandatangan: ..............................</td>
			</tr>
			<tr>
				<td colspan="2" style="font-weight:bold;">*Dimana berkenaan</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<span class="title" >Perakuan Penyerahan Award</span><br>
					<span style="font-style: italic;">(Untuk diisi oleh PSU yang menyerahkan award)</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<span style="text-align: justify;">Bahawa saya ................................................................................................. No. Kad Pengenalan .......................................... mengaku telah menyerahkan salinan asal award Tribunal Tuntutan Pengguna Malaysia ini kepada penama di atas pada ....................... <small>(tarikh)</small> jam ...................</span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 20px;">
					Tandatangan: ..............................<br>
					Jawatan: ...................................
				</td>
			</tr>
		</table>
	</div>

</body>


</html>