@extends("emails.layouts.layout")

@section("content")
<tr>
    <td align="center" style="margin:0;padding:0">
        <h2 class="title-layout" style="color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }};">{{$title}}</h2>
        <p class="p-layout pb-0">Hola: {{$user}}</p>
        <p class="p-layout mb-0">{!! $text !!}</p>
    </td>
</tr>
<tr>
    <td class="button-layout-td" align="center">
        <a href="{{$buttonLink}}" class="btn btn-primary button-layout" style="background-color: {{ $type === 1 ? '#CE305B' : '#6AB0B5' }};">
            {{$buttonText}}
        </a>
    </td>
</tr>        
@if(isset($text2))
<tr>
    <td align="center" style="margin:0;padding:0">
        <p class="p-layout">{!! $text2 !!}</p>
    </td>
</tr>
@endif
@endsection
        