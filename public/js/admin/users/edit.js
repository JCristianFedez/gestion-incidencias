// Datatable configuration

$(function () {
    let user = $('#users-relation-table').data("userId");
    // Agrego la tabla
    let table = $('#users-relation-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: "http://gestion.incidencias/datatables/plugin-Spanish.json"
        },
        ajax: `/datatables/usuario/${user}/proyectos`,
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "projectsName", class: "projectsName" },
            { data: "levelsName" },
            { data: "created_at" },
            { data: "options" },
        ],
        columnDefs: [
            { orderable: false, targets: [3] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2],
            }
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
            // Limpio los eventos para que no se dupliquen
            $("#select-project").off("change");
            $("#select-project").on("change", onSelectProjectChange);

            $("[data-relation]").off("click");
            $("[data-relation]").on("click", editRealtionModal);
            
            $("#users-relation-table").off('click', '.delete-user-project'); 
            $("#users-relation-table").on('click', '.delete-user-project', function (e) {
                e.preventDefault();
                loadEventsDeleteUserProject(this);
            });

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
        },
    });
});

/**
 *  Load the levels of the selected project into the select of levels
 */
function onSelectProjectChange() {
    let project_id = $(this).val();
    let select_level = $("#select-level");
    let html_select = "<option value=''>Seleccione nivel</option>";

    if (!project_id) {
        select_level.html(html_select);
        return;
    }

    // AJAX
    $.get(`/api/proyecto/${project_id}/niveles`, function (data) {

        for (let i = 0; i < data.length; i++) {
            html_select += "<option value='" + data[i].id + "' >" + data[i].name + "</option>"
        }
        select_level.html(html_select);
    });
}

/**
 * Setting the modal to edit the relationship
 */
function editRealtionModal() {
    let project_id = $(this).data("project-id");
    let project_name = $(this).parent().parent().parent().find(".projectsName").text();
    console.log(project_name);
    let level_id = $(this).data("level-id");
    let title = $("#EditProjectRelationModalLabel");
    let select_level = $("#select_level_relation");
    let html_select = "";
    $("#project_id_relation").val(project_id);
    $("#project_user_id_relation").val($(this).val());
    console.log($("#project_user_id_relation").val());
    title.text(`Editar Relacion con ${project_name}`);

    $("#project_id").val(project_id);

    // AJAX
    $.get(`/api/proyecto/${project_id}/niveles`, function (data) {

        for (let i = 0; i < data.length; i++) {
            if (data[i].id == level_id) {
                html_select += "<option selected value='" + data[i].id + "' >" + data[i].name + "</option>"
            } else {
                html_select += "<option value='" + data[i].id + "' >" + data[i].name + "</option>"
            }
        }
        select_level.html(html_select);
    });
}


/**
 * Eliminar usuario
 */
 function loadEventsDeleteUserProject(theElement) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // Recojo Url
    let url = $(theElement).parent().attr("action");
    url = url.split("gestion.incidencias")[1];
    
    Swal.fire({
        title: 'Atencion !',
        text: `¿ Esta seguro de eliminar la relacion ?`,
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
                        'Eliminada!',
                        'Relacion eliminada correctamente.',
                        'success');
                    $('#users-relation-table').DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la eliminacion",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}