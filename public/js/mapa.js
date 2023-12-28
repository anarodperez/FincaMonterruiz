// Inicializar el mapa y centrarlo en una ubicación específica (latitud, longitud)
var mymap = L.map('map').setView([36.701023, -6.200812], 13);

// Agregar una capa de mapa base (por ejemplo, OpenStreetMap)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);

// Agregar un marcador al mapa
var marker = L.marker([36.701023, -6.200812]).addTo(mymap);

// Agregar un popup al marcador
marker.bindPopup("<b>Finca Monterruiz</b><br>Barriada el Polila, 123.").openPopup();
