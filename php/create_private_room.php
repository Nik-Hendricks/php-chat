<?php
require 'utils.php';
    if(isset($_POST)){
        if( (isset($_POST['to_uid'])) && ($_POST['from_uid']) ){
        
            echo json_encode(create_private_room($_POST['to_uid'], $_POST['from_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function create_private_room($to_uid, $from_uid){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
 
        try {
            $room_uid = _uniqid();
            

            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1 = "INSERT INTO private_rooms (id, room_uid, to_uid, from_uid) VALUES(?, ?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute([null, $room_uid, $to_uid, $from_uid]);
            $stmt1->execute([null, $room_uid, $from_uid, $to_uid]);

            $query2 = "INSERT INTO rooms (id, room_uid, room_name) VALUES(?, ?, ?)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->execute([null, $room_uid, "private"]);

            return $room_uid;

            
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
          $conn = null;
        
    }
?>