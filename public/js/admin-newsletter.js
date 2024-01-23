 var deleteModal = document.getElementById('deleteModal');
 var deleteForm = document.getElementById('deleteForm');
 var confirmDeleteBtn = document.getElementById('confirmDelete');

 deleteModal.addEventListener('show.bs.modal', function(event) {
 var button = event.relatedTarget;
 var newsletterId = button.getAttribute('data-id');
 deleteForm.action = '/admin/newsletters/' + newsletterId; // Ajusta esta ruta
 });

 confirmDeleteBtn.addEventListener('click', function() {
 deleteForm.submit();
 });

 // Script para la Vista Previa
 function previewNewsletter(id) {
 var previewFrame = document.getElementById('previewFrame');
 previewFrame.src = '/admin/newsletters/preview/' + id; // Ajusta esta ruta a tu endpoint de vista previa
 $('#previewModal').modal('show');
 }

 // Script para Búsqueda en Tiempo Real
 document.getElementById('searchBox').addEventListener('keyup', function(event) {
 var searchValue = event.target.value.toLowerCase();
 var rows = document.querySelectorAll('#newsletterTableBody tr');
 rows.forEach(row => {
 var title = row.querySelector('td:first-child').textContent.toLowerCase();
 if (title.includes(searchValue)) {
 row.style.display = '';
 } else {
 row.style.display = 'none';
 }
 });
 });
