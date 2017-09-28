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
    
    
    $sql = "SELECT * FROM Likes INNER JOIN Posts ON Likes.postID = Posts.postID WHERE Likes.postID = :currentPost AND Likes.userEmail = :currentUser";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':currentPost', $postID);
    $stmt->bindValue(':currentUser', $_SESSION['user_id']);
    
     $stmt->execute();
    
      //Fetch the row.
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['likeID'] > 0){
       echo "<script> 
            alert('You already liked this post');
          </script>";
         return false;
    } else {
        $sql2 = "UPDATE Posts set likeCount=likeCount + 1 where postID = :currentPost";
        $stmt = $db->prepare($sql2);
        $stmt->bindValue(':currentPost', $postID);
        $stmt->execute();
        
        $sql3 = "INSERT INTO Likes (postID,userEmail) VALUES (:currentPost,:currentUser)";
        $stmt = $db->prepare($sql3);
        $stmt->bindValue(':currentPost', $postID);
        $stmt->bindValue(':currentUser', $_SESSION['user_id']);
        $stmt->execute();
        
        $sql4 = "SELECT * FROM Posts WHERE postID = :currentPost";
        $sth = $db->prepare($sql4);
        $sth->bindValue(':currentPost', $postID);
        $sth->execute();
    }
    /* Fetch all of the remaining rows in the result set */
    $response = $sth->fetchAll();

    echo json_encode($response);
    header("Content-type:application/json");
?>