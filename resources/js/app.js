require('./bootstrap');

document.addEventListener("DOMContentLoaded", () => {
    $('select').selectpicker();

    const map = L.map('map', { zoomControl: false }).setView([51.163361, 10.447683], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        'attribution':  '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
        'useCache': true
    }).addTo(map);
    const circle = L.icon({
        iconUrl: 'assets/circle.svg',
        iconSize: [10, 10],
        iconAnchor: [5, 5],
        popupAnchor: [0, -5]
    });
    const marker = L.marker([51.163361, 10.447683], {icon: circle}).addTo(map);
    marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
    L.circle([51, 7.5], {radius: 30000, opacity: 0.5, fillOpacity: 0.05}).addTo(map);
});

var app = new Vue({
    el: '#app',
    data: {
        view: 'launch_sites',
        receive_station: {
            name: "",
            operator: "",
            lat: "",
            long: "",
            elevation: "",
            antenna_height: "",
            antenna_type: "",
            processing_system_type: "",
            concurrent_receivers: "",
            reporting_to: []
        },
        proposal: {
            email: '',
            comment: ''
        }
    },
    methods: {
        proposeReceiveStation() {
            if(!this.$refs.receive_station_proposal.checkValidity()){
                this.$refs.receive_station_proposal.reportValidity();
                return;
            }
            fetch()
        }
    }
})
