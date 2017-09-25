<?php
    session_start();
    
    if(!isset($_SESSION['user_id'])){
    //User not logged in. Redirect them back to the login.php page.
       // echo $_SESSION['user_id'];
        header('Location: welcome');
        exit;
    }
 
?>
<!doctype html>

<html lang="en">
  <head>
    <title>Instagram assignment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css?v2">
    <link rel="stylesheet" href="./css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css">
  </head>
  <body onload="onload()">
    <?php require_once('header.php'); ?>
    <main class="main-feed">
      <div class="container">
        <div class="col-md-7 center-block" id="feed-container">
          
        </div>
      </div>
      <div class="container">
           
           <!-- Modal -->
           <div class="modal fade" id="myModal" role="dialog">
             <div class="modal-dialog">
             
               <!-- Modal content-->
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add a Picture</h4>
                 </div>
                <div class="modal-body">
                     <form id="uploadForm" enctype="multipart/form-data" name="uploadForm" novalidate>
                         <input type="file" name="userPhoto" id="userPhoto" />
                     </form>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal" onclick="uploadClick();">Send</button>
                 </div>
               </div>
             </div>
           </div>
           <!-- create a div with an id to give us an anchor point to let the javascript do its work -->
           <div id="posts"></div>
         </div>
    </main>
    
    <script src="./js/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="./js/feed.js"></script>
  </body>
</html>
