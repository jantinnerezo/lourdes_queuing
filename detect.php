<?php 
	require_once('configs/config.php');
	require('configs/connection.php');

	 if(isset($_POST['changed'])){

	 	$fetch_current = "SELECT MIN(queue_id) as id from queue WHERE status = 1";
                $current = mysqli_query($conn, $fetch_current);
                $current_id = mysqli_fetch_assoc($current);
                mysqli_free_result($current);

	  	$query = "SELECT* from queue WHERE queue_id = '".$current_id['id']."'";

                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
        
                if($row){
                	echo json_encode($row);
                }else{

                }

	  }

?>