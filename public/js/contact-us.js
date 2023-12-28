document.addEventListener("DOMContentLoaded", function() {
    const contactForm = document.getElementById('contactForm');
       const successMessage = document.getElementById('successMessage');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;

        // Validar Nombre
        const nombre = document.getElementById('nombre');
        const errorNombre = document.getElementById('errorNombre');
        if (nombre.value.trim() === '') {
            errorNombre.textContent = 'Por favor, ingresa tu nombre.';
            isValid = false;
        } else {
            errorNombre.textContent = '';
        }

        // Validar Email
        const email = document.getElementById('email');
        const errorEmail = document.getElementById('errorEmail');
        if (!validateEmail(email.value)) {
            errorEmail.textContent = 'Por favor, ingresa un email válido.';
            isValid = false;
        } else {
            errorEmail.textContent = '';
        }

        // Validar Teléfono
        const telefono = document.getElementById('telefono');
        const errorTelefono = document.getElementById('errorTelefono');
        if (!validatePhone(telefono.value)) {
            errorTelefono.textContent = 'Por favor, ingresa un número de teléfono válido.';
            isValid = false;
        } else {
            errorTelefono.textContent = '';
        }

        // Validar Mensaje
        const mensaje = document.getElementById('mensaje');
        const errorMensaje = document.getElementById('errorMensaje');
        if (mensaje.value.trim() === '') {
            errorMensaje.textContent = 'Por favor, ingresa tu mensaje.';
            isValid = false;
        } else {
            errorMensaje.textContent = '';
        }

        if (isValid) {
            contactForm.submit();
            // Muestra el mensaje de éxito
            successMessage.style.display = 'block';
        }
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(phone) {
        const re = /^\d{9,}$/; // Ajusta esta regex a tus necesidades
        return re.test(String(phone));
    }
});
