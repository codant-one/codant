@extends('layouts.master')

@section('content')

<style>
    #animacion-1{
        border: none;
        margin-top:-122px;
    }
</style>

    <div class="g-0">

        <div class="col-12">
            <video id="animacion-1" autoplay="" loop=""  muted="" playsinline="" data-wf-ignore="true" data-object-fit="cover"><source src="{{asset('/video/slider_ESP.mp4')}}" data-wf-ignore="true"><source src="{{asset('/video/slider_ESP.mp4')}}" data-wf-ignore="true"></video>
        </div>
        <div class="col-12" style="text-align:center">
            <button class="button-video" onclick="window.location.href='#contacto'">Quiero comenzar un proyecto</button>
        </div>
    </div>

    <div class="row g-0 sections" id="quienes-somos">
        <p><span>(01)</span> <span style="margin-left:78px">¿QUIÉNES SOMOS?</span></p>
        <div class="col-md-7 section-we">
            <p class="text-we">
                <b>Codant</b> es un grupo de profesionales con colonia en el mundo, donde la ingeniería y la creatividad convergen 
                para dar vida a marcas que quieren anidar un universo digital. <b>Nos une la pasión de crear un entorno diferente, 
                único y que te represente.</b>
            </p>
        </div>
        <div class="col-md-5">
            <div class="row g-0">
                <div class="col-6">
                    <div class="img-right">
                        <img class="diego-img" src="{{asset('/img/Diego.png')}}" alt="Diego">
                        <img class="francisco-img"  src="{{asset('/img/Francisco.png')}}" alt="Francisco">
                    </div>
                </div>
                <div class="col-6 align-self-end">
                    <div class="img-left">
                        <img class="steffani-img" src="{{asset('/img/Steffani.png')}}" alt="Steffani">
                        <img class="freddy-img"  src="{{asset('/img/Freddy.png')}}" alt="Freddy">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0 sections section-creemos" id="creemos">
            <p><span>(02)</span> <span style="margin-left:78px">¿EN QUÉ CREEMOS?</span></p>
            <div class="col-md-5">
                <h3 class="title-creemos">La transparencia es la base <br> de nuestro hormiguero,</h3>
                <p>a raíz de ella construimos todos los caminos que <br> componen el universo digital quequieres lograr.</p>
            </div>
            <div class="col-md-7">
                <div class="figura-abs">
                    <img style="margin-top:50px;" src="{{asset('/img/figura-1.png')}}" alt="figura-abstracta" width="265px">
                </div>
                <p class="text-creemos">
                    Además, creemos en ti, que quieres que tu web<br> no sea una más, que quieres crear una <br>experiencia, 
                    que deseas resolver un problema <br>de la vida cotidiana con tu idea, que quieres <br>aplicar a tu marca 
                    nuevas tecnologías, <br>creemos en ti, que ves el mundo de otra manera.
                </p>
            </div>
    </div>

    <div class="row g-0 sections" id="hacemos">
        <p><span>(03)</span> <span style="margin-left:78px">¿QUÉ HACEMOS?</span></p>
        
        <div class="services">
            <div class="item">
                <div class="element">
                    <img src="{{asset('/img/icono-ui-ux.svg')}}" style="width:101px; margin-right:5px"  alt="ux/ui">
                    <span class="text">Diseño UI/UX</span>
                </div>
            </div>
            <div class="item">
                <div class="element">
                    <img src="{{asset('/img/desarrollo-icono.svg')}}" style="width:48px; margin-right:5px"  alt="web developer">
                    <span class="text">Desarrollo web</span>
                </div>
            </div>
            <div class="item">
                <div class="element">
                    <img src="{{asset('/img/aplicaciones.svg')}}" style="width:101px; margin-right:5px" alt="aplications mobile">
                    <span class="text">Aplicaciones moviles</span>
                </div>
            </div>
            <div class="item">
                <div class="element">
                    <img src="{{asset('/img/digital.svg')}}" style="width:48px; margin-right:5px"  alt="digital">
                    <span class="text">Productos digitales</span>
                </div>
            </div>
        </div>

        <!--Versión mobile de servicios-->

        <div class="col-6 services-mobile">
            <img src="{{asset('/img/icono-ui-ux.svg')}}" alt="ux-ui">
            <span class="text-mobile">Diseño UI/UX</span>
        </div>
        <div class="col-6 services-mobile">
            <img src="{{asset('/img/desarrollo-icono.svg')}}" alt="developer">
            <span class="text-mobile">Desarrollo web</span>
        </div>
        <div class="col-6 services-mobile">
            <img src="{{asset('/img/aplicaciones.svg')}}" alt="aplications">
            <span class="text-mobile">Aplicaciones moviles</span>
        </div>
        <div class="col-6 services-mobile">
            <img src="{{asset('/img/digital.svg')}}" alt="digital">
            <span class="text-mobile">Productos digitales</span>
        </div>

        <!--Fin Versión mobile de servicios-->

    </div>

    <!--SECCIÓN DEL FORMULARIO-->
    <div class="row g-0 sections-form" id="contacto">
        <div class="row fila-formulario">
           <h3 style="color: #FFF; text-align:center; font-size:48px; font-weight:700">Escríbenos un mensaje</h3>
           <p style="color:#FFF; text-align:center; font-size:24px;font-weight:400">Queremos saber de qué va tu proyecto y en que te podemos ayudar</p>

           <form action="{{route('main.store')}}" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label style=" color:#FFF; font-size: 16px; font-style: normal; font-weight: 400;">Nombre</label>
                        <input type="text" class="form-control input-formulario" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label style=" color:#FFF; font-size: 16px; font-style: normal; font-weight: 400;">Correo Electrónico</label>
                        <input type="email" class="form-control input-formulario" name="email" required>
                    </div>
                    <div class="col-md-4">
                        <label style="color:#FFF; font-size: 16px; font-style: normal; font-weight: 400;">Que servicio deseas</label>
                        <input type="text" class="form-control input-formulario" name="service" required>
                    </div>
                </div>
                <div class="form-group" style="margin-top:24px">
                    <label style=" color:#FFF; font-size: 16px; font-style: normal; font-weight: 400;">Cuéntanos que proyecto tienes en mente</label>
                    <textarea class="form-control input-formulario" name="description" rows="5"></textarea>
                </div>

                @csrf
                <button type="submit" class="button-formulario">Enviar</button>
            </form>
        </div>
    </div>
   
    <script>
    var container = document.querySelector('.services');
        var scrollPosition = 0;

        // Agregar un evento de scroll
        window.addEventListener('scroll', function() {
            var newScrollPosition = window.scrollY;
            
            // Detectar dirección de scroll
            var scrollDirection = (newScrollPosition > scrollPosition) ? 'down' : 'up';
            
            // Actualizar el desplazamiento horizontal del contenedor
            if (scrollDirection === 'down') {
                container.style.transform = `translateX(20px)`;
                
            } else {
                container.style.transform = `translateX(-20px)`;
                
            }
            
            // Actualizar la posición de scroll
            scrollPosition = newScrollPosition;
        });
</script>
@endsection