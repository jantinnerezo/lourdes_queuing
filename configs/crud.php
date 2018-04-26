<?php

	require('config.php');
	require('connection.php');


	function multiple_rows($query){

	    # Get Result
	    $query = "SELECT* from queue";
	    $database_query = mysqli_query($conn, $query);

	    # Fetch Data
	    $results = mysqli_fetch_all($database_query, MYSQLI_ASSOC);
	  
	    #$count = mysqli_num_rows($result);

	    # Free Result
	    mysqli_free_result($results);

	    # Close Connection after
	   

	    return $results;

	     mysqli_close($conn);

	}


	function single_row($query){

	    $database_query = mysqli_query($conn, $query);
	    $result = mysqli_fetch_assoc($database_query);
	    mysqli_free_result($result);
  
	}


?>