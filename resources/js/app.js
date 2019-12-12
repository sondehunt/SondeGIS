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
            this.map = L.map('map', { zoomControl: false }).setView([51.163361, 10.447683], 5)

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                'attribution': '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
                'useCache': true
            }).addTo(this.map)
        }
    },
    mounted () {
        this.initSelects()
        this.initMap()
        this.loadReceiveStations()

        // test
        L.circle([51, 7.5], { radius: 30000, opacity: 0.5, fillOpacity: 0.05 }).addTo(this.map)
    },
    watch: {
        receive_stations: {
            deep: true,
            handler () {
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
                    L.marker([receiveStation.lat, receiveStation.long], {
                        icon: this.point_icon
                    }).addTo(this.map).bindPopup(popupContent)
                })
            }
        }
    }
})
