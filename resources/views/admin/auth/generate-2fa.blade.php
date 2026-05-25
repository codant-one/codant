@extends('admin.layouts.public')

@section('content')
<style>
    .indicator-progress {
        display: none;
    }
</style>
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden pb-0 pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row justify-content-center g-0">
                            <div class="col-lg-6">
                                @include('admin.layouts.partials.sliders')
                            </div>
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div class="text-center"> {!! $qr !!} </div>
                                    <div class="text-muted text-center mx-lg-3">
                                        <h4 class="d-none d-md-block">Escanee el código QR</h4>
                                        <p>
                                            Configure su autenticación de dos factores escaneando el código QR a continuación.
                                            Alternativamente, puede usar el código <strong>{{ $token }}</strong><br>
                                            Debe configurar su aplicación de autenticación (Google Authenticator, Authy, etc.). De lo contrario, no podrá iniciar sesión.
                                        </p>
                                        <p>Escriba su código de seguridad de 6 dígitos</p>
                                    </div>
                                    <div class="mt-2 mt-md-4">
                                        <form action="{{ route('auth.2fa.validate') }}" method="POST" autocomplete="off" id="form_2fa_digits">
                                            @csrf
                                            <input type="hidden" name="route" id="hidden-route" value="auth.2fa.generate">
                                            <div class="row">
                                                @for ($i = 1; $i <= 6; $i++)
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="digit{{ $i }}-input" class="visually-hidden">Digit {{ $i }}</label>
                                                        <input type="text"
                                                            class="form-control form-control-lg bg-light border-light text-center digit-input"
                                                            onkeyup="moveToNext({{ $i }},event)" maxLength="1"
                                                            id="digit{{ $i }}-input" name="digit{{ $i }}">
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="token_2fa" id="token_2fa_hidden">
                                            <div class="mt-0 mt-md-3">
                                                <button type="submit" class="btn btn-success w-100" id="btn_2fa_confirm">
                                                    <span class="indicator-label">Confirmar</span>
                                                    <span class="indicator-progress">
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.partials.footer')
</div>
@endsection
@section('script')
@stack('scripts')
<script>
    function moveToNext(index, event) {
        const key = event.key;
        if (key === 'Backspace' && index > 1) {
            document.getElementById('digit' + (index - 1) + '-input').focus();
            return;
        }
        if (/^[0-9]$/.test(key) && index < 6) {
            document.getElementById('digit' + (index + 1) + '-input').focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar alerta de error si existe (session o errors)
        @if (session('register_error'))
            Swal.fire({
                html: `<div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>{!! session('register_error') !!}</h4>
                            <p class="text-muted mx-4 mb-0">
                                {!! session('text') !!}
                            </p>
                        </div>
                    </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                html: `<div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>Error de validación</h4>
                            <p class="text-muted mx-4 mb-0">{{ $errors->first() }}</p>
                        </div>
                    </div>`,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif

        // Configurar formulario
        const form = document.getElementById('form_2fa_digits');
        const btn = document.getElementById('btn_2fa_confirm');
        const indicatorLabel = btn.querySelector('.indicator-label');
        const indicatorProgress = btn.querySelector('.indicator-progress');
        const digitInputs = document.querySelectorAll('.digit-input');
        const tokenHidden = document.getElementById('token_2fa_hidden');
        
        // Limpiar inputs al cargar
        digitInputs.forEach(function(input) { input.value = ''; });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let code = '';
            let valid = true;
            
            digitInputs.forEach(function(input) {
                if (!input.value.match(/^[0-9]$/)) {
                    valid = false;
                }
                code += input.value;
            });
            
            if (!valid || code.length !== 6) {
                Swal.fire({
                    html: `<div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                            <div class="fs-15">
                                <h4>Algo ha ido mal</h4>
                                <p class="text-muted mx-4 mb-0">Por favor, ingresa los 6 dígitos correctamente.</p>
                            </div>
                        </div>`,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: 'btn btn-primary w-xs mb-1',
                    },
                    cancelButtonText: 'Entendido',
                    buttonsStyling: false,
                    showCloseButton: true
                });
                return false;
            }
            
            tokenHidden.value = code;
            indicatorLabel.style.display = 'none';
            indicatorProgress.style.display = 'inline-block';
            btn.disabled = true;
            
            setTimeout(function() {
                form.submit();
            }, 1000);
        });
    });
</script>
@endsection