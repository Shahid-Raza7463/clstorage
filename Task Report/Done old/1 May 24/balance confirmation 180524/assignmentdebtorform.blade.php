{!! $description ?? '' !!}

<div class="container">
    <div class="content-container">
        <h3 style="text-align: center; color: green;text-decoration: underline;">Confirmation</h3>
        <p style="text-align: center;">
            @if ($amounthidestatus == 1)
                We confirm that in our books of account, the outstanding balance as on
                {{ date('F d,Y', strtotime($date)) }} is
                <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span>
            @else
                We request you to provide the
                @if ($type == 1)
                    <span>Debtor</span>
                @elseif($type == 2)
                    <span>Creditor</span>
                @else
                    <span>Bank</span>
                @endif
                Balance Confirmation as on
                {{ date('F d,Y', strtotime($date)) }} at the earliest.
            @endif
            <br />
            To Accept or Refuse, please click the button below.
        </p>
        <div style="text-align: center;">
            <a href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no . '&&' . 'type=' . $type) }}"
                style="padding: 8px 16px;background: green;color: white;text-decoration: none;width: 75px;text-align: center;">Click
                Here
            </a>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<hr>






{{-- 

<p><br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br />
    @if ($amounthidestatus == 1)
        We confirm that in our books of account, the outstanding balance as on {{ date('F d,Y', strtotime($date)) }} is
        <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span>
    @else
        We request you to provide the
        @if ($type == 1)
            <span>Debtor</span>
        @elseif($type == 2)
            <span>Creditor</span>
        @else
            <span>Bank</span>
        @endif
        Balance Confirmation as on
        {{ date('F d,Y', strtotime($date)) }} at the earliest.
    @endif
    <br />
    To Accept or Refuse, please click the button below
    <a href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no . '&&' . 'type=' . $type) }}"
        style=" background-color: #00ff6a;">here</a>
</p>
<p>&nbsp;</p>
<br>
<hr> --}}
<p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
<p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended for
        a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
        distribution, transmission, copying or disclosure of this information in any way or in any manner is strictly
        prohibited. You should delete this message and inform the sender. </em></p>
<p>&nbsp;</p>





















{{-- {!! $description ?? '' !!}

<p><br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br />
    @if ($amounthidestatus == 1)
        We confirm that in our books of account, the outstanding balance as on {{ date('F d,Y', strtotime($date)) }} is
        <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span>
    @else
        We request you to provide the
        @if ($type == 1)
            <span>Debtor</span>
        @elseif($type == 2)
            <span>Creditor</span>
        @else
            <span>Bank</span>
        @endif
        Balance Confirmation as on
        {{ date('F d,Y', strtotime($date)) }} at the earliest.
    @endif
    <br />
    To Accept or Refuse, please click <a
        href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no . '&&' . 'type=' . $type) }}"
        style=" background-color: #00ff6a;">here</a>
</p>
<p>&nbsp;</p>
<br>
<hr>
<p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
<p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended for
        a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
        distribution, transmission, copying or disclosure of this information in any way or in any manner is strictly
        prohibited. You should delete this message and inform the sender. </em></p>
<p>&nbsp;</p> --}}
