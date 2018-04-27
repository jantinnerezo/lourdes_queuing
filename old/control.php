<?php
   require('configs/crud.php'); 
   require('configs/connection.php');
   include('configs/header.php'); 
   require('configs/globals.php');
?>

<div class="control">
<?php
  

    #Auto add queues 1 - 100
   if(isset($_POST['auto_add'])){
    // Get form data
    $query1 = "DELETE FROM queue";
    $query2 = "DELETE FROM previous";
       
       
        if(mysqli_query($conn, $query1)){

            for($x = 1; $x <= 100; $x++){

             $query = "INSERT INTO queue(student_id, status) VALUES('$x', 0)";

            if(mysqli_query($conn, $query)){

                #Query succeed
                #No alert
             
            } else {

               #Query failed
             

            }
          }

        } else {
          
           #Query failed
        }
         if(mysqli_query($conn, $query2)){

            #Query succeed
            #No alert
        } else {
          
            #Query failed
      }

    
  }



 
    # Function is called when queuing started for the first time when - no previous queued
    if(isset($_POST['call'])){

        $id = mysqli_real_escape_string($conn, $_POST['id']);

        $query1 = "UPDATE queue SET status = 1 WHERE queue_id = '$id'";
       
       
        if(mysqli_query($conn, $query1)){
              //header('Location: '.ROOT_URL.'/control.php');
        } else {

          echo '
          <div class="container">
            <div class="alert alert-danger"> An error occured, something went wrong '.mysqli_error($conn).' </div
          </div>';
          
        }

    }

  
    # Function is there was previous queued and selecting the next queue 
    if(isset($_POST['up_next'])){

        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $id2 = mysqli_real_escape_string($conn, $_POST['current']);
        $id3 = mysqli_real_escape_string($conn, $_POST['student_id']);

        $query1 = "UPDATE queue SET status = 1 WHERE queue_id = '$id'";
        $query2 = "INSERT INTO previous(student_id) VALUES('$id3')";
        $query3 = "DELETE FROM queue WHERE queue_id = '$id2'";
       
       
        if(mysqli_query($conn, $query1)){

           
        } else {
            echo mysqli_error($conn);
        }
        if(mysqli_query($conn, $query2)){
           
        } else {
            echo mysqli_error($conn);
        }
         if(mysqli_query($conn, $query3)){
           
        } else {
            echo mysqli_error($conn);
        }


    }

   


    function select_current(){
          // Create Query
      $query = "SELECT* FROM queue WHERE status = 1";

      // Get Result
      $prev = mysqli_query($conn, $query);

      // Fetch Data
      $get_prev = mysqli_fetch_assoc($prev);
      //var_dump($posts);

      // Free Result
      mysqli_free_result($prev);
    }

    function insert_prev(){
        $query2 = "INSERT INTO previous(queue_id) VALUES('$id')";
    }

    ######################### GET CURRENT IF NOT STARTED FOR FIRST TIME ##################################
    $query = "SELECT* FROM queue WHERE status = 1";

    // Get Result
    $prev = mysqli_query($conn, $query);

    // Fetch Data
    $get_prev = mysqli_fetch_assoc($prev);
    //var_dump($posts);

    // Free Result
    mysqli_free_result($prev);
  

    #########################################################################################
   
    // Create Query
    $fetch_current = "SELECT MIN(queue_id) as id from queue WHERE status = 0";

    // Get Result
    $current = mysqli_query($conn, $fetch_current);

    // Fetch Data
    $current_id = mysqli_fetch_assoc($current);
    //var_dump($posts);

    // Free Result
    mysqli_free_result($current);


    function queueList($conn){

      $fetch = 'SELECT * FROM queue';

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
      

    }

    $queues = display_queues($conn);
    $listQueue = queueList($conn);


   
  
?>



    <div class="container">
      <div class="row">
          <div class="col-md-8">
           
          </div>
           <div class="col-md-4">
            
          </div>
      </div>

      <div class="row">
        <hr>
      </div>
  

      <div class="row">
        <div class="col-md-4">
            <div class="form-group" id="toolbar">
              <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
                    <input type="hidden" name="id"  value="<?php echo $current_id['id']; ?>"/>
                    <input type="hidden" name="current"  value="<?php echo $get_prev['queue_id'];?>"/>
                    <input type="hidden" name="student_id"  value="<?php echo $get_prev['student_id'];?>"/>
                    <?php if($get_prev): ?>
                        <button type="submit" class="btn btn-block btn-success" name="up_next"><span class="oi oi-arrow-right"></span> Next Queue</button>
                     <?php else: ?>
                        <?php if($listQueue): ?>
                             <button type="submit" class="btn btn-block btn-lourdes" name="call">Start</button>
                        <?php endif; ?>
                    <?php endif;?>
              </form>
          </div>
            
        </div>
        <div class="col-md-4">
          <div class="form-group">
               <button data-toggle="modal" data-target="#announcementModal" class="btn btn-block btn-info"><span class="oi oi-flag"></span> Announcements</button>
          </div>
          
        </div>
        <div class="col-md-4">
             <div class="form-group" id="clear">
               
             
           
            </div>
        </div>
      </div>
      <hr>
      
            <div class="table-responsive" id="queues_list">
              
            </div>
      
    
       <div class="row">
         <div class="col-md-4">
           
          </div>

          <div class="col-md-4">
           
          </div>

           <div class="col-md-4">
            
          </div>
        </form>
    </div>
    </div>



     <!-- Add Queues Modal -->
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-info" id="exampleModalLabel">Announcements</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="<?php echo ROOT_URL; ?>/configs/globals.php">
              <div class="modal-body">
                  <div class="form-group">
                      <textarea row="4" col="4" name="announcement" class="form-control"></textarea>
                  </div>
               </div>

              <div class="modal-footer">
                  <button  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="announce" class="btn btn-success"> Display</button>
              </div>
            </form>
        </div>
      </div>
    </div>

   
</div>


<script>

  $(document).ready(function(){

      setInterval(function() {
                  refresh_list();
                 // next_btn();
                  clear_btn();
                 
      }, 1000); 

     function refresh_list(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{display:true},
              dataType: "html",
              success:function(data){
                    $("#queues_list").html(data);
              }
           });
        }

        function next_btn(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{next_btn:true},
              dataType: "html",
              success:function(data){
                    $("#toolbar").html(data);
              }
           });
        }

          function clear_btn(){
             $.ajax({
              url:"configs/globals.php",
              method:"POST",
              data:{clear_btn:true},
              dataType: "html",
              success:function(data){
                    $("#clear").html(data);
              }
           });
        }

      });
</script>
