 //Para el modal de borrar valoración
 document.addEventListener("DOMContentLoaded", function() {
    var valoracionModal = document.getElementById('deleteValoracionModal');
    valoracionModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var valoracionId = button.getAttribute('data-id');
        var deleteForm = document.getElementById('deleteValoracionForm');
        deleteForm.action = '/valoraciones/' + valoracionId;
    });
});

//Para el modal de editar valoración
document.addEventListener("DOMContentLoaded", function() {
    var editValoracionModal = document.getElementById('editValoracionModal');
    editValoracionModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Botón que activó el modal
        var valoracionId = button.getAttribute('data-id'); // Extrae el ID de la valoración
        var puntuacion = button.getAttribute('data-puntuacion'); // Extrae la puntuación
        var comentario = button.getAttribute('data-comentario'); // Extrae el comentario

        var form = document.getElementById('editValoracionForm');
        form.action = '/valoraciones/actualizar/' + valoracionId;
        form.querySelector('#puntuacion').value = puntuacion;
        form.querySelector('#comentario').value = comentario;
    });
});

//Para el modal de cancelar actividad
document.addEventListener("DOMContentLoaded", function() {
    var cancelModal = document.getElementById('cancelModal');
    cancelModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var reservaId = button.getAttribute('data-id');
        var cancelForm = document.getElementById('cancelForm');
        cancelForm.action = '/reservas/' + reservaId + '/cancelar';
    });
});
