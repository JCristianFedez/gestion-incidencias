////////////// START CATEGORIES TABLE ///////////////////////
$(function () {
    let project = $('#categories-table').data("projectId");
    let host = $(location).attr('host');

    // Agrego la tabla
    let table = $('#categories-table').DataTable({
        responsive: true,
        processing: true,
        language: {
            url: `//${host}/datatables/plugin-Spanish.json`
        },
        ajax: `/datatables/proyecto/${project}/categorias`,
        dom:
            "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-12'B>>" +
            "<'#filtro-para-tablas.row'<'col-12'P>>" +
            "<'row'<'col-12'tr>>" +
            "<'row'<'col-lg'i><'col-lg'p >>",
        columns: [
            { data: "name" },
            { data: "created_at" },
            { data: "options" }
        ],
        columnDefs: [
            { orderable: false, targets: [2] },
            {
                searchPanes: {
                    show: true,
                },
                targets: [0, 1],
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
                    columns: [0, 1]
                }

            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [0, 1]
                }
            },
            'colvis', 'colvisRestore'
        ],
        drawCallback: function () {
            // Limpio los eventos para que no se dupliquen

            $("#categories-table").off("click", "[data-category-id]");
            $("#categories-table").on("click", "[data-category-id]", function (e) {
                editCategoryModal(this);
            });

            $("body").off("submit", "#modalEditCategory");
            $("body").on("submit", "#modalEditCategory", function (e) {
                e.preventDefault();
                editCategory(this);
            });

            $("#categories-table").off('click', '.delete-category');
            $("#categories-table").on('click', '.delete-category', function (e) {
                e.preventDefault();
                deleteCategory(this);
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
 * Cargar los datos de la categoria en el modal
 */
function editCategoryModal(theElement) {
    let category_id = $(theElement).data("categoryId");
    let category_name = $(theElement).data("categoryName");

    $("#modalEditCategory #category_id").val(category_id);
    $("#modalEditCategory #category_name").val(category_name);
    $("#modalEditCategory").data("categoryName", category_name);
}

/**
 * Editar categoria
 */
function editCategory(theElement) {
    $("#modalEditCategory").modal('hide');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Recojo Url
    let url = $(theElement).find("form").attr("action");
    url = url.split($(location).attr('host'))[1];

    // Recojo nombre e id
    let newName = $("#modalEditCategory #category_name").val();
    let categoryId = $("#modalEditCategory #category_id").val();

    $.ajax({
        url: url,
        type: 'POST',
        data: { '_method': 'PUT', 'category_id': categoryId, 'name': newName },
        success: function success(data) {
            $.toast({
                heading: data.head,
                text: data.message,
                showHideTransition: 'slide',
                icon: data.type,
                loader: true,
            });
            if (data.type != "error") {
                $('#categories-table').DataTable().ajax.reload(null, false);
            }
        },
        error: function error() {
            $.toast({
                heading: 'Error',
                text: "Error al editar categoria",
                showHideTransition: 'fade',
                icon: 'error'
            })
        }
    });
}

/**
 * Eliminar categoria
 */
function deleteCategory(theElement) {
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
    let name = form.data("categoryName");

    Swal.fire({
        title: '¡Atencion!',
        text: `¿Esta seguro de eliminar la categoria ${name}?`,
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
                        'Categoria eliminada.',
                        'success');
                    $('#categories-table').DataTable().ajax.reload(null, false);
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

////////////// END CATEGORIES TABLE ///////////////////////