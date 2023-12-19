// Escucha el evento 'DOMContentLoaded' para asegurarse de que el DOM está completamente cargado

    document.addEventListener("DOMContentLoaded", function() {
    // Obtención del formulario y establecimiento del evento 'submit'
    const registerForm = document.getElementById('form');

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente

        // Array con campos a validar y mensajes de error asociados
        const fieldsToValidate = [{
                inputId: 'nombre',
                errorMessage: 'Nombre no válido. Introduce un nombre válido.'
            },
            {
                inputId: 'apellido1',
                errorMessage: 'Apellido no válido. Introduce tu primer apellido.'
            },
            {
                inputId: 'apellido2',
                errorMessage: 'Apellido no válido. Introduce tu segundo apellido. '
            },
            {
                inputId: 'telefono',
                errorMessage: 'Formato de teléfono no válido. Introduce un número de teléfono válido.'
            },
            {
                inputId: 'email',
                errorMessage: 'Formato de email no válido.'
            }
        ];

        let errors = false; // Inicialización de la variable de error

        // Validación de cada campo
        fieldsToValidate.forEach(field => {
            const input = document.getElementById(field.inputId);
            if (!validateField(input, field.errorMessage)) {
                errors = true;
            }
        });

        // Envío del formulario si no hay errores
        if (!errors) {
            registerForm.submit();
        }
    });

    // Validación de un campo específico con su mensaje de error
    function validateField(input, errorMessage) {
        if (!input) {
            return false; // Salir de la función si el elemento es nulo
        }

        // Verificación de cada campo según su validación específica
        if ((!input.value || input.value.trim().length < 1) && input.id !== 'apellido2') {
            showError(input, 'Este campo es requerido');
            return false;
        } else if (
            (input.id === 'nombre' && (input.value.length < 3 || !validarInput(input.value))) ||
            (input.id === 'apellido1' && (input.value.length < 5 || !validarInput(input.value))) ||
            (input.id === 'apellido2' && input.value.trim().length > 0 && (input.value.length < 5 || !validarInput(input.value))) ||
            (input.id === 'email' && (input.value.length < 10 || !isValidEmail(input.value))) ||
            (input.id === 'password' && !validarContraseña(input.value)) ||
            (input.id === 'telefono' && !validatePhone(input.value.trim())) // Validación específica para el campo de teléfono
        ) {
            showError(input, errorMessage);
            return false;
        } else {
            hideError(input);
            return true;
        }
    }

    // Función para mostrar un mensaje de error asociado a un campo específico
    function showError(input, message) {
    let errorSpan = input.nextElementSibling; // Obtiene el siguiente hermano del campo

    // Si no existe el mensaje de error o no tiene la clase 'error-message'
    if (!errorSpan || !errorSpan.classList.contains('error-message')) {
        errorSpan = document.createElement('span'); // Crea un nuevo elemento 'span' para el mensaje de error
        errorSpan.classList.add('error-message'); // Agrega la clase 'error-message' al nuevo elemento
        input.parentNode.insertBefore(errorSpan, input.nextElementSibling); // Inserta el nuevo elemento antes del siguiente hermano del campo
    }

    errorSpan.innerHTML = `<span class="error-icon">❌</span> ${message}`; // Establece el mensaje de error dentro del elemento
    input.classList.add('is-invalid'); // Agrega una clase para resaltar visualmente el campo con error
    errorSpan.classList.add('error-visible'); // Hace visible el mensaje de error
    }

    // Función para ocultar el mensaje de error asociado a un campo específico
    function hideError(input) {
    const errorSpan = input.nextElementSibling; // Obtiene el siguiente hermano del campo

    // Verifica si hay un mensaje de error y si tiene la clase 'error-message'
    if (errorSpan && errorSpan.classList.contains('error-message')) {
        input.classList.remove('is-invalid'); // Elimina la clase de resaltado del campo
        errorSpan.remove(); // Elimina el mensaje de error
    }
    }

    // Función para validar si el email es válido
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/;
        return emailRegex.test(email);
    }

    // Función para validar si la entrada es un apellido válido
    function validarInput(input) {
        const regex = /^[a-zA-ZñÑáéíóúü\s-]+$/;
        return regex.test(input);
    }

    // Función para validar si la entrada es un número de teléfono válido
    function validatePhone(phone) {
        // Puedes ajustar la expresión regular según tus necesidades
        const phoneRegex = /^(\+\d{1,4}|\d{1,4})?[6-9]\d{8}$/;
        return phoneRegex.test(phone);
    }
});
