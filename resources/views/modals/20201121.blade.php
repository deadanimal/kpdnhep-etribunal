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
                                <b>Arahan ini terpakai untuk urusan di Pejabat Tribunal Tuntutan Pengguna (TTPM) seluruh Negara.</b>
                                <br><br>
                                Sila ambil perhatian, susulan daripada pelanjutan Perintah Kawalan Pergerakan Bersyarat (PKPB) sehingga 6 Disember 2020 di seluruh negara kecuali negeri Pahang, Perlis, Melaka, Terengganu, Kedah (kecuali Daerah Kulim) dan Johor (kecuali Daerah Kota Tinggi dan Daerah Mersing),  
								Semua tuntutan boleh difailkan secara atas talian (online) di sistem e-Tribunal manakala bagi pemfailan tuntutan secara manual di kaunter TTPM hendaklah dibuat secara temujanji sahaja. 
								Bagi tujuan ini, sila merujuk kepada direktori pejabat TTPM melalui pautan ttpm.kpdnhep.gov.my                               
								<br><br>
								Sila ambil maklum bahawa kes yang ditetapkan untuk pendengaran pada tempoh ini ditangguhkan ke tarikh 
								pendengaran baharu. Kesemua pihak yang terlibat akan dimaklumkan tarikh pendengaran baharu.                                 
								<br><br>
                                Kami memohon maaf atas segala kesulitan.
                                <br><br>
                                Terima kasih
                                <br><br>
                                21hb November 2020
                            @else
                                <b>This notice applies to all Tribunal for Consumer Claims Malaysia (TCCM).</b>
                                <br><br>
                                Please be advised, pursuant to the extension of Conditional Movement Control Order (CMCO), 
								to 6<sup>th</sup> December 2020 in all states except Pahang, Perlis, Melaka, Terengganu, Kedah (exclude Kulim District), Johor  (exclude Kota Tinggi and Mersing Districts. 
								All claims can be filed online at e-Tribunal system while filling claims at TCCM counter shall only be made by way of appointment. 
								For this purpose, please refer to our website at ttpm.kpdnhep.gov.my for contact details.								
                                				<br><br>
                               					 Kindly be informed that all scheduled hearings during this period have been postponed to a new 
								hearing date. All parties concerned will be notified of the new hearing date.                                
								<br><br>
                                We apologies for any inconvenience caused.
                                <br><br>
                                Thank you
                                <br><br>
                                21<sup>th</sup> November 2020
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