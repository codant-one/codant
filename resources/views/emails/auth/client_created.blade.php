@extends("emails.layouts.layout")

@section("content")
<tr>
    <td align="center" style="margin:0;padding:0">
        <h2 class="title-layout mb-0" style="color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }};">
            ¡Bienvenid@!
        </h2>
    </td>
</tr>
<tr>
    <td align="center" style="padding:0;margin:0;padding-top:15px;padding-bottom:20px;border-bottom: 1px solid #B2B2B2;">
        <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
            Cuenta creada satisfactoriamente
        </p>
    </td>
</tr>
<tr>
    <td align="center" style="padding:0;margin:0;padding-top:10px;">
        <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
            <strong>Hola, {{$data['user']}}</strong>
        </p>
    </td>
</tr>
<tr>
    <td align="center" style="padding:0;margin:0;padding-left:15px;padding-right:15px">
        <p class="p-layout pb-0">
            Le damos la bienvenida, hemos creado satisfactoriamente su cuenta de usuario para que pueda administrar nuestro sitio.
        </p>
    </td>
</tr>
<tr>
    <td align="center" style="padding:0;margin:0;padding-top:15px;padding-bottom:15px;">
        <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
            Usuario:&nbsp;<br>
            <strong>{{$data['email']}}</strong>
        </p><br>
        <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
            Contraseña de acceso:&nbsp;<br>
            <strong>{{$data['password']}}</strong>
        </p>
    </td>
</tr>
@endsection