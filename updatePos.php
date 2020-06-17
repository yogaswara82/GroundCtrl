<?php
try {
            // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}
    function http_request($url){
    // persiapkan curl
        $ch = curl_init(); 

    // set url 
        curl_setopt($ch, CURLOPT_URL, $url);

    // set user agent    
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
        $output = curl_exec($ch); 

    // tutup curl 
        curl_close($ch);      

    // mengembalikan hasil curl
        return $output;
    }
    $data = json_decode($_POST['json'],false);
    if($data->id == "")
    {
       $x = file_get_contents("php://input");

     // ...and decode it into a PHP array.
       $data = json_decode($x);
   }  

   $id = $data->data[0]->id;
   $lat = $data->data[0]->lat;
   $lon = $data->data[0]->lon;




// ubah string JSON menjadi array



   $link = mysqli_connect("localhost", "root", "", "groundctrl");

   $check = "SELECT * FROM `loc` WHERE `id`='$id'";
   $result = mysqli_query($link, $check);
   $row = mysqli_fetch_assoc($result);

   $sql = "INSERT INTO `loc`(`id`,`lat`,`lon`) VALUES ('$id','$lat','$lon') ON DUPLICATE KEY UPDATE lat = '$lat', lon = '$lon';";

   if(mysqli_query($link, $sql)){
    echo "Loc update";
   } else {
       // echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
   }
   
   if($id!=$row['id'])
   {
    $url='http://api.worldweatheronline.com/premium/v1/marine.ashx?key=896fdb89d42247e5a8e190752201706&format=json&tp=1&q='.$lat.','.$lon;
    $profile = http_request($url);
    date_default_timezone_set('Asia/Jakarta');
    $hour = date("G");

    $data = json_decode($profile, false);
    $data = $data->data->weather[0]->hourly[$hour];
    echo json_encode($data);
    $desc = $data->weatherDesc[0]->value;
    $sql = "UPDATE cuaca SET temp = '$data->tempC',windspeed='$data->windspeedKmph',winddir='$data->winddir16Point',humidity='$data->humidity',wave='$data->swellHeight_m',sigWave='$data->sigHeight_m',`waveperiod`='$data->swellPeriod_secs',watertemp='$data->waterTemp_C',description='$desc' WHERE id = '$id' AND prediksi = 'cuaca' ";

    if(mysqli_query($link, $sql)){
        echo "Weather Target updated.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
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
