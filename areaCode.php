   
<style>
    display:none
</style>
<form id="myForm" method="post" >
    <input hidden type="text" value="<?= $_GET['lat'] ?>" id="lat">
    <input hidden type="text" value="<?= $_GET['lon'] ?>" id="lon">
    <input hidden type="text" value="<?= $_GET['url'] ?>" id="url">
    <input hidden type="text" value="" id="kode" name="kode">
    <input hidden type="button"  value="Submit form">
</form>

<pre id="json"></pre>

<script src="leaflet/leaflet.js"></script>
<script src="leaflet/leaflet-src.js"></script>
<script src="assets/js/easy-button.js"></script>

<script src="assets/js/turf.min.js"></script>
<script src="assets/js/leaflet-pip.js"></script>
<script src="assets/js/leaflet-knn.min.js"></script>

<script src="assets/js/jquery.min.js"></script>

<script>

   
   


        var counties = $.ajax({
            url: "area/map.geojson",
            dataType: "json",
           // success: console.log("load"),
            error: function (xhr) {
                alert(xhr.statusText);
            }
        });

        $.when(counties).done(function () {
            var lat = document.getElementById("lat").value;
            var lon = document.getElementById("lon").value;
            var durl = document.getElementById("url").value;
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
                var url = 'http://localhost/AzureLane/weatherground.php?kode=' + codearea;
                $(document).ready(function () {
                    $.getJSON(url, function (result) {
                        //document.getElementById("json").innerHTML = JSON.stringify(result, undefined, 2);
                        document.getElementById("json").innerHTML = array2json(result);
                        //window.data=array2json(result);
                        var data = JSON.stringify(result);
                        window.parent.postMessage(data, durl);
                    });
                });

                function array2json(arr) {
                    var parts = [];
                    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

                    for (var key in arr) {
                        var value = arr[key];
                        if (typeof value == "object") { //Custom handling for arrays
                            if (is_list)
                                parts.push(array2json(value)); /* :RECURSION: */
                            else
                                parts.push('"' + key + '":' + array2json(value)); /* :RECURSION: */
                            //else parts[key] = array2json(value); /* :RECURSION: */

                        } else {
                            var str = "";
                            if (!is_list)
                                str = '"' + key + '":';

                            //Custom handling for multiple data types
                            if (typeof value == "number")
                                str += value; //Numbers
                            else if (value === false)
                                str += 'false'; //The booleans
                            else if (value === true)
                                str += 'true';
                            else
                                str += '"' + value + '"'; //All other things
                            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

                            parts.push(str);
                        }
                    }
                    var json = parts.join(",");

                    if (is_list)
                        return '[' + json + ']';//Return numerical JSON
                    return '{' + json + '}';//Return associative JSON
                }

//                        var xhr = new XMLHttpRequest();
//                        var url = 'http://localhost/AzureLane/weatherground.php?kode=' + codearea;
//                        xhr.open("GET", url, true);
//                        xhr.setRequestHeader("Content-Type", "application/json");
//                        xhr.onreadystatechange = function () {
//                            if (xhr.readyState === 4 && xhr.status === 200) {
//                                var json = JSON.parse(xhr.responseText);
//                                console.log(json);
//                                Response.Write(json);
//                            }
//                        };
//                        xhr.send();


            }
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



    

</script>


