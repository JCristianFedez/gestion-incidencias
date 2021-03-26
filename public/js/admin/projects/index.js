
// Paginacion
$(document).on("click", "#paginacionProyectos .pagination a", function (e) {
    e.preventDefault();
    $.ajax({
        url: "/proyectos",
        data: { page: $(this).attr("href").split("page=")[1]},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allProjectsTable").html(result);
        }
    });

});

// Para filtrar por nombre
$(document).on("click", "#btn-filtro-nombre", function (e) {

    $.ajax({
        url: "/proyectos",
        data: { scope: $("#nameFilter").val()},
        type: "GET",
        dataType: "json",
        success: function(result){
            $("#allProjectsTable").html(result);
        }
    });

});