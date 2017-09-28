<?php 
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require_once "vendor/autoload.php";
  require 'lib/password.php';
  
  $servername = getenv('IP');
  $username = getenv('C9_USER');
  
  if(isset($_POST['forgetpassword'])){
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
       //Hash the password as we do NOT want to store our passwords in plain text.
        $passwordHash = password_hash($userPassword, PASSWORD_BCRYPT, array("cost" => 12));
      
        //Prepare our INSERT statement.
        //Remember: We are inserting a new row into our users table.
        $sql = "INSERT INTO PasswordResets (passwordHash, userID) VALUES (:userpass2,:useremail2)";
        $stmt = $db->prepare($sql);
      
        //Bind our variables.
        $stmt->bindValue(':useremail2', $userEmail);
        $stmt->bindValue(':userpass2', $passwordHash);
     
        //Execute the statement and insert the new account.
        $result = $stmt->execute();
        /*
         $mail = new PHPMailer(true);                              // Passing true enables exceptions
 
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAutoTLS = false;
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'prog8165@gmail.com';                 // SMTP username
        $mail->Password = 'Prog8165!';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, ssl also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        
        //Recipients
        $mail->setFrom('recievewebdesign@gmail.com', 'Instagram');
        $mail->addAddress($resetEmail);     // Add a recipient
        
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Reset your password at Instagram';
        
        $mail->Body  = 'https://instagram-php-smb26.c9users.io/client/verifypassword?id=' . $passwordHash;
        $mail->send();
        */
        
      }
    
      
      
      //If the signup process is successful.
      if($result){
          //What you do here is up to you!
          echo "<script> 
            alert('Check your email to finish the process of changing passwords!');
            window.location.replace('./welcome');
          </script>";
      }
            
      
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
  }
?>