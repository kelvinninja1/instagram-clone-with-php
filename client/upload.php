<?php
    session_start();
    
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    
    $postID = $_GET["postID"];
    

    try {
        $db = new PDO("mysql:dbname=instagram;host=$servername", $username, "" );
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
        
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    
 
        $imgFile = $_FILES['userPhoto']['name'];
        $tmp_dir = $_FILES['userPhoto']['tmp_name'];
        $imgSize = $_FILES['userPhoto']['size'];
        $upload_dir = './img/upload/';
 
        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
  
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
  
        // rename uploading image
        $userpic = rand(1000,1000000).".".$imgExt;
    
       // allow valid image file formats
       if(in_array($imgExt, $valid_extensions)){   
        // Check file size '5MB'
        if($imgSize < 5000000)    {
         move_uploaded_file($tmp_dir,$upload_dir.$userpic);
        }
        else{
            echo "Sorry, your file is too large.";
          //  exit;
        }
       }  else{
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //    exit;
       }

    $emailarray  = explode('@',$_SESSION['user_id']);
    $userNameEmail = $emailarray[0];
  
    $stmt = $db->prepare('INSERT INTO Posts(datePosted,caption,commentCount,likeCount,imageURL,userName) VALUES(:newDataPosted,:newCaption,:noComment,:noLikeCount,:upic,:user)');
    $stmt->bindValue(':newDataPosted', date("M j,Y"));
    $stmt->bindValue(':newCaption', 'Another amazing trip');
    $stmt->bindValue(':noComment', 0);
    $stmt->bindValue(':noLikeCount', 0);
    $stmt->bindValue(':upic', "img/upload/". $userpic);
    $stmt->bindValue(':user', $userNameEmail);
   
   if($stmt->execute())
   {
   // $successMSG = "new record succesfully inserted ...";
    header("Location: posts"); 
   }
   else
   {
  //  $errMSG = "error while inserting....";
   }
?>
