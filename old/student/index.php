<?php include('header.php'); ?>
<?php
    require('../configs/config.php'); 
    require('../configs/connection.php');
     require('../configs/globals.php'); 
?>

<?php 
    
    $queueDisplay = queues_order($conn);
    $status = keyboard($conn);
      


?>

<div class="student-grid">

   <div class="grid-left">

        <?php if($queueDisplay): ?>
                    <h2><span class="oi oi-sort-ascending"></span> Priority List</h2>
                   <div id="student-container"></div>
                   <!-- <?php foreach($queueDisplay as $queue):?>
                         <div class="order-row">
                              <div class="order"><?php echo $queue['priority'];?></div>
                              <div class="arrow"><span class="oi oi-arrow-right"></span></div>
                              <div class="student_id"><?php echo $queue['student_id'];?></div>
                          </div>
                    <?php endforeach;?> -->
                
               
            
        <?php else: ?>
            <div class="no_result">
                <h1 class="text-muted"><span class="oi oi-ban"></span></h1>
                <p class="lead text-muted">Nothing to display</p>
                <a href="<?php ROOT_URL;?>" class="btn btn-lourdes"><span class="oi oi-reload"></span> Reload</a>
            </div> 
        <?php endif;?>
        
    </div> 
    <div class="grid-right">
       <div class="overlay"> </div>
        <div class="student-parent">  
<?php       
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
            
            save_id1($conn, $with_c, $order, $status);

        }else{

            $order = 1;
            save_id1($conn, $with_c, $order, $status);
            

        }
        
    
        // Free Result
        mysqli_free_result($result);
    
        // Close connection
       
        
  }



  function save_id1($conn, $student_id, $order, $status){

        $query = "INSERT INTO queue(student_id, priority, status) VALUES('$student_id', '$order', '$status')";
        
        if(mysqli_query($conn, $query)){

            $priority = fetch_order($conn, $student_id);
            $all = fetch_all($conn);
            $total = $all['count_all'] - 1;

          
            echo '
                    <div class="form-group">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                               <span class="oi oi-check"></span> You are currently in number '.$priority['priority'].'
                        </div>
                    </div>';

            header('Location: '.ROOT_URL.'/student?number=');
            mysqli_close($conn);

        } else {
            echo 'ERROR: '. mysqli_error($conn);
            mysqli_close($conn);
        }
        

    }

?>  

      <?php if(isset($_GET['number'])):?>

            <?php $number = $_GET['number']; ?>
            <input type="hidden" id="base_url" value="<?php echo ROOT_URL;?>">
            <div class="form-group message">
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close close-message" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                         <span class="oi oi-check"></span> Your currently in number <?php echo $number; ?>
                  </div>
            </div>

      <?php endif;?>

       

         <div class="inner-student">

                <div class="form-group">
                    <img src="<?php echo ROOT_URL;?>/assets/img/lc.svg" width=100>
                </div>
                <div class="student-title">
                    <h1>ITC Office </h1>
                </div>
               
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

                    <div class="form-group">
                        <label class="text-center lead text-light">ENTER YOUR ID # AND PRESS ENTER</label>
                    <div class="input-group">
                        <span class="input-group-addon extension" id="basic-addon1"><strong>C</strong></span>
                        <input type="text" class="form-control input-lg" id="student_id"  placeholder="<?php echo Date('y').'-00**';?>" name="student_id" required>
                        <span class="input-group-addon extension"><button type="submit" name="add_new" class="enter">Enter</button></span>
                        </div>

                    </div>
                    
                </form>

              
            </div>

              <?php if($status):?>
                    <div class="keyboard-view" id="key-view"> 

                   <div class="keyboard">

                    <div class="key1">
                        1
                    </div>
                     <div class="key2">
                        2
                    </div>
                     <div class="key3">
                        3
                    </div>
                     <div class="key4">
                        4
                    </div>
                     <div class="key5">
                        5
                    </div>
                   
                    </div>


                 <div class="keyboard">

                    
                     <div class="key6">
                        6
                    </div>
                     <div class="key7">
                        7
                    </div>
                     <div class="key8">
                        8
                    </div>
                     <div class="key9">
                        9
                    </div>
                     <div class="key0">
                        0
                    </div>
                </div>

                  <div class="keyboard">

                    <div class="key-dash">
                        -
                    </div>
                     <div class="key-back">
                        <
                    </div>
                     
                   
                   
                </div>
              </div>
             
              <?php endif;?>
              

        </div>
 </div>
</div>



<script>
    $(document).ready(function(){
        
        var base_url = $('#base_url').val();

         $('.key1').click(function(){
              $('#student_id').val($('#student_id').val() + 1);
              var count = $('#student_id').val().length;
              if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key2').click(function(){
              $('#student_id').val($('#student_id').val() + 2);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key3').click(function(){
              $('#student_id').val($('#student_id').val() + 3);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
          $('.key4').click(function(){
              $('#student_id').val($('#student_id').val() + 4);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key5').click(function(){
              $('#student_id').val($('#student_id').val() + 5);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
          $('.key6').click(function(){
              $('#student_id').val($('#student_id').val() + 6);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key7').click(function(){
              $('#student_id').val($('#student_id').val() + 7);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
          $('.key8').click(function(){
              $('#student_id').val($('#student_id').val() + 8);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key9').click(function(){
              $('#student_id').val($('#student_id').val() + 9);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
          $('.key0').click(function(){
              $('#student_id').val($('#student_id').val() + 0);
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
         $('.key-dash').click(function(){
              $('#student_id').val($('#student_id').val() + '-');
              var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
              }
         });
          $('.key-back').click(function(){
              $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
              })
         });

          $("#student_id").on("change paste keyup", function() {

            var count = $('#student_id').val().length;
               if(count > 7){  
                 $('#student_id').val(
                  function(index, value){
                      return value.substr(0, value.length - 1);
               })
               }
              
              
          });


         setInterval(function() {
               
                  display_list();
                  
        }, 1000); // <-- time in milliseconds


        /*  setInterval(function() {
               
                  $(".alert").alert('close');
                  location.replace(base_url + "/student");

                  
        }, 5000); // <-- time in milliseconds*/


        function display_list(){
             $.ajax({
              url:"../configs/globals.php",
              method:"POST",
              data:{priorities:true},
              dataType: "html",
              success:function(data){
                  $("#student-container").html(data);
              }
           });
        }

         function show_keyboard(){
             $.ajax({
              url:"../configs/globals.php",
              method:"POST",
              data:{enable:true},
              dataType: "html",
              success:function(data){
                  $("#key-view").html(data);
              }
           });
        }

        $('#close-message').click(function(){


            location.replace(base_url + "/student");

        });


      
     

    });
</script>