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
    
    
    $sql = "SELECT * FROM Likes WHERE Likes.userName = :currentUser";
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':currentUser', $_SESSION['user_id']);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['num'] > 0){
        $sql2 = "UPDATE Likes set postID='' where userName = :currentUser";
        $stmt2 = $db->prepare($sql2);

        $stmt2->bindValue(':currentUser', $_SESSION['user_id']);
        $stmt2->execute();
        
    }
    /* Fetch all of the remaining rows in the result set */
    //$response = $sth->fetchAll();

    echo json_encode($response);
    header("Content-type:application/json");
?>