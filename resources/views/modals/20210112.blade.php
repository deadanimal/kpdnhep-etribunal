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
                                <b></b>
                                <br><br>
                                Makluman berhubung pelaksanaan <b>PERINTAH KAWALAN PERGERAKAN (PKP)</b> di Pulau Pinang, Selangor, 
								Wilayah Persekutuan (Kuala Lumpur, Putrajaya dan Labuan), Johor, Sabah dan Melaka serta 
								<b>PERINTAH KAWALAN PERGERAKAN BERSYARAT (PKP-B)</b> di Pahang, Perak, Negeri Sembilan, Kedah, Terengganu 
								dan Kelantan berkuat kuasa pada <b>13 Januari sehingga 26 Januari 2021</b>-                               
								<br><br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut akan ditangguhkan ke suatu tarikh pendengaran baharu. 
								Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li>
								<li>semua tuntutan hendaklah difailkan secara dalam talian (online) di sistem e-Tribunal melalui 
								pautan https://ttpm.kpdnhep.gov.my dan pemfailan di kaunter adalah tidak digalakkan; dan </li>
								<li>bagi tujuan keterangan lanjut, sila hubungi pejabat cawangan TTPM terdekat (sila rujuk direktori di bawah). </li>							
								</ol>
								<br><br>
                                Bagi pelaksanaan <b>PERINTAH KAWALAN PERGERAKAN PEMULIHAN (PKP-P)</b> di Perlis dan Sarawak yang 
								berkuat kuasa untuk tempoh yang sama-
                                <br><br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut di Kuching, Miri dan Bintulu sahaja 
								akan ditangguhkan ke suatu tarikh pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai 
								tarikh pendengaran baharu kelak; dan</li>
								<li>segala urusan di Pejabat TTPM negeri berkenaan adalah <b>beroperasi seperti biasa.</b> </li>					
								</ol>
								<br><br>
                                Sila ambil perhatian, semua kes pendengaran yang dijadualkan di TTPM Georgetown akan dipindahkan ke TTPM Seberang Perai Tengah berkuat kuasa pada 01 Januari sehingga 23 Julai 2021 seperti alamat berikut:
								<br><br><b>
								Pejabat TTPM Seberang Perai Tengah
								<br>
								G-03,Tingkat Bawah,
								<br>
 								Kompleks Sempilai Jaya,
								<br>
 								Jalan Sempilai, Seberang Jaya,
								<br>
								13700 Seberang Perai Tengah, Pulau Pinang.
								<br>
								No. Telefon: 04-3840122 / 04-3840240 
								</b>
                                <br><br>
                                Kami memohon maaf atas segala kesulitan.
								<br><br>
                                Terima kasih
                                <br><br>
                                12hb Januari 2021
                            @else
                                <b></b>
                                <br><br>
                                Kindly be informed that due to the implementation of <b>Movement Control Order (MCO)</b> in Pulau Pinang, Selangor, 
								Wilayah Persekutuan (Kuala Lumpur, Putrajaya and Labuan), Johor, Sabah and Melaka and 
								<b>Conditional Movement Control Order (CMC-O)</b> in Pahang, Perak, Negeri Sembilan, Kedah, Terengganu and Kelantan 
								effective from <b>13<sup>th</sup> January until 26<sup>th</sup> January 2021</b>-                                
								<br><br>
                                <ol type="i">
								<li>all scheduled hearings during this period shall be postponed to a new hearing date. All parties concerned 
								will be notified of the new hearing date;</li>
								<li>all claims can be filed online through e-Tribunal system at https://ttpm.kpdnhep.gov.my and filling claims 
								at TCCM counter is not advisable; and</li>
								<li>for further inquiries, please contact the nearest TCCM offices (kindly refer to the directory below.)</li>							
								</ol>
								<br><br>
                                For the implementation of <b>Recovery Movement Control Order (RMC-O)</b> in Perlis and Sarawak effective for the same period-
                                <br><br>
                                <ol type="i">
								<li>all scheduled hearings during this period at Kuching, Miri dan Bintulu shall be postponed to a new hearing date. 
								All parties concerned will be notified of the new hearing date;</li>
								<li>the said offices are <b>operating as usual.</b> </li>					
								</ol>
                                <br><br>                              							
								Please be advised, all hearing cases scheduled at TTPM Georgetown will be transferred to TTPM Seberang Perai Tengah effective 
								from 01<sup>st</sup> January until 23<sup>rd</sup> July 2021 at the following address:
								<br><br><b>
								Pejabat TTPM Seberang Perai Tengah
								<br>
								G-03, Tingkat Bawah,
								<br>
 								Kompleks Sempilai Jaya,
								<br>
 								Jalan Sempilai, Seberang Jaya,
								<br>
								13700 Seberang Perai Tengah, Pulau Pinang.
								<br>
								Telephone no: 04-3840122 / 04-3840240 
								<br><br></b>
                                We apologies for any inconvenience caused.
								<br><br>
                                Thank you
                                <br><br>
                                12<sup>th</sup> January 2021
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