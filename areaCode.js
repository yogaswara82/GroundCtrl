/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function areaCode(lat,lon,callback) {
    var counties = $.ajax({
        url: "area/map.geojson",
        dataType: "json",
        // success: console.log("load"),
        error: function (xhr) {
            alert(xhr.statusText);
        }
    });

    $.when(counties).done(function () {
        
        //var durl = document.getElementById("url").value;
        // Add requested external GeoJSON to map
        var gjLayer = L.geoJson(counties.responseJSON);
        // check point inside feature if true returns result as array of the polygon of the point
        var latlng = new L.latLng(lat, lon);
        var results = leafletPip.pointInLayer(latlng, gjLayer);
        //console.log(results);
        if (isEmpty(results)) {
            //console.log('not in polygon');
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
            //console.log(codearea);
            //document.getElementById("kode").value = codearea;

            // myFunction();
            // var url = 'http://maritim.bmkg.go.id/xml/wilayah_pelayanan/prakiraan?kode=' + codearea + '&format=json';
            
//            var url = 'http://localhost/AzureLane/weatherground.php?kode=' + codearea;
//            $(document).ready(function () {
//                $.getJSON(url, function (result) {
//                    var data = JSON.stringify(result);
//                    window.parent.postMessage(data, durl);
//                });
//            });
            return callback(codearea);
            }
            
    });
    
}

            
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


