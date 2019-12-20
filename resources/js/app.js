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
        layer_launch_sites: null,
        layer_receive_stations: null,
        layer_hunters: null,
        launch_sites: [],
        receive_stations: [],
        hunters: [],
        launch_sites_loading: true,
        receive_stations_loading: true,
        hunters_loading: true,
        new_launch_site: {},
        new_receive_station: {
            name: '',
            operator: '',
            latitude: null,
            longitude: null,
            elevation: null,
            antenna_height: null,
            antenna_type: '',
            processing_system_type: '',
            concurrent_receivers: null,
            reporting_to: [],
        },
        new_hunter: {
            name: '',
            latitude: null,
            longitude: null,
            radius: null,
            activity: null,
            telegram: '',
            twitter: '',
            callsign: '',
        },
        proposal: {
            email: '',
            comment: '',
        },
    },
    methods: {
        loadLaunchSites () {
            fetch(window.api_url + '/launch_sites')
                .then(response => response.json())
                .then(launchSites => this.launch_sites = launchSites)
                .catch(console.log)
        },
        loadReceiveStations () {
            fetch(window.api_url + '/receive_stations')
                .then(response => response.json())
                .then(receiveStations => this.receive_stations = receiveStations)
                .catch(console.log)
        },
        loadHunters () {
            fetch(window.api_url + '/hunters')
                .then(response => response.json())
                .then(hunters => this.hunters = hunters)
                .catch(console.log)
        },
        proposeReceiveStation () {
            if (!this.$refs.receive_station_proposal.reportValidity()) {
                return
            }
            fetch(window.api_url + '/receive_stations', {
                body: JSON.stringify({
                    receive_station: this.new_receive_station,
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
        proposeHunter () {
            if (!this.$refs.hunter_proposal.reportValidity()) {
                return
            }
            fetch(window.api_url + '/hunters', {
                body: JSON.stringify({
                    hunter: this.new_hunter,
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
        this.loadLaunchSites()
        this.loadReceiveStations()
        this.loadHunters()

        // test
        //L.circle([51, 7.5], { radius: 30000, opacity: 0.5, fillOpacity: 0.05 }).addTo(this.map)
    },
    watch: {
        launch_sites: {
            deep: true,
            handler () {
                let launchSitesMarkers = []
                this.launch_sites.forEach((launchSite) => {
                    let popupContent = '<b>' + launchSite.name + '</b><br><table>'
                    for (let prop in launchSite) {
                        if (Object.prototype.hasOwnProperty.call(launchSite, prop)) {
                            popupContent += '<tr>'
                            popupContent += '<td style="text-align: right;">' + prop + '</td>'
                            popupContent += '<td><strong>' + launchSite[prop] + '</strong></td>'
                            popupContent += '</tr>'
                        }
                    }
                    popupContent += '</table>'
                    launchSitesMarkers.push(L.marker([launchSite.latitude, launchSite.longitude], {
                        icon: this.point_icon
                    }).addTo(this.map).bindPopup(popupContent))
                })
                this.layer_launch_sites = L.layerGroup(launchSitesMarkers)
                this.map.addLayer(this.layer_launch_sites)
                this.launch_sites_loading = false
            }
        },
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
                    receiveStationMarkers.push(L.marker([receiveStation.latitude, receiveStation.longitude], {
                        icon: this.point_icon
                    }).addTo(this.map).bindPopup(popupContent))
                })
                this.layer_receive_stations = L.layerGroup(receiveStationMarkers)
                this.map.addLayer(this.layer_receive_stations)
                this.layer_receive_stations.removeFrom(this.map)
                this.receive_stations_loading = false
            }
        },
        hunters: {
            deep: true,
            handler () {
                let hunterMarkers = []
                this.hunters.forEach((hunter) => {
                    let popupContent = '<b>' + hunter.name + '</b><br><table>'
                    for (let prop in hunter) {
                        if (Object.prototype.hasOwnProperty.call(hunter, prop)) {
                            popupContent += '<tr>'
                            popupContent += '<td style="text-align: right;">' + prop + '</td>'
                            popupContent += '<td><strong>' + hunter[prop] + '</strong></td>'
                            popupContent += '</tr>'
                        }
                    }
                    popupContent += '</table>'
                    hunterMarkers.push(L.circle([hunter.latitude, hunter.longitude], {
                        radius: hunter.radius * 1000,
                        opacity: hunter.activity,
                        fillOpacity: 0.05,
                    }).addTo(this.map).bindPopup(popupContent))
                })
                this.layer_hunters = L.layerGroup(hunterMarkers)
                this.map.addLayer(this.layer_hunters)
                this.layer_hunters.removeFrom(this.map)
                this.hunters_loading = false
            }
        },
        view: {
            handler (value) {
                if (this.launch_sites_loading === false) {
                    this.layer_launch_sites.removeFrom(this.map)
                }
                if (this.receive_stations_loading === false) {
                    this.layer_receive_stations.removeFrom(this.map)
                }
                if (this.hunters_loading === false) {
                    this.layer_hunters.removeFrom(this.map)
                }

                switch (value) {
                    case 'launch_sites':
                        this.layer_launch_sites.addTo(this.map)
                        break
                    case 'receive_stations':
                        this.layer_receive_stations.addTo(this.map)
                        break
                    case 'hunters':
                        this.layer_hunters.addTo(this.map)
                        break
                    default:
                        break
                }
            }
        }
    }
})
