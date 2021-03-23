// Usado en admin/users/edit

$(function() {
    $("#select-project").on("change", onSelectProjectChange);
    $("[data-relation]").on("click", editRealtionModal);

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

function editRealtionModal(){
    let project_id = $(this).data("project-id");
    let project_name = $(this).data("project-name");
    let level_id = $(this).data("level-id");
    let title = $("#EditProjectRelationModalLabel");
    let select_level = $("#select_level_relation");
    let html_select = "";
    $("#project_id_relation").val(project_id);
    $("#project_user_id_relation").val($(this).val());
    console.log($("#project_user_id_relation").val());
    title.text(`Editar Relacion con ${project_name}`);

    $("#project_id").val(project_id);
    
    // AJAX
    $.get(`/api/proyecto/${project_id}/niveles`, function (data){
    
        for (let i = 0; i < data.length; i++) {
            if(data[i].id == level_id){
                html_select += "<option selected value='"+ data[i].id +"' >"+ data[i].name +"</option>"
            }else{
                html_select += "<option value='"+ data[i].id +"' >"+ data[i].name +"</option>"
            }
        }
        select_level.html(html_select);
    });
}