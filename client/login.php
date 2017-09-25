<?php
    session_start();
    
    require 'lib/password.php';
  
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    
    if(isset($_POST['login'])){
      try {
        $db = new PDO("mysql:dbname=instagram;host=$servername", $username, "" );
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
    
        

        $userEmail = $_POST['useremail'];
        $passwordAttempt = $_POST['password'];
      
        
        $sql = "SELECT userEmail, userPass FROM Users WHERE userEmail = :emailProvided";
        $stmt = $db->prepare($sql);
      

        $stmt->bindValue(':emailProvided', $userEmail);
        $stmt->execute();
        

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        if($user === false){
              echo "<script> 
                alert('Ops, incorrect user. Are you sure you're registered?);
              </script>";
              return false;
        } else{
            $validPassword = password_verify($passwordAttempt, $user['userPass']);
            
            //If $validPassword is TRUE, the login has been successful.
            if($validPassword){
                
                //Provide the user with a login session.
                $_SESSION['user_id'] = $user['userName'];
                $_SESSION['logged_in'] = time();
                
                //Redirect to our protected page, which we called home.php
                header('Location: posts');
                exit;
                
            } else{
                //$validPassword was FALSE. Passwords do not match.
                echo "<script> 
                  alert('Incorrect password. Remember, you can always recover if it's forgotten.');
                </script>";
                return false;
            }
        }
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
    }
 
?>