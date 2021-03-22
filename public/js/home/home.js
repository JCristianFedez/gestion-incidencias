$(function() {
    $("tbody tr").on("click", function(){
        window.location = $(this).data('href');
        return false;
    });
});