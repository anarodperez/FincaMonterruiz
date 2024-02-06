var currentCancelFormId = null;
var isBatchCancellation = false; //  variable para rastrear si es una cancelación en lote

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('selectAll').addEventListener('change', function(e) {
        // Selecciona todos los checkboxes de las reservas utilizando su clase
        const reservaCheckboxes = document.querySelectorAll('.reserva-checkbox');

        reservaCheckboxes.forEach(checkbox => {
            // Establece el estado de cada checkbox de reserva para que coincida con el estado del checkbox principal
            checkbox.checked = e.target.checked;
        });
    });
});

function openCancelModal(reservaId, estado) {
    isBatchCancellation = false; // Establece a false para cancelaciones individuales
    currentCancelFormId = 'cancel-form-' + reservaId;
    var modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    var messageElement = document.getElementById('cancelMessage');
    document.getElementById('confirmBatchCancel').style.display = 'none';
    document.getElementById('confirmCancel').style.display =
        'inline-block';

    if (estado === 'cancelada') {
        messageElement.textContent = 'Esta reserva ya está cancelada.';
        document.getElementById('confirmCancel').disabled = true;
    } else {
        messageElement.textContent = '¿Estás seguro de que deseas cancelar esta reserva?';
        document.getElementById('confirmCancel').disabled = false;
    }

    modal.show();
}

// Añade una función para abrir el modal en modo lote
function openBatchCancelModal() {
    isBatchCancellation = true;
    var modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    document.getElementById('cancelMessage').textContent = 'Ingresa el motivo de la cancelación en lote:';
    document.getElementById('confirmCancel').style.display = 'none';
    document.getElementById('confirmBatchCancel').style.display = 'inline-block';

    modal.show();
}

document.getElementById('cancelarReservasEnLote').addEventListener('click', openBatchCancelModal);

document.getElementById('confirmCancel').addEventListener('click', function() {
    var motivoCancelacion = document.getElementById('cancelReason').value;
    var motivoInput = document.createElement('input');
    motivoInput.setAttribute('type', 'hidden');
    motivoInput.setAttribute('name', 'motivoCancelacion');
    motivoInput.value = motivoCancelacion;

    if (!isBatchCancellation) {
        var form = document.getElementById(currentCancelFormId);
        form.appendChild(motivoInput);
        form.submit();
    }
});

document.getElementById('confirmBatchCancel').addEventListener('click', function() {
    var motivoCancelacion = document.getElementById('cancelReason').value;
    if (isBatchCancellation) {
        let selectedReservas = Array.from(document.querySelectorAll('.reserva-checkbox:checked')).map(cb =>
            cb.value);
        if (selectedReservas.length === 0) {
            alert('Por favor, selecciona al menos una reserva para cancelar.');
            return;
        }

        var form = document.getElementById('batchCancelForm');
        document.getElementById('batchCancelInput').value = JSON.stringify(selectedReservas);

        var motivoInputLote = document.createElement('input');
        motivoInputLote.setAttribute('type', 'hidden');
        motivoInputLote.setAttribute('name', 'motivoCancelacion');
        motivoInputLote.value = motivoCancelacion;
        form.appendChild(motivoInputLote);

        form.submit();
    }
});
