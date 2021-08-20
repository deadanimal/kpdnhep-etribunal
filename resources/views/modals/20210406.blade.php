<div id="myModalInfo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"
                 style="text-align: justify; border: 3px solid #b71440; border-radius: 10px; margin: 10px;">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h3 style="font-size:24px">
                    @if(Lang::getLocale() == 'my')
                    Pengumuman Penting
                    @else
                    Important Announcement
                    @endif
                </h3>
                <table class="table table-no-border">
                    <tr>
                        <td>
                            @if(Lang::getLocale() == 'my')
                                <b></b><ol type="1">
                                <br><br><li>
								Makluman berhubung pelaksanaan total lockdown di seluruh negara mulai 1 Jun sehingga 14 Jun 2021- </li> 
								<br>
                                <ol type="i">
								
								<li>Semua kes yang ditetapkan untuk pendengaran pada 1 Jun sehingga 30 Jun 2021 telah ditangguhkan ke suatu tarikh pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak.</li><br>

								<li>semua tuntutan hendaklah difailkan secara dalam talian di sistem e-Tribunal melalui pautan https://ttpm.kpdnhep.gov.my.</li>							
								</ol>
							
                               					
                                <br>
				
								
							<li>Semua kes yang ditetapkan pendengaran di pejabat TTPM Georgetown akan dipinda ke <b>TTPM Seberang Perai Tengah </b> bermula pada <b>1 Januari sehingga 23 Julai 2021</b> seperti berikut:				    
					
			  					<br><br> <b>	TTPM Seberang Perai Tengah
				    						<br>G-03, Tingkat Bawah,
				    						<br>Kompleks Sempilai Jaya,
				    						<br>Jalan Sempilai, Seberang Jaya,
  				    						<br>13700 Seberang Perai Tengah, Pulau Pinang.
				    						<br>Telephone no: 04-3840122 / 04-3840240
 				   				 </b></li><br>

					

								<li>Sila ambil maklum bahawa suatu pusat pengantara (mediation centre) di bawah Jabatan Perdana Menteri yang diberi 
								nama <b>PUSAT MEDIASI COVID-19 (PMC-19)</b> telah mula beroperasi pada 11 November 2020 khusus untuk menangani pertikaian komersial (tidak melebihi RM500,000.00) 
								bagi kategori kontrak sebagaimana yang diperuntukkan di bawah Akta Langkah-Langkah Sementara Bagi Mengurangkan Kesan Penyakit Koronavirus 2019 (COVID-19) 2020 [Akta 829].</li><br>

								Untuk maklumat lanjut sila layari portal rasmi Pusat Mediasi Covid-19 <b>http://www.pmc19.gov.my</b><br>

								<br><b>Dimaklumkan bahawa Pusat Mediasi Covid-19 (PMC-19) akan membuka booth di ruang pejabat TTPM Putrajaya pada 19 April sehingga 19 Mei 2021 untuk 
								membolehkan pegawai PMC-19 memberi penerangan kepada orang awam berkaitan khidmat mediasi yang ditawarkan oleh PMC-19</b><br>

								<br><b>Untuk makluman waktu operasi kaunter sepanjang bulan Ramadhan adalah bermula pada jam 8.00 pagi sehingga 4.30 petang.</b>

						
								<br><br>Kami memohon maaf atas segala kesulitan.
								<br><br>
                                Terima kasih
                                <br><br></ol>
                                6hb April 2021
                            @else
                                <b></b><ol type="1">
                                <br><li>
                               					Please be advised, pursuant to the implementation of total lockdown throughout the country from June 1 to June 14, 2021– </b></li>
								<br><ol type="i">

								<li>all scheduled hearings from June 1 to June 30 have been postponed to a new hearing date. All parties concerned will be notified of the new hearing date.</li><br>

								<li>all claims can be filed online through e-Tribunal system at https://ttpm.kpdnhep.gov.my.</li>							
								</ol>
								<br>

				<li>All hearing cases scheduled at TTPM Georgetown will be transferred to <b>TTPM Seberang Perai Tengah </b> effective from <b>01<sup>st</sup> January until 23<sup>rd</sup> July 2021</b> at the following address:
				    
					
				<br><br> <b>TTPM Seberang Perai Tengah
				    	<br>G-03, Tingkat Bawah,
				    	<br>Kompleks Sempilai Jaya,
				    	<br>Jalan Sempilai, Seberang Jaya,
  				    	<br>13700 Seberang Perai Tengah, Pulau Pinang.
				    	<br>Telephone no: 04-3840122 / 04-3840240
 				    </b></li><br>

								<li>Kindly be informed that <b>Pusat Mediasi COVID-19 (PMC-19)</b> is a mediation centre established under the Prime Ministers Department. 
								The centre has been operating since 11 November 2020 specifically to deal with commercial disputes (not exceeding RM 500,000.00) for the contract category under the provision of Temporary Measures for Reducing the Impact of Coronavirus Disease 2019 (COVID-19) 2020 [Act 829]. 
								For more information, please visit the official portal of the Covid-19 Mediation Centre at http://www.pmc19.gov.my</b><br>

								<br><b>Covid-19 Mediation Centre will open its booth at the TTPM Putrajaya office from 19 April until 19 May 2021 for PMC officers to disseminate information to the public on the mediation services offered by PMC-19.</b><br>
								<br><b>Please be inform that during Ramadhan month, counter operation hours are from 8.00 am until 4.30 pm.</b>
                               							
					            <br><br> We apologies for any inconvenience caused.
								<br><br>
                                Thank you
                                <br><br></ol>
                                6<sup>th</sup> April 2021
                            @endif
                        </td>
                    </tr>
                </table>
                <hr>
                <table>
                    <tr>
                        <td><img src="{{asset('assets/pages/img/etribunalv2/logo-ttpm.png')}}" width="150px" alt="">
                        </td>
                        <td>
                            <p style="margin: 10px; font-size: 12px">
                                {{ __('login.ttpm_full') }}<br>
                                {{ __('login.kpdnkk_full') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>