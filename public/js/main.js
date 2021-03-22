$(function() {
    $("#list-of-projects").on("change", onNewProjectSelected);
});

function onNewProjectSelected(){
    let project_id = $(this).val();
    location.href = `/seleccionar/proyecto/${project_id}`;
}

$(document).ready(function(){
    $(".toast").toast();
    
    setTimeout(function() {
            $(".toast").fadeOut(1500);
    },3000);
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})