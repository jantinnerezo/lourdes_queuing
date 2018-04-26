<?php include('configs/config.php'); ?>
<?php include('configs/imports.php'); ?>
<?php require('configs/connection.php');?>

<?php

  function count_next($conn){

    $query = 'SELECT* FROM queue WHERE status != 1 ORDER BY queue_id';

    # Get Result
    $result = mysqli_query($conn, $query);

    # Fetch Data
    $next = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //var_dump($posts);
    $count_next = mysqli_num_rows($result);
    # Free Result
    mysqli_free_result($result);

    # Close Connection after

    return $count_next;

    mysqli_close($conn);

  }


  function count_prev($conn){

    $query = 'SELECT* FROM queue WHERE status != 1 ORDER BY queue_id';

    # Get Result
    $result = mysqli_query($conn, $query);

    # Fetch Data
    $prev = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //var_dump($posts);
    $prev_count = mysqli_num_rows($result);
    # Free Result
    mysqli_free_result($result);

    # Close Connection after

    return $prev_count;

    mysqli_close($conn);

  }

  function get_status($conn){


      // Create Query
      $query = 'SELECT* FROM queue where status = 1';
  
      // Get Result
      $result = mysqli_query($conn, $query);
  
      // Fetch Data
      $level = mysqli_fetch_assoc($result);

      //var_dump($posts);
      
      if(!IS_NULL($level)){

          return true;
      }else{

          return false;
      }
      
  
      // Free Result
      mysqli_free_result($result);
  
      // Close connection
  }

  $count_next = count_next($conn);
  $count_prev = count_prev($conn);
  $status = get_status($conn);

   
?>

<div class="disp">

    <div class="row">

      <!-- Side bar part -->
    	<div class="col-md-3 column1" >
    		
    		<div class="queues text-center">
          <input type="hidden" id="detect">
          <div id="serving">
             
          </div>
          <div id="next-parent">
             
          </div>
           <div id="prev-parent">
             
          </div>
            
            
  
           
           
    		</div>
    	</div>

      <!-- Video Player Part -->
    	<div class="col-md-9 column2">
    	   <div class="video-frame">
              <h1 class="heading">Lourdes College ITC Office</h1>
            <p class="animated flash" id="popup"><strong></strong></p>
      	      <video autoplay muted>
                     <!-- Video source url -->
                    <source src="<?php echo ROOT_URL;?>/assets/videos/kenshin.mp4" type="video/mp4">
              </video>
               <marquee class="sliding" id="sliding_text"></marquee>
          </div>

    	</div>
    </div>
</div>


<!-- JQuery and Javascript -->
<script>
		$(document).ready(function(){

      //Get notification sound url
			var sound = window.location.origin + '/queuing/assets/sounds/notification.mp3';
      
      //
      var $changed = $("#detect");

      queue_list();

      $changed.data("value", $changed.val());

          setInterval(function() {
                 detect_changes();
                 queue_list();
                 next_list();
                 previous_list();
                 get_next();
                 
        }, 3000); // <-- time in milliseconds

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

        function proceed(){
          	 $.ajax({
  				 	 	url:"current.php",
  				 	 	method:"POST",
  				 	 	data:{response:true},
  				 	 	dataType:"json",
  				 	 	success:function(data){
                  var icon = '<span class="glyphicon glyphicon-ok"></span>';
                  $("#current").addClass('animated flash');
                    var wait = setTimeout(function(){
                 $("#current").removeClass('animated flash');
                }, 100000);
  				 	 		$("#current").text(data.student_id);
                
                 $( "#popup" ).show();
                $("#popup").text(data.student_id);
	 
  				 	 	}
  			 	 });
        }

         function queue_list(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{response:true},
              dataType: "html",
              success:function(data){
                  $("#serving").html(data);
                  previous_list();

              }
           });
        }

        function next_list(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{next:true},
              dataType: "html",
              success:function(data){
                  $("#next-parent").html(data);

              }
           });
        }

          function previous_list(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{previous:true},
              dataType: "html",
              success:function(data){
                  $("#prev-parent").html(data);

              }
           });
        }

        function get_next(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{get_next:true},
              dataType: "html",
              success:function(data){
                  $("#sliding_text").html(data);
              }
           });
        }


         function next(){
             $.ajax({
              url:"next.php",
              method:"POST",
              data:{next:true},
              dataType:"json",
              success:function(data){
                queue_list();
                
                  $("#next").addClass('animated slideInLeft');
                    var wait = setTimeout(function(){
                 $( "li" ).first().removeClass('animated slideInLeft');
                }, 100000);
                $( "#next" ).text(data.student_id);
                   
              }
           });
        }
          var $myText = $("#detect");
          setInterval(function() {
               var data = $myText.data("value"),
                  val = $myText.val();

              if (data !== val) {
                  $myText.data("value", val);
                    new Audio(sound).play();
                   proceed();
                   next();
              }else{
                   
              }
  
                 
        }, 1000); 


            setInterval(function() {
              $( "#popup" ).hide();
        }, 7000); 

		});
</script>

