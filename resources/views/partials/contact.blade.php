<div class="row g-0 sections-form" id="contact">
    <div class="row row-form">
        <h3>Escríbenos un mensaje</h3>
        <p>Queremos saber de qué va tu proyecto y en que te podemos ayudar</p>

        <form class="mt-10" action="{{route('main.store')}}" method="POST">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label>Nombre</label>
                    <input type="text" class="form-control input-form" name="name" required>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label>Correo Electrónico</label>
                    <input type="email" class="form-control input-form" name="email" required>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    @php $locale = session()->get('locale'); @endphp
                    <label>Que servicio deseas</label>
                    <select class="form-select input-form servicesSelect"
                        name="service_id"
                        id="service_id"
                        data-control="select2"
                        required>
                        <option value="0">Seleccione</option>
                        @foreach ($services as $key => $service)
                            <option value="{{ $service->id }}">
                                @if($locale === 'es')
                                    {{ $service->es }}
                                @else
                                    {{ $service->en }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mb-3 mb-md-0 mt-md-8">
                <label>Cuéntanos que proyecto tienes en mente</label>
                <textarea class="form-control input-form" name="description" rows="5"></textarea>
            </div>

            @csrf
            <button type="submit" class="btn btn-secondary button-form">Enviar</button>
        </form>
    </div>
</div>