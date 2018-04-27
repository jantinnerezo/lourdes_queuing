<?php 
	require_once('configs/config.php');
	require('configs/connection.php');
	include('header.php');

         #Select current served
        $fetch_current = "SELECT MIN(queue_id) as id from queue WHERE status = 1";
        $current = mysqli_query($conn, $fetch_current);
        $current_id = mysqli_fetch_assoc($current);
        mysqli_free_result($current);

        #Display data
        $result = "SELECT* from queue WHERE queue_id = '".$current_id['id']."'";
        $display_result = mysqli_query($conn, $result);
        $assessment = mysqli_fetch_assoc($display_result);
        mysqli_free_result($display_result);

        #Get latest previous ID
        $result2 = "SELECT MAX(id) as prev_id from previous";
        $display_result2 = mysqli_query($conn, $result2);
        $prev_id = mysqli_fetch_assoc($display_result2);
        mysqli_free_result($display_result2);

        #Display data
        $result3 = "SELECT* from previous where id = '" .$prev_id['prev_id']."'";
        $display_result3 = mysqli_query($conn, $result3);
        $prev_data = mysqli_fetch_assoc($display_result3);
        mysqli_free_result($display_result3);

     
        #Display data
        $result4 = "SELECT * FROM queue WHERE queue_id > '".$current_id['queue_id']."' and status = 0 ORDER BY queue_id LIMIT 1;";
        $display_result4 = mysqli_query($conn, $result4);
        $next_data = mysqli_fetch_assoc($display_result4);
        mysqli_free_result($display_result4);


       /* #Next
        $fetch_next= "SELECT * FROM queue WHERE id > '".$current_id['id']."' ORDER BY id LIMIT 1;";
        $next = mysqli_query($conn, $fetch_next);
        $next_data = mysqli_fetch_assoc($next);*/
        // Fetch Data
        
        //var_dump($posts);

        // Free Result
    

        // Close Connection
        mysqli_close($conn);

?>
<html>
	
	<body>
		
		<div class="background_image">
		 <audio id="notification" src="<?php echo ROOT_URL;?>/assets/sounds/ping.mp3" autoplay hidden></audio>
			<div class="upper">
			<p class="prev animated bounce"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Prev: <?php echo $prev_data['student_id'];?>  </p>
				<p class="next animated bounce"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Next: <?php echo $next_data['student_id'];?>   </p>
			</div>
			<div class="text">
				<p class="label-text"> Now serving </p>
				<p class="student animated flash" id="priority"><?php echo $assessment['student_id'];?></p>
			</div>
		

            
		</div>
        <input type="hidden" id="detect" />
    
	</body>

	<script>
		$(document).ready(function(){


           
            detect_changes();
			  /*$('#priority').addClass('animated flash');
		        var wait = setTimeout(function(){
		          $('#priority').removeClass('animated flash');
		        }, 100000);*/
              
            var $myText = $("#detect");

            $myText.data("value", $myText.val());

                setInterval(function() {
                     var data = $myText.data("value"),
                        val = $myText.val();

                    if (data !== val) {
                        $myText.data("value", val);
                      
                    }else{
                         
                    }

                        detect_changes();
                       
              }, 1000); // <-- time in milliseconds

              function detect_changes(){
                     $.ajax({
                        url:"detect.php",
                        method:"POST",
                        data:{changed:true},
                        dataType:"json",
                        success:function(data){
                            $('#detect').val(data.queue_id);

                        }
                     });
              }

		});
	</script>
</html>