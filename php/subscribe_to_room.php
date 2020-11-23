<?php 
    if(isset($_POST)){
        if( (isset($_POST['room_uid'])) && (isset($_POST['user_uid'])) ){
            echo subscribe_to_room($_POST['room_uid'], $_POST['user_uid']);
        }
    }

    function subscribe_to_room($room_uid, $user_uid){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
 
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1 = "INSERT INTO room_subscribers (id, room_uid, user_uid) VALUES(?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute([null, $room_uid, $user_uid]);

            return true;
            
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
          $conn = null;
    }
?>