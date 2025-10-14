@extends('layouts.master', [
    'toolbar' => false,
    'title' => 'Inicio',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio'
    ]
])

@section('content')

<div class="container pb-8">
   DASHBOARD ADMIN
</div>
   
@endsection
