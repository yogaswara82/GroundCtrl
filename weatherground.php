


<?php
header('Content-Type: application/json');
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
// if (!empty($_GET['kode'])){
// $kode = $_GET['kode'];}
//  else {
// $kode = $_POST['kode'];}    



//$url='http://maritim.bmkg.go.id/xml/wilayah_pelayanan/prakiraan?kode='.$kode.'&format=json';
date_default_timezone_set('Asia/Jakarta');
$hour = date("H");


 $url='http://api.worldweatheronline.com/premium/v1/marine.ashx?key=65bd05aa76bd457db74201958192311&format=json&tp=1&q='.$_GET['lat'].','.$_GET['lon'];
 $profile = http_request($url);

// // ubah string JSON menjadi array
 $profile = json_decode($profile, false);
 $profile = $profile->data->weather[0]->hourly[$hour];


echo json_encode($profile);

?>
