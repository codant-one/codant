@props([
    'avatar' => auth()->user()->avatar,
    'updateRoute' => 'updateAvatar',
    'size' => 'avatar-xl',
    'inputId' => 'profile-img-file-input'
])

<div class="profile-user position-relative d-inline-block mx-auto mb-4">
    <img id="img-{{ $inputId }}" 
        src="@if(is_null($avatar)){{ URL::asset('build/images/users/avatar-1.jpg') }}@else{{ asset('storage/'.$avatar) }}@endif"
        class="rounded-circle {{ $size }} img-thumbnail user-profile-image"
        alt="user-profile-image">
    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
        <input id="{{ $inputId }}" type="file" class="profile-img-file-input" accept="image/*">
        <label for="{{ $inputId }}" class="profile-photo-edit avatar-xs">
            <span class="avatar-title rounded-circle bg-light text-body">
                <i class="ri-camera-fill"></i>
            </span>
        </label>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('{{ $inputId }}').addEventListener('change', function(e) {
        $('#loader').show();
        const file = e.target.files[0];
        if (!file) return;

        // Validar que sea una imagen
        if (!file.type.match('image.*')) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                <div class="fs-15">
                                <h4>Error</h4>
                                <p class="text-muted mx-4 mb-0">
                                    Por favor selecciona un archivo de imagen válido
                                </p>
                            </div>
                    `,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: 'btn btn-primary w-xs mb-1',
                    },
                    cancelButtonText: 'Entendido',
                    buttonsStyling: false,
                    showCloseButton: true
                });
            } else {
                alert('Por favor selecciona un archivo de imagen válido');
            }
            return;
        }

        // Mostrar preview inmediatamente usando FileReader
        const reader = new FileReader();
        const imgElement = document.getElementById('img-{{ $inputId }}');
        
        reader.onload = function(event) {
            // Actualizar la imagen visualmente de inmediato
            imgElement.src = event.target.result;
        };
        
        reader.readAsDataURL(file);

        // Crear FormData
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', '{{ csrf_token() }}');

        // Enviar petición
        fetch('{{ route($updateRoute) }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error en la respuesta del servidor');
        })
        .then(data => {
            if (data === 'success') {
                if (typeof Swal !== 'undefined') {
                     Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>¡Enhorabuena!</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        Avatar actualizado correctamente
                                    </p>
                                </div>
                        `,
                        showCancelButton: true,
                        showConfirmButton: false,
                        customClass: {
                            cancelButton: 'btn btn-primary w-xs mb-1',
                        },
                        cancelButtonText: 'Entendido',
                        buttonsStyling: false,
                        showCloseButton: true
                    });

                    Livewire.dispatch('resetNavbar');
                    $('#loader').hide();
                } else {
                    location.reload();
                }
            } else {
                // Revertir la imagen si falla
                imgElement.src = "{{ is_null($avatar) ? URL::asset('build/images/users/avatar-1.jpg') : asset('storage/'.$avatar) }}";
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Error</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        No se pudo actualizar el avatar
                                    </p>
                                </div>
                        `,
                        showCancelButton: true,
                        showConfirmButton: false,
                        customClass: {
                            cancelButton: 'btn btn-primary w-xs mb-1',
                        },
                        cancelButtonText: 'Entendido',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                } else {
                    alert('Error: ' + (data.message || 'No se pudo actualizar el avatar'));
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revertir la imagen si falla
            imgElement.src = "{{ is_null($avatar) ? URL::asset('build/images/users/avatar-1.jpg') : asset('storage/'.$avatar) }}";
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                <div class="fs-15">
                                <h4>Error</h4>
                                <p class="text-muted mx-4 mb-0">
                                    Ocurrió un error al actualizar el avatar
                                </p>
                            </div>
                    `,
                    showCancelButton: true,
                    showConfirmButton: false,
                    customClass: {
                        cancelButton: 'btn btn-primary w-xs mb-1',
                    },
                    cancelButtonText: 'Entendido',
                    buttonsStyling: false,
                    showCloseButton: true
                });
            } else {
                alert('Ocurrió un error al actualizar el avatar');
            }
        });
    });
</script>
@endpush
