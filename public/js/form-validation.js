// formValidation.js

// Funciones de validación

function validateEmail(email) {
    const emailRegex = /^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/;
    return emailRegex.test(email);
}
function validarInput(input) {
    const regex = /^[a-zA-ZñÑáéíóúü\s-]+$/;
    return regex.test(input);
}

function validatePassword(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return regex.test(password);
}

// Funciones de manejo de errores

function showError(input, message) {
    let errorSpan = input.nextElementSibling;

    if (!errorSpan || !errorSpan.classList.contains('error-message')) {
        errorSpan = document.createElement('span');
        errorSpan.classList.add('error-message');
        input.parentNode.insertBefore(errorSpan, input.nextElementSibling);
    }

    errorSpan.innerHTML = `<span class="error-icon">❌</span> ${message}`;
    input.classList.add('is-invalid');
    errorSpan.classList.add('error-visible');
}

function hideError(input) {
    const errorSpan = input.nextElementSibling;

    if (errorSpan && errorSpan.classList.contains('error-message')) {
        input.classList.remove('is-invalid');
        errorSpan.remove();
    }
}

export { validateEmail, validarInput, validatePassword, showError, hideError };
