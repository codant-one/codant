var BootstrapModalActions = (function(){
    return {
        init: function () {
            document.querySelector(".form-modal-dismiss") ?
                document.querySelectorAll(".form-modal-dismiss").forEach(function(item){
                    item.addEventListener("click", function (e) {
                        e.preventDefault(),
                        Swal.fire({
                            text: "¿Está seguro de descartar el formulario?",
                            imageUrl: "/img/icon_warning.png",
                            imageAlt: "Maintenance",
                            focusConfirm: false,
                            focusCancel: false,
                            showCloseButton: true,
                            confirmButtonText: "¡Entendido!",
                            closeButtonHtml: `<img src="/svg/close-circle-gray.svg" alt="close" style="transform: scale(0.7);">`,
                            customClass: { 
                                image: 'mt-10 mb-0 mx-auto w-25',
                                confirmButton: "btn btn-standar", 
                                closeButton: 'custom-swal-close-button'
                            },
                        }).then(function (t) {
                            if(t.value){
                               
                                if ($(".form-modal-dismiss").hasClass('dismiss-create'))
                                    window.location.href = window.location.href.replace('create', '');
                                else
                                    document.querySelector('.modal.show [data-bs-dismiss]').click()
                            }
                                
                        });
                    });
                })
            : null
        }
    }
})();


$(document).ready(function () {
    BootstrapModalActions.init();
});

function modalShow(id, route){
    var myModalEl = document.querySelector(id);
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

    //Update the Form Action attribute.
    $(id).find("form").attr('action', route);
    //Open the Modal.
    modal.show();
}