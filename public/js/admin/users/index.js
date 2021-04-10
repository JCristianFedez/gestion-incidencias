
$(function () {

    // Agrego la tabla
    let table = $('#users-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: "http://gestion.incidencias/datatables/plugin-Spanish.json"
        },
        ajax: "datatables/usuarios",
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "email" },
            { data: "name"},
            { data: "created_at" },
            { data: "role" },
            { data: "status" },
            { data: "opciones" },
        ],
        columnDefs: [
            { orderable: false, targets: [5] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2, 3, 4],
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
                    columns: [0, 1, 2, 3, 4]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {
            $("#users-table").off('click', '.delete-user'); // Limpio los eventos para que no se dupliquen
            $("#users-table").on('click', '.delete-user', function (e) {
                e.preventDefault();
                loadEventsDeleteUser(this);
            });

            $("#users-table").off('click', '.force-destroy-user'); // Limpio los eventos para que no se dupliquen
            $("#users-table").on('click', '.force-destroy-user', function (e) {
                e.preventDefault();
                loadEventsForceDestoryUser(this);
            });

            $("#users-table").off('click', '.restore-user'); // Limpio los eventos para que no se dupliquen
            $("#users-table").on('click', '.restore-user', function (e) {
                e.preventDefault();
                loadEventsRestoreUser(this);
            });

             // Oculto el ultimo serachpanel que es el de las opciones
            // ya que por ahora (7 - abril - 2021) datatables al usar withtrashed en laravel
            // no funciona el ocultar paneles
            $(".dtsp-searchPane").eq(5).hide();

            $('.dtsp-searchPanes').hide(); // Por defecto oculto el panel de busqueda
        },
    });


});



/**
 * Eliminar usuario
 */
function loadEventsDeleteUser(theElement) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // Recojo Url
    let url = $(theElement).parent().attr("action");
    url = url.split("gestion.incidencias")[1];

    // Recojo nombre
    let form = $(theElement).parent();
    let name = $("[data-user-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de dar de baja al usuario ${name} ?`,
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
                        'Desactivado!',
                        'Usuario dado de baja correctamente.',
                        'success');
                    $('#users-table').DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la baja",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}


/**
 * Resturar usuario
 */
 function loadEventsRestoreUser(theElement) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // Recojo Url
    let url = $(theElement).parent().attr("action");
    url = url.split("gestion.incidencias")[1];

    // Recojo nombre
    let form = $(theElement).parent();
    let name = $("[data-user-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de activar el usuario ${name} ?`,
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
                        'Usuario habilitado.',
                        'success');
                    $("#users-table").DataTable().ajax.reload(null, false)
                },
                error: function error() {
                    Swal.fire({
                        title: 'Error!',
                        text: "Ha abido un error en la activacion",
                        type: 'error',
                        timer: 5000
                    });
                }
            });
        }
    })

}

/**
 * Eliminar usuario completamente
 */
 function loadEventsForceDestoryUser(theElement) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // Recojo Url
    let url = $(theElement).parent().attr("action");
    url = url.split("gestion.incidencias")[1];

    // Recojo nombre
    let form = $(theElement).parent();
    let name = $("[data-user-name]", form).val();

    Swal.fire({
        title: 'Atencion !',
        text: `Esta seguro de eliminar competamente al usuario ${name} ?`,
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
                        'Usuario eliminado completamente.',
                        'success');
                    $('#users-table').DataTable().ajax.reload(null, false)
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