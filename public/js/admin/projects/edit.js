$(function() {
    $("[data-category]").on("click", editCategoryModal);
});

function editCategoryModal(){
    let category_id = $(this).data("category");
    let category_name = $(this).data("name");
    
    $("#category_id").val(category_id);
    $("#category_name").val(category_name);

}

$(function() {
    $("[data-level]").on("click", editLevelModal);
});

function editLevelModal(){
    let level_id = $(this).data("level");
    let level_name = $(this).data("name");
    
    $("#level_id").val(level_id);
    $("#level_name").val(level_name);

}