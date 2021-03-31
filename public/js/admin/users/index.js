
$(document).on("DOMContentLoaded", function () {

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
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p>>",
        columns: [
            { data: "email" },
            { data: "name", className: "name" },
            { data: "role", name: "role" },
            { data: "opciones" },
        ],
        columnDefs: [
            { orderable: false, targets: 3 },
            { orderable: false, targets: 2 },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1, 2],
            }
        ],
        buttons: [
            "searchPanes",
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
            $('[data-action="delete-user"]').off('click'); // Limpio los eventos para que no se dupliquen
            loadEventsDeleteUser(); // Los vuelvo a dar 
        },
    });

});


// Eliminar usuario
function loadEventsDeleteUser() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-action="delete-user"]').on("click", function (e) {

        e.preventDefault();

        // Recojo Url
        let url = $(this).parent().attr("action");
        url = url.split("gestion.incidencias")[1];

        // Recojo nombre
        let tr = $(this).closest("tr");
        let name = $(".name", tr).text();

        Swal.fire({
            title: 'Atencion !',
            text: `Esta seguro de eliminar al usuario <strong>${name}</strong> ?`,
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
                            'Usuario eliminado.',
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

    });
}