
@if($language == 1)
<table class="m_2541210229120469261wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%"> 
    <tbody>
        <tr>
            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <table class="m_2541210229120469261content" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
                    <tbody>
                        <tr>
                            <td class="m_2541210229120469261header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center">
                                <a href="https://ttpm.kpdnhep.gov.my" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank">
                                    <font style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box" size="3">
                                        Tribunal For Consumer Claims Malaysia, <br>
                                        Ministry Of Domestic Trade And Consumer Affairs, <br></font>
                                        <font style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box" size="2">e-Tribunalv2</font>
                                    </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="m_2541210229120469261body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                                <table class="m_2541210229120469261inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                                    <tbody>
                                        <tr>
                                            <td class="m_2541210229120469261content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                                    <span class="im">
                                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Sir/Madam,</h1>
                                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">   
                                                            <center><p>There is an inquiry by {{ $inquiry->inquired_by->name ?? '-' }} which requires your attention. Please click on the button below to read and reply to the inquiry.</p></center>
                                                            @component('mail::button', ['url' => "https://ttpm.kpdnhep.gov.my/onlineprocess/inquiry"])
                                                            List of Inquiries
                                                            @endcomponent
                                                            <center><p>If the button does not work, you may copy and paste the link below into your browser.</p></center>
                                                            <center><p>https://ttpm.kpdnhep.gov.my/onlineprocess/inquiry</p></center>
                                                            <br/>
                                                        </p>
                                                            <table class="m_2541210229120469261action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                                        <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                        </td>
                                                                            </tr></tbody></table>
                                                                        </td>
                                                                            </tr></tbody></table>
                                                                            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"></p>
                                                                            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Regards,<br>e-Tribunalv2</p>
                                                                            </span>
                                                                            <table class="m_2541210229120469261subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px"></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                                </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                            <table class="m_2541210229120469261footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="m_2541210229120469261content-cell" align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                                                                            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">Tribunal For Consumer Claims Malaysia, <br>
Ministry Of Domestic Trade And Consumer Affairs, <br>
Copyright © 2017 e-Tribunalv2. All rights reserved.</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
        </tr></tbody></table>

@elseif($language == 2)

<table class="m_2541210229120469261wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%"><tbody><tr>
<td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <table class="m_2541210229120469261content" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
<tbody><tr>
<td class="m_2541210229120469261header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center">
        <a style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" >
            <a href="https://ttpm.kpdnhep.gov.my" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank">
            <font style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box" size="3">
                Tribunal Tuntutan Pengguna Malaysia, <br>
                Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, <br></font>
                <font style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box" size="2">e-Tribunalv2</font>
            </a>
        </a>
    </td>
</tr>
<tr>
<td class="m_2541210229120469261body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            <table class="m_2541210229120469261inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
<tbody><tr>
<td class="m_2541210229120469261content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px"><span class="im">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Tuan/Puan,</h1>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">

                    <center><p>Terdapat satu pertanyaan daripada {{ $inquiry->inquired_by->name ?? '-' }} yang memerlukan perhatian anda. Sila klik butang di bawah untuk membaca dan membalas pertanyaan tersebut.</p></center>
                    @component('mail::button', ['url' => "https://ttpm.kpdnhep.gov.my/onlineprocess/inquiry"])
                    Senarai Pertanyaan
                    @endcomponent
                    <center><p>Jika butang di atas tidak berjaya, anda boleh buka pautan di bawah menggunakan pelayar web anda.</p></center>
                    <center><p>https://ttpm.kpdnhep.gov.my/onlineprocess/inquiry</p></center>
                    <br/>

</p>
<table class="m_2541210229120469261action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%"><tbody><tr>
<td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box"><tbody><tr>
<td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box"><tbody><tr>
<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                    
                                </td>
                            </tr></tbody></table>
</td>
                </tr></tbody></table>
</td>
    </tr></tbody></table>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"></p>
<p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Sekian,<br>e-Tribunalv2</p>
</span><table class="m_2541210229120469261subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px"><tbody><tr>
<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
            <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px"></p>
        </td>
    </tr></tbody></table>
</td>
                                </tr>
</tbody></table>
</td>
                    </tr>
<tr>
<td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
        <table class="m_2541210229120469261footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px"><tbody><tr>
<td class="m_2541210229120469261content-cell" align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">Tribunal Tuntutan Pengguna Malaysia, <br>
Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna, <br>
Hakcipta © 2017 e-Tribunalv2. Hakcipta terpelihara.</p>
                </td>
            </tr></tbody></table>
</td>
</tr>
</tbody></table>
</td>
        </tr></tbody></table>

@endif










<!-- 

                 <center>  <td class="m_2541210229120469261header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center">
        <a  style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" >
            e-Tribunalv2
        </a>
    </td></center>

                                        
                       <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Sir/Madam,</h1> 

                <center>   <p>User ID : {{ $identification_no or ''}}</p></center>
            <center>    <p>Password : {{ $password or '' }}</p>     </center>
                <center><p>Click here to log in : <a href="{{ route('login') }}">http://103.21.183.181/etribunalv2_2_git</a></p></center>
              <center><p> Thank you for registering as a e-Tribunal user. Your registration was succeed and you can make a filing regarding your claims to Tribunal Tuntutan Pengguna Malaysia through this systems.</p></center>                         
                  <center> <p>  This is a system generated email. Please do not reply to it.</p></center>
                                <br/><br/>


          <p>  Regards,</p>
      <p>      e-Tribunalv2 </p>

 -->
