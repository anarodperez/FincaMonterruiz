
function setLastVisitCookie() {
    var now = new Date();
    document.cookie = "lastVisit=" + now.toUTCString() + "; path=/; expires=" + new Date(now.getTime() + 365*24*60*60*1000).toUTCString();
}
window.onload = setLastVisitCookie;


function checkLastVisitCookie() {
    var lastVisit = getCookie("lastVisit");
    if (lastVisit) {
        var lastVisitDate = new Date(lastVisit);
        var now = new Date();
        var timeDiff = now - lastVisitDate; // Diferencia en milisegundos
        var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24));

        var message = "Tu última visita fue el " + lastVisitDate.toLocaleString() + ".";
        if (daysDiff < 1) {
            message += " ¡Qué bueno verte de nuevo hoy!";
        } else if (daysDiff === 1) {
            message += " ¡Bienvenido de nuevo! Ha pasado 1 día desde tu última visita.";
        } else {
            message += " ¡Bienvenido de nuevo! Han pasado " + daysDiff + " días desde tu última visita.";
        }

        // Mostrar el mensaje en el dashboard
        document.getElementById('welcomeMessage').innerHTML = message;
    }
}


function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


window.onload = function() {
    checkLastVisitCookie();
    setLastVisitCookie();
};
