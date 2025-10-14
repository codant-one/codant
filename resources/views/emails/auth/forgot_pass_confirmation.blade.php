@extends("emails.layouts.layout")

@section("content")
<tr>
    <td align="center" style="margin:0;padding:0">
        <h2 class="title-codant" style="color:#151426">{{$title}}</h2>
        <p class="p-codant pb-0">Hola: {{$user}}</p>
        <p class="p-codant mb-0">{!! $text !!}</p>
    </td>
</tr>
<tr>
    <td class="button-codant-td" align="center">
        <a href="{{$buttonLink}}" class="btn btn-primary button-codant" style="background-color:#AA83FF">
            {{$buttonText}}
        </a>
    </td>
</tr>        
@if(isset($text2))
<tr>
    <td align="center" style="margin:0;padding:0">
        <p class="p-codant">{!! $text2 !!}</p>
    </td>
</tr>
@endif
@endsection
        