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
                                                		Makluman berhubung pelaksanaan <b>Perintah Kawalan Pergerakan (PKP)</b> di Pulau Pinang, Selangor, Wilayah Persekutuan (Kuala Lumpur, Putrajaya dan Labuan), 
								Johor, Sabah dan Melaka berkuat kuasa pada 13 Januari sehingga 26 Januari 2021, Kelantan berkuat kuasa pada 16 Januari sehingga 29 Januari SERTA Negeri Sembilan, 
								Pahang, Perak, Kedah, Terengganu dan Perlis berkuat kuasa pada 22 Januari sehingga 4 Februari 2021-</li> 
								
								<br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut akan ditangguhkan ke suatu tarikh 
								pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li><br>
								<li>semua tuntutan hendaklah difailkan secara dalam talian (online) di sistem e-Tribunal melalui 
								pautan https://ttpm.kpdnhep.gov.my dan pemfailan di kaunter adalah tidak digalakkan; dan </li><br>
								<li>bagi tujuan keterangan lanjut, sila hubungi pejabat cawangan TTPM terdekat (sila rujuk direktori di bawah). </li>							
								</ol>
								<br><br><li>

								<p style="color:red">
								Penutupan operasi pejabat TTPM Negeri Kedah bermula pada 17 Januari sehingga 25 Januari 2021 untuk 
								proses sanitasi pejabat bagi tujuan keselamatan orang awam. 
								</p>


                                Bagi pelaksanaan <b>PERINTAH KAWALAN PERGERAKAN PEMULIHAN (PKP-P)</b> di Sarawak yang berkuat kuasa kuasa pada 13 Januari sehingga 26 Januari 2021-</li>
                                <br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut di Kuching, Miri dan Bintulu sahaja akan ditangguhkan 
								ke suatu tarikh pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li><br>
								<li>segala urusan di Pejabat TTPM negeri berkenaan adalah <b>beroperasi seperti biasa.</b>  </li>					
                                                                <br>
                                				
								Kami memohon maaf atas segala kesulitan.
								<br><br>
                                				Terima kasih
                                <br><br></ol>
                                20hb Januari 2021
                            @else
                                <b></b><ol type="1">
                                <br><br><li>
                               					Kindly be informed that due to the implementation of <b>Movement Control Order (MCO)</b> in Pulau Pinang, Selangor, 
								Wilayah Persekutuan (Kuala Lumpur, Putrajaya and Labuan), Johor, Sabah and Melaka effective from 13 January until 26 January 2021,
								Kelantan effective from 16 January until 29 January 2021 AND Negeri Sembilan, Pahang, Perak, Kedah Terengganu and Perlis effective from 22 January until 4th February 2021- 
<br>
		                               
								<br>
                               				        <ol type="i">
								<li>all scheduled hearings during this period shall be postponed to a new hearing date. All parties concerned 
								will be notified of the new hearing date;</li><br>
								<li>all claims can be filed online through e-Tribunal system at https://ttpm.kpdnhep.gov.my and filling claims 
								at TCCM counter is not advisable; and</li><br>
								<li>for further inquiries, please contact the nearest TCCM offices (kindly refer to the directory below.)</li>							
								</ol>
								<br><br><li>

								<p style="color:red">
								TCCM Kedah is temporarily closed from 17<sup>th</sup> January until 25<sup>th</sup> January 2021 for sanitization work to ensure the safety of the public. </p>


                                For the implementation of <b>Recovery Movement Control Order (RMC-O)</b> in Sarawak effective from 13 January until 26 January 2021-</li>
                                <br><br>
                                <ol type="i">
								<li>all scheduled hearings during this period at Kuching, Miri dan Bintulu shall be postponed to a new hearing date. 
								All parties concerned will be notified of the new hearing date;</li><br>
								<li>the said offices are <b>operating as usual.</b> </li>					
								</ol>
                                <br><br> <li>                             							
					                                We apologies for any inconvenience caused.
								<br><br>
                                Thank you
                                <br><br></ol>
                                20<sup>th</sup> January 2021
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