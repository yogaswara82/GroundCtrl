<?php
$data = '{"id":"AB",
		 "klorofil":166,
		 "time":"0","tempC":"25","tempF":"76",
		 "windspeedMiles":"17",
		 "windspeedKmph":"28",
		 "winddirDegree":"125",
		 "winddir16Point":"SE",
		 "weatherCode":"353",
		 "weatherIconUrl":[{"value":"http://cdn.worldweatheronline.net/images/wsymbols01_png_64/wsymbol_0025_light_rain_showers_night.png"}],
		"weatherDesc":[{"value":"Light rain shower"}],
		"precipMM":"0.4","precipInches":"0.0",
		 "humidity":"77","visibility":"10",
		 "visibilityMiles":"6","pressure":"1012",
		 "pressureInches":"30","cloudcover":"51",
		 "HeatIndexC":"27","HeatIndexF":"80",
		 "DewPointC":"20","DewPointF":"69",
		 "WindChillC":"25","WindChillF":"76",
		 "WindGustMiles":"23","WindGustKmph":"38",
		 "FeelsLikeC":"27","FeelsLikeF":"80",
		 "sigHeight_m":"1.2","swellHeight_m":"0.7",
		 "swellHeight_ft":"2.3","swellDir":"150",
		 "swellDir16Point":"SSE",
		 "swellPeriod_secs":"13.4",
		 "waterTemp_C":"26","waterTemp_F":"78"}';
$oe = json_decode($data,false);

$uyy =  array($oe->weatherDesc);
var_dump($oe->weatherDesc);
echo $oe->weatherDesc[0]->value;