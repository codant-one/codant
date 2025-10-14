@extends("emails.layouts.layout")

@section("content")
<tr>
    <td style="padding-bottom: 1.5rem!important;padding-left:15px;padding-right:15px;" align="center">
        <h2 class="title-codant" style="color:#151426">
            {!! $title !!}
        </h2>
        <p class="p-codant pb-0">Hola: {{$user}}</p>
        <p class="p-codant mb-0">{!! $text !!}</p>
    </td>
</tr>
@if(isset($buttonText))
<tr>
    <td style="padding-bottom: 1.5rem!important; font-size: 12px;" align="center">
        <a href="{{$buttonLink}}" class="btn btn-primary button-codant" style="background-color: #AA83FF">
            {!! $buttonText !!}
        </a>
    </td>
</tr>
@endif
@if(isset($LinkText))
<tr>
    <td style="font-size: 12px;" align="center">
        <a href="{{$Link}}" target="_blank" class="btn btn-primary"  style="color: #151426">
            {!! $LinkText !!}
        </a>
    </td>
</tr>
@endif
@if(isset($text2))
<tr>
    <td align="center" style="margin:0;padding:0">
        <p class="p-codant">{!! $text2 !!}</p>
    </td>
</tr>
@endif
@endsection
        