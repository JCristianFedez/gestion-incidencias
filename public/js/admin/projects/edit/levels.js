
////////////// START LEVELS TABLE ///////////////////////
$(function () {
    let project = $('#levels-table').data("projectId");
    let host = $(location).attr('host');

    // Agrego la tabla
    let table = $('#levels-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: `/datatables/proyecto/${project}/niveles`,
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p >>",
        columns: [
            { data: "difficulty" },
            { data: "name" },
            { data: "created_at" },
            { data: "options" }
        ],
        columnDefs: [
            { orderable: false, targets: [3] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2],
            },
        ],
        buttons: [
            {
                text: 'Paneles de búsqueda',
                className: 'spToggle showPanes',
                action: function (e, dt, node, config) {
                    dt.searchPanes.container().find('.dtsp-searchPanes').slideToggle(200, function () {
                        $('.spToggle').toggleClass('showPanes', $(this).is(':visible'));
                    });
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {

            $("#levels-table").off("click", "[data-level-id]");
            $("#levels-table").on("click", "[data-level-id]", function (e) {
                editLevelModal(this);
            });

            $("body").off("submit", "#modalEditLevel");
            $("body").on("submit", "#modalEditLevel", function (e) {
                e.preventDefault();
                editLevel(this);
            });

            $("#levels-table").off('click', '.delete-level'); // Limpio los eventos para que no se dupliquen
            $("#levels-table").on('click', '.delete-level', function (e) {
                e.preventDefault();
                deleteLevel(this);
            });

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda

            // Cargo los tooltips secundarios
            $('[data-toggle-second="tooltip"]').tooltip();

        },
    });

    // Cargo los tooltips secundarios cuando la tabla se hace responsive
    table.on('responsive-display', function (e, datatable, row, showHide, update) {
        $('[data-toggle-second="tooltip"]').tooltip();
    });


});

/**
 * Cargar los datos del nivel en el modal 
 */
function editLevelModal(theElement) {
    let level_id = $(theElement).data("levelId");
    let level_name = $(theElement).data("levelName");
    let levelDifficulty = $(theElement).data("levelDifficulty");

    $("#modalEditLevel #level_id").val(level_id);
    $("#modalEditLevel #level_name").val(level_name);
    $("#modalEditLevel #level_difficulty").val(levelDifficulty);
    $("#modalEditLevel").data("levelName", level_name);
}

/**
 * Editar nivel
 */
function editLevel(theElement) {
    $("#modalEditLevel").modal('hide');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Recojo Url
    let url = $(theElement).find("form").attr("action");
    url = url.split($(location).attr('host'))[1];

    // Recojo nombre
    let newName = $("#modalEditLevel #level_name").val();
    let newDifficulty = $("#modalEditLevel #level_difficulty").val();
    let levelId = $("#modalEditLevel #level_id").val();

    $.ajax({
        url: url,
        type: 'POST',
        data: { '_method': 'PUT', 'level_id': levelId, 'name': newName, 'difficulty': newDifficulty },
        success: function success(data) {
            $.toast({
                heading: data.head,
                text: data.message,
                showHideTransition: 'slide',
                icon: data.type,
                loader: true,
            });
            if (data.type != "error") {
                $('#levels-table').DataTable().ajax.reload(null, false);
            }
        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: "Error al editar nivel",
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });
}

/**
 * Eliminar nivel
 */
function deleteLevel(theElement) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Recojo Url
    let url = $(theElement).parent().attr("action");
    url = url.split($(location).attr('host'))[1];

    // Recojo nombre
    let form = $(theElement).parent();
    let name = form.data("levelName");

    let cantLevls = $("#level-difficulty").val();

    Swal.fire({
        title: '¡Atencion!',
        text: `¿Esta seguro de eliminar el nivel ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: { '_method': 'DELETE' },
                success: function success() {
                    Swal.fire(
                        '¡Eliminada!',
                        'Nivel eliminado.',
                        'success');
                    $('#levels-table').DataTable().ajax.reload(null, false);

                    // Update max value and auto-value
                    $("#level-difficulty").val(cantLevls - 1);
                    $("#level-difficulty").attr({
                        "max": cantLevls - 1,
                    });
                    $("#level_difficulty").attr({
                        "max": cantLevls - 2,
                    });
                },
                error: function error() {
                    Swal.fire({
                        title: '¡Error!',
                        text: "Ha ocurrido un error en la eliminacion.",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}
////////////// END LEVELS TABLE ///////////////////////

