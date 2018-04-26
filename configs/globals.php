<?php

	
	# Handles global database operations
	
	# Imports
	require('connection.php');
	include('imports.php');
	// Add assessment request

	

	if(isset($_POST['response'])){

		$query = 'SELECT* FROM queue WHERE status = 1 ORDER BY queue_id ASC limit 1';
		$result = mysqli_query($conn, $query);
	    $rows =  mysqli_fetch_all($result,  MYSQLI_ASSOC);
	
	
	    mysqli_free_result($result);

	    # Close database conection after fetching
	    mysqli_close($conn);

	    if($rows){
	    	  echo ' <div class="prev-header mar">
                      <h5> <span class="oi oi-circle-check"> </span> NOW SERVING </h5>
                    </div>
               <div id="list-container">
               		<ul>';
               			foreach($rows as $row){
               					echo '<li>' . $row['student_id'] . '</li>';
               			} 
           echo	  '</ul>
               </div>
               <hr>';

	    }else{


	    }

	  

	 
	}

	if(isset($_POST['previous'])){

		$query = 'SELECT* FROM previous ORDER BY id DESC limit 2';
		$result = mysqli_query($conn, $query);
	    $rows =  mysqli_fetch_all($result,  MYSQLI_ASSOC);
	
	
	    mysqli_free_result($result);

	    # Close database conection after fetching
	    mysqli_close($conn);

	      if($rows){
	    	  echo ' <div class="prev-header">
                      <h5> <span class="oi oi-arrow-left"> </span> PREVIOUS </h5>
                    </div>
               <div id="prev-container">
               		<ul>';
               			foreach($rows as $row){
               					echo '<li>' . $row['student_id'] . '</li>';
               			} 
           echo	  '</ul>
               </div>
               <hr>';

	    }else{


	    }

	  
	}


	if(isset($_POST['next'])){

		$query = 'SELECT* FROM queue WHERE status != 1 ORDER BY queue_id ASC limit 2';
		$result = mysqli_query($conn, $query);
	    $rows =  mysqli_fetch_all($result,  MYSQLI_ASSOC);
	
	
	    mysqli_free_result($result);

	    # Close database conection after fetching
	    mysqli_close($conn);

	    if($rows){
	    	  echo ' <div class="prev-header">
                      <h5> <span class="oi oi-arrow-right"> </span> NEXT </h5>
                    </div>
               <div id="next-container">
               		<ul>';
               			foreach($rows as $row){
               					echo '<li>' . $row['student_id'] . '</li>';
               			} 
           echo	  '</ul>
               </div>
               <hr>';

	    }else{


	    }

	}

	if(isset($_POST['get_next'])){

		

        $result4 = "SELECT * FROM announcements ORDER BY id DESC LIMIT 1";
        $display_result4 = mysqli_query($conn, $result4);
        $next_data = mysqli_fetch_assoc($display_result4);
        mysqli_free_result($display_result4);

        echo '<h1 class="announcement">' . $next_data['announcement'] . '</h1>';
	}

	

	# Fetch table rows function and returns an array
	function fetch_rows($conn, $query, $type){
		 
	    # Get Result
	    $result = mysqli_query($conn, $query);
	    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	
	    mysqli_free_result($result);

	    # Close database conection after fetching
	    mysqli_close($conn);

	    if($type = 'json'){
	    	return json_encode($rows);
	    }else{
	    	return $rows;
	    }

	   
	}

	# Count table rows
	function count_rows($conn, $query){

		$result = mysqli_query($conn, $query);
		$count = mysqli_num_rows($result);
		mysqli_close($conn);

		return $count;
	}

	# Fetch table single row function and returns an array
	function fetch_field($conn, $query){


	    $execute = mysqli_query($conn, $query);
	    $row = mysqli_fetch_assoc($execute);
	   
	    return $row;
  
	}







	// Students side functionality -----------------------------------------------------------------------------------
	function queues_order($conn){

		$fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queueDisplay = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $counts = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    return $queueDisplay;
	    # Close Connection after
	}

	if(isset($_POST['priorities'])){

        $fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queueDisplay = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $counts = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    if($queueDisplay){

	    	 foreach($queueDisplay as $queue){

		    	echo ' <div class="order-row">
	                              <div class="order">'. $queue['priority'].'</div>
	                              <div class="arrow"><span class="oi oi-arrow-right"></span></div>
	                              <div class="student_id">'.$queue['student_id'].'</div>
	                      </div>';
	   			 }


	    }


	   


	    # Close Connection after
	}

    function fetch_order($conn, $id){
        
                $query = "SELECT priority from queue WHERE student_id = '$id'";        
                $execute = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($execute);
                
                return $row; 
             
    }

    function fetch_all($conn){
        
                $query = "SELECT COUNT(*) as count_all from queue";        
                $execute = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($execute);
                
                return $row;
               
    }
    

	// Detect newly added ID number
	if(isset($_POST['add_new'])){

		
		  // Create Query
        $query = 'SELECT MAX(priority) as level FROM queue';
    
        // Get Result
        $result = mysqli_query($conn, $query);
    
        // Fetch Data
        $level = mysqli_fetch_assoc($result);

        //var_dump($posts);

        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

        $with_c = 'C' . $student_id;
        
        $status = 0;
        
        if(!IS_NULL($level)){

            $order = $level['level'] + 1;
            save_id($conn, $with_c, $order, $status);

        }else{

            $order = 1;
            save_id($conn, $with_c, $order, $status);
            

        }
        
    
        // Free Result
        mysqli_free_result($result);
    
        // Close connection
       
        
	}



	function save_id($conn, $student_id, $order, $status){

        $query = "INSERT INTO queue(student_id, priority, status) VALUES('$student_id', '$order', '$status')";
        
        if(mysqli_query($conn, $query)){

            $priority = fetch_order($conn, $student_id);
            $all = fetch_all($conn);
            $total = $all['count_all'] - 1;

          
            echo '
            <div class="grid-right">
        		<div class="student-parent">  
		                <div class="form-group">
		                    <div class="alert alert-success alert-dismissible fade show" role="alert">
		                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                            <span aria-hidden="true">&times;</span>
		                        </button>
		                           <span class="oi oi-check"></span> You are currently in number '.$priority['priority'].'
		                    </div>
		                </div>';

            header('Location: '.ROOT_URL.'/student?number='.$priority['priority']);
            mysqli_close($conn);

        } else {
            echo 'ERROR: '. mysqli_error($conn);
            mysqli_close($conn);
        }
        

    }


    function keyboard($conn){


      // Create Query
        $query = 'SELECT* from keyboard where status = 1';
    
        // Get Result
        $result = mysqli_query($conn, $query);
    
        // Fetch Data
        $status = mysqli_fetch_assoc($result);

        //var_dump($posts);
        
        if($status){

            return true;
            
        }
        else{

           return false;
        }
    
        // Free Result
        mysqli_free_result($result);
    
        // Close connection
    }

 


    // Admin Functionalities --------------------------------------------------------------------------------------
    // Display queue list on tables
    function display_queues($conn){

    	$fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queues = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $count = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    # Close Connection after

	    return $queues;
	    mysqli_close($conn);

	
    }
  


    if(isset($_POST['next_btn'])){

	    $query1 = "SELECT* FROM queue WHERE status = 1";
	    $fetch_current = "SELECT MIN(queue_id) as id from queue WHERE status = 0";

	    // Get Result
	    $prev = mysqli_query($conn, $query1);
	    $current = mysqli_query($conn, $fetch_current);

	    // Fetch Data
	    $get_prev = mysqli_fetch_assoc($prev);
	    $current_id = mysqli_fetch_assoc($current);
	    //var_dump($posts);

	   

		$fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queues = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $count = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    if($queues){

	    	echo '<form method="POST" action="'.$_SERVER['PHP_SELF']. '">
                    <input type="text" name="id"  value="'.$current_id['id'].'"/>
                    <input type="text" name="current"  value="'.$get_prev['queue_id'].'"/>
                    <input type="text" name="student_id"  value="'.$get_prev['student_id'].'"/>';
                    if($get_prev){
                         echo   '<button type="submit" class="btn btn-block btn-success" name="up_next"><span class="oi oi-arrow-right"></span> Next Queue</button>';
                   		}{
                       echo '<button type="submit" class="btn btn-block btn-lourdes" name="call">Start</button>';
                   		}
                   
              echo  '</form>';

	    	
	    }else{

	    
	    		
	    }

	  
   

	    mysqli_close($conn);
	}


	if(isset($_POST['clear_btn'])){

		
		$fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queues = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $count = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    if($queues){

	    	echo '   <form method="POST" action="'.$_SERVER['PHP_SELF'].'">
                <button type="submit" class="btn btn-block btn-danger" name="clear"><span class="oi oi-trash"></span> Clear all</button>
                </form>';

	    	
	    }else{

	    
	    }

	  
   

	    mysqli_close($conn);
	}

	 if(isset($_GET['key-enable'])){
    	

     $status = 1;

	  	  $query = "UPDATE keyboard SET status = '$status' WHERE id = 1";

      if(mysqli_query($conn, $query)){

         header('Location: '.ROOT_URL.'/control.php');

      } else {

     

      }
     	
        	    
    
    }

     if(isset($_GET['key-disable'])){
    	

    	$status = 0;

		  $query = "UPDATE keyboard SET status = '$status' WHERE id = 1";

	      if(mysqli_query($conn, $query)){

	         header('Location: '.ROOT_URL.'/control.php');

	      } else {

	     
	      	

	      }
     	
        	    
    
    }



    if(isset($_POST['display'])){

		
		$fetch = 'SELECT * FROM queue ORDER BY queue_id ASC';

	    # Get Result
	    $result = mysqli_query($conn, $fetch);

	    # Fetch Data
	    $queues = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    //var_dump($posts);
	    $count = mysqli_num_rows($result);
	    # Free Result
	    mysqli_free_result($result);

	    if($queues){


	    	 echo '<table class="table table-condensed table-bordered">
                    <thead class="bg-dark">
                        <th class="bg-dark"><span class="oi oi-sort-ascending"></span> Priority Order</th>
                        <th class="bg-dark"><span class="oi oi-key"></span> Priority ID #</th>
                        <th class="bg-dark"><span class="oi oi-pin"></span> Status</th>
                    </thead>
                    <tbody >';
                 
                        foreach($queues as $queue){

                                  if($queue['status'] == 1){
                                  	 echo '<td class="bg-success text-light"> <strong>'.$queue['priority']. '</strong></td>';
                                  	 echo '<td class="bg-success text-light"><strong> '.$queue['student_id']. '</strong></td>';
                                     echo '<td class="bg-success text-light"><strong> Currently serving </strong> </td>';
                                  }
                                else{
                                	 echo '<td > '.$queue['priority']. '</td>';
                                	  echo '<td > '.$queue['student_id']. '</td>';
                                    echo '<td> Pending </td>';
                                }
                                 
                            echo '</tr>';

                        }
                      
                 echo '</tbody>';
       echo '</table>';
	    }else{

	    	echo '<div class="text-center"> 
            <p class="lead text-muted">Currently there is no queues added yet</p>
          </div>';

	    }

	

	    mysqli_close($conn);
	}


	// Update announcement

   if(isset($_POST['announce'])){
    // Get form data
     
          $announcement = mysqli_real_escape_string($conn, $_POST['announcement']);
          $query = "INSERT INTO announcements(announcement) VALUES('$announcement')";

          if(mysqli_query($conn, $query)){

             header('Location: '.ROOT_URL.'/control.php');

          } else {

             // Query failed
            echo '<div class="container">
              <div class="alert alert-danger"> An error occured while adding checker </div
            </div>';  


          }
            
    
    }


    


   



   if(isset($_GET['status'])){
    	

     		$status = mysqli_real_escape_string($conn, $_POST['status']);

     		

		 $query = "UPDATE keyboard SET status = '$status'";

      if(mysqli_query($conn, $query)){

         header('Location: '.ROOT_URL.'/control.php');

      } else {

     


      }
     	
        	
         
            
    
    }


	 // Removes all queues from table queue and previous
    if(isset($_POST['clear'])){

        $query1 = "DELETE FROM queue";
        $query2 = "DELETE FROM previous";
       
       
        if(mysqli_query($conn, $query1)){

          

        } else {
          
          	
        }
         if(mysqli_query($conn, $query2)){

            header('Location: '.ROOT_URL.'/control.php');
            
        } else {
          
           
        }

    }





	

?>