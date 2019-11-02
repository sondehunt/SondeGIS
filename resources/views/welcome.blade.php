<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SondeGIS</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>

<body>
<div id="app">
    <!--NAVBAR-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <img src="assets/parachute.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <a class="navbar-brand ml-2">SondeGIS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-right mr-2">
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/bazjo/SondeGIS">Github</a>
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
                <button class="btn btn-outline-primary d-block d-md-inline mr-2 mt-2 mt-md-0" type="button" data-toggle="modal" data-target="#launchSiteModal">Add Launch Site</button>
                <button class="btn btn-outline-info d-block d-md-inline mr-2 mt-3 mt-md-0" type="button" data-toggle="modal" data-target="#receiveStationModal">Add Receive Station</button>
                <button class="btn btn-outline-secondary d-block d-md-inline mt-3 mt-md-0" type="button" data-toggle="modal" data-target="#hunterModal" >Add Hunter</button>
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
                <label v-on:click="view='launch_sites'" class="btn btn-outline-primary active">
                    <input type="radio" name="view" autocomplete="off" checked> Launch Sites
                </label>
                <label v-on:click="view='receive_stations'" class="btn btn-outline-info">
                    <input type="radio" name="view" autocomplete="off"> Receive Stations
                </label>
                <label v-on:click="view='hunters'" class="btn btn-outline-secondary">
                    <input type="radio" name="view" autocomplete="off"> Hunters
                </label>
            </div>
        </div>
        <!--LEGEND LAUNCH SITE-->
        <div v-if="view=='launch_sites'" class="overlay card scrollable ml-3" style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Type</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck5">
                    <label class="custom-control-label" for="customCheck5">Operational</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck6">
                    <label class="custom-control-label" for="customCheck6">Sporadic</label>
                </div>

                <h6 class="card-subtitle mt-3 mb-2 text-muted">Observation Time</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck7">
                    <label class="custom-control-label" for="customCheck7">00Z or 12Z</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck8">
                    <label class="custom-control-label" for="customCheck8">00Z/12Z</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck9">
                    <label class="custom-control-label" for="customCheck9">00Z/06Z/12Z/18Z</label>
                </div>

                <h6 class="card-subtitle mt-3 mb-2 text-muted">Sonde Family</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">RS41</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">DFM-09</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">M10</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck4">
                    <label class="custom-control-label" for="customCheck4">iMS-100</label>
                </div>
            </div>
        </div>

        <!--LEGEND RECEIVE STATION-->
        <div v-else-if="view=='receive_stations'" class="overlay card scrollable ml-3" style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Reporting to</h6>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="siteReportAPRS">
                    <label class="custom-control-label" for="siteReportAPRS">aprs.fi</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="siteReportSondehub">
                    <label class="custom-control-label" for="siteReportSondehub">sondehub.org</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="siteReportRadiosondy">
                    <label class="custom-control-label" for="siteReportRadiosondy">radiosondy.info</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="siteReportWetterson">
                    <label class="custom-control-label" for="siteReportWetterson">wetterson.de</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="siteReportProprietary">
                    <label class="custom-control-label" for="siteReportProprietary">proprietary site</label>
                </div>
            </div>
        </div>

        <!--LEGEND HUNTER-->
        <div v-else-if="view=='hunters'" class="overlay card scrollable ml-3" style="z-index: 500; margin-top: calc(2rem + 38px)">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Hunting Radius</h6>
                <input type="range" class="custom-range" style="width:200px" id="customRange1">
            </div>
        </div>
    </div>

    <!--MODAL LAUNCH SITE-->
    <div class="modal fade" id="launchSiteModal" tabindex="-1" role="dialog" aria-labelledby="launchSiteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="launchSiteModalLabel">Add/Edit Launch Site</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="siteName">Name*</label>
                            <input type="text" class="form-control" id="siteName" required placeholder="e.g. 'Essen-Bredney'">
                        </div>
                        <div class="form-group">
                            <label for="siteOperator">Operator*</label>
                            <input type="text" class="form-control" id="siteOperator" required placeholder="e.g. 'Deutscher Wetterdienst'">
                        </div>
                        <div class="form-group">
                            <label for="siteOperator">WMO-ID</label>
                            <input type="text" class="form-control" id="siteWmoId" required placeholder="e.g. '10410'">
                        </div>
                        <div class="form-group">
                            <label for="siteLocation">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" id="siteLocationLat" required placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="siteLocationLon" required placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="siteAltASL">Elevation</label>
                            <input type="text" class="form-control" id="siteAltASL" placeholder="above sea level [m] e.g. '580'">
                        </div>
                        <!--LAUNCHES-->
                        <h4>Launch</h4>
                        <div class="form-group">
                            <label for="siteReport">Type</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="siteLaunchType" id="siteLaunchTypeOperational">
                                <label class="custom-control-label" for="siteLaunchTypeOperational">operational</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="siteLaunchType" id="siteLaunchTypeSporadic">
                                <label class="custom-control-label" for="siteLaunchTypeSporadic">sporadic</label>
                            </div>
                        </div>
                        <h5>Schedule</h5>

                        <div class="form-group">
                            <label for="siteFreqPrim">Primary Frequency</label>
                            <input type="text" class="form-control" id="siteFreqPrim" placeholder="e.g. '405.3'">
                        </div>
                        <div class="form-group">
                            <label for="siteFreqPrim">Secondary Frequencies</label>
                            <input type="text" class="form-control" id="siteFreqPrim" placeholder="e.g. '405.3'">
                            <button class="btn btn-success">+</button>
                            <button class="btn btn-danger">-</button>
                        </div>
                        <h5>Sonde</h5>

                        <div class="form-group">
                            <label for="siteLaunchBallon">Ballon</label>
                            <select id="siteLaunchBallon" class="form-control">
                                <option>red, 100g</option>
                                <option>white, 600g</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siteLaunchGas">Gas</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="siteLaunchGas" id="siteLaunchGasHydrogen">
                                <label class="custom-control-label" for="siteLaunchGasHydrogen">hydrogen</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="siteLaunchGas" id="siteLaunchGasHelium">
                                <label class="custom-control-label" for="siteLaunchGasHelium">helium</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="siteLaunch>Parachute">Parachute</label>
                            <select id="siteLaunch>Parachute" class="form-control">
                                <option>white, 60cm, inside ballon</option>
                                <option>white, 40cm, inside ballon</option>
                                <option>none</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siteAnnotations">Annotations</label>
                            <input type="text" class="form-control" id="siteAnnotations" placeholder="e.g. 'sporadic additional launches at 06Z/18Z'">
                        </div>

                        <div class="form-group">
                            <label for="siteEMail">Your E-Mail*</label>
                            <input type="email" class="form-control" id="siteEMail" required placeholder="E-Mail Address">
                            <small id="siteEMailHelp" class="form-text text-muted">Your E-Mail is only used to sent you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="siteComment">Your Comment</label>
                            <textarea class="form-control" id="siteComment" rows="3" placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="siteCommentHelp" class="form-text text-muted">Comments are only sent to the administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Propose Addition/Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL RECEIVE STATION-->
    <div class="modal fade" id="receiveStationModal" tabindex="-1" role="dialog" aria-labelledby="receiveStationModalLabel" aria-hidden="true">
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
                            <label for="siteName">Name*</label>
                            <input v-model="receive_station.name" type="text" class="form-control" id="siteName" required placeholder="e.g. 'DB4ZJO-11'">
                        </div>
                        <div class="form-group">
                            <label for="siteOperator">Operator*</label>
                            <input v-model="receive_station.operator" type="text" class="form-control" id="siteOperator" required placeholder="e.g. 'DB4ZJO'">
                        </div>
                        <div class="form-group">
                            <label for="siteLocation">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input v-model="receive_station.lat" type="text" class="form-control" id="siteLocationLat" required placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input v-model="receive_station.long" type="text" class="form-control" id="siteLocationLon" required placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="siteAltASL">Elevation</label>
                            <input v-model="receive_station.elevation" type="text" class="form-control" id="siteAltASL" placeholder="above sea level [m] e.g. '580'">
                        </div>
                        <div class="form-group">
                            <label for="siteAltAGL">Antenna Height</label>
                            <input v-model="receive_station.antenna_height" type="text" class="form-control" id="siteAltAGL" placeholder="above ground level [m] e.g. '34'">
                        </div>
                        <div class="form-group">
                            <label for="siteAntenna">Antenna Type</label>
                            <input v-model="receive_station.antenna_type" type="text" class="form-control" id="siteAntenna" placeholder="e.g. 'Diamond X30'">
                        </div>
                        <div class="form-group">
                            <label for="siteProcessingSystem">Processing System Type</label>
                            <input v-model="receive_station.processing_system_type" type="text" class="form-control" id="siteProcessingSystem" placeholder="e.g. 'Raspberry Pi 4 4GB + 3 NESDR Smart'">
                        </div>
                        <div class="form-group">
                            <label for="siteConcurrentReceivers">Number of concurrent Receivers</label>
                            <input v-model="receive_station.concurrent_receivers" type="text" class="form-control" id="siteConcurrentReceivers" placeholder="e.g. '24'">
                        </div>
                        <div class="form-group">
                            <label for="siteReport">Reporting to</label>
                            <select v-model="receive_station.reporting_to" class="selectpicker form-control" multiple data-live-search="true">
                                <option>aprs.fi</option>
                                <option>sondehub.org</option>
                                <option>radiosondy.info</option>
                                <option>wetterson.de</option>
                                <option>proprietary site</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siteEMail">Your E-Mail*</label>
                            <input v-model="proposal.email" type="email" class="form-control" id="siteEMail" required placeholder="E-Mail Address">
                            <small id="siteEMailHelp" class="form-text text-muted">Your E-Mail is only used to sent you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="siteComment">Your Comment</label>
                            <textarea v-model="proposal.comment" class="form-control" id="siteComment" rows="3" placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="siteCommentHelp" class="form-text text-muted">Comments are only sent to the administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-on:click="proposeReceiveStation()" type="button" class="btn btn-success">Propose Addition/Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL HUNTER-->
    <div class="modal fade" id="hunterModal" tabindex="-1" role="dialog" aria-labelledby="hunterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hunterModalLabel">Add/Edit Hunter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="proposeReceiveStation()" ref="receive_station_proposal">
                        <div class="form-group">
                            <label for="siteName">Name*</label>
                            <input v-model="receive_station.name" type="text" class="form-control" id="siteName" required placeholder="e.g. 'DB4ZJO-11'">
                        </div>
                        <div class="form-group">
                            <label for="siteOperator">Operator*</label>
                            <input v-model="receive_station.operator" type="text" class="form-control" id="siteOperator" required placeholder="e.g. 'DB4ZJO'">
                        </div>
                        <div class="form-group">
                            <label for="siteLocation">Location*</label>
                            <div class="row">
                                <div class="col">
                                    <input v-model="receive_station.lat" type="number" class="form-control" id="siteLocationLat" required placeholder="Latitude e.g. '51.1234'">
                                </div>
                                <div class="col">
                                    <input v-model="receive_station.long" type="number" class="form-control" id="siteLocationLon" required placeholder="Longitude e.g. '7.5678'">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="siteAltASL">Elevation</label>
                            <input v-model="receive_station.elevation" type="number" class="form-control" id="siteAltASL" placeholder="above sea level [m] e.g. '580'">
                        </div>
                        <div class="form-group">
                            <label for="siteAltAGL">Antenna Height</label>
                            <input v-model="receive_station.antenna_height" type="number" class="form-control" id="siteAltAGL" placeholder="above ground level [m] e.g. '34'">
                        </div>
                        <div class="form-group">
                            <label for="siteAntenna">Antenna Type</label>
                            <input v-model="receive_station.antenna_type" type="text" class="form-control" id="siteAntenna" placeholder="e.g. 'Diamond X30'">
                        </div>
                        <div class="form-group">
                            <label for="siteProcessingSystem">Processing System Type</label>
                            <input v-model="receive_station.processing_system_type" type="text" class="form-control" id="siteProcessingSystem" placeholder="e.g. 'Raspberry Pi 4 4GB + 3 NESDR Smart'">
                        </div>
                        <div class="form-group">
                            <label for="siteConcurrentReceivers">Number of concurrent Receivers</label>
                            <input v-model="receive_station.concurrent_receivers" type="number" class="form-control" id="siteConcurrentReceivers" placeholder="e.g. '24'">
                        </div>
                        <div class="form-group">
                            <label for="siteReport">Reporting to</label>
                            <select v-model="receive_station.reporting_to" class="selectpicker form-control" multiple data-live-search="true">
                                <option>aprs.fi</option>
                                <option>sondehub.org</option>
                                <option>radiosondy.info</option>
                                <option>wetterson.de</option>
                                <option>proprietary site</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="siteEMail">Your E-Mail*</label>
                            <input v-model="proposal.email" type="email" class="form-control" id="siteEMail" required placeholder="E-Mail Address">
                            <small id="siteEMailHelp" class="form-text text-muted">Your E-Mail is only used to sent you information whether your proposal was accepted</small>
                        </div>
                        <div class="form-group">
                            <label for="siteComment">Your Comment</label>
                            <textarea v-model="proposal.comment" class="form-control" id="siteComment" rows="3" placeholder="Additional Information or Sources; Proof of consent if you are not signing up yourself!"></textarea>
                            <small id="siteCommentHelp" class="form-text text-muted">Comments are only sent to the administrator who reviews your request</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-on:click="proposeReceiveStation()" type="button" class="btn btn-success">Propose Addition/Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
<script type="text/javascript">
  window.api_url="{{env('APP_URL')}}/api";
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
