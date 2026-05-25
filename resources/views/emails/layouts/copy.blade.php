<tr>
    <td>
        <table width="100%" style="margin-bottom: 5px; padding-left: 15px; padding-right: 15px;">
            <tr>
                <td class="container-social" style="width: 50%;">
                    <a href="#">
                        <img src="{{ $type === 1 ? secure_asset('images/linkedin_mail_1.png') : secure_asset('images/linkedin_mail_2.png') }}" alt="linkedin" width="32">
                    </a>
                    <a href="#">
                        <img src="{{ $type === 1 ? secure_asset('images/twitter_mail_1.png') : secure_asset('images/twitter_mail_2.png') }}" alt="X" width="32">
                    </a>
                </td>
                <td style="width: 50%; text-align: right;">
                    <a 
                        href="mailto:admin@domain.net" 
                        style="font-size: 16px; color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }}; text-decoration: none;">
                        admin@domain.net
                    </a>
                </td>
            </tr>
        </table>
    </td>     
</tr>