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
								</b><br><br>

                                Kami memohon maaf atas segala kesulitan.
                                <br><br>
                                Terima kasih
                                <br><br>
                                11hb Januari 2021
                            @else
                                <b></b>
                                <br><br>
                                
							
								Please be advised, all hearing cases scheduled at TTPM Georgetown will be transferred to TTPM Seberang Perai Tengah effective from 01 January until 23 July 2021 at the following address:
								<br>
								<br><b>
								Pejabat TTPM Seberang Perai Tengah
								<br><b>
								G-03, Tingkat Bawah,
								<br><b>
 								Kompleks Sempilai Jaya,
								<br><b>
 								Jalan Sempilai, Seberang Jaya,
								<br><b>
								13700 Seberang Perai Tengah, Pulau Pinang.
								<br><b>
								Telephone no: 04-3840122 / 04-3840240 
								<br><br></b>



                                We apologies for any inconvenience caused.
                                <br><br>
                                Thank you
                                <br><br>
                                11<sup>th</sup> January 2021
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