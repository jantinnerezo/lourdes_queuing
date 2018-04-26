

<?php 
require('connection.php');


 function keyb($conn){


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
$status = keyb($conn);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <title>ICT Queue Control</title>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/bootstrap.min.css">

     <!-- Open Iconic Bootstrap -->
     <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/open-iconic-bootstrap.css">

     <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/style.css">

	   <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/animate.css">

	   <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/font-awesome.min.css">

     <link rel="stylesheet" href="<?php echo ROOT_URL;?>/assets/css/jquery.toast.min.css">

  </head>
  <body>
    

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-lourdes">
        <div class="container">
             <a class="navbar-brand" href="#">ITC Queue Control</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav justify-content-right">

              <?php if($status):?>

                 <li class="nav-item">
                     <a class="nav-link" href="configs/globals.php?key-disable=true"  role="button" >
                                    <span class="oi oi-ban"></span> Disable on screen keyboard
                      </a>
                    </form>
              </li>
              <?php else: ?>
                    <li class="nav-item" >
              
                     <a class="nav-link" href="configs/globals.php?key-enable=true"  role="button" >
                                    <span class="oi oi-grid-three-up"></span> Enable on screen keyboard
                      </a>
                 
                    </li>
              <?php endif;?>
            

             

                     <!--   <li class="nav-item">
                          <div class="dropdown">
                              <a class="nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="oi oi-person"> </span> Admin <span class="oi oi-caret-bottom"> </span>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                   <a class="dropdown-item"> <span class="oi oi-account-logout"></span> Logout</a>   
                              </div>
                        </div>
                        </li> -->
            </ul>
        </div>
        </div>


    </nav>

  
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo ROOT_URL;?>/assets/js/jquery-3.2.1.slim.min.js" ></script>
    <script src="<?php echo ROOT_URL;?>/assets/js/popper.min.js"></script>
    <script src="<?php echo ROOT_URL;?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo ROOT_URL;?>/assets/js/jquery.toast.min.js" ></script>

  </body>
</html>




