<script>
    // Countries details list
    let countriesDetails = @json((isset($countriesDetails)) ? $countriesDetails : false);
    var auth = `{!! isset(auth()->user()->userDetail) ? addslashes(auth()->user()->userDetail) : 'false' !!}`;
    var userDetail = (auth !== 'false') ? JSON.parse(auth) : null;
    var country_id = (auth !== 'false' && userDetail.address !== null) ? userDetail.address.city.province.country.id : `{!! env("COUNTRY_ID") !!}`;
    var isManualAddressEdit = false; // Flag to track manual edits

    $(document).ready(function () {
        // Initialize Select2
        if (typeof $.fn.select2 !== 'undefined') {
            $('.countries').select2({
                width: '100%',
                placeholder: 'Seleccione'
            });
            $('.provinces').select2({
                width: '100%',
                placeholder: 'Seleccione'
            });
            $('.genders').select2({
                width: '100%',
                placeholder: 'Seleccione'
            });
            $('.cities').select2({
                width: '100%',
                placeholder: 'Seleccione'
            });
        }

        const form = document.getElementById('profileForm');
        if (!form) return;

        // Form submission with Bootstrap 5 validation
        const submitButton = document.getElementById('form_submit');
        if (submitButton) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Check Bootstrap 5 validation
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                        <h4>Algo ha ido mal</h4>
                                        <p class="text-muted mx-4 mb-0">
                                            Por favor, complete todos los campos requeridos correctamente.
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
                    }
                    return false;
                }

                // Validate phone manually - 1) not empty, 2) digits only, 3) exact length
                var phoneInput = $("#phone");
                var phoneValue = phoneInput.val().replace(/\D/g, '');
                var phoneMinLength = phoneInput.prop("minLength");
                var phoneRequired = phoneInput.prop("required");
                var errorMessage = '';
                
                // 1. Check if empty (when required)
                if (phoneRequired && !phoneValue) {
                    errorMessage = 'El teléfono es requerido';
                }
                // 2. Check if contains only digits
                else if (phoneValue && !/^\d+$/.test(phoneValue)) {
                    errorMessage = 'Debe introducir la longitud correcta para el número de teléfono';
                }
                // 3. Check exact length
                else if (phoneValue && phoneMinLength > 0 && phoneValue.length !== phoneMinLength) {
                    errorMessage = 'Debe introducir la longitud correcta para el número de teléfono';
                }

                if (errorMessage) {
                    form.classList.add('was-validated');
                    phoneInput[0].setCustomValidity(errorMessage);
                    phoneInput[0].reportValidity();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                        <h4>Algo ha ido mal</h4>
                                        <p class="text-muted mx-4 mb-0">
                                            Por favor, complete todos los campos requeridos correctamente.
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
                    }
                    return false;
                }
                
                // Clear any custom validity if validation passed
                phoneInput[0].setCustomValidity('');

                // Show loading
                const indicatorLabel = submitButton.querySelector('.indicator-label');
                const indicatorProgress = submitButton.querySelector('.indicator-progress');
                
                if (indicatorLabel) indicatorLabel.classList.add('d-none');
                if (indicatorProgress) indicatorProgress.classList.remove('d-none');
                submitButton.disabled = true;

                // Simulate processing
                setTimeout(function () {
                    if (indicatorLabel) indicatorLabel.classList.remove('d-none');
                    if (indicatorProgress) indicatorProgress.classList.add('d-none');
                    submitButton.disabled = false;

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                        <h4>¡Enhorabuena!</h4>
                                        <p class="text-muted mx-4 mb-0">
                                        ¡Los datos han sido guardados con éxito!
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
                        }).then(function (result) {
                            // Submit form when modal is dismissed (any way)
                            $('#country_id').prop('disabled', false);
                            form.submit();
                        });
                    } else {
                        $('#country_id').prop('disabled', false);
                        form.submit();
                    }
                }, 2000);
            });

            // Handle button click
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();
                form.dispatchEvent(new Event('submit'));
            });
        }

        // Load provinces and phone by country
        if ($('#loader').length) $('#loader').show();
        
        $.ajax({
            url: `{{ route("provinces.provincesByCountryId", ["id" => 'here']) }}`.replace('here', country_id),
            type: 'GET',                       
            success: function (response) {
                drawProvinces(response, 0);
                drawPhone(country_id);

                if (userDetail && userDetail.address) {
                    $.ajax({
                        url: `{{ route("cities.citiesByProvinceId", ["id" => 'here']) }}`.replace('here', userDetail.address.city.province.id),
                        type: 'GET',                       
                        success: function (data) {
                            drawCities(data, 0);
                            if ($('#loader').length) $('#loader').hide();
                        }
                    });

                    // If address exists in database, keep it and update map with it
                    // We don't need to trigger change here because initMap already handles the initial address
                    if ($('#loader').length) $('#loader').hide();
                } else {
                    // If no user address, initialize map with country
                    setTimeout(function () {
                        var countryName = $('#country_id option:selected').text().trim();
                        // Only set if empty to avoid overwriting if user already typed something
                        if (!$('#details-address').val()) {
                            $('#details-address').val(countryName).trigger('change');
                        }
                        if ($('#loader').length) $('#loader').hide();
                    }, 500);
                }
            },
            error: function() {
                if ($('#loader').length) $('#loader').hide();
            }
        });

        // Initialize Flatpickr for birthday
        if (typeof flatpickr !== 'undefined') {
            const birthdayInput = document.getElementById('birthday');
            if (birthdayInput) {
                flatpickr(birthdayInput, {
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    locale: "es"
                });
            }
        }

        // Update map on postal code change
        $('#postal_code').on('input', function() {
            const postalCode = $(this).val();
            const postalCodeInput = this;
            
            // Clear any validation messages
            $("#invalid-postal-code").text('');
            postalCodeInput.setCustomValidity('');
        });

        // Track manual edits to address field
        var addressInputTimeout;
        $('#details-address').on('input', function() {
            // Clear any pending timeout
            clearTimeout(addressInputTimeout);
            
            // Set flag after a small delay to avoid conflicts with map updates
            addressInputTimeout = setTimeout(function() {
                isManualAddressEdit = true;
            }, 200);
        });

        // Allow programmatic updates on change event
        $('#details-address').on('change', function() {
            // This will be triggered by .trigger('change') calls
            // but not by user typing
        });

        $('#postal_code').on('change', function() {
            const postalCode = $(this).val();
            
            // Clear validation messages
            $("#invalid-postal-code").text('');
            this.setCustomValidity('');
            
            // Check if this update comes from the map
            if (typeof isMapUpdate !== 'undefined' && isMapUpdate) {
                return;
            }
            
            // Update address if postal code changes (regardless of manual edit flag)
            if (postalCode && postalCode.trim() !== '') {
                var currentAddress = $('#details-address').val();
                var cityName = $('#city_id option:selected').text().trim();
                var countryName = $('#country_id option:selected').text().trim();
                
                // Only update if there's already a city selected and address doesn't already contain postal code
                if (cityName && cityName !== 'Seleccione' && cityName !== '' && (!currentAddress || !currentAddress.startsWith(postalCode))) {
                    var fullAddress = postalCode.trim() + ' ' + cityName + ', ' + countryName;
                    $('#details-address').val(fullAddress).trigger('change');
                }
            }
        });

        $('#city_id').on('change', function() {
            var city_id = this.value;
            
            // Check if this update comes from the map
            if (typeof isMapUpdate !== 'undefined' && isMapUpdate) {
                return;
            }
            
            // Update address if city changes (regardless of manual edit flag)
            if (city_id) {
                var existingAddress = $('#details-address').val();
                var cityName = $('#city_id option:selected').text().trim();
                var countryName = $('#country_id option:selected').text().trim();
                
                // If address is empty or generic, or if user wants to update map by changing city
                // We construct a new address. 
                // Note: This might overwrite custom text, but ensures map updates as requested.
                var address = cityName + ', ' + countryName;
                $('#details-address').val(address).trigger('change');
            }
        });

        $('#province_id').on('change', function() {
            var province_id = this.value;
            $("#city_id").html('<option value="">Seleccione</option>');
            $("#postal_code").val("");
            $("#invalid-postal-code").text('');
            document.getElementById('postal_code').setCustomValidity('');
            $("#details-address").val("");
            isManualAddressEdit = false; // Reset flag when province changes

            if (province_id != '') {
                if ($('#loader').length) $('#loader').show();
                $.ajax({
                    url: `{{ route("cities.citiesByProvinceId", ["id" => 'here']) }}`.replace('here', province_id),
                    type: 'GET',                       
                    success: function (data) {
                        drawCities(data, 0);
                        
                        // Update map to first city or province
                        var provinceName = $('#province_id option:selected').text().trim();
                        var countryName = $('#country_id option:selected').text().trim();
                        var address = provinceName + ', ' + countryName;
                        $('#details-address').val(address).trigger('change');
                        
                        if ($('#loader').length) $('#loader').hide();
                    },
                    error: function() {
                        if ($('#loader').length) $('#loader').hide();
                    }
                });
            }
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
            $("#invalid-postal-code").text('');
            document.getElementById('postal_code').setCustomValidity('');
            isManualAddressEdit = false; // Reset flag when country changes

            if (country_id != '') {
                if ($('#loader').length) $('#loader').show();
                $.ajax({
                    url: `{{ route("provinces.provincesByCountryId", ["id" => 'here']) }}`.replace('here', country_id),
                    type: 'GET',                       
                    success: function (data) {
                        drawProvinces(data, 0);
                        drawPhone(country_id);
                        
                        // Update map to country capital
                        var countryName = $('#country_id option:selected').text().trim();
                        $('#details-address').val(countryName).trigger('change');
                        
                        if ($('#loader').length) $('#loader').hide();
                    },
                    error: function() {
                        if ($('#loader').length) $('#loader').hide();
                    }
                });
            }
        });

        // Validate phone on input
        $('#phone').on('input', function() {
            var phoneInput = $(this);
            var phoneValue = phoneInput.val().replace(/\D/g, '');
            var phoneMinLength = phoneInput.prop("minLength");
            var phoneElement = phoneInput[0];
            var feedbackElement = phoneInput.closest('.input-group').find('.invalid-feedback');
            
            // If empty, use default required validation
            if (!phoneValue) {
                phoneElement.setCustomValidity('El teléfono es requerido');
                feedbackElement.text('El teléfono es requerido');
                phoneInput.addClass('is-invalid').removeClass('is-valid');
            }
            // Check exact length
            else if (phoneMinLength > 0 && phoneValue.length !== phoneMinLength) {
                var diff = phoneMinLength - phoneValue.length;
                var msg = 'Debe introducir la longitud correcta para el número de teléfono';
                phoneElement.setCustomValidity(msg);
                feedbackElement.text(msg);
                phoneInput.addClass('is-invalid').removeClass('is-valid');
            }
            // Valid
            else {
                phoneElement.setCustomValidity('');
                feedbackElement.text('');
                phoneInput.removeClass('is-invalid').addClass('is-valid');
            }
        });
    });

    function drawCities(data, city_id) {
        Object.keys(data).forEach(key => {
            var selected = (key == city_id) ? 'selected' : '';
            var html = `<option value="${key}" ${selected}>${data[key]}</option>`;
            $("#city_id").append(html);
        });
    }

    function drawProvinces(data, province_id) {
        Object.keys(data).forEach(key => {
            var selected = (key == province_id) ? 'selected' : '';
            var html = `<option value="${key}" ${selected}>${data[key]}</option>`;
            $("#province_id").append(html);
        });
    }

    function drawPhone(country_id) {
        var countriesPhoneCodes = @json($countriesPhoneCodes ?? []);
        var element = false;
        var countriesDetails = @json($countriesDetails ?? []);

        if (countriesDetails.length > 0) {
            element = countriesDetails.find(function(element) {
                return element.id == country_id;
            });

            if (element) {
                $("#phone").prop("minLength", 0);
                $("#phone").prop("maxLength", 0);
                $("#phone").prop("maxLength", element.phone_digits);
                $("#phone").prop("minLength", element.phone_digits);
                var phonePrefix = '+' + element.phonecode;
                $("#phonecode").html(phonePrefix);
                $("#phone").prop("readonly", false);

                if (userDetail !== null && userDetail.phone !== null)
                    $("#phone").val(userDetail.phone.replace(phonePrefix, ''));

                var mask = "";
                for (var i = 0; i < element.phone_digits; i++)
                    mask = mask + '9';

                if (typeof Inputmask !== 'undefined') {
                    Inputmask({
                        "mask": mask
                    }).mask("#phone");
                }
                
                // Update invalid-feedback message dynamically
                var phoneElement = document.getElementById('phone').text;
                var phoneFeedback = phoneElement ? phoneElement.closest('.input-group').querySelector('.invalid-feedback') : null;
                
                if (phoneFeedback) {
                    phoneFeedback.textContent = 'Debe introducir la longitud correcta para el número de teléfono';
                }
            }
        }
    }

    function editProfile() {
        const settingsTab = document.querySelector('[href="#settings"]');
        if (settingsTab) {
            var tab = new bootstrap.Tab(settingsTab);
            tab.show();
        }
    }
</script>