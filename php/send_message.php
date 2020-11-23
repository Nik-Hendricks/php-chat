<?php
require 'utils.php';
    if(isset($_POST)){
        //var_dump($_POST);
        if((isset($_POST['message'])) && (isset($_POST['user_uid'])) && (isset($_POST['room_uid']))){
            //return $_POST['message'];

            echo addMessageToDb($_POST['message'], $_POST['room_uid'], $_POST['user_uid']);
        }

        
    }else{
        echo "no pogger";
    }

    function addMessageToDb($message, $room_uid, $user_uid){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
 
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1 = "INSERT INTO messages (id, uid, room_uid, message, user_uid) VALUES(?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($query1);

            $message_uid = _uniqid();

            $stmt1->execute([null, $message_uid, $room_uid, $message, $user_uid]);

            return $message_uid;
            
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
          $conn = null;
        
    }



?>