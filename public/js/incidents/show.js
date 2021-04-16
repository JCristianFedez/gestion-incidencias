$(function() {
    darEventos();    
});

/**
 * Especifico los eventos a los botones
 */
function darEventos(){
    $(".btn-action-js").off("click",ejecutarFuncionDelBoton);
    $(".btn-action-js").on("click",ejecutarFuncionDelBoton);
}

/**
 * Ejecuta la funcion de cada boton por ajax
 * @param {event} e 
 */
function ejecutarFuncionDelBoton(e){
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Recojo Url
    let url = $(this).attr("href");
    let successMessage = $(this).data("success-message");
    let errorMessage = $(this).data("error-message");

    $.ajax({
        url: url,
        type: 'GET',
        data: { '_method': 'GET' },
        success: function success(data) {
            console.log(data.head);
            $.toast({
                heading: data.head,
                text: data.message,
                showHideTransition: 'slide',
                icon: data.type,
                loader: true,
            });
            $("#action-butons").load(" #action-butons", function(){
                darEventos();
            });
            $("#tabla-incidencia").load(" #tabla-incidencia");
            $("#tabla-incidencia2").load(" #tabla-incidencia2");
        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: errorMessage,
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });
}