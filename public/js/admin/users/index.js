$(document).ready(function () {

    // Agrego la tabla
    let table = $('#users-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: "http://gestion.incidencias/datatables/plugin-Spanish.json"
        },
        ajax: "datatables/usuarios",
        dom:
            "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
        columns: [
            { data: "email" },
            { data: "name" },
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
        ]
    });

    // Activar tooltips despues de pintar la tabla
    table.on('draw', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    // Le añado los inputs y selects
    $('#users-table thead tr:eq(1) th').each(function (i) {

        // Agrego los eventos a cada input
        $('input,select', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });

    });


    // Elimino el filtro
    $('[data-clear-filter]').each(function () {
        $(this).on("click", function () {
            $(this).tooltip("hide");
            let idTable = $(this).data("clearFilter");
            $(`#${idTable} thead input`).val("");
            $(`#${idTable} thead select`).val("");

            let tableToClear = $(`#${idTable}`).DataTable();
            tableToClear
                .search('')
                .columns().search('')
                .draw();
        });
    });
});