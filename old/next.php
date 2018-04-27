<?php require('configs/config.php'); ?>
<?php require('configs/connection.php'); ?>
<?php

  if(isset($_POST['next'])){

        $query = "SELECT* FROM queue WHERE status = 0 ORDER BY queue_id ASC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        if($row){
                echo json_encode($row);
        }else{
                $response = array('none' => 'No more');
                 echo json_encode($response);
        } 

  	
   } 
?>