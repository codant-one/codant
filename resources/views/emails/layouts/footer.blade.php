@php
    $faviconUrl = env('DOMAIN_FAVICON_URL');
    $faviconSrc = \Illuminate\Support\Str::startsWith($faviconUrl, ['http://', 'https://']) ? $faviconUrl : secure_asset($faviconUrl);
@endphp
<tr>
    <td bgcolor="{{ $type === 1 ? '#FFE0E4' : '#F2F9F9' }}" style="text-align:center;padding-top:25px;padding-bottom:25px; background-color:{{ $type === 1 ? '#FFE0E4' : '#F2F9F9' }}">
        <img src="{{ $faviconSrc }}" alt="icon-layout">
        <p style="text-align: center; font-size: 12px; color: #4F4F4F;">
            © 2025 {{ env('APP_NAME') }}. All rights reserved.
        </p>
        <a 
            href="{{ env('URL_TERMINOS_Y_CONDICIONES') }}" 
            target="_blank" 
            style="text-align: center; font-size: 12px; text-decoration: none; color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }};">
            Términos y condiciones
        </a>
        <a 
            href="{{ env('URL_POLITICA_DE_PRIVACIDAD') }}" 
            target="_blank" 
            style="text-align: center; font-size: 12px; text-decoration: none; color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }}; margin-left: 5px;">
            Políticas de privacidad
        </a>
    </td>
</tr>