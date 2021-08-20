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
                                <b>Arahan ini hanya terpakai untuk urusan di Pejabat Tribunal Tuntutan Pengguna (TTPM)
                                    Negeri Selangor, Sabah, Wilayah Persekutuan Kuala Lumpur dan Wilayah Persekutuan
                                    Putrajaya sahaja.</b>
                                <br><br>
                                Sila ambil perhatian, susulan daripada pelaksanaan Perintah Kawalan Pergerakan Bersyarat
                                (PKPB) di Negeri Sabah yang berkuatkuasa mulai 7 Oktober sehingga 20 Oktober 2020 dan
                                Negeri Selangor, Wilayah Persekutuan Kuala Lumpur dan Wilayah Persekutuan Putrajaya
                                yang berkuatkuasa pada 14 Oktober sehingga 27 Oktober 2020, semua tuntutan boleh
                                difailkan secara online di Sistem e-Tribunal manakala bagi pemfailan tuntutan secara
                                manual di kaunter TTPM hendaklah dibuat secara temujanji sahaja. Bagi tujuan ini sila hubungi:-
                                <br><br>
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <td>(i)</td>
                                        <td>TTPM Negeri Selangor</td>
                                        <td>03-5514 4717 <br> ttpmb@kpdnhep.gov.my</td>
                                    </tr>
                                    <tr>
                                        <td>(ii)</td>
                                        <td>TTPM Wilayah Persekutuan Kuala Lumpur</td>
                                        <td>03- 4042 4181 <br>
                                            ttpmwp@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(iii)</td>
                                        <td>TTPM Wilayah Persekutuan Putrajaya</td>
                                        <td>03- 8882 5822 <br>
                                            ttpmputrajaya@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(iv)</td>
                                        <td>TTPM Negeri Sabah</td>
                                        <td>088- 484 564 <br>
                                            ttpmsabah@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                </table>
                                Sila ambil maklum bahawa semua kes yang telah ditetapkan untuk pendengaran pada tempoh
                                ini ditangguhkan ke tarikh pendengaran baharu. Kesemua pihak yang terlibat akan dimaklumkan
                                tarikh pendengaran baharu.
                                <br><br>
                                Kami memohon maaf atas segala kesulitan.
                                <br><br>
                                Terima kasih
                                <br><br>
                                13hb Oktober 2020
                            @else
                                <b>This notice only applies to Tribunal for Consumer Claims (TCCM) the State of Selangor,
                                    Sabah, Wilayah Persekutuan Kuala Lumpur and Wilayah Persekutuan Putrajaya.</b>
                                <br><br>
                                Please be advised, pursuant to the implementation of Conditional Movement Control Order (CMCO),
                                in State of Sabah effective from 7th October to 20th October 2020 and the State of Selangor,
                                Wilayah Persekutuan Kuala Lumpur and Wilayah Persekutuan Putrajaya effective from
                                14th October 2020 to 27th October, all claims can be filed online at e-Tribunal
                                System while filling claims at TCCM counter shall only be made by way of appointment.
                                For this purpose, please contact:
                                <br><br>
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <td>(i)</td>
                                        <td>TCCM State of Selangor</td>
                                        <td>03-5514 4717 <br>  ttpmb@kpdnhep.gov.my</td>
                                    </tr>
                                    <tr>
                                        <td>(ii)</td>
                                        <td>TCCM Wilayah Persekutuan Kuala Lumpur</td>
                                        <td>03- 4042 4181 <br>
                                            ttpmwp@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(iii)</td>
                                        <td>TCCM Wilayah Persekutuan Putrajaya</td>
                                        <td>03- 8882 5822 <br>
                                            ttpmputrajaya@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>(iv)</td>
                                        <td>TCCM State of Sabah</td>
                                        <td>088- 484 564 <br>
                                            ttpmsabah@kpdnhep.gov.my
                                        </td>
                                    </tr>
                                </table>
                                Kindly be informed that all scheduled hearings during this period have been postponed to new hearing date.
                                All parties concerned will be notified of the new hearing date.
                                <br><br>
                                We apologies for any inconvenience caused.
                                <br><br>
                                Thank you
                                <br><br>
                                13<sup>th</sup> October 2020
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