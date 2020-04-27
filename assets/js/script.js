var counties = $.ajax({
    url: "area/map.geojson",
    dataType: "json",
    success: console.log("County data successfully loaded."),
    error: function (xhr) {
        alert(xhr.statusText)
    }
})
//var map = L.map('map', {
//    zoom: 5,
//    center: {lat: -5.087470, lng: 117.670192},
//    streetViewControl: false,
//    fullscreenControl: false,
//    mapTypeControl: false,
//    // scrollwheel: false,
//});
//var basemap = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
//    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
//}).addTo(map);

var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var osmAttrib = 'Map data © <a href="http://osm.org/copyright">OpenStreetMap</a> contributors';
var osm = new L.TileLayer(osmUrl, {
    attribution: osmAttrib,
    detectRetina: true
});

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
    var oke = L.geoJSON(counties.responseJSON).addTo(map);
});
console.log('Area Draw');

var ls = L.control.locate({
    flyTo:true,
    watch:true,
    setView: 'always',
    drawCircle: true,
    markerClass: L.circleMarker,
    showCompass: true,
    strings: {
        title: "Locate"
    },
    locateOptions: {
        enableHighAccuracy: true
    }
    
}).addTo(map);
function onLocationFound(e) {
    var radius = e.accuracy / 2;
    //L.marker(e.latlng).addTo(map).bindPopup("You are within " + radius + " meters from this point").openPopup();
    //L.circle(e.latlng, radius).addTo(map);
//    console.log('location found');
//    var x = e.layerPoint.x;
//    var y = e.layerPoint.y;
//    console.log([x, y]);
   var pointXY = map.latLngToLayerPoint(e.latlng);
    console.log("Point in x,y space: " + pointXY);
//
// convert to lat/lng space
   var pointlatlng = map.layerPointToLatLng(pointXY);
    // why doesn't this match e.latlng?
    console.log("Point in lat,lng space: " + pointlatlng);
}
map.on('locationfound', onLocationFound);
//map.locate({setView: true, watch: true, maxZoom: 16});

map.on("contextmenu", function (event) {
    console.log("user right-clicked on map coordinates: " + event.latlng.toString());
    var a = L.marker(event.latlng).addTo(map);
    var x = event.layerPoint.x;
    var y = event.layerPoint.y;
    //var pt = turf.point([-77, 44]);
    var pt = turf.point([x, y]);
    var poly = turf.polygon([[
            [-81, 41],
            [-81, 47],
            [-72, 47],
            [-72, 41],
            [-81, 41]
        ]]);
    console.log([x, y]);
    var pointXY = L.point(x, y);
    console.log("Point in x,y space: " + pointXY);

    // convert to lat/lng space
    var pointlatlng = map.layerPointToLatLng(pointXY);
    // why doesn't this match e.latlng?
    console.log("Point in lat,lng space: " + pointlatlng);

    console.log(turf.booleanPointInPolygon(pt, poly).toString())
    if (turf.booleanPointInPolygon(pt, poly)) {
        console.log('ok');
    } else
    {
        console.log('nope');
    }
});
var context = d3.select('#map canvas')
  .node()
  .getContext('2d');
function update() {
  context.clearRect(0, 0, 800, 400);

 counties.features.forEach(function(d) {
    context.beginPath();
    context.fillStyle = state.clickedLocation && d3.geoContains(d, state.clickedLocation) ? 'red' : '#aaa';
    geoGenerator(d);
    context.fill();
  })
}