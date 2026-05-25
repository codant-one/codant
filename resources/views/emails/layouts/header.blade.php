@php
    $logoUrl = $logo === 1 ? env('DOMAIN_LOGO_URL_SERVICES') : env('DOMAIN_LOGO_URL_CONNECT');
    $logoSrc = \Illuminate\Support\Str::startsWith($logoUrl, ['http://', 'https://']) ? $logoUrl : secure_asset($logoUrl);
@endphp
<tr>
    <td align="center" style="padding:0;margin:0;padding:15px">
        <img src="{{ $logoSrc }}" alt="logo-layout" width="250">
    </td>
    
</tr>
<tr>
    <td align="center" style="padding:0;margin:0;padding:15px" class="img-layout pb-0">
        <img src="{{ $type === 1 ? secure_asset('images/illustration_mail_1.png') : secure_asset('images/illustration_mail_2.png') }}" alt="img-layout">
    </td>
</tr>