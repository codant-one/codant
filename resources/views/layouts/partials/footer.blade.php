<div class="row g-0 footer p-10 py-md-10 px-md-15 align-items-center">
    <div class="col-md-4 d-none d-md-block mb-3" class="img-footer">
        <img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="Codant-logo">
    </div>
    <div class="col-md-4 d-block d-md-none text-center mb-3" class="img-footer">
        <img width="78px" src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="Codant-logo">
    </div>
    <div class="col-md-8">
        <p class="text-footer">
            © {{ date('Y') }} Codant All Rights Reserved.
        </p>
    </div>
</div>
