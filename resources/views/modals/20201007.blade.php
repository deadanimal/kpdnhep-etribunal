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
                                <b>Arahan ini hanya terpakai untuk urusan di Pejabat Tribunal Tuntutan Pengguna Negeri Sabah sahaja.</b>
                                <br><br>
                                Sila ambil perhatian, susulan daripada pelaksanaan Perintah Kawalan Pergerakan Bersyarat (PKPB)
                                di negeri Sabah yang berkuat kuasa mulai 7 hingga 20 Oktober 2020,
                                semua tuntutan boleh difailkan secara online di Sistem e-Tribunal manakala bagi pemfailan
                                tuntutan secara manual di kaunter TTPM hendaklah dibuat secara temujanji sahaja.
                                Bagi tujuan ini sila hubungi:
                                <br><br>
                                <span style="text-align: center">
                                    <b>Tribunal Tuntutan Pengguna Malaysia</b>
                                    <br>Pejabat Kementerian Perdagangan Dalam Negeri
                                    <br>dan Hal Ehwal Pengguna Negeri Sabah
                                    <br>Aras 6, Blok A Kompleks Pentadbiran Kerajaan Persekutuan Sabah, Jalan Ums
                                    <br>88450 Kota Kinabalu
                                    <br>Tel: 088-484500 /546/ 564
                                    <br>WhatsApp: 019-3898940
                                    <br>Faks: 088-484 548
                                    <br>E-mel: ttpmsabah@kpdnhep.gov.my
                                </span>
                                <br><br>
                                Sila ambil maklum bahawa semua kes yang telah ditetapkan untuk pendengaran pada tempoh
                                ini ditangguhkan ke tarikh pendengaran baharu. Kesemua pihak yang terlibat akan dimaklumkan
                                tarikh pendengaran baru.
                                <br><br>
                                Kami memohon maaf atas segala kesulitan.
                                <br><br>
                                Terima kasih
                                <br><br>
                                7hb Oktober 2020
                            @else
                                <b>This notice only applies to Tribunal for Consumer Claims the state of Sabah</b>
                                <br><br>
                                Please be advised, pursuant to the implementation of Conditional Movement Control Order (CMCO),
                                effective from 7th October to 20th October 2020,
                                all claims can be filed online at e-Tribunal System while filling claims at TTPM counter
                                shall only be made by way of appointment. For this purpose, please contact:
                                <br><br>
                                <span style="text-align: center">
                                    <b>Tribunal for Consumer Claims Malaysia</b>
                                    <br>Ministry of Domestic Trade and Consumer Affair Office
                                    <br>Aras 6, Blok A Kompleks Pentadbiran Kerajaan Persekutuan Sabah, Jalan Ums
                                    <br>88450 Kota Kinabalu
                                    <br>Tel: 088-484500 /546/ 564
                                    <br>WhatsApp: 019-3898940
                                    <br>Fax: 088-484 548
                                    <br>Email: ttpmsabah@kpdnhep.gov.my
                                </span>
                                <br><br>
                                Kindly be informed that all scheduled hearings during this period have been postponed to new hearing date.
                                All parties concerned will be notified of the new hearing date.
                                <br><br>
                                We apologies for any inconvenience caused.
                                <br><br>
                                Thank yous
                                <br><br>
                                7<sup>st</sup> October 2020
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