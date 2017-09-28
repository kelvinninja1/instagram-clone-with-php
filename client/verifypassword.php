<?php 
  
  require 'lib/password.php';
  
  $servername = getenv('IP');
  $username = getenv('C9_USER');
  

    try {
      $db = new PDO("mysql:dbname=instagram;host=$servername", $username, "" );
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
  
      session_start();
      
      $passwordHash = $_GET['id'];           
      
      $sql = "SELECT userID AS num FROM PasswordResets WHERE passwordHash = :userpass2";
      $stmt = $db->prepare($sql);
      
      //Bind the provided username to our prepared statement.
      $stmt->bindValue(':userpass2', $passwordHash);
      
      //Execute.
      $stmt->execute();
    
      //Fetch the row.
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if($row['num'] != NULL){
            
      //If the provided username already exists - display error.
      //TO ADD - Your own method of handling this error. For example purposes,
      //I'm just going to kill the script completely, as error handling is outside
      //the scope of this tutorial.

            $sql = "UPDATE Users SET userPass = :userpass2 WHERE userEmail = :userName";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':userName', $row['num']);
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
            return false;
          //die('That email already exists!');
    
      }
      
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

?>