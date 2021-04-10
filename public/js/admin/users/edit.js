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
            $("#select-project").on("change", onSelectProjectChange);
            $("[data-relation]").on("click", editRealtionModal);
            
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

