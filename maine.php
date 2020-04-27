<!DOCTYPE html>
<html>
    <head>
        <title>Web GIS simple</title>
        <!--<script type="text/javascript" src="js/googlemap.js"></script>-->
        <script src="js/jquery.min.js"></script>
        <meta http-equiv="refresh" content="" >
        <style type="text/css">
            .container {
                height: 442px;
            }
            #map {
                width: 100%;
                height: 100%;
                border: 1px solid blue;
            }
            #data, #allData {
                display: none;
            }


            }
        </style>
    </head>


    <body style="background-color: #000;">
        <div class="container">


            <?php
            $con = mysqli_connect('localhost', 'root', 'raspberry', 'bismillahwebgis');
            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($con, 'SELECT * FROM uny');
            $maps = array();
            while ($row = mysqli_fetch_array($result)) {
                $maps[] = $row;
            }
            ?>			


            <div id="map"></div>

        </div>
    </body>

    <script type="text/javascript">
        //var locations = JSON.parse('<?php echo json_encode($maps) ?>');
        var id = 3;


        function initMap()
        {
            var loc = JSON.parse('<?php echo json_encode($maps) ?>');
            //untuk display lingkaran
            var citymap = {
                Yogyakarta: {
                    //center: {lat: 110.407, lng: -7.777},	
                    //center: {lat: -7.777, lng: 110.407},
                    center: new google.maps.LatLng(loc[id - 1].lat, loc[id - 1].long),
                    population: 1800
                }
            };

            var map = new google.maps.Map(document.getElementById('map'),
                    {
                        zoom: 13,
                        scrollwheel: false,
                        center: new google.maps.LatLng(loc[id - 1].lat, loc[id - 1].long),
                        //center: {lat: 110.407, lng: -7.777},
                        //center: {lat: -7.777, lng: 110.407},
                        mapTypeId: 'terrain'
                                //mapTypeId: google.maps.MapTypeId.ROADMAP
                    });



            // center: {lat: 37.090, lng: -95.712},



            //untuk display lingkaran
            for (var city in citymap) {
                // Add the circle for this city to the map.
                var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.11,
                    map: map,
                    center: citymap[city].center,
                    radius: Math.sqrt(citymap[city].population) * 100
                });
            }


            var infowindow = new google.maps.InfoWindow();

            $(document).ready(function ()
            {
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
                                //info terbaru
                                //document.getElementById("demo").innerHTML = locations[0].message;  //id ATC default 0

                                var marker, i;


                                for (i = 0; i < locations.length; i++)
                                {


                                    marker = new google.maps.Marker({
                                        position: new google.maps.LatLng(locations[i].lat, locations[i].long),
                                        map: map

                                    });

                                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                        return function () {

                                            infowindow.setContent(locations[i].id + '<br>' + locations[i].name + '<br>' + locations[i].type + '<br>' + locations[i].lat + ',' + locations[i].long);
                                            infowindow.open(map, marker);
                                        }
                                    })(marker, i));


                                }


                                /////////////////////////////////////////////////	   
                            }
                        });
            }


        }







    </script>


    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAELuqtE6zJbqaAfaQdJYDnLc72LbDrhvI&callback=initMap">

    </script>



</html>
