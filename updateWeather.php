<?php
try {
    $data = json_decode($_POST['json'],false);
            // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}
    
    $desc = $data->weatherDesc[0]->value;
    $mode = $_POST['mode'];
    echo $desc;
    date_default_timezone_set('Asia/Jakarta');
    $hour = date("G:i");

    $link = mysqli_connect("localhost", "root", "", "groundctrl");
    
    if ($mode == 'cuaca') {
       $sql = "UPDATE cuaca SET temp = '$data->tempC',windspeed='$data->windspeedKmph',winddir='$data->winddir16Point',humidity='$data->humidity',wave='$data->swellHeight_m',sigWave='$data->sigHeight_m',`waveperiod`='$data->swellPeriod_secs',watertemp='$data->waterTemp_C',description='$desc' WHERE id = '$data->id' AND prediksi = 'cuaca' ";
       $f = fopen('pengujian cuaca.csv','a');
       $linedata = array($data->id,$data->lat,$data->lon,$hour,$data->klorofil,$data->tempC,$data->windspeedKmph,$data->winddir16Point,$data->humidity,$data->swellHeight_m,$data->sigHeight_m,$data->swellPeriod_secs,$data->waterTemp_C,$desc,'kapal');
   } elseif ($mode=='target') {
    $sql = "UPDATE cuaca SET temp = '$data->tempC',windspeed='$data->windspeedKmph',winddir='$data->winddir16Point',humidity='$data->humidity',wave='$data->swellHeight_m',sigWave='$data->sigHeight_m',`waveperiod`='$data->swellPeriod_secs',watertemp='$data->waterTemp_C',description='$desc' WHERE id = '$data->id' AND prediksi = 'target' ";
    $f = fopen('pengujian target.csv','a');
    $linedata = array($data->id,$data->lat,$data->lon,$hour,$data->klorofil,$data->tempC,$data->windspeedKmph,$data->winddir16Point,$data->humidity,$data->swellHeight_m,$data->sigHeight_m,$data->swellPeriod_secs,$data->waterTemp_C,$desc,'target');
}
   //fputcsv($f,$linedata,',');



if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


    } catch (mysqli_sql_exception $e) { // Failed to connect? Lets see the exception details..
            //echo "MySQLi Error Code: " . $e->getCode() . "<br />";
            //echo "Exception Msg: " . $e->getMessage();
        $json = array('error' => true
            , 'message' => $e->getMessage()
            ,'data' => null  );
            echo json_encode(($json)); // Parse to JSON and print.

            exit(); // exit and close connection.
        }
