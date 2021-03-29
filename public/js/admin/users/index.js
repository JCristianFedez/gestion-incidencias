let campo = "";
let valor = "";
let campoOrdenar = "";
let orden = "";

// Paginacion
$(document).on("click", "#paginacionUsuarios .pagination a", function (e) {
    e.preventDefault();

    params = {
        url: "/usuarios",
        type: "GET",
        dataType: "json",
        data: { 
            page: $(this).attr("href").split("page=")[1], 
            campo: campo, 
            valor: valor, 
            campoOrdenar: campoOrdenar, 
            orden: orden },
        success: function (result) {
            $("#all-users-table").html(result);
        }
    };

    $.ajax(params);

});

// Para filtrar por campos
$(document).on("click", ".btn-filter", filtrarPorCampo);
$(document).on("keydown", ".form-filter", filtrarPorCampo);

function filtrarPorCampo(e) {
    if (e.type == "keydown" && e.which != 13) return;

    campo = $(this).data("campo");
    valor = $(`#${campo}-filter`).val();

    filtroActivo = campo;

    $.ajax({
        url: "/usuarios",
        data: { campo: campo, valor: valor, orden: null },
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#all-users-table").html(result);
            $(`#dropdown-${campo}`).dropdown('toggle'); // Cerrar dropdawn
        }
    });

}

// Para remover el filtro
$(document).on("click", "#remove-filter", function (e) {

    campo = "";
    valor = "";
    campoOrdenar = "";
    orden = "";

    $.ajax({
        url: "/usuarios",
        data: null,
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#all-users-table").html(result);
            $(".tooltip").tooltip("hide"); // Sirve para ocultar el tooltip una vez borrado el filtro
            emptyFilter();
        }
    });

});


// Para valciar el valor de los filtros
function emptyFilter() {
    $('#filtros-usuarios input[type=text]').each(function () {
        $(this).val("");
    });
}


////////// ORDER BY

$(document).on("click", ".order-data", function (e) {

    orden = $(this).data("orden");
    campoOrdenar = $(this).data("campo");

    console.log(orden);
    console.log(campo);

    $.ajax({
        url: "/usuarios",
        data: { campo: campo, valor: valor, campoOrdenar: campoOrdenar, orden: orden },
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#all-users-table").html(result);
        }
    });
});