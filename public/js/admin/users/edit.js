$(function() {

    $("#select-project").on("change", onSelectProjectChange);
});

function onSelectProjectChange(){
    let project_id = $(this).val();
    let select_level = $("#select-level");
    let html_select = "<option value=''>Seleccione nivel</option>";

    if(! project_id){
        select_level.html(html_select);
        return;
    }

    // AJAX
    $.get(`/api/proyecto/${project_id}/niveles`, function (data){
        
        for (let i = 0; i < data.length; i++) {
            html_select += "<option value='"+ data[i].id +"' >"+ data[i].name +"</option>"
        }
        select_level.html(html_select);
    });
}