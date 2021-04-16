
$(function () {
    let host = $(location).attr('host');
    // Agrego la tabla
    let table = $('#projects-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: "datatables/proyectos",
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "name" },
            { data: "description"},
            { data: "start" },
            { data: "status" },
            { data: "opciones" },
        ],
        columnDefs: [
            { orderable: false, targets: [4] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2, 3],
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
                    columns: [0, 1, 2, 3]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {
            $("#projects-table").off('click', '.delete-project'); // Limpio los eventos para que no se dupliquen
            $("#projects-table").on('click', '.delete-project', function (e) {
                e.preventDefault();
                loadEventsDeleteProject(this);
            });

            $("#projects-table").off('click', '.restore-project'); // Limpio los eventos para que no se dupliquen
            $("#projects-table").on('click', '.restore-project', function (e) {
                e.preventDefault();
                loadEventsRestoreProject(this);
            });

            $("#projects-table").off('click', '.force-destroy-project'); // Limpio los eventos para que no se dupliquen
            $("#projects-table").on('click', '.force-destroy-project', function (e) {
                e.preventDefault();
                loadEventsForceDeleteProject(this);
            });

            // Oculto el ultimo serachpanel que es el de las opciones
            // ya que por ahora (7 - abril - 2021) datatables al usar withtrashed en laravel
            // no funciona el ocultar paneles
            $(".dtsp-searchPane").eq(4).hide();

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
            
   


        },
    });


});



/**
 * Eliminar proyecto
 */
function loadEventsDeleteProject(theElement) {
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
    let name = $("[data-project-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de deshabilitar el proyecto ${name} ?`,
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
                        'Deshabilitado!',
                        'Proyecto deshabilitado.',
                        'success');
                    $('#projects-table').DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la deshabilitacion",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}

/**
 * Resturar proyecto
 */
 function loadEventsRestoreProject(theElement) {
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
    let name = $("[data-project-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de restaurar el proyecto ${name} ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'GET',
                data: { '_method': 'GET' },
                success: function success() {
                    Swal.fire(
                        'Restaurado!',
                        'Proyecto habilitado.',
                        'success');
                    $('#projects-table').DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la restauracion",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}



/**
 * Eliminar proyecto
 */
 function loadEventsForceDeleteProject(theElement) {
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
    let name = $("[data-project-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de eliminar completamente el proyecto ${name} ?`,
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
                        'Eliminado!',
                        'Proyecto eliminado completamente.',
                        'success');
                    $('#projects-table').DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la eliminacino",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}
