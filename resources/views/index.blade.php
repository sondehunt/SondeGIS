<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SondeGIS</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
</head>

<body>
<div id="app">
    <!--NAVBAR-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <img src="{{ asset('assets/parachute.svg') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        <a class="navbar-brand ml-2">SondeGIS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-right mr-2">
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/sondehunt/SondeGIS">Github</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://sondehunt.de">Main Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://sondehunt.de/language/en/privacy-policy">Privacy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://sondehunt.de/language/en/imprint">Imprint</a>
                </li>
            </ul>
            <form class="form-inline d-block d-md-inline">
                <button class="btn btn-outline-primary d-block d-md-inline mr-2 mt-2 mt-md-0" type="button"
                        data-toggle="modal" data-target="#launchSiteModal">Add Launch Site
                </button>
                <button class="btn btn-outline-info d-block d-md-inline mr-2 mt-3 mt-md-0" type="button"
                        data-toggle="modal" data-target="#receiveStationModal">Add Receive Station
                </button>
                <button class="btn btn-outline-secondary d-block d-md-inline mt-3 mt-md-0" type="button"
                        data-toggle="modal" data-target="#hunterModal">Add Hunter
                </button>
            </form>
        </div>
    </nav>

    <!--MAP+OVERLAY-->
    <div class="wrapper">
        <!--MAP-->
        <div class="underlay" id='map'></div>

        <!--VIEW SELECTOR-->
        <div class="overlay card mt-3 ml-3" style="z-index: 501;">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label v-on:click="view='launch_sites'"
                       :class="'btn btn-outline-primary' + (view === 'launch_sites' ? ' active' : '')">
                    <input type="radio" name="view" autocomplete="off">
                    Launch Sites
                    <span v-if="launch_sites_loading" class="spinner-grow spinner-grow-sm" role="status"
                          aria-hidden="true"></span>
                </label>
                <label v-on:click="view='receive_stations'"
                       :class="'btn btn-outline-info' + (view === 'receive_stations' ? ' active' : '')">
                    <input type="radio" name="view" autocomplete="off">
                    Receive Stations
                    <span v-if="receive_stations_loading" class="spinner-grow spinner-grow-sm" role="status"
                          aria-hidden="true"></span>
                </label>
                <label v-on:click="view='hunters'"
                       :class="'btn btn-outline-secondary' + (view === 'hunters' ? ' active' : '')">
                    <input type="radio" name="view" autocomplete="off">
                    Hunters
                    <span v-if="hunters_loading" class="spinner-grow spinner-grow-sm" role="status"
                          aria-hidden="true"></span>
                </label>
            </div>
        </div>

        <!--FILTER LAUNCH SITE-->
        <div v-if="view=='launch_sites'" class="overlay card scrollable ml-3"
             style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Type</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="typeOperational"
                           v-model="filters.launch_sites.types.operational">
                    <label class="custom-control-label" for="typeOperational">Operational</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="typeSporadic"
                           v-model="filters.launch_sites.types.sporadic">
                    <label class="custom-control-label" for="typeSporadic">Sporadic</label>
                </div>

                <h6 class="card-subtitle mt-3 mb-2 text-muted">Observation Time</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ObservationTimeOnePerDay"
                           v-model="filters.launch_sites.observation_times.one_per_day">
                    <label class="custom-control-label" for="ObservationTimeOnePerDay">1 per day</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ObservationTimeTwoPerDay"
                           v-model="filters.launch_sites.observation_times.two_per_day">
                    <label class="custom-control-label" for="ObservationTimeTwoPerDay">2 per day</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="ObservationTimeFourPerDay"
                           v-model="filters.launch_sites.observation_times.four_per_day">
                    <label class="custom-control-label" for="ObservationTimeFourPerDay">4 per day</label>
                </div>

                <h6 class="card-subtitle mt-3 mb-2 text-muted">Sonde Family</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyVaisala"
                           v-model="filters.launch_sites.sonde_families.vaisala">
                    <label class="custom-control-label" for="SondeFamilyVaisala">Vaisala</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyLockheedMartin"
                           v-model="filters.launch_sites.sonde_families.lockheed_martin">
                    <label class="custom-control-label" for="SondeFamilyLockheedMartin">Lockheed Martin</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyMeteomodem"
                           v-model="filters.launch_sites.sonde_families.meteomodem">
                    <label class="custom-control-label" for="SondeFamilyMeteomodem">Meteomodem</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyGraw"
                           v-model="filters.launch_sites.sonde_families.graw">
                    <label class="custom-control-label" for="SondeFamilyGraw">Graw</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyMeisei"
                           v-model="filters.launch_sites.sonde_families.meisei">
                    <label class="custom-control-label" for="SondeFamilyMeisei">Meisei</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyVarRussian"
                           v-model="filters.launch_sites.sonde_families.var_russian">
                    <label class="custom-control-label" for="SondeFamilyVarRussian">var. Russian</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="SondeFamilyVarChinese"
                           v-model="filters.launch_sites.sonde_families.var_chinese">
                    <label class="custom-control-label" for="SondeFamilyVarChinese">var. Chinese</label>
                </div>
            </div>
        </div>

        <!--FILTER RECEIVE STATION-->
        <div v-else-if="view=='receive_stations'" class="overlay card scrollable ml-3"
             style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Reporting to</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="reportAPRS"
                           v-model="filters.receive_stations.aprs">
                    <label class="custom-control-label" for="reportAPRS">aprs.fi</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="reportSondehub"
                           v-model="filters.receive_stations.sondehub">
                    <label class="custom-control-label" for="reportSondehub">sondehub.org</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="reportRadiosondy"
                           v-model="filters.receive_stations.radiosondy">
                    <label class="custom-control-label" for="reportRadiosondy">radiosondy.info</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="reportWetterson"
                           v-model="filters.receive_stations.wetterson">
                    <label class="custom-control-label" for="reportWetterson">wetterson.de</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="reportProprietary"
                           v-model="filters.receive_stations.proprietary">
                    <label class="custom-control-label" for="reportProprietary">proprietary site</label>
                </div>
            </div>
        </div>

        <!--FILTER HUNTER-->
        <div v-else-if="view=='hunters'" class="overlay card scrollable ml-3"
             style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Hunting Activity Probability</h6>
                <input type="range" class="custom-range" style="width:250px" title="Hunting Activity Probability"
                       v-model.number="filters.hunters.hunting_activity" min="0" max="100">
                <br>
                <span class="text-muted">@{{ filters.hunters.hunting_activity }} % to 100 %</span>
            </div>
        </div>
    </div>

    <!--MODAL LAUNCH SITE-->
    <div class="modal fade" id="launchSiteModal" tabindex="-1" role="dialog" aria-labelledby="launchSiteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="launchSiteModalLabel">Add/Edit Launch Site</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="proposeLaunchSite()" ref="launch_station_proposal">
                        <div class="form-group">
                            <label for="launchSiteName">Name*</label>
                            <input type="text" class="form-control" id="launchSiteName" required
                                   placeholder="e.g. 'Essen-Bredney'">
                        </div>
                        <div class="form-group">
                            <label for="launchSiteOperator">Operator*</label>
                            <input type="text" class="form-control" id="launchSiteOperator" required
                                   placeholder="e.g. 'Deutscher Wetterdienst'">
                        </div>
                        <div class="form-group">
                            <label for="launchSiteWmoId">WMO-ID</label>
                            <input type="text" class="form-control" id="launchSiteWmoId" required
                                   placeholder="e.g. '10410'">
                        </div>
                        <div class="form-group">
                            <label for="launchSiteLocationLat">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" id="launchSiteLocationLat" required
                                           placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="launchSiteLocationLon" required
                                           placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="launchSiteAltASL">Elevation</label>
                            <input type="text" class="form-control" id="launchSiteAltASL"
                                   placeholder="above sea level [m] e.g. '580'">
                        </div>
                        <!--LAUNCHES-->
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-secondary" type="button" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                            Toggle View Launch #1
                                        </button>
                                        <button class="btn btn-danger" type="button">Delete</button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                     data-parent="#accordionExample">
                                    <div class="card-body">
                                        <h4>Launch</h4>
                                        <div class="form-group">
                                            <label for="siteReport">Type</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="siteLaunchType"
                                                       id="launchSiteLaunchTypeOperational">
                                                <label class="custom-control-label"
                                                       for="launchSiteLaunchTypeOperational">operational</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" name="siteLaunchType"
                                                       id="launchSiteLaunchTypeSporadic">
                                                <label class="custom-control-label" for="launchSiteLaunchTypeSporadic">sporadic</label>
                                            </div>
                                        </div>
                                        <h5>Schedule</h5>
                                        <div class="accordion" id="accordionExample2">
                                            <div class="card">
                                                <div class="card-header" id="headingOne2">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-secondary" type="button"
                                                                data-toggle="collapse" data-target="#collapseOne2"
                                                                aria-expanded="true" aria-controls="collapseOne">
                                                            Toggle View Schedule #1
                                                        </button>
                                                        <button class="btn btn-danger" type="button">Delete</button>
                                                    </h5>
                                                </div>

                                                <div id="collapseOne2" class="collapse show"
                                                     aria-labelledby="headingOne2" data-parent="#accordionExample2">
                                                    <div class="card-body">
                                                        Test
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-success collapsed" type="button"
                                                                data-toggle="collapse" data-target="#collapseThree2"
                                                                aria-expanded="false" aria-controls="collapseThree2">
                                                            Add new Schedule
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="mt-3">Sonde</h5>

                                        <div class="form-group">
                                            <label for="launchSiteLaunchBallon">Ballon</label>
                                            <select id="launchSiteLaunchBallon" class="form-control">
                                                <option>red, 100g</option>
                                                <option>white, 600g</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="siteLaunchGas">Gas</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="siteLaunchGas"
                                                       id="launchSiteLaunchGasHydrogen">
                                                <label class="custom-control-label" for="launchSiteLaunchGasHydrogen">hydrogen</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" name="siteLaunchGas"
                                                       id="launchSiteLaunchGasHelium">
                                                <label class="custom-control-label" for="launchSiteLaunchGasHelium">helium</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="launchSiteLaunch>Parachute">Parachute</label>
                                            <select id="launchSiteLaunch>Parachute" class="form-control">
                                                <option>white, 60cm, inside ballon</option>
                                                <option>white, 40cm, inside ballon</option>
                                                <option>none</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-success collapsed" type="button" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                            Add new Launch
                                        </button>
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="launchSiteAnnotations">Annotations</label>
                            <input type="text" class="form-control" id="launchSiteAnnotations"
                                   placeholder="e.g. 'sporadic additional launches at 06Z/18Z'">
                        </div>

                        <div class="form-group">
                            <label for="launchSiteEMail">Your E-Mail*</label>
                            <input type="email" class="form-control" id="launchSiteEMail" required
                                   placeholder="E-Mail Address">
                            <small id="launchSiteEMailHelp" class="form-text text-muted">Your E-Mail is only used to
                                sent you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="launchSiteComment">Your Comment</label>
                            <textarea class="form-control" id="launchSiteComment" rows="3"
                                      placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="launchSiteCommentHelp" class="form-text text-muted">Comments are only sent to the
                                administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-on:click="proposeLaunchSite()" type="button" class="btn btn-success">Propose
                        Addition/Edit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL RECEIVE STATION-->
    <div class="modal fade" id="receiveStationModal" tabindex="-1" role="dialog"
         aria-labelledby="receiveStationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiveStationModalLabel">Add/Edit Receive Station</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="proposeReceiveStation()" ref="receive_station_proposal">
                        <div class="form-group">
                            <label for="receiveStationName">Name*</label>
                            <input v-model="new_receive_station.name" type="text" class="form-control"
                                   id="receiveStationName" required placeholder="e.g. 'DB4ZJO-11'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationOperator">Operator*</label>
                            <input v-model="new_receive_station.operator" type="text" class="form-control"
                                   id="receiveStationOperator" required placeholder="e.g. 'DB4ZJO'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationLocationLat">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input v-model="new_receive_station.latitude" type="text" class="form-control"
                                           id="receiveStationLocationLat" required
                                           placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input v-model="new_receive_station.longitude" type="text" class="form-control"
                                           id="receiveStationLocationLon" required
                                           placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="receiveStationAltASL">Elevation</label>
                            <input v-model="new_receive_station.elevation" type="text" class="form-control"
                                   id="receiveStationAltASL" placeholder="above sea level [m] e.g. '580'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationAltAGL">Antenna Height</label>
                            <input v-model="new_receive_station.antenna_height" type="text" class="form-control"
                                   id="receiveStationAltAGL" placeholder="above ground level [m] e.g. '34'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationAntenna">Antenna Type</label>
                            <input v-model="new_receive_station.antenna_type" type="text" class="form-control"
                                   id="receiveStationAntenna" placeholder="e.g. 'Diamond X30'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationProcessingSystem">Processing System Type</label>
                            <input v-model="new_receive_station.processing_system_type" type="text" class="form-control"
                                   id="receiveStationProcessingSystem"
                                   placeholder="e.g. 'Raspberry Pi 4 4GB + 3 NESDR Smart'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationConcurrentReceivers">Number of concurrent Receivers</label>
                            <input v-model="new_receive_station.concurrent_receivers" type="text" class="form-control"
                                   id="receiveStationConcurrentReceivers" placeholder="e.g. '24'">
                        </div>
                        <div class="form-group">
                            <label for="receiveStationReport">Reporting to</label>
                            <select v-model="new_receive_station.reporting_to" id="receiveStationReport"
                                    class="selectpicker form-control" multiple data-live-search="true">
                                <option>aprs.fi</option>
                                <option>sondehub.org</option>
                                <option>radiosondy.info</option>
                                <option>wetterson.de</option>
                                <option>proprietary site</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="receiveStationEMail">Your E-Mail*</label>
                            <input v-model="proposal.email" type="email" class="form-control" id="receiveStationEMail"
                                   required placeholder="E-Mail Address">
                            <small id="receiveStationEMailHelp" class="form-text text-muted">Your E-Mail is only used to
                                sent you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="receiveStationComment">Your Comment</label>
                            <textarea v-model="proposal.comment" class="form-control" id="receiveStationComment"
                                      rows="3"
                                      placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="receiveStationCommentHelp" class="form-text text-muted">Comments are only sent to
                                the administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-on:click="proposeReceiveStation()" type="button" class="btn btn-success">Propose
                        Addition/Edit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL HUNTER-->
    <div class="modal fade" id="hunterModal" tabindex="-1" role="dialog" aria-labelledby="hunterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hunterModalLabel">Add/Edit Hunter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="proposeHunter()" ref="hunter_proposal">
                        <div class="form-group">
                            <label for="hunterName">Name*</label>
                            <input v-model="new_hunter.name" type="text" class="form-control" id="hunterName" required
                                   placeholder="e.g. 'Niklas'">
                        </div>
                        <div class="form-group">
                            <label for="hunterLocationLat">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input v-model="new_hunter.latitude" type="text" class="form-control"
                                           id="hunterLocationLat" required placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input v-model="new_hunter.longitude" type="text" class="form-control"
                                           id="hunterLocationLon" required placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hunterRadius">Radius* (kilometers)</label>
                            <input v-model="new_hunter.radius" type="number" class="form-control" id="hunterRadius"
                                   required placeholder="e.g. '50'">
                        </div>
                        <div class="form-group">
                            <label for="hunterActivity">Activity*</label>
                            <input v-model="new_hunter.activity" type="number" class="form-control" id="hunterActivity"
                                   required placeholder="e.g. '0.4'" min="0" max="1" step="0.1">
                        </div>
                        <div class="form-group">
                            <label for="hunterTelegram">Telegram</label>
                            <input v-model="new_hunter.telegram" type="text" class="form-control" id="hunterTelegram"
                                   placeholder="e.g. '@bazjo'">
                        </div>
                        <div class="form-group">
                            <label for="hunterTwitter">Twitter</label>
                            <input v-model="new_hunter.twitter" type="text" class="form-control" id="hunterTwitter"
                                   placeholder="e.g. '@bazjo73'">
                        </div>
                        <div class="form-group">
                            <label for="hunterCallsign">Callsign</label>
                            <input v-model="new_hunter.callsign" type="text" class="form-control" id="hunterCallsign"
                                   placeholder="e.g. 'DB4ZJO'">
                        </div>

                        <div class="form-group">
                            <label for="hunterEMail">Your E-Mail*</label>
                            <input v-model="proposal.email" type="email" class="form-control" id="hunterEMail" required
                                   placeholder="E-Mail Address">
                            <small id="hunterEMailHelp" class="form-text text-muted">Your E-Mail is only used to sent
                                you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="hunterComment">Your Comment</label>
                            <textarea v-model="proposal.comment" class="form-control" id="hunterComment" rows="3"
                                      placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="hunterCommentHelp" class="form-text text-muted">Comments are only sent to the
                                administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-on:click="proposeHunter()" type="button" class="btn btn-success">Propose Addition/Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
<script type="text/javascript">
    window.api_url = "{{ env('APP_URL') }}/api"
</script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
