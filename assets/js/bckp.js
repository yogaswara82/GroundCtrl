var center = false;
var counties = $.ajax({
    url: "area/map.geojson",
    dataType: "json",
    success: console.log("County data successfully loaded."),
    error: function (xhr) {
        alert(xhr.statusText)
    }
})

//var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
//var osmAttrib = 'Map data © <a href="http://osm.org/copyright">OpenStreetMap</a> contributors';
//var osm = new L.TileLayer(osmUrl, {
//    attribution: osmAttrib,
//    detectRetina: true
//});
// please replace this with your own mapbox token!
var token = 'pk.eyJ1IjoiZG9tb3JpdHoiLCJhIjoiY2o0OHZuY3MwMGo1cTMybGM4MTFrM2dxbCJ9.yCQe43DMRqobazKewlhi9w';
var mapboxUrl = 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}@2x?access_token=' + token;
var mapboxAttrib = 'Map data © <a href="http://osm.org/copyright">OpenStreetMap</a> contributors. Tiles from <a href="https://www.mapbox.com">Mapbox</a>.';
var mapbox = new L.TileLayer(mapboxUrl, {
    attribution: mapboxAttrib,
    tileSize: 512,
    zoomOffset: -1
});
var map = new L.Map('map', {
    layers: [mapbox],
    zoom: 5,
    center: {lat: -5.087470, lng: 117.670192},
    zoomControl: true
});
$.when(counties).done(function () {
// Add requested external GeoJSON to map
    console.log(counties.responseJSON);
    var oke = L.geoJSON(counties.responseJSON).addTo(map);
    L.geoJson(counties.responseJSON, {
        onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.name);
            //var poly = turf.polygon([feature.geometry.coordinates]);


        }
    }).addTo(map);
});
console.log('Area Draw');
// var ls = L.control.locate({
//     flyTo: true,
//     watch: true,
//     setView: 'always',
//     drawCircle: true,
//     markerClass: L.circleMarker,
//     showCompass: true,
//     strings: {
//         title: "Locate"
//     },
//     locateOptions: {
//         enableHighAccuracy: true
//     }
// }).addTo(map);

//var tinnedGps = { lat: 52.5, lng: -2.0 };
// //map.addControl( new L.Control.Gps( 
//     { transform: function(realGps) ({ return tinnedGps; } 

//     ) ));
// map.addControl( new L.Control.Gps({
//     transform : function(realGps){
//         return tinnedGps;
//     }
// }) );
var marker = null;
var oe = function onLocationFound(e) {
    var options = {
        radius: 8,
        weight: 1,
        //opacity: 1,
        fillOpacity: 0.8,
        color: 'blue'
    };
    if (marker !== null) {
        map.removeLayer(marker);
    }
    marker = L.circleMarker(e.latlng, options).addTo(map);
    //L.circle(e.latlng, radius).addTo(map);
    console.log('location found');
    var pointXY = map.latLngToLayerPoint(e.latlng);
    console.log("Point in x,y space: " + pointXY);
    // convert to lat/lng space
    var pointlatlng = map.layerPointToLatLng(pointXY);
    // why doesn't this match e.latlng?
    console.log("Point in lat,lng space: " + pointlatlng);
    // check if location inside the feature
    $.when(counties).done(function () {
        // Add requested external GeoJSON to map
        var gjLayer = L.geoJson(counties.responseJSON);
        // check point inside feature if true returns result as array of the polygon of the point
        var results = leafletPip.pointInLayer(pointlatlng, gjLayer);
        if (isEmpty(results)) {
            console.log('not in polygon');
        } else
        {
            //console.log(results);
            console.log(results.shift().feature.properties.name);
        }
        if (center){
            map.setView([e.latlng.lat, e.latlng.lng], 16);
        }
    });
}
var successFunction = function (data) {
    /* do something here */
    var locations = data;
    var latlng1 = new L.latLng(locations[id - 1].lat, locations[id - 1].lon);
    
    console.log(latlng1);
  
    oe({latlng: latlng1});
}
//map.on('locationfound', onLocationFound);
var id = 2;
$(document).ready(function ()
{
    console.log('oi');
    setInterval(ajaxcall, 2000);
});
function ajaxcall()
{
    $.ajax
            ({
                url: 'database.php',
                success: function (data)
                { //////////////////////////////////////

                    var locations = JSON.parse(data);
                    successFunction(locations);
                },
                error: function (req, err) {
                    console.log('my message' + err)
                }
            });
}



map.locate({watch: true, maxZoom: 16, enableHighAccuracy: true});
map.on("contextmenu", function (event) {
    console.log("user right-clicked on map coordinates: " + event.latlng.toString());
    var a = L.marker(event.latlng).addTo(map);
    var x = event.layerPoint.x;
    var y = event.layerPoint.y;
    //var pt = turf.point([-77, 44]);
    var pt = turf.point([x, y]);
    console.log([x, y]);
    var features = [];
    $.when(counties).done(function () {
        // Add requested external GeoJSON to map
        var gjLayer = L.geoJson(counties.responseJSON, {
            onEachFeature: function (feature, layer) {

                features.push(feature);
            }
        });
        // check point inside feature if true returns result as array of the polygon of the point
        var results = leafletPip.pointInLayer(event.latlng, gjLayer);
        if (isEmpty(results)) {
            console.log('not in polygon');
        } else
        {
            //console.log(results);
            a = results.shift();
            code = a.feature.properties.name;
            //console.log(a);

            //neighbor
            //var index = leafletKnn(gjLayer);
            // var nearest = index.nearest(event.latlng, 5);
            //console.log(nearest);
            var codearea = matchAreaToJson(code); //return i.e : A.1 into A.01;
            console.log(codearea);
            //var url = 'http://maritim.bmkg.go.id/xml/wilayah_pelayanan/prakiraan?kode=' + codearea + '&format=json';
            var url = 'http://localhost/AzureLane/weatherground.php?kode='+codearea;
            $(document).ready(function () {
                $.getJSON(url, function (result) {
                    console.log(result);
                });
            });
        }
    });
});
function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}


function matchAreaToJson(str) {
    var arrcode = str.split('.');
    var codenum = parseInt(arrcode[1]);
    return arrcode[0] + '.' + pad(codenum);
}

function pad(n) {
    if (n < 10) {
        return '0' + n;
    } else
        return n;
}

function matchJsonToArea(str) {
    var arrcode = str.split('.');
    var codenum = parseInt(arrcode[1]);
    return arrcode[0] + '.' + codenum;
}


var animatedToggle = L.easyButton({
    id: 'animated-marker-toggle',
    type: 'animate',
    states: [{
            stateName: 'add-markers',
            icon: 'glyphicon glyphicon-map-marker',
            title: 'center',
            onClick: function (control) {
                center = true;
                console.log('Centering Map : ' + center);
                control.state('remove-markers');
            }
        }, {
            stateName: 'remove-markers',
            icon: 'glyphicon glyphicon-map-marker',
            title: 'free',
            onClick: function (control) {
                center = false;
                console.log('Centering Map : ' + center);
                control.state('add-markers');
            }
        }]
});
animatedToggle.addTo(map);
//http://danielmontague.com/projects/easyButton.js/v1/examples/