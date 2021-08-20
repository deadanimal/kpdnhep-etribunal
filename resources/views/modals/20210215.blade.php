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
								Makluman berhubung pelanjutan <b>Perintah Kawalan Pergerakan (PKP)</b> sehingga <b>18 Februari 2021</b> 
								di seluruh negara kecuali Sarawak-  </li> 
								<br>
                                <ol type="i">
								
								<li>semua tuntutan hendaklah difailkan secara dalam talian (online) di sistem e-Tribunal melalui pautan https://ttpm.kpdnhep.gov.my 
								dan pemfailan di kaunter adalah tidak digalakkan; dan</li><br>

								<li>bagi tujuan keterangan lanjut, sila hubungi pejabat cawangan TTPM terdekat (sila rujuk direktori di bawah). </li>							
								</ol>
							
                                <br><li>
								Bagi pelaksanaan <b>Perintah Kawalan Pergerakan Bersyarat (PKPB)</b> di Sarawak <b>sehingga 1 Mac 2021-</b></li>
                                <br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut di Kuching, Miri, Bintulu dan Sibu sahaja akan ditangguhkan ke suatu tarikh 
								pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li><br>
								<li>segala urusan di Pejabat TTPM negeri berkenaan adalah <b>beroperasi seperti biasa.</b> </li>					
                                </ol><br>
				
								
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

						
								<br><br>Kami memohon maaf atas segala kesulitan.
								<br><br>
                                Terima kasih
                                <br><br></ol>
                                15hb Februari 2021
                            @else
                                <b></b><ol type="1">
                                <br><br><li>
                               	Kindly be informed that pursuant to the extension of <b>Movement Control Order (MCO)</b> in all Malaysian States except Sarawak until <b>18<sup>th</sup> February 2021-</b></li>
								<br><br><ol type="i">

								<li>all claims can be filed online through e-Tribunal system at https://ttpm.kpdnhep.gov.my and filling claims at TCCM 
								counter is not advisable; and</li>

								<li>for further inquiries, please contact the nearest TCCM offices (kindly refer to the directory below.)</li>							
								</ol>
								<br>

								
                                <li>For the implementation of <b>Conditional Movement Control Order (CMCO)</b> in Sarawak until <b>1<sup>st</sup> March 2021-</b></li>
                                <br><br>
                                <ol type="i">
								<li>all scheduled hearings during this period at Kuching, Miri, Bintulu and Sibu shall be postponed to a new hearing date. 
								All parties concerned will be notified of the new hearing date;</li>
								<li>the said offices are <b>operating as usual.</b> </li>					
								</ol>
				<br>

				<li>All hearing cases scheduled at TTPM Georgetown will be transferred to <b>TTPM Seberang Perai Tengah </b> effective from <b>01<sup>st</sup> January until 23<sup>rd</sup> July 2021</b> at the following address:
				    
					
				<br><br> <b>TTPM Seberang Perai Tengah
				    	<br>G-03, Tingkat Bawah,
				    	<br>Kompleks Sempilai Jaya,
				    	<br>Jalan Sempilai, Seberang Jaya,
  				    	<br>13700 Seberang Perai Tengah, Pulau Pinang.
				    	<br>Telephone no: 04-3840122 / 04-3840240
 				    </b></li>
			                                                         							
					            <br><br> We apologies for any inconvenience caused.
								<br><br>
                                Thank you
                                <br><br></ol>
                                15<sup>th</sup> February 2021
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