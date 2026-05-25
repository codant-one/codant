@extends('admin.layouts.public')

@section('content')

<div class="d-flex flex-column flex-root text-center">
	<div class="d-flex flex-column flex-md-row flex-column-fluid">
        <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
            LANDING

            <a href="{{route('auth.login')}}" class="btn btn-lg btn-primary">ADMIN</a>
        </div>
    </div>
</div>
@endsection
