<?php
require 'utils.php';
    if(isset($_POST)){
        if( (isset($_POST['user_uid'])) && (isset($_POST['room_uid'])) && (isset($_POST['message_uid'])) ){
            //return $_POST['message'];
            
            echo add_to_unread($_POST['user_uid'], $_POST['room_uid'], $_POST['message_uid']);
        }

        
    }else{
        echo "no pogger";
    }

    function add_to_unread($user_uid, $room_uid, $message_uid){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
 
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1 = "INSERT INTO unread_messages (id, user_uid, message_uid, room_uid) VALUES(?, ?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute([null, $user_uid, $message_uid, $room_uid]);

            return true;

            
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
          $conn = null;
        
    }
?>