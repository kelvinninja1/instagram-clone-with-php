<?php

    session_start();
    
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    
    $queryType = $_GET["query"];
    $toSearchFor = $_GET["postToSearch"];

    try {
        $db = new PDO("mysql:dbname=instagram;host=$servername", $username, "" );
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
        
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    
    //echo $queryType;
    if($queryType == 'post'){
        $sth = $db->prepare("SELECT * FROM Posts INNER JOIN Users ON Posts.userName = Users.userName");
    } else {
        if($queryType == 'hashtag'){
            $sth = $db->prepare("SELECT * FROM Hashtags INNER JOIN Posts ON Posts.postID = Hashtags.postID WHERE Posts.postID = :toSearch");
            $sth->bindValue(':toSearch', $toSearchFor);
        } else {
            $sth = $db->prepare("SELECT Comments.userName AS 'userC', content FROM Comments INNER JOIN Posts ON Comments.postID = Posts.postID WHERE Posts.postID = :toSearch");
            $sth->bindValue(':toSearch', $toSearchFor);
        }
    }
    $sth->execute();

    /* Fetch all of the remaining rows in the result set */
    $response = $sth->fetchAll();

    echo json_encode($response);
    header("Content-type:application/json");
?>