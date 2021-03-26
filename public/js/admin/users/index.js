
// Paginacion
$(document).on("click", "#paginacionUsuarios .pagination a", function (e) {
    e.preventDefault();
    $.ajax({
        url: "/usuarios",
        data: { page: $(this).attr("href").split("page=")[1]},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allUsersTable").html(result);
        }
    });

});

// Para filtrar por email
$(document).on("click", "#btn-filtro-email", function (e) {

    $.ajax({
        url: "/usuarios",
        data: { scope: $("#emailFilter").val()},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allUsersTable").html(result);
            $("#dropdownEmail").dropdown('toggle'); // Cerrar dropdown una vez echa la peticion
        }
    });

});

// Para filtrar por nombre
$(document).on("click", "#btn-filtro-nombre", function (e) {

    $.ajax({
        url: "/usuarios",
        data: { scope: $("#nameFilter").val()},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allUsersTable").html(result);
            $("#dropdownNombre").dropdown('toggle'); // Cerrar dropdown una vez echa la peticion
        }
    });

});

// Para remover el filtro
$(document).on("click", "#removeFilter", function (e) {

    $.ajax({
        url: "/usuarios",
        data: { scope: null},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allUsersTable").html(result);
            $(".tooltip").tooltip("hide"); // Sirve para ocultar el tooltip una vez borrado el filtro
        }
    });

});