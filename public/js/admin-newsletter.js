// Vista Previa
function previewNewsletter(id) {
    var previewFrame = document.getElementById('previewFrame');
    previewFrame.src = '/admin/newsletters/preview/' + id; // Ajusta esta ruta a tu endpoint de vista previa
    $('#previewModal').modal('show');
}

//Borrado
document.addEventListener('DOMContentLoaded', function() {
    var deleteModal = document.getElementById('deleteModal');
    var deleteForm = document.getElementById('deleteForm');
    var confirmDeleteBtn = document.getElementById('confirmDelete');

    deleteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var newsletterId = button.getAttribute('data-id');
        deleteForm.action = '/admin/newsletters/' + newsletterId;
    });

    confirmDeleteBtn.addEventListener('click', function() {
        deleteForm.submit();
    });

    // Script para Búsqueda en Tiempo Real
    document.getElementById('searchBox').addEventListener('keyup', function(event) {
        var searchValue = event.target.value.toLowerCase();
        var rows = document.querySelectorAll('#newsletterTableBody tr');
        rows.forEach(row => {
            var title = row.querySelector('td:first-child').textContent.toLowerCase();
            row.style.display = title.includes(searchValue) ? '' : 'none';
        });
    });

   // Event listener para los botones de "Programar Envío"
   document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.scheduleButton').forEach(button => {
        button.addEventListener('click', function() {
            const newsletterId = this.getAttribute('data-newsletter-id');
            console.log("Opening modal for newsletter ID:", newsletterId); // Para depuración
            openScheduleModal(newsletterId);
        });
    });

});
});

//Programación y selección newsletter
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.scheduleButton').forEach(button => {
        button.addEventListener('click', function() {
            const newsletterId = this.getAttribute('data-newsletter-id');
            document.getElementById('modal_newsletter_id').value = newsletterId;
        });
    });
});

// Función para enviar el formulario de programación
function submitScheduleForm() {
    document.getElementById('scheduleForm').submit();
}
