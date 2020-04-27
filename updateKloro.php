<?php
try {
            // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}


    if ($_POST['id'])
    {

        $id = $_POST['id'];
        $klorofil = $_POST['klorofil'];
        $mode = $_POST['mode'];
    }
    else{

        $id = $_GET['id'];
        $klorofil = $_GET['klorofil'];  
        $mode = $_GET['mode'];  
    }
    
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
  $kloro = prediksi($klorofil);

// ubah string JSON menjadi array
    $link = mysqli_connect("localhost", "root", "", "groundctrl");
    if($mode=='target'){
        $sql = "UPDATE cuaca SET klorofil = '$kloro' WHERE id = '$id' AND prediksi ='target' ";
    
       
    }
    elseif ($mode=='loc') {
        $sql = "UPDATE cuaca SET klorofil = '$kloro' WHERE id = '$id' AND prediksi ='cuaca'";
      
    }
    
    if(mysqli_query($link, $sql)){
        echo "Weather Target updated. "+ $mode + $klorofil;
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
