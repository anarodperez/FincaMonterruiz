
function setLastVisitCookie() {
    var now = new Date(); // Obtiene la fecha y hora actual
    // Crea/actualiza la cookie 'lastVisit' con la fecha/hora actual, establece el path a la raíz ('/') y la expiración a un año desde ahora
    document.cookie = "lastVisit=" + now.toUTCString() + "; path=/; expires=" + new Date(now.getTime() + 365*24*60*60*1000).toUTCString();
}

window.onload = setLastVisitCookie;


function checkLastVisitCookie() {
    var lastVisit = getCookie("lastVisit"); // Obtiene el valor de la cookie 'lastVisit'
    if (lastVisit) { // Si la cookie existe
        var lastVisitDate = new Date(lastVisit); // Convierte el valor de la cookie a un objeto Date
        var now = new Date(); // Fecha y hora actual
        var timeDiff = now - lastVisitDate; // Calcula la diferencia de tiempo en milisegundos
        var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24)); // Convierte la diferencia de tiempo a días

        // Construye el mensaje personalizado basándose en la diferencia de días
        var message = "Tu última visita fue el " + lastVisitDate.toLocaleString() + ".";
        if (daysDiff < 1) {
            message += " ¡Qué bueno verte de nuevo hoy!";
        } else if (daysDiff === 1) {
            message += " ¡Bienvenido de nuevo! Ha pasado 1 día desde tu última visita.";
        } else {
            message += " ¡Bienvenido de nuevo! Han pasado " + daysDiff + " días desde tu última visita.";
        }

        // Muestra el mensaje en el elemento con ID 'welcomeMessage'
        document.getElementById('welcomeMessage').innerHTML = message;
    }
}


function getCookie(name) {
    var nameEQ = name + "="; // Formato del nombre de la cookie para la búsqueda
    var ca = document.cookie.split(';'); // Divide todas las cookies en un array
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i].trim(); // Elimina espacios en blanco al inicio de cada cookie
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length); // Si encuentra la cookie, devuelve su valor
    }
    return null; // Si no encuentra la cookie, devuelve null
}


window.onload = function() {
    checkLastVisitCookie(); // Verifica y muestra el mensaje basado en la última visita
    setLastVisitCookie(); // Actualiza la cookie 'lastVisit' con la fecha y hora actuales
};

