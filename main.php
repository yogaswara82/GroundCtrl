<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>A simple map</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css">
    <link href="assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/leaflet/leaflet.css" />
    <link rel="stylesheet" href="assets/css/leaflet-gps.css" />
    <link rel="stylesheet" href="assets/css/easy-button.css" />
    <link rel="stylesheet" href="assets/css/L.Control.Locate.min.css" />
    <link href="assets/css/L.Control.Locate.mapbox.css" rel="stylesheet"/>
    <link href="assets/css/L.Control.Locate.css" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
    <link type="text/css" rel="stylesheet" href="mapbox.css" />
    
    <style>
        html, body, #map {
            height: 100%;
            margin: 0px;
            z-index:0;
        }
        #controls {
            position: absolute;
            left: 54px;
            top: 11px;
            z-index: 1;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 1px 7px rgba(0,0,0,0.65);
            padding: 6px;
        }

        #controls button {
            border-radius: 5px;

        }

        #date {
            width: 5em;
        }

        #transparent-container {
            margin-top: 4px;
        }

        .ui-widget {
            font-size: 0.8em;
        }

        .ui-datepicker { 
            margin-left: -77px;
        }

        .state-remove-markers,
        .state-add-markers{
            transition-duration: .5s;
            transform: scaleY(0);
            position: absolute;
            display: block;
            top: 0;
            width: 100%;}

            .state-remove-markers{
                transform-origin: 50% 0; }
                .state-add-markers{
                    transform-origin: 50% 100%; }

                    .state-remove-markers.remove-markers-active{
                        transform: scaleY(1); }

                        .state-add-markers.add-markers-active{
                            transform: scaleY(1); }
                        </style>
                    </head>

                    <body>
                      <div id="controls">
                        <button id="prev">Kemarin</button>
                        <input id="date">
                        <button id="next">Besok</button>
                        <!-- pengujian kloro -->
                        <div id="transparent-container">
                            <label>
                                <input id="Lat" type="text">
                                <input id="Lon" type="text"> 
                            </label>
                            <button onclick="cek()">Cari Koordinat</button>
                        </div>
                        
                    </div>
                    <div id="map"></div>
                    <script src="assets/js/mapbox.js"></script>
                    <script src="assets/js/event.js"></script>
                    <script src="assets/js/storage.js"></script>
                    <script src="assets/js/map.js"></script>
                    <script src="assets/js/run.js"></script>
                    <script src="assets/leaflet/leaflet.js"></script>
                    <script src="assets/leaflet/leaflet-src.js"></script>
                    <script src="assets/js/easy-button.js"></script>
                    <script src="assets/js/L.Control.Locate.js" ></script>
                    <script src="assets/js/turf.min.js"></script>
                    <script src="assets/js/leaflet-pip.js"></script>
                    <script src="assets/js/leaflet-knn.min.js"></script>
                    <script src="assets/js/leaflet-gps.js"></script>
                    <script src="assets/js/jquery.min.js"></script>
                    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
                    <script src="assets/js/bootstrap.min.js"></script>
                    <script src="areaCode.js"></script>
                    <script type="text/javascript" src="assets/js/GIBSLayer.js"></script>
                    <script src="assets/js/GIBSMetadata.js"></script>
                    <script src="assets/js/leaflet-tilelayer-colorpicker.js"></script>
                    <script type="text/javascript" src="assets/js/leaflet-hash.js"></script>
                    <script type="text/javascript" src="assets/js/main.js?newversion"></script>






                </body>

                </html>