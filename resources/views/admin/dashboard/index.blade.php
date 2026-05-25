@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="container pb-8">
   DASHBOARD ADMIN
</div>
   
@endsection
