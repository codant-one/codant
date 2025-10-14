<script>
    //Detalles del listado de paises.
    let countriesDetails = @json( (isset($countriesDetails)) ? $countriesDetails : false);
    var auth = `{!! isset(auth()->user()->userDetail) ? addslashes(auth()->user()->userDetail) : 'false' !!}`;
    var userDetail = (auth !== 'false') ? JSON.parse(auth) : null;
    var country_id = (auth !== 'false' && userDetail.address !== null) ? userDetail.address.city.province.country.id : null;
    validator = null;

    $(document).ready(function () {
        $("#phone").numeric();
        $('.countries').select2();
        $('.provinces').select2();
        $('.genders').select2();
        $('.cities').select2();

        const form = document.getElementById('profileForm');

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'firstname': {
                        validators: {
                            notEmpty: {
                                message: 'El primer nombre es requerido'
                            }
                        }
                    },
                    'lastname': {
                        validators: {
                            notEmpty: {
                                message: 'El primer apellido es requerido'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'El correo electrónico es requerido'
                            }
                        }
                    },
                    'birthday': {
                        validators: {
                            notEmpty: {
                                message: 'La fecha de nacimiento es requerida'
                            }
                        }
                    },
                    'document': {
                        validators: {
                            notEmpty: {
                                message: 'El documento es requerido'
                            }
                        }
                    },
                    'country_id': {
                        validators: {
                            notEmpty: {
                                message: 'El país es requerido'
                            }
                        }
                    },
                    'gender_id': {
                        validators: {
                            notEmpty: {
                                message: 'El género es requerido'
                            }
                        }
                    },
                    'province_id': {
                        validators: {
                            notEmpty: {
                                message: 'El estado es requerido'
                            }
                        }
                    },
                    'city_id': {
                        validators: {
                            notEmpty: {
                                message: 'La ciudad es requerida'
                            }
                        }
                    },
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'El teléfono es requerido'
                            }
                        }
                    },
                    'details-address': {
                        validators: {
                            notEmpty: {
                                message: 'La dirección es requerida'
                            }
                        }
                    },
                    'postal_code': {
                        validators: {
                            notEmpty: {
                                message: 'El código postal es requerido'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        const submitButton = document.getElementById('form_submit');
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        setTimeout(function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                            Swal.fire({
                                title: '¡Enhorabuena!',
                                html: `
                                        <div class="d-flex flex-column">
                                            <span class="swal2-subtitle-success">¡Los datos han sido guardados con éxito!</span>
                                        </div>
                                `,
                                confirmButtonText: "¡Entendido!",
                                focusConfirm: false,
                                focusCancel: false,
                                showCloseButton: true,
                                imageUrl: "{{ asset('img/icon_success_2.png') }}",
                                imageAlt: "Profile",
                                closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                customClass: {
                                    image: 'mt-10 mb-0 mx-auto w-25',
                                    confirmButton: "btn btn-standar",
                                    closeButton: 'custom-swal-close-button',
                                    htmlContainer: 'swal2-html-container', 
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    $('#country_id').prop('disabled', false);
                                    form.submit();
                                }
                            });
                            
                        }, 2000);
                    } else {
                        Swal.fire({
							title: 'Algo ha ido mal',
							html: `
								<div class="d-flex flex-column">
									<span class="swal2-subtitle-error">Lo sentimos, algunos datos son errados. </span>
									<span class="swal2-html-container d-flex mt-0 align-center">
										<img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
										<span class="ms-2">Revise la información e intente de nuevo.</span>
									</span>
								</div>
							`,
							confirmButtonText: "Entendido",
							focusConfirm: false,
							focusCancel: false,
							showCloseButton: true,
							imageUrl: "{{ asset('img/icon_error.png') }}",
							imageAlt: "Error",
							closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
							customClass: {
								image: 'mt-10 mb-0 mx-auto w-25',
								confirmButton: "btn btn-standar",
								closeButton: 'custom-swal-close-button',
								htmlContainer: 'swal2-html-container', 
							}
						})
                    }
                });
            }
        });

        if(country_id) {
            $('#loader').show()
            $.ajax({
                url: `{{ route("provinces.provincesByCountryId", ["id" => 'here']) }}`.replace('here', country_id),
                type: 'GET',                       
                success: function (response) {
                    drawProvinces(response, 0);
                    drawPhone(country_id);

                    if(userDetail) {

                        $.ajax({
                            url: `{{ route("cities.citiesByProvinceId", ["id" => 'here']) }}`.replace('here', userDetail.address.city.province.id),
                            type: 'GET',                       
                            success: function (data) {
                                drawCities(data, 0);
                                $('#loader').hide();
                            }
                        });

                        $('#details-address').val(userDetail.address.address).trigger('change');

                        setTimeout(function () {
                            $('#details-address').val(userDetail.address.address);
                            $('#postal_code').val(userDetail.address.postal_code);
                            validator.revalidateField('postal_code');  
                            $('#loader').hide()         
                        }, 1000);
                    
                    }
                }
            });
        }

        $("#birthday").daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            maxDate: moment().format("YYYY-MM-DD"),
            maxYear: moment().format('YYYY'),
            locale: {
                daysOfWeek: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_'),
                monthNames: 'Ene._Feb._Mar._Abr._May._Jun._Jul._Ago._Sept._Oct._Nov._Dic.'.split('_'),
                format: 'YYYY-MM-DD'
            },
        });

        $('input[name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            validator.revalidateField('birthday');
        });   

        $('#gender_id').on('change', function() {
            validator.revalidateField('gender_id');
        });

        $('#postal_code').on('change', function() {
            validator.revalidateField('postal_code');
        });

        $('#city_id').on('change', function() {
            var city_id = this.value;
            var address = $('#city_id option:selected').text() + ', ' + $('#country_id option:selected').text()

            $('#details-address').val(address).trigger('change');

            validator.revalidateField('city_id');
        });

        $('#province_id').on('change', function() {
            var province_id = this.value;
            $("#city_id").html('<option value="">Seleccione</option>');
            $("#postal_code").val("");

            if(province_id != ''){
                $('#loader').show();
                $.ajax({
                    url: `{{ route("cities.citiesByProvinceId", ["id" => 'here']) }}`.replace('here', province_id),
                    type: 'GET',                       
                    success: function (data) {
                        drawCities(data, 0);
                        $('#loader').hide();
                    }
                });
            }

            validator.revalidateField('province_id');
            validator.revalidateField('postal_code');
        });

        $('#country_id').on('change', function() {
            var country_id = this.value;
            $("#province_id").html('<option value="">Seleccione</option>');
            $("#city_id").html('<option value="">Seleccione</option>');
            $("#phone").val("");
            $("#phonecode").html("");
            $("#phone").prop("readonly", true);
            $("#details-address").val("");
            $("#postal_code").val("");

            if(country_id != '') {
                $('#loader').show();
                $.ajax({
                    url: `{{ route("provinces.provincesByCountryId", ["id" => 'here']) }}`.replace('here', country_id),
                    type: 'GET',                       
                    success: function (data) {
                        drawProvinces(data, 0);
                        drawPhone(country_id);
                        $('#loader').hide();
                    }
                });
            }

            validator.revalidateField('country_id');
        });
    });  

    function drawCities(data, city_id){
        Object.keys(data).forEach (key => {
            var selected = (key == city_id) ? 'selected' : '';
            var html = `<option value="${key}" ${selected}>${data[key]}</option>`;
            $("#city_id").append(html);
        });

        validator.revalidateField('city_id');
    }

    function drawProvinces(data, province_id){
        Object.keys(data).forEach (key => {
            var selected = (key == province_id) ? 'selected' : '';
            var html = `<option value="${key}" ${selected}>${data[key]}</option>`;
            $("#province_id").append(html);
        });

        validator.revalidateField('province_id');
        validator.revalidateField('city_id');
    }

    function drawPhone(country_id) {
        var countriesPhoneCodes = @json($countriesPhoneCodes);
        var element = false;
        var countriesDetails = @json($countriesDetails);

        if (countriesDetails.length > 0){
            element = countriesDetails.find(function(element) {
                return element.id == country_id;
            });

            if (element){
                $("#phone").prop("minLength", 0);
                $("#phone").prop("maxLength", 0);
                $("#phone").prop("maxLength", element.phone_digits);
                $("#phone").prop("minLength", element.phone_digits);
                var phonePrefix = '+' + element.phonecode;
                $("#phonecode").html(phonePrefix);
                $("#phone").prop("readonly", false);

                if(userDetail !== null && userDetail.phone !== null)
                    $("#phone").val(userDetail.phone.replace(phonePrefix, ''));

                var mask = ""

                for(var i = 0; i < element.phone_digits; i++)
                    mask = mask + '9'

                Inputmask({
                    "mask" : mask
                }).mask("#phone");   
                

                if (validator.getFields().phone !== undefined)
                    validator.removeField('phone');
                
                validator.addField(
                    'phone', 
                    {
                        validators: {
                            stringLength: {
                                min: element.phone_digits,
                                max: element.phone_digits,
                                message: 'Debe introducir la longitud correcta para el número de teléfono'
                            },
                            digits: {
                                message: 'Debe introducir la longitud correcta para el número de teléfono'
                            },
                            notEmpty: {
                                message: 'El teléfono es requerido'
                            }
                        }
                    }
                );
            }
        }
    }

    function editProfile(){
        $('#settingsTab')[0].click();
    }

</script>