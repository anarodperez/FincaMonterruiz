document.addEventListener("DOMContentLoaded", function() {
    const contactForm = document.getElementById('contactForm');
       const successMessage = document.getElementById('successMessage');

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;

        // Validar Nombre
        const nombre = document.getElementById('nombre');
        const errorNombre = document.getElementById('errorNombre');
        const trimmedNombre = nombre.value.trim();

        if (trimmedNombre  === '') {
            errorNombre.textContent = 'Por favor, ingresa tu nombre y apellidos.';
            isValid = false;
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s'-]+$/.test(trimmedNombre)) {
            errorNombre.textContent = 'El nombre solo puede contener letras, espacios y guiones.';
            isValid = false;
        } else if (trimmedNombre.length < 3 || trimmedNombre.length > 50) {
            errorNombre.textContent = 'El nombre debe tener entre 3 y 50 caracteres.';
            isValid = false;
        }  else {
            errorNombre.textContent = '';
        }

        // Validar Email
        const email = document.getElementById('email');
        const errorEmail = document.getElementById('errorEmail');
        if (email.value.trim() === '') {
            errorEmail.textContent = 'Por favor, ingresa tu correo electrónico.';
            isValid = false;
        } else if (!validateEmail(email.value)) {
            errorEmail.textContent = 'Por favor, ingresa un email válido.';
            isValid = false;
        } else {
            errorEmail.textContent = '';
        }

        // Validar Teléfono
        const telefono = document.getElementById('telefono');
        const errorTelefono = document.getElementById('errorTelefono');
        const trimmedTelefono = telefono.value.trim();

        if (trimmedTelefono === '') {
            errorTelefono.textContent = 'Por favor, ingresa tu número de teléfono.';
            isValid = false;
        } else if (!validatePhone(trimmedTelefono)) {
            errorTelefono.textContent = 'Por favor, ingresa un número de teléfono válido.';
            isValid = false;
        } else {
            errorTelefono.textContent = '';
        }

        // Validar Mensaje
        const mensaje = document.getElementById('mensaje');
        const errorMensaje = document.getElementById('errorMensaje');
        const trimmedMensaje = mensaje.value.trim();

        if (trimmedMensaje === '') {
            errorMensaje.textContent = 'Por favor, ingresa tu mensaje.';
            isValid = false;
        } else if (trimmedMensaje.length > 500) {
            errorMensaje.textContent = 'El mensaje no puede exceder los 500 caracteres.';
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
        const re =  /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(phone) {
        const re = /^(?:\+\d{1,3})?\d{6,12}$/;
        return re.test(String(phone));
    }
});
