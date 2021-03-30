$(document).ready(function () {
    // Creo la segunda columna
    $('#users-table thead tr').clone(true).appendTo('#users-table thead');

    // Le añado los inputs y selects
    $('#users-table thead tr:eq(1) th').each(function (i) {
        if (i < 2) {
            let title = $(this).text();
            $(this).html('<input type="text" class="form-control w-100" placeholder="Buscar ' + title + '" />');

            // Agrego los eventos a cada input
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        } else {
            // Select de los estados
            if (i == 2) {
                let title = $(this).text();
                var arr = [
                    { val: "", text: `Seleccionar ${title}`},
                    { val: 'Admin', text: 'Adminstrador' },
                    { val: 'Support', text: 'Support' },
                    { val: 'Cliente', text: 'Cliente' }
                ];

                var sel = $('<select class="custom-select w-100">');

                $(arr).each(function () {
                    sel.append($("<option>").attr('value', this.val).text(this.text));
                });

                $(this).html(sel);

                // Agrego el evento
                $('select', this).on('change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

            } else {
                $(this).text("");
            }
        }
    });

    // Agrego la tabla
    let table = $('#users-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        language: {
            url: "http://gestion.incidencias/js/datatables/datatables-plugin-Spanish.js"
        },
        ajax: "datatables/usuarios",
        columns: [
            { data: "email" },
            { data: "name" },
            { data: "role", name: "role" },
            { data: "opciones" }
        ],
        columnDefs: [
            { orderable: false, targets: 3 },
            { orderable: false, targets: 2 },
        ],
        orderCellsTop: true,
        fixedHeader: true
    });
});