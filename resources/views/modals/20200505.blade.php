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
                                Sila ambil perhatian, semua tuntutan boleh difailkan secara online bermula 6hb Mei 2020
                                di Sistem e-Tribunal V2.
                                <br><br>
                                Pemfailan tuntutan secara manual di kaunter TTPM hendaklah dibuat secara temujanji.
                                Bagi tujuan ini sila hubungi :
                                <br><br>
                                <ol style="list-style-type: lower-alpha; padding-left:30px">
                                    <li>Hotline 1800 88 9811 [Isnin- Jumaat (8.00 pagi - 5 petang)]; dan</li>
                                    <li>Emel atau hubungi pejabat cawangan TTPM [rujuk direktori dibawah].</li>
                                </ol>
                                Sila ambil maklum bahawa semua kes yang telah ditetapkan untuk pendengaran sepanjang tempoh PKPB ditangguhkan ke tarikh pendengaran baharu.
                                Kesemua pihak yang terlibat akan dimaklumkan tarikh pendengaran baru.
                                <br><br>
                                Kami memohon maaf atas segala kesulitan.
                                <br><br>
                                Terima kasih
                                <br><br>
                                1hb Jun 2020
                            @else
                                Please be advised that all claims can be filed online at Sistem e-Tribunal v2 starting from 6th May 2020.
                                <br><br>
                                Filing of claims at TTPM’s counters, can only be made by way of appointments.
                                For this purpose, please contact:
                                <br><br>
                                <ol style="list-style-type: lower-alpha; padding-left:30px">
                                    <li>Hotline 1800 88 9811 [Monday-Friday (8am – 5pm)]; and</li>
                                    <li>Email or call the respective TCC branches [refer directory below].</li>
                                </ol>
                                Kindly be informed that all scheduled hearings during MCO will be deferred to a new date.
                                Involved parties will be notified of the new hearing date.
                                <br><br>
                                We apologies for any inconvenience caused.
                                <br><br>
                                Thank yous
                                <br><br>
                                1<sup>st</sup> Jun 2020
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