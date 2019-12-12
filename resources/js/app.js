//require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    $('select').selectpicker()

    const map = L.map('map', { zoomControl: false }).setView([51.163361, 10.447683], 5)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        'attribution': '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
        'useCache': true
    }).addTo(map)
    const circle = L.icon({
        iconUrl: 'assets/circle.svg',
        iconSize: [10, 10],
        iconAnchor: [5, 5],
        popupAnchor: [0, -5]
    })
    const marker = L.marker([51.163361, 10.447683], { icon: circle }).addTo(map)
    marker.bindPopup('<b>Hello world!</b><br>I am a popup.')
    L.circle([51, 7.5], { radius: 30000, opacity: 0.5, fillOpacity: 0.05 }).addTo(map)
})

let app = new Vue({
    el: '#app',
    data: {
        view: 'launch_sites',
        launch_sites: [],
        new_launch_site: {},
        receive_stations: [],
        new_receive_station: {
            name: '',
            operator: '',
            lat: null,
            long: null,
            elevation: null,
            antenna_height: null,
            antenna_type: '',
            processing_system_type: '',
            concurrent_receivers: null,
            reporting_to: []
        },
        hunters: [],
        new_hunter: {},
        proposal: {
            email: '',
            comment: ''
        }
    },
    methods: {
        loadReceiveStations () {
            fetch(window.api_url + '/receive_stations')
                .then(console.log)
                .catch(console.log)
        },
        proposeReceiveStation () {
            if (!this.$refs.receive_station_proposal.reportValidity()) {
                return
            }
            fetch(window.api_url + '/receive_stations', {
                body: JSON.stringify({
                    receive_station: this.receive_station,
                    proposal: this.proposal
                }),
                headers: {
                    'Content-Type': 'application/json'
                },
                method: 'POST'
            })
                .then(console.log)
                .catch(console.log)
        }
    },
    mounted () {
        this.loadReceiveStations()
    },
})
