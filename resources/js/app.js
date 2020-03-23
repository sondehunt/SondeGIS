function ucFirst (string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
}

let app = new Vue({
    el: '#app',
    data: {
        map: null,
        point_icon: L.icon({
            iconUrl: 'assets/circle.svg',
            iconSize: [10, 10],
            iconAnchor: [5, 5],
            popupAnchor: [0, -5],
        }),
        view: 'hunters',
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
        filters: {
            launch_sites: {
                types: {
                    operational: false,
                    sporadic: false,
                },
                observation_times: {
                    one_per_day: false,
                    two_per_day: false,
                    four_per_day: false,
                },
                sonde_families: {
                    vaisala: false,
                    lockheed_martin: false,
                    meteomodem: false,
                    graw: false,
                    meisei: false,
                    var_russian: false,
                    var_chinese: false,
                },
            },
            receive_stations: {
                aprs: false,
                sondehub: false,
                radiosondy: false,
                wetterson: false,
                proprietary: false,
            },
            hunters: {
                hunting_activity: 0,
            },
        },
    },
    computed: {
        filtered_hunters () {
            return this.hunters
        }
    },
    watch: {
        launch_sites: {
            deep: true,
            handler () {
                let launchSitesMarkers = []
                this.launch_sites.forEach((launchSite) => {
                    let popupContent = '<h5 class="card-title">' + launchSite.name + '</h5>'
                    popupContent += '<a href="javascript:void(0)" class="btn btn-outline-primary mt-1">Edit</a>'
                    popupContent += '<div style="clear: both;">'
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
                    let popupContent = '<h5 class="card-title">' + receiveStation.name + '</h5>'
                    if (receiveStation.operator) {
                        popupContent += '<span class="font-weight-bold text-muted">Operator</span> ' + receiveStation.operator + '<br>'
                    }
                    if (receiveStation.elevation) {
                        popupContent += '<span class="font-weight-bold text-muted">Elevation</span> ' + receiveStation.elevation + ' m<br>'
                    }
                    if (receiveStation.antenna_height) {
                        popupContent += '<span class="font-weight-bold text-muted">Antenna Height</span> ' + receiveStation.antenna_height + ' m<br>'
                    }
                    if (receiveStation.antenna_type) {
                        popupContent += '<span class="font-weight-bold text-muted">Antenna Type</span><br>' + receiveStation.antenna_type + '<br>'
                    }
                    if (receiveStation.processing_system_type) {
                        popupContent += '<span class="font-weight-bold text-muted">Processing System Type</span><br>' + receiveStation.processing_system_type + '<br>'
                    }
                    if (receiveStation.concurrent_receivers) {
                        popupContent += '<span class="font-weight-bold text-muted">Concurrent Receivers</span> ' + receiveStation.concurrent_receivers + '<br>'
                    }
                    if (receiveStation.reporting_to) {
                        popupContent += '<span class="font-weight-bold text-muted">Reporting To</span><br>'
                        for (let report of receiveStation.reporting_to) {
                            popupContent += '<span class="badge badge-info mr-1">' + report + '</span>'
                        }
                    }
                    popupContent += '<a href="javascript:void(0)" class="btn btn-outline-primary mt-1">Edit</a>'
                    popupContent += '<div style="clear: both;">'
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
                this.filtered_hunters.forEach((hunter) => {
                    let popupContent = '<h5 class="card-title">' + hunter.name + '</h5>'
                    if (hunter.radius) {
                        popupContent += '<span class="font-weight-bold text-muted">Hunting Radius</span> ' + hunter.radius + ' km<br>'
                    }
                    if (hunter.activity) {
                        popupContent += '<span class="font-weight-bold text-muted">Hunting Activity Probability</span> ' + Math.floor(hunter.activity * 100) + ' %<br>'
                    }
                    if (hunter.contact) {
                        popupContent += '<span class="font-weight-bold text-muted">Contact</span><br>'
                        for (let contactType in hunter.contact) {
                            let userText = ''
                            switch (contactType) {
                                case 'telegram':
                                    userText = '<a href="https://t.me/' + hunter.contact[contactType] + '" target="_blank">@' + hunter.contact[contactType] + '</a>'
                                    break
                                case 'twitter':
                                    userText = '<a href="https://twitter.com/' + hunter.contact[contactType] + '" target="_blank">@' + hunter.contact[contactType] + '</a>'
                                    break
                                default:
                                    userText = hunter.contact[contactType]
                            }
                            popupContent += ucFirst(contactType) + ': ' + userText + '<br>'
                        }
                    }
                    popupContent += '<a href="javascript:void(0)" class="btn btn-outline-primary mt-1">Edit</a>'
                    popupContent += '<div style="clear: both;">'
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
        proposeLaunchSite () {
            if (!this.$refs.launch_station_proposal.reportValidity()) {
                return
            }
            console.log('propose launch site')
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
})
