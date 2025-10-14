<tr>
    <td bgcolor="#151426" style="text-align:center;padding-top:25px;padding-bottom:25px; background-color:#151426">
        <img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="icon-codant">
        <p style="text-align: center; font-size: 12px; color: #FFFFFF;">
            © {{ date('Y') }} CODANT. All Rights Reserved.
        </p>
        <a 
            href="{{ env('URL_TERMINOS_Y_CONDICIONES') }}" 
            target="_blank" 
            style="text-align: center; font-size: 12px; text-decoration: none; color:#FFFFFF">
            Términos y condiciones
        </a>
        <a 
            href="{{ env('URL_POLITICA_DE_PRIVACIDAD') }}" 
            target="_blank" 
            style="text-align: center; font-size: 12px; text-decoration: none; color:#FFFFFF; margin-left: 5px;">
            Políticas de privacidad
        </a>
    </td>
</tr>