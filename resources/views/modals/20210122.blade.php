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
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut akan ditangguhkan ke suatu tarikh pendengaran baharu. 
								Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li><br>

								<li>semua tuntutan hendaklah difailkan secara dalam talian (online) di sistem e-Tribunal melalui pautan https://ttpm.kpdnhep.gov.my 
								dan pemfailan di kaunter adalah tidak digalakkan; dan</li><br>

								<li>bagi tujuan keterangan lanjut, sila hubungi pejabat cawangan TTPM terdekat (sila rujuk direktori di bawah). </li>							
								</ol>
							
                                <br><li>
								Bagi pelaksanaan <b>Perintah Kawalan Pergerakan Bersyarat (PKPB)</b> di Sarawak <b>sehingga 18 Februari 2021-</b></li>
                                <br>
                                <ol type="i">
								<li>semua kes yang ditetapkan untuk pendengaran dalam tempoh tersebut di Kuching, Miri, Bintulu dan Sibu sahaja akan ditangguhkan ke suatu tarikh 
								pendengaran baharu. Pihak-pihak yang terlibat akan dimaklumkan mengenai tarikh pendengaran baharu kelak;</li><br>
								<li>segala urusan di Pejabat TTPM negeri berkenaan adalah <b>beroperasi seperti biasa.</b> </li>					
                                </ol><br>
				
								
								Kami memohon maaf atas segala kesulitan.
								<br><br>
                                Terima kasih
                                <br><br></ol>
                                3hb Februari 2021
                            @else
                                <b></b><ol type="1">
                                <br><br><li>
                               	Kindly be informed that pursuant to the extension of <b>Movement Control Order (MCO)</b> in all Malaysian States except Sarawak until  to <b>18<sup>th</sup> February 2021-</b></li>
								<br><br><ol type="i">

								<li>all scheduled hearings during this period shall be postponed to a new hearing date. All parties concerned will be 
								notified of the new hearing date;</li>

								<li>all claims can be filed online through e-Tribunal system at https://ttpm.kpdnhep.gov.my and filling claims at TCCM 
								counter is not advisable; and</li>

								<li>for further inquiries, please contact the nearest TCCM offices (kindly refer to the directory below.)</li>							
								</ol>
								<br>

								
                                <li>For the implementation of <b>Conditional Movement Control Order (CMCO)</b> in Sarawak until <b>18<sup>th</sup> February 2021-</b></li>
                                <br><br>
                                <ol type="i">
								<li>all scheduled hearings during this period at Kuching, Miri, Bintulu and Sibu shall be postponed to a new hearing date. 
								All parties concerned will be notified of the new hearing date;</li>
								<li>the said offices are <b>operating as usual.</b> </li>					
								</ol>
				<br>
			                                                         							
					             We apologies for any inconvenience caused.
								<br><br>
                                Thank you
                                <br><br></ol>
                                3<sup>rd</sup> February 2021
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