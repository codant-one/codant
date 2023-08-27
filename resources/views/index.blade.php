@extends('layouts.master')

@section('content')


    @include('partials.video')
    @include('partials.about_us')
    @include('partials.believe')
    @include('partials.do')
    @include('partials.contact')
    
@endsection

@section('scripts')
<script>
    
    var services = document.querySelector('.services');
    var servicesTwo = document.querySelector('.servicesTwo');
    var scrollPosition = 0;

    // Agregar un evento de scroll
    window.addEventListener('scroll', function() {
        var newScrollPosition = window.scrollY;

        // Detectar dirección de scroll
        var scrollDirection = (newScrollPosition > scrollPosition) ? 'down' : 'up';
       
        // Actualizar el desplazamiento horizontal del contenedor
        if (scrollDirection === 'down') {
            services.style.transform = `translateX(40px)`; 
            servicesTwo.style.transform = `translateX(-40px)`;    
        } else {
            services.style.transform = `translateX(-40px)`;  
            servicesTwo.style.transform = `translateX(40px)`;   
        }
            
        // Actualizar la posición de scroll
        scrollPosition = newScrollPosition;
    });

</script>
@endsection