
/////////////////// TABLA - Incidencias asignadas para mi
$(function () {
    let host = $(location).attr('host');

    // Agrego la tabla
    let table = $('#incidencias-asignadas-a-mi').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: "datatables/dashboard/incidentsByMe",
        dom:
            "<'row'<'col-lg-6'l><'col-lg-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "id" },
            { data: "category" },
            { data: "severity" },
            { data: "status" },
            { data: "created_at" },
            { data: "title" },
            { data: "options" },
        ],
        columnDefs: [
            { orderable: false, targets: [6] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2, 3, 4, 5],
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
                    columns: [0, 1, 2, 3, 4, 5]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {
            $("#incidencias-asignadas-a-mi").off('click', '.disatend-incident'); // Limpio los eventos para que no se dupliquen
            $("#incidencias-asignadas-a-mi").on('click', '.disatend-incident', function (e) {
                e.preventDefault();
                loadEventsDistakeIncident(this);
            });

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
        },
    });

});

/**
 * Desatender incidencia
 */
 function loadEventsDistakeIncident(theElement) {
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
    let name = $("[data-incident-name]", form).val();

    $.ajax({
        url: url,
        type: 'GET',
        data: { '_method': 'GET' },
        success: function success() {
            $.toast({
                heading: 'Correcto',
                text: `Ya no estas atendiendo ${name}`,
                showHideTransition: 'slide',
                icon: 'success',
                loader: true,
            });
            $('#incidencias-asignadas-a-mi').DataTable().ajax.reload(null, false);
            $('#incidencias-sin-asignar').DataTable().ajax.reload(null, false);
            $('#mis-incidencias').DataTable().ajax.reload(null, false);

        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: `Ha ocurrido un error al desatender la incidencia ${name}`,
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });

}



//////////////////// TABLA - Mis incidencias
$(function () {
    let host = $(location).attr('host');

    // Agrego la tabla
    let table = $('#mis-incidencias').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: "datatables/dashboard/myIncidents",
        dom:
            "<'row'<'col-lg-6'l><'col-lg-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "id" },
            { data: "category" },
            { data: "severity" },
            { data: "status" },
            { data: "created_at" },
            { data: "title" },
            { data: "supportName" },
            { data: "options" },
        ],
        columnDefs: [
            { orderable: false, targets: [6] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2, 3, 4, 5],
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
                    columns: [0, 1, 2, 3, 4, 5]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
        },
    });


});



//////////////////// TABLA - Incidencias sin asignar
$(function () {
    let host = $(location).attr('host');

    // Agrego la tabla
    let table = $('#incidencias-sin-asignar').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: "datatables/dashboard/pendingIncidents",
        dom:
            "<'row'<'col-lg-6'l><'col-lg-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "id" },
            { data: "category" },
            { data: "severity" },
            { data: "status" },
            { data: "created_at" },
            { data: "title" },
            { data: "options" },
        ],
        columnDefs: [
            { orderable: false, targets: [6] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2, 3, 4, 5],
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
                    columns: [0, 1, 2, 3, 4, 5]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {
            $("#incidencias-sin-asignar").off('click', '.take-incident'); // Limpio los eventos para que no se dupliquen
            $("#incidencias-sin-asignar").on('click', '.take-incident', function (e) {
                e.preventDefault();
                loadEventsTakeIncident(this);
            });


            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
        },
    });


});



/**
 * Atender incidencia
 */
function loadEventsTakeIncident(theElement) {
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
    let name = $("[data-incident-name]", form).val();

    

    $.ajax({
        url: url,
        type: 'GET',
        data: { '_method': 'GET' },
        success: function success() {
            $.toast({
                heading: 'Correcto',
                text: `Ahora estas atendiendo la incidencia ${name}`,
                showHideTransition: 'slide',
                icon: 'success',
                loader: true,
            });
            $('#incidencias-asignadas-a-mi').DataTable().ajax.reload(null, false);
            $('#incidencias-sin-asignar').DataTable().ajax.reload(null, false);
            $('#mis-incidencias').DataTable().ajax.reload(null, false);

        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: `Ha ocurrido un error al atender la incidencia ${name}`,
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });

}

