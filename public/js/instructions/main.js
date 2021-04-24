$(function () {
    let indice = $("#indice");
    let instructions = $("#instructions-container");

    if (indice.height() > instructions.height())
        instructions.height(indice.height());

});