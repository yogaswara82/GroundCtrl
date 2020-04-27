<?php

	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	$kloro= $_POST['kloro'];
	$date = $_POST['date'];

	function prediksi ($kloro){

		if($kloro == 0){
			$pred = "Potensi Ikan Tidak Diketahui";
		}
		elseif (140<=$kloro && $kloro<=220) {
			$pred = "Potensi Ikan Tinggi";
		}
		else{
			$pred = "Potensi Ikan Rendah";  
		}
		return $pred;
	}

	$prediksi = prediksi($kloro);
	$f = fopen('pengujian kloro.csv','a');
	$linedata = array($lat,$lon,$date,$kloro,$prediksi);
	fputcsv($f,$linedata,',');

