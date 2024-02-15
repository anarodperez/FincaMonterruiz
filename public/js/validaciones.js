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
                inputId: 'email',
                errorMessage: 'Formato de email no válido.'
            },
            {
                inputId: 'password',
                errorMessage: 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula y un número.'
            },
            {
                inputId: 'fecha_nacimiento',
                errorMessage: 'Fecha de nacimiento no válida. Debes ser mayor de 18 años.'
            },
            {
                inputId: 'telefono',
                errorMessage: 'Número de teléfono no válido. Debe tener entre 9 y 15 dígitos y puede incluir un prefijo internacional.'
            },
        ];

        let errors = false; // Inicialización de la variable de error

        // Itera sobre cada campo definido para su validación
        fieldsToValidate.forEach(field => {
            const input = document.getElementById(field.inputId); // Obtiene el elemento del campo a validar
            // Llama a la función de validación para el campo actual, mostrando un error si es necesario
            if (!validateField(input, field.errorMessage)) {
                errors = true; // Marca que se encontró un error
            }
        });

        // Validación para verificar que las contraseñas coincidan
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        // Comprueba si las contraseñas no coinciden y muestra un mensaje de error s
        if (passwordInput.value !== passwordConfirmationInput.value) {
            showError(passwordConfirmationInput, 'Las contraseñas no coinciden');
            errors = true; // Marca que se encontró un error
        } else if (passwordConfirmationInput.value.trim().length < 1) {
            // Verifica también si el campo de confirmación de contraseña está vacío
            showError(passwordConfirmationInput, 'Este campo es requerido');
            errors = true; // Marca que se encontró un error
        } else {
            hideError(passwordConfirmationInput); // Si no hay errores, oculta el mensaje de error
        }

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
        if ((!input.value || input.value.trim().length < 1) && input.id !== 'apellido2' && input.id !== 'telefono') {
            showError(input, 'Este campo es requerido');
            return false;
        } else if (
            (input.id === 'nombre' && (input.value.length < 3 || !validarInput(input.value))) ||
            (input.id === 'apellido1' && (input.value.length < 5 || !validarInput(input.value))) ||
            (input.id === 'apellido2' && input.value.trim().length > 0 && (input.value.length < 5 || !
                validarInput(input.value))) ||
            (input.id === 'email' && (input.value.length < 10 || !isValidEmail(input.value))) ||
            (input.id === 'password' && !validarContraseña(input.value)) ||
            (input.id === 'fecha_nacimiento' && !validarFechaNacimiento(input.value)) ||
            (input.id === 'telefono' && input.value.trim().length > 0  && !validarTelefono(input.value))
        )
         {
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

    // Función para validar si la contraseña es segura
    function validarContraseña(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        return regex.test(password);
    }

    // Función para validar la fecha de nacimiento asegurando que el usuario sea mayor de 18 años
    function validarFechaNacimiento(fecha) {
        const hoy = new Date();
        const fechaNacimiento = new Date(fecha);
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const m = hoy.getMonth() - fechaNacimiento.getMonth();

        // Ajuste de la edad basado en el mes y día actual
        if (m < 0 || (m === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        return edad >= 18; // Retorna true si la edad es 18 o más, false en caso contrario
    }

    // Función para validar el formato del teléfono permitiendo un rango de dígitos y, opcionalmente, un prefijo internacional
    function validarTelefono(telefono) {
        const regexTelefono = /^(?:\+\d{1,3})?\d{9,15}$/;
        return regexTelefono.test(telefono);
    }

});
