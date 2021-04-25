$(function () {
    $('body').scrollspy({ target: '#index-container', offset: 200 });
});


$(function () {
    $("#select-project-instruction").on("change", onNewProjectSelected);
});

function onNewProjectSelected() {
    let project_id = $(this).val();
    location.href = `/seleccionar/proyecto/${project_id}`;
}