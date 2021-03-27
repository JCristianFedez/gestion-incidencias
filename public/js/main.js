$(function () {
  $("#list-of-projects").on("change", onNewProjectSelected);
});

function onNewProjectSelected() {
  let project_id = $(this).val();
  location.href = `/seleccionar/proyecto/${project_id}`;
}


// Toast
$(document).ready(function () {
  $(".toast").toast();

  setTimeout(function () {
    $(".toast").fadeOut(1500);
  }, 3000);
});

// Tooltips
$(function () {
  $('body [data-toggle="tooltip"]').tooltip();
  $('body [data-toggle-second="tooltip"]').tooltip();
});

// Validar formulario
(function () {
  'use strict';
  window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


// Menu vertical
$(function () {
  $('#vertiacalSidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
  });
});

// No enviar formulario al pulsar enter
$(function () {
  $(document).on("keydown", ".form-not-send", function (e) {
    if ((e.keyCode || e.which) == 13) {
      e.preventDefault();
      return;
    }
  });
  
  $(document).on("submit", ".form-not-send", function (e) {
    e.preventDefault();
  });

});
