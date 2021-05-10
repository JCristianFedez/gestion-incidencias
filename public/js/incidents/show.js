const REFRESH_CHAT = 1000;
let oldChat;
let newChat;

$(function () {
    darEventos();
    oldChat = $("#chat-messages li").length;
});

/**
 * Especifico los eventos a los botones
 */
function darEventos() {
    $(".btn-action-js").off("click");
    $(".btn-action-js").on("click", ejecutarFuncionDelBoton);
    $("#btn-submit-message").on("click", enviarMensaje);

    setInterval(() => {
        $("#chat-messages").load(" #chat-messages");
    }, REFRESH_CHAT);
}

/**
 * Ejecuta la funcion de cada boton por ajax
 * @param {event} e 
 */
function ejecutarFuncionDelBoton(e) {
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
            $("#action-butons").load(" #action-butons", function () {
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

function enviarMensaje(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let form = $(this).closest("form");
    let message = form.find("#message").val();
    form.find("#message").val("");
    if (message.length <= 0) return;
    let url = form.attr("action");

    $.ajax({
        url: url,
        type: 'POST',
        data: { message: message },
        success: function success() {
            $("#chat-messages").load(" #chat-messages");
            
            $.toast({
                heading: 'Correcto',
                text: `Mensaje enviado correctamente`,
                showHideTransition: 'slide',
                icon: 'success',
                loader: true,
            });
        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: "Error al enviar mensaje",
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });
}