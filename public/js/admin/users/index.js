let filtroActivo = "";

// Paginacion
$(document).on("click", "#paginacionUsuarios .pagination a", function (e) {
    e.preventDefault();

    let params = {
        url: "/usuarios",
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#allUsersTable").html(result);
        }
    };

    switch (filtroActivo) {
        case "email":
            params.data = { page: $(this).attr("href").split("page=")[1], email: $("#emailFilter").val() };
            break;
        case "name":
            params.data = { page: $(this).attr("href").split("page=")[1], name: $("#nameFilter").val() };
            break;
        case "rol":
            params.data = { page: $(this).attr("href").split("page=")[1], rol: $("#rolFilter").val() };
            break;
        default:
            params.data = { page: $(this).attr("href").split("page=")[1] };
            break;
    }

    $.ajax(params);

});

// Para filtrar por email
$(document).on("click", "#btn-filtro-email", filtrarPorEmail);
$(document).on("keydown", "#emailFilter", filtrarPorEmail);

function filtrarPorEmail(e) {
    if (e.type == "keydown" && e.which != 13) return;

    filtroActivo = "email";

    $.ajax({
        url: "/usuarios",
        data: { email: $("#emailFilter").val() },
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#allUsersTable").html(result);
            $("#dropdownEmail").dropdown('toggle'); // Cerrar dropdawn
        }
    });


}

// Para filtrar por nombre
$(document).on("click", "#btn-filtro-nombre", filtrarPorNombre);
$(document).on("keydown", "#nameFilter", filtrarPorNombre);

function filtrarPorNombre (e) {
    if (e.type == "keydown" && ((e.keyCode || e.which) != 13)) return;


    filtroActivo = "name";
    $.ajax({
        url: "/usuarios",
        data: { name: $("#nameFilter").val() },
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#allUsersTable").html(result);
            $("#dropdownNombre").dropdown('toggle'); // Cerrar dropdawn
        }
    });

}

// Para filtrar por rol
$(document).on("click", "#btn-filtro-rol", function (e) {
    filtroActivo = "rol";

    $.ajax({
        url: "/usuarios",
        data: { rol: $("#rolFilter").val() },
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#allUsersTable").html(result);
            $("#dropdownRol").dropdown('toggle'); // Cerrar dropdawn
        }
    });

});

// Para remover el filtro
$(document).on("click", "#removeFilter", function (e) {
    filtroActivo = "";
    $.ajax({
        url: "/usuarios",
        data: null,
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#allUsersTable").html(result);
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