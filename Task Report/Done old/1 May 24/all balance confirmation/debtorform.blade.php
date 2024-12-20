{!! $description ?? '' !!}

<p><br /> <br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br /> We
    confirm that the in our books of account, the outstanding balance as on 30.09.2022 is
    <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span> <br />
    To Accept or Refuse, please click <a
        href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
</p>
<p>&nbsp;</p>
<br>
<hr>
<p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
<p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended for
        a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
        distribution, transmission, copying or disclosure of this information in any way or in any manner is strictly
        prohibited. You should delete this message and inform the sender. </em></p>
<p>&nbsp;</p>
