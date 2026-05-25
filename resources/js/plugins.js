/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Version: 4.3.0
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Common Plugins Js File
*/

//Common plugins
if (document.querySelectorAll("[toast-list]") || document.querySelectorAll('[data-choices]') || document.querySelectorAll("[data-provider]")) {
    // Función para cargar scripts dinámicamente
    function loadScript(src) {
        return new Promise(function(resolve, reject) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = src;
            script.onload = function() { resolve(); };
            script.onerror = function() { reject(new Error('Failed to load script: ' + src)); };
            document.head.appendChild(script);
        });
    }

    // Cargar scripts necesarios
    if (document.querySelectorAll("[toast-list]").length > 0) {
        loadScript('https://cdn.jsdelivr.net/npm/toastify-js');
    }
    if (document.querySelectorAll('[data-choices]').length > 0) {
        loadScript('/build/libs/choices.js/public/assets/scripts/choices.min.js');
    }
    if (document.querySelectorAll("[data-provider]").length > 0) {
        loadScript('/build/libs/flatpickr/flatpickr.min.js');
    }
}
