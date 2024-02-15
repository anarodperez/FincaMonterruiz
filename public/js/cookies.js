// Espera a que todo el contenido del DOM se cargue antes de ejecutar la función.
document.addEventListener('DOMContentLoaded', function() {
    // Intenta recuperar el valor de la cookie "cookieConsent".
    var cookieConsent = getCookie("cookieConsent");

    // Si no se encuentra la cookie "cookieConsent", muestra el contenedor de consentimiento de cookies.
    if (!cookieConsent) {
        document.getElementById('cookieConsentContainer').style.display = 'block';
    }

    // Añade un evento de clic al botón de aceptar el consentimiento de cookies.
    document.getElementById('acceptCookieConsent').onclick = function() {
        // Al hacer clic, establece la cookie "cookieConsent" a "accepted" por 30 días y oculta el contenedor de consentimiento.
        setCookie("cookieConsent", "accepted", 30); // Guarda una cookie por 30 días.
        document.getElementById('cookieConsentContainer').style.display = 'none'; // Oculta el contenedor de consentimiento.
    };
});

// Función para establecer una cookie.
function setCookie(name, value, days) {
    var expires = "";
    // Si se especifica un número de días, configura una fecha de expiración para la cookie.
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Calcula la fecha de expiración.
        expires = "; expires=" + date.toUTCString(); // Convierte la fecha a formato UTC.
    }
    // Establece la cookie con el nombre, valor y fecha de expiración proporcionados.
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Función para obtener el valor de una cookie específica.
function getCookie(name) {
    var nameEQ = name + "="; // Formato del nombre de la cookie.
    var ca = document.cookie.split(';'); // Divide todas las cookies disponibles en un array.
    // Itera a través de cada cookie.
    for(var i=0; i < ca.length; i++) {
        var c = ca[i];
        // Elimina los espacios en blanco al inicio de la cookie.
        while (c.charAt(0)==' ') c = c.substring(1, c.length);
        // Si la cookie actual coincide con la buscada, devuelve su valor.
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    // Si no se encuentra la cookie, devuelve null.
    return null;
}
