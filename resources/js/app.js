let app = new Vue({
    el: '#app',
    data: {
        map: null,
        point_icon: L.icon({
            iconUrl: 'assets/circle.svg',
            iconSize: [10, 10],
            iconAnchor: [5, 5],
            popupAnchor: [0, -5]
        }),
        view: 'launch_sites',
        layer_main: null,
        layer_receive_stations: null,
        launch_sites: [],
        new_launch_site: {},
        receive_stations: [],
        receive_stations_loading: true,
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
                .then(response => response.json())
                .then(receiveStations => this.receive_stations = receiveStations)
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
        },
        initSelects () {
            $('select').selectpicker()
        },
        initMap () {
            this.map = L.map('map', { zoomControl: false })
            this.map.setView([51.163361, 10.447683], 5)
            this.layer_main = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
                useCache: true,
                minZoom: 5,
                maxZoom: 19,
            })
            this.map.addLayer(this.layer_main)
        },
    },
    mounted () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                this.map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude), 7)
            })
        }
        this.initSelects()
        this.initMap()
        this.loadReceiveStations()

        // test
        //L.circle([51, 7.5], { radius: 30000, opacity: 0.5, fillOpacity: 0.05 }).addTo(this.map)
    },
    watch: {
        receive_stations: {
            deep: true,
            handler () {
                let receiveStationMarkers = []
                this.receive_stations.forEach((receiveStation) => {
                    let popupContent = '<b>' + receiveStation.name + '</b><br><table>'
                    for (let prop in receiveStation) {
                        if (Object.prototype.hasOwnProperty.call(receiveStation, prop)) {
                            popupContent += '<tr>'
                            popupContent += '<td style="text-align: right;">' + prop + '</td>'
                            popupContent += '<td><strong>' + receiveStation[prop] + '</strong></td>'
                            popupContent += '</tr>'
                        }
                    }
                    popupContent += '</table>'
                    receiveStationMarkers.push(L.marker([receiveStation.lat, receiveStation.long], {
                        icon: this.point_icon
                    }).addTo(this.map).bindPopup(popupContent))
                })
                this.layer_receive_stations = L.layerGroup(receiveStationMarkers)
                this.map.addLayer(this.layer_receive_stations)
                this.receive_stations_loading = false
            }
        }
    }
})
