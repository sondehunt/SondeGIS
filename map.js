document.addEventListener("DOMContentLoaded", function(event) {
  var map = L.map('map', { zoomControl: false }).setView([51.163361, 10.447683], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    'attribution':  '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
    'useCache': true
  }).addTo(map);
  var marker = L.marker([51.163361, 10.447683]).addTo(map);
  marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
  });
