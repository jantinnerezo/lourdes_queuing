<?php require('configs/config.php'); ?>
<?php require('configs/connection.php'); ?>
<?php

   if(isset($_POST['response'])){

        $query = "SELECT* from queue WHERE status = 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        if($row){
                echo json_encode($row);
        }else{

        }


  }
  	
       
?>