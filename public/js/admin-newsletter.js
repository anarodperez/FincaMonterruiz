// Script para la Vista Previa
function previewNewsletter(id) {
    var previewFrame = document.getElementById('previewFrame');
    previewFrame.src = '/admin/newsletters/preview/' + id; // Ajusta esta ruta a tu endpoint de vista previa
    $('#previewModal').modal('show');
}

// Script para Abrir Modal de Programación
function openScheduleModal() {
    $('#scheduleModal').modal('show');
}

// Script para Enviar el Formulario de Programación
function submitScheduleForm() {
    const scheduleDate = document.getElementById('modal_day_of_week').value;
    const scheduleTime = document.getElementById('modal_execution_time').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    const form = document.createElement('form');
    form.method = 'post';
    form.action = '/admin/newsletters/updateConfig';
    form.innerHTML = `
    <input type="hidden" name="day_of_week" value="${scheduleDate}">
    <input type="hidden" name="execution_time" value="${scheduleTime}">
    <input type="hidden" name="_token" value="${csrfToken}">
`;

    document.body.appendChild(form);
    form.submit();
}

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

    // Añadir Event Listeners a los Botones de Programar Envío
    document.querySelectorAll('.scheduleButton').forEach(button => {
        button.addEventListener('click', function() {
            const newsletterId = this.getAttribute('data-newsletter-id');
            openScheduleModal(newsletterId);
        });
    });
});
