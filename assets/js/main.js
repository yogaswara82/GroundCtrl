//BENERIN UPDATE KLORO

var wet=false;    
var cuk = false;
var temp;
var DATE_FORMAT = 'dd.mm.yy';

function s2(num) { return num < 10 ? '0' + num : num; }

var strToDateUTC = function(str) {
  var date = $.datepicker.parseDate(DATE_FORMAT, str);
  return new Date(date - date.getTimezoneOffset()*60*1000);
}
var $date = $('#date');



var now = new Date();
now.setDate(now.getDate());
        var oneDay = 1000*60*60*24, // milliseconds in one day
        startTimestamp = now.getTime()
        startDate = new Date(startTimestamp);
        console.log(startDate);
        $date.val($.datepicker.formatDate(DATE_FORMAT, startDate));
        var token = 'pk.eyJ1IjoieW9nYXN3YXJhODIiLCJhIjoiY2s5aXF6Z2U5MDVjaTNndnkwOGhlajh0YiJ9.8B8Ljfp2nMoY0cpD-2DoEg';
        var mapboxUrl = 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}@2x?access_token=' + token;

        var mapboxAttrib = 'Map data © <a href="http://osm.org/copyright">OpenStreetMap</a> contributors. Tiles from <a href="https://www.mapbox.com">Mapbox</a>. ';
        var mapbox = new L.TileLayer(mapboxUrl, {
          attribution: mapboxAttrib,
          tileSize: 512,
          zoomOffset: -1,

          
        });

        var alterDate = function(delta) {
          var date = $.datepicker.parseDate(DATE_FORMAT, $date.val());

          $date
          .val($.datepicker.formatDate(DATE_FORMAT, new Date(date.valueOf() + delta * oneDay)))
          .change();
        }

        document.getElementById("prev").onclick = alterDate.bind(null, -1);
        document.getElementById("next").onclick = alterDate.bind(null, 1);


        var map = new L.Map('map', {
          layers: [mapbox],
          zoom: 7,
          minZoom:7,
          center: {lat: -7.395153, lng: 109.544678},
          zoomControl: true
        });

        var terra = new L.GIBSLayer('MODIS_Terra_Chlorophyll_A', {
          date: startDate,
          transparent: true,

        }).addTo(map);

        var aqua = new L.GIBSLayer('MODIS_Aqua_Chlorophyll_A', {
          date: startDate,
          transparent: true,

        }).addTo(map);

        var aquacolorpicker = L.tileLayer.colorPicker('http://gibs.earthdata.nasa.gov/wmts/epsg3857/best/MODIS_Aqua_Chlorophyll_A/default/'+startDate.getUTCFullYear() + '-' + s2(startDate.getUTCMonth() + 1) + '-' + s2(startDate.getUTCDate()+1)+'/GoogleMapsCompatible_Level7/{z}/{y}/{x}.png',{attribution : '<a href="https://earthdata.nasa.gov/gibs">NASA EOSDIS GIBS</a>' }).addTo(map);
        var tcolorpicker = L.tileLayer.colorPicker('http://gibs.earthdata.nasa.gov/wmts/epsg3857/best/MODIS_Terra_Chlorophyll_A/default/'+startDate.getUTCFullYear() + '-' + s2(startDate.getUTCMonth() + 1) + '-' + s2(startDate.getUTCDate()+1)+'/GoogleMapsCompatible_Level7/{z}/{y}/{x}.png',{attribution : '<a href="https://earthdata.nasa.gov/gibs">NASA EOSDIS GIBS</a>'}).addTo(map);

        
        $date.datepicker({
          dateFormat: DATE_FORMAT
        }).change(function() {
          var date = strToDateUTC(this.value);
          map.removeLayer(aquacolorpicker);
          map.removeLayer(tcolorpicker);
          map.removeLayer(aqua);
          map.removeLayer(terra);
          aquacolorpicker = L.tileLayer.colorPicker('http://gibs.earthdata.nasa.gov/wmts/epsg3857/best/MODIS_Aqua_Chlorophyll_A/default/'+date.getUTCFullYear() + '-' + s2(date.getUTCMonth()+1 ) + '-' + s2(date.getUTCDate())+'/GoogleMapsCompatible_Level7/{z}/{y}/{x}.png',{attribution : '<a href="https://earthdata.nasa.gov/gibs">NASA EOSDIS GIBS</a>' }).addTo(map);
          tcolorpicker = L.tileLayer.colorPicker('http://gibs.earthdata.nasa.gov/wmts/epsg3857/best/MODIS_Terra_Chlorophyll_A/default/'+date.getUTCFullYear() + '-' + s2(date.getUTCMonth()+1 ) + '-' + s2(date.getUTCDate())+'/GoogleMapsCompatible_Level7/{z}/{y}/{x}.png',{attribution : '<a href="https://earthdata.nasa.gov/gibs">NASA EOSDIS GIBS</a>'}).addTo(map);

          console.log(date);
        });

       

        // var layers = L.layerGroup([terra,aqua]);
        // var overLayer = {
        //   'Chlorophyll': layers

        // };

        var baseMaps = {
          "Mapbox" : mapbox
        }



        


        L.control.layers(baseMaps).addTo(map);

        map.on("mousemove", function(event) {
          var b = tcolorpicker.getColor(event.latlng);
          var a = aquacolorpicker.getColor(event.latlng);

          var h = null;
          var hsv;
          if (a !== null && b!==null){
            h=1;
            var haqua = rgb2hsv(a[0],a[1],a[2]);
            var hterra = rgb2hsv(b[0],b[1],b[2]);
            if (haqua['h'] == 0){
              hsv = hterra['h'];
            }
            else if(hterra['h']==0)
            {
              hsv = haqua['h'];
            }
            else
            {
              
              hsv = Math.max(haqua['h'],hterra['h']);
              if (hsv>220) {
                hsv = Math.min(haqua['h'],hterra['h'])
              }
            }
          }
          // console.log(hterra["h"]);
          // console.log(haqua["h"]);
          //console.log(hsv);
          map.attributionControl.setPrefix(h==null ? "N/A" : 'H Aqua ' + haqua['h'] + ' H terra ' + hterra['h'] + ' H' + hsv);

        });

        var options = {
          radius: 8,
          weight: 1,
            //opacity: 1,
            fillOpacity: 0.8,
            color: 'blue'
          };

          var markers = {};

          function setMarkers(data) {
            data.data.forEach(function (obj) {
              if (!markers.hasOwnProperty(obj.id)) {
                console.log(obj.id);
                markers[obj.id] = new L.circleMarker([obj.lat, obj.lon],options).bindPopup(obj.id+"<br>"+obj.lat+","+obj.lon).addTo(map);
                markers[obj.id].previousLatLngs = [];
              } else {
                markers[obj.id].previousLatLngs.push(markers[obj.id].getLatLng());
                markers[obj.id].setLatLng([obj.lat, obj.lon]);
              }
            });
          }


          var target = {};

          function setTarget(data) {
           data.target.forEach(function (obj) {
            if (!target.hasOwnProperty(obj.id)) {
              console.log(obj.id);
              target[obj.id] = new L.Marker([obj.lat, obj.lon]).bindPopup(obj.id+"<br>"+obj.lat+","+obj.lon).addTo(map);
              target[obj.id].previousLatLngs = [];
            } else {
              target[obj.id].previousLatLngs.push(target[obj.id].getLatLng());
              target[obj.id].setLatLng([obj.lat, obj.lon]);
            }
          });
         }


         var successFunction = function (data) {

          /* do something here */

          temp = data;
          setMarkers(data);
          setTarget(data);
          updateKloro(data);
          if(!wet)
          {
            updateWeather(data);
            wet = true;
          }
          


        } 
        function exportToJsonFile(jsonData,name) {
          let dataStr = JSON.stringify(jsonData);
          let dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);

          let exportFileDefaultName = name;

          let linkElement = document.createElement('a');
          linkElement.setAttribute('href', dataUri);
          linkElement.setAttribute('download', exportFileDefaultName);
          linkElement.click();
        }
        var updateWeather = function () {
          var data = temp;
          var d = new Date();
          var n = d.getHours();
         // body...
         
         data.data.forEach(function (obj) {
          getWWO(obj.lat,obj.lon,function (response) {
           // console.log(response.data.weather[0].hourly[n]);
           var klorofil = getChloro(obj.lat,obj.lon); 
           var obj1 = {
            "id" : obj.id,
            "klorofil": klorofil,
            "lat" : obj.lat,
            "lon" : obj.lon
          }
          var obj2 = response.data.weather[0].hourly[n];
          var finalObj = $.extend(obj1, obj2);
          console.log(obj.id + ' cuaca');
          console.log(response);
          name = obj.id + ' cuaca.json'
          //exportToJsonFile(response,name)
          $.ajax({
            type: 'POST',
            url: 'updateWeather.php',
            data: {json: JSON.stringify(finalObj),mode :'cuaca'},
            dataType: 'json'
          });
        });
        });
        // console.log('cuaca ok');
        data.target.forEach(function (obj) {
          getWWO(obj.lat,obj.lon,function (response) {
           // console.log(response.data.weather[0].hourly[n]);
           var klorofil = getChloro(obj.lat,obj.lon); 
           var obj1 = {
            "id" : obj.id,
            "klorofil": klorofil,
            "lat" : obj.lat,
            "lon" : obj.lon
          }
          var obj2 = response.data.weather[0].hourly[n+1];
          var finalObj = $.extend(obj1, obj2);
          console.log(obj.id + ' target');
          console.log(response);
          name = obj.id + ' target.json'
          //exportToJsonFile(response,name)
          $.ajax({
            type: 'POST',
            url: 'updateWeather.php',
            data: {json: JSON.stringify(finalObj),mode :'target'},
            dataType: 'json'
          });
        });
        });
         //console.log('target ok');
       }

       function Timer(funct, delayMs, times)
       {
        if(times==undefined)
        {
          times=-1;
        }
        if(delayMs==undefined)
        {
          delayMs=10;
        }
        this.funct=funct;
        var times=times;
        var timesCount=0;
        var ticks = (delayMs/10)|0;
        var count=0;
        Timer.instances.push(this);

        this.tick = function()
        {
          if(count>=ticks)
          {
            this.funct();
            count=0;
            if(times>-1)
            {
              timesCount++;
              if(timesCount>=times)
              {
                this.stop();
              }
            }
          }
          count++; 
        };

        this.stop=function()
        {
          var index = Timer.instances.indexOf(this);
          Timer.instances.splice(index, 1);
        };
      }

      Timer.instances=[];

      Timer.ontick=function()
      {
        for(var i in Timer.instances)
        {
          Timer.instances[i].tick();
        }
      };

      window.setInterval(Timer.ontick, 10);

      $(document).ready(function ()
      { 

        var timer = new Timer(ajaxcall,10000,-1); // -1 untuk timer berkelanjutan, bisa diganti dg jumlah dilakukan  
        var timer = new Timer(updateWeather,1800000,-1); // -1 untuk timer berkelanjutan, bisa diganti dg jumlah dilakukan  

      });

      // $(window).load(function ()
      // { 
      //   //var timer = new Timer(updateWeather(temp),10000,-1); // -1 untuk timer berkelanjutan, bisa diganti dg jumlah dilakukan  
      //   setTimeout(new Timer(updateWeather(), 10000,-1), 20000);
      // });



      function ajaxcall()
      {
        $.ajax
        ({
          url: 'getCurrent.php',
          success: function (data)
                    { //////////////////////////////////////

                      var locations = JSON.parse(data);
                      temp = locations;
                      successFunction(locations);
                    },
                    error: function (req, err) {
                      console.log('my message' + err)
                    }
                  });
      }

      





      var markers = [];
      var targetlat = null;
      var targetlon = null;
      map.on("contextmenu", function (event) {
        console.log("user right-clicked on map coordinates: " + event.latlng.toString());
        if (markers.length > 0) {
          map.removeLayer(markers.pop());
        }
        var marker;
        marker = L.marker(event.latlng).addTo(map);
        markers.push(marker);

        var x = event.layerPoint.x;
        var y = event.layerPoint.y;
        //var pt = turf.point([-77, 44]);
        var pt = turf.point([x, y]);

        targetlat=event.latlng.lat;
        targetlon=event.latlng.lng;

       // getBMKG(event.latlng.lat,event.latlng.lng,function (response) {
       //  console.log(response);
       //   });

       hsv = getChloro(event.latlng.lat,event.latlng.lng);
       var finalObj = {
        "id" : 'AB',
        "lat" : targetlat,
        "lon" : targetlon
      }

      $.ajax({
        type: 'POST',
        url: 'target.php',
        data: {json: JSON.stringify(finalObj)},
        dataType: 'json'
      });

      $.ajax({
        type: 'POST',
        url: 'updateKloro.php',
        data: {klorofil: hsv,id: 'TEST'}
      });


      marker.on({
        click: function (e) {

         alert(hsv);
       }
     });

    //     getStromy(event.latlng.lat,event.latlng.lng,function (response) {
    //     console.log(response);
    // });
  });
      
      //pengujian kloro

      function cek() {
        console.log(document.getElementById("Lat").value);
        console.log(document.getElementById("Lon").value);
        tlat = document.getElementById("Lat").value;
        tlon = document.getElementById("Lon").value;
        date = document.getElementById("date").value;
        latlng = new L.latLng(tlat,tlon);
        map.setView(latlng, 7);
        hsv = getChloro(tlat,tlon);
        if (markers.length > 0) {
          map.removeLayer(markers.pop());
        }
        var marker;
        marker = L.marker(latlng).addTo(map);
        markers.push(marker);
        marker.on({
          click: function (e) {

           alert(hsv);
         }
       });

        $.ajax({
          type: 'POST',
          url: 'rekap.php',
          data: {kloro :hsv, lat :tlat, lon:tlon, date: date},
        });

        
      }

      function getChloro (lat,lon,callback){
        var latlon = new L.latLng(lat, lon);
        var b = tcolorpicker.getColor(latlon);
        var a = aquacolorpicker.getColor(latlon);

        var h = null;
        var hsv;
        if (a !== null && b!==null){
          h=1;
          var haqua = rgb2hsv(a[0],a[1],a[2]);
          var hterra = rgb2hsv(b[0],b[1],b[2]);
          if (haqua['h'] == 0){
            hsv = hterra['h'];
          }
          else if(hterra['h']==0)
          {
            hsv = haqua['h'];
          }
          else
          {
            hsv = Math.max(haqua['h'],hterra['h']);
            if (hsv>220) {
              hsv = Math.min(haqua['h'],hterra['h'])
            }
          }
        }
        return hsv;
      }


      function updateKloro(data) {
        data.target.forEach(function (obj) {
          var klorofil = getChloro(obj.lat,obj.lon);
          console.log('target : '+klorofil);
          $.ajax({
            type: 'POST',
            url: 'updateKloro.php',
            data: {klorofil: klorofil,id: obj.id,mode: 'target'}
          });
        });
        data.data.forEach(function (obj) {
          var klorofil = getChloro(obj.lat,obj.lon); 
          console.log('loc : '+klorofil);
          $.ajax({
            type: 'POST',
            url: 'updateKloro.php',
            data: {klorofil: klorofil,id: obj.id,mode:'loc'}
          });
        });
      }





      function getBMKG(lat,lon,callback) {
       var url = 'http://localhost/GroundCtrl/areaCode.php?lat=' + lat + '&lon=' + lon+'&url='+window.location.href ;
       $('#dummy').attr('src',url);

       $(window).on('message',function(e){
         var message = JSON.parse(e.originalEvent.data);
           //console.log(message[0]);
           return callback(message);
           
         });
     };

     function getWWO (lat,lon,callback){
      var url = 'http://api.worldweatheronline.com/premium/v1/marine.ashx?key=896fdb89d42247e5a8e190752201706&format=json&tp=1&q='+lat+','+lon;

      $.getJSON(url, function (result) {
        return callback(result);
      });


    };

    function getStromy(lat,lon,callback) {

      var api = '090b90aa-8d33-11e9-9e74-0242ac130004-090b91a4-8d33-11e9-9e74-0242ac130004';
      var time = Math.round((new Date()).getTime() / 1000);

      fetch(`https://api.stormglass.io/v1/weather/point?lat=${lat}&lng=${lon}&start=${time}&end=${time}`, {
        headers: {
          'Authorization': api
        }
      }).then((response) => response.json()).then((jsonData) => {
        return callback(jsonData);
      });
    };


    function rgb2hsv (r, g, b) {
      let rabs, gabs, babs, rr, gg, bb, h, s, v, diff, diffc, percentRoundFn;
      rabs = r / 255;
      gabs = g / 255;
      babs = b / 255;
      v = Math.max(rabs, gabs, babs),
      diff = v - Math.min(rabs, gabs, babs);
      diffc = c => (v - c) / 6 / diff + 1 / 2;
      percentRoundFn = num => Math.round(num * 100) / 100;
      if (diff == 0) {
        h = s = 0;
      } else {
        s = diff / v;
        rr = diffc(rabs);
        gg = diffc(gabs);
        bb = diffc(babs);

        if (rabs === v) {
          h = bb - gg;
        } else if (gabs === v) {
          h = (1 / 3) + rr - bb;
        } else if (babs === v) {
          h = (2 / 3) + gg - rr;
        }
        if (h < 0) {
          h += 1;
        }else if (h > 1) {
          h -= 1;
        }
      }
      return {
        h: Math.round(h * 360),
        s: percentRoundFn(s * 100),
        v: percentRoundFn(v * 100)
      };
    }



// L.easyButton( 'glyphicon glyphicon-map-marker', function(){
//   map.setView([curlat, curlon], 12);
// }).addTo(map);

// L.easyButton( 'glyphicon glyphicon-cloud', function(){
//   $('#mymodal').modal('show');
// }).addTo(map);

// L.easyButton('glyphicon glyphicon-road',function() {
//     var x = distance(curlat,curlon,targetlat,targetlon);
//     // console.log('Distance : ' + x);
//     document.getElementById('jarak').value=x+' Km';
//     $('#calcu').modal('show');
// }).addTo(map);




    //http://danielmontague.com/projects/easyButton.js/v1/examples/
    