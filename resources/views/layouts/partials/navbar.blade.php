<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="row g-0 menu-desktop" style="background-color:#151426; padding-bottom:24px; padding-top:24px; padding-right:113px;padding-left:113px">
    <div class="col-md-10" style="background-color:#FFFFFF; z-index: 99;  padding-bottom:16px; padding-top:16px; padding-right:48px;padding-left:48px; border-radius: 48px;">
        <div class="row">

            <div class="col-2">
                <img src="{{asset('/img/logo-codant.svg')}}" alt="Codant-logo">
            </div>

            <div class="col-7">
                <nav id ="main-menu"class="navbar navbar-expand-lg navbar-light" style="background-color:#FFFFFF;">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#quienes-somos">¿Quiénes somos? <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#creemos">¿En que creemos?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#hacemos">¿Que hacemos?</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-3" style="margin: auto; text-align:right;">
                <button class="button-contact" onclick="window.location.href='#contacto'">Contacto</button>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="text-align:right; margin:auto; z-index: 99;">
        <button class="button-language">ES</button>
    </div>
</div>

<div class="container menu-mobile">
    <div class="row g-0">
        <div class="col-12" style="z-index: 99;">
            <div class="row g-0" style="background-color:#FFFFFF;  padding: 16px 10px; border-radius: 20px; margin-top:20px">
                
                <div class="col-3" style="text-align:center; margin:auto;">

                    <nav id ="mobile-menu"class="navbar navbar-expand-lg navbar-light" style="background-color:#FFFFFF;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#quienes-somos">¿Quiénes somos? <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#creemos">¿En que creemos?</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#hacemos">¿Que hacemos?</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
            
                </div>
                <div class="col-6" style="text-align:center; margin:auto;">
                    <img src="{{asset('/img/logo-codant.svg')}}" alt="Codant-logo">
                </div>
                <div class="col-3" style="text-align:center; margin:auto;">
                    <button class="button-language">ES</button>
                </div>
            </div>
        </div>
    </div>
</div>