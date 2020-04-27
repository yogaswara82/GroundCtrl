<?php


// Function to print out objects / arrays
function PrintObj ($o) { echo "<pre>"; print_r($o); echo "</pre>"; }

// Load the POST.
$x = file_get_contents("php://input");

// ...and decode it into a PHP array.
$data = json_decode($x); 

echo $data->id;
// Do whatever with the array. 
PrintObj($data);