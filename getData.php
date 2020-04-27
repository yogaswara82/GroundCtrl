<?php
header('Content-Type: application/json');
try {
            // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}
            $mysqli = new mysqli("localhost", "root", "", "groundctrl");


            $statement = $mysqli->prepare("SELECT * FROM `cuaca`");
           

            $statement->execute(); // Execute the statement.

            $result = $statement->get_result(); // Binds the last executed statement as a result.
           
            
            $cuaca = array();
            $target_cuaca = array();
            while ( $row = mysqli_fetch_assoc($result)) {
              if($row['prediksi']=='cuaca')
              $cuaca[] = $row;
              else
              $target_cuaca[] = $row;
            }
            
          date_default_timezone_set("Asia/Jakarta");
          $milliseconds=microtime(true);
          $json = array("error" => false,
            "message" => $milliseconds
            ,"data" => ["cuaca" => $cuaca,
                             "target_cuaca" => $target_cuaca  
                ]


            );
            
            echo json_encode(($json)); // Parse to JSON and print.


        } catch (mysqli_sql_exception $e) { // Failed to connect? Lets see the exception details..
            //echo "MySQLi Error Code: " . $e->getCode() . "<br />";
            //echo "Exception Msg: " . $e->getMessage();
            $json = array('error' => true
                , 'message' => $e->getMessage()
                ,'data' => null  );
            echo json_encode(($json)); // Parse to JSON and print.

            exit(); // exit and close connection.
        }