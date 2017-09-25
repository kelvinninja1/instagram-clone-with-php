<?php 
  
  require 'lib/password.php';
  
  $servername = getenv('IP');
  $username = getenv('C9_USER');
  
  if(isset($_POST['signin'])){
    if($_POST['password'] != $_POST['repeatpassword']){
      echo "<script>
        alert('Sorry, passwords doesn\'t match, please try again.');
      </script>";
      return false;
    }
    try {
      $db = new PDO("mysql:dbname=instagram;host=$servername", $username, "" );
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
  
      session_start();
                
      $userEmail = $_POST['useremail'];
      $userPassword = $_POST['password'];
      
      $sql = "SELECT COUNT(userEmail) AS num FROM Users WHERE userEmail = :useremail2";
      $stmt = $db->prepare($sql);
      
      //Bind the provided username to our prepared statement.
      $stmt->bindValue(':useremail2', $userEmail);
      
      //Execute.
      $stmt->execute();
    
      //Fetch the row.
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      //If the provided username already exists - display error.
      //TO ADD - Your own method of handling this error. For example purposes,
      //I'm just going to kill the script completely, as error handling is outside
      //the scope of this tutorial.
      if($row['num'] > 0){
        echo "<script> 
            alert('That email already exists. You'll be redirected to login.');
            window.location.replace('./welcome');
          </script>";
          return false;
          //die('That email already exists!');
      }
    
      //Hash the password as we do NOT want to store our passwords in plain text.
      $passwordHash = password_hash($userPassword, PASSWORD_BCRYPT, array("cost" => 12));
    
      //Prepare our INSERT statement.
      //Remember: We are inserting a new row into our users table.
      $sql = "INSERT INTO Users ( userName, userPass,profilePicture,userEmail) VALUES (:username2, :userpass2,:profilepicture2, :useremail2)";
      $stmt = $db->prepare($sql);
      
      $emailarray  = explode('@',$userEmail);
      $userNameEmail = $emailarray[0];
    
      //Bind our variables.
      $stmt->bindValue(':username2', $userNameEmail);
      $stmt->bindValue(':useremail2', $userEmail);
      $stmt->bindValue(':profilepicture2', './img/glyphicons-halflings.png');
      $stmt->bindValue(':userpass2', $passwordHash);
   
      //Execute the statement and insert the new account.
      $result = $stmt->execute();
      
      //If the signup process is successful.
      if($result){
          //What you do here is up to you!
          echo "<script> 
            alert('Ready to rock? Just have to login in your account now.');
            window.location.replace('./welcome');
          </script>";
      }
            
      
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
  }
?>