<html>
	<head>
		<style>
			body{
				font-family: Arial, Helvetica, sans-serif;
			}
			.main {
				margin: 30px 15px;
				border: 1px solid;

			}
			img{
				width: 100px;
				height: 80px;
			}
			.detail {
				text-align: right;
				padding-right: 15px;
			}
			table{
				padding: 20px;
			}
			tr{ line-height: 23px; }
			td{ line-height: 18px; }
			tr.row_detail td { padding-bottom:20px}
		</style>
	</head>
	<body>
		<div class="main">
			<table style="width: 100%">
				<tr style="text-align: center">
					<td></td>
					<td colspan="3">
						<p style="text-align: center;">
							<span style="text-transform: uppercase;">
								RESIT RASMI / OFFICIAL RECEIPT
							</span>
							<br><br>
							Tribunal Tuntutan Pengguna Malaysia
						</p>
					</td>
					<td><br>{{ $status }}</td>
				</tr>
				<tr style="text-align: center; vertical-align: top;">
					<td style="width: 18%;"><img src="{{ url('/images/logo_malaysia.png') }}"></td>
					<td style="width: 64%;" colspan="3">
						<p style="text-align: center;">
							<br>
							Kementerian Perdagangan Dalam Negeri,<br>
							Koperasi Dan Kepenggunaan <br>
							Aras 5, Podium 2,<br>
							No. 13, Persiaran Perdana, Presint 2,<br>
							62623 Putrajaya<br>
							<small>Talian Bebas Tol: 1800-88-9811 &nbsp;&nbsp;&nbsp; No. Fax: 03-8882 5831</small>
						</p>
					</td>
					<td style="width: 18%;"><img src="{{ url('/images/logo_kpdnkk.png') }}"></td>
				</tr>
				<tr>
					<td colspan="5"><hr></td>
				</tr>
				<tr class="row_detail" style="font-size: small"> 
					<td colspan="3" style="width: 40%"></td>
					<td style="width: 30%">
						<p>
						No Resit / <i>Receipt No.</i> <br>
						Tarikh / <i>Date</i> <br>
						Masa / <i>Time</i> <br>
						</p>
					</td>
					<td>
						<p>
						: {{ $payment->receipt_no  or '' }} <br>
						: {{ $paid_at_date  or '' }} <br>
						: {{ $paid_at_time  or '' }} <br>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2" width="30%">No. Rujukan Bank / <i>Bank Reference No.</i></td>
					<td colspan="3">:  &nbsp; {{ $payment->fpx->fpx_transaction_no  or '' }} </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">No. Rujukan TTPM / <i>TTPM Reference No.</i></td>
					<td colspan="3">:  &nbsp; {{ $payment->case->case_no  or '' }} </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Pembayar / <i>Payee</i></td>
					<td colspan="3">:  &nbsp; {{ $payment->fpx->paid_by  or '' }}  </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Bayaran Bagi Pihak / <i>Payment on Behalf</i></td>
					<td colspan="3">:  &nbsp; {{ $payment->form_no == 1 ? $payment->case->claimant_address->name : $payment->multiOpponents()->withTrashed()->first()->opponent_address->name }} </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Perihal Transaksi / <i>Transaction Details</i></td>
					<td colspan="3">:  &nbsp; Pemfailan Borang 1/2 / <i>Filing For Claim Form 1/2</i> </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Kod Pengelasan / <i>Classification Code</i></td>
					<td colspan="3">:  &nbsp; H0272101 </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Amaun / <i>Amount</i> (RM)</td>
					<td colspan="3">:  &nbsp; 5.00 </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Ringgit Malaysia / <i>Malaysian Ringgit</i></td>
					<td colspan="3">:  &nbsp; Lima Sahaja / <i>Five Only</i> </td>
				</tr>
				<tr>
					<td colspan="2" width="30%">Bentuk Pungutan / <i>Mode of Collection</i></td>
					<td colspan="3">:  &nbsp; Portal/Perbankan Internet / <i>Portal/Internet Banking</i> </td>
				</tr>
				<tr style="text-align: center;">
					<td colspan="5">
						<div style="padding: 30 0px; ">
							<small>Ini adalah cetakan komputer dan tidak memerlukan tandatangan. <br>This is a computer generated receipt and no signature is required.
							</small>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="5"><small>No. Kelulusan : BPKS(8.15)248-11(34)</small></td>
				</tr>
			</table>

		</div>
	</body>
</html>
