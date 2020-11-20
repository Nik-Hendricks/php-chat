<?php
require 'utils.php';
    if(isset($_POST)){
        if(isset($_POST['room_name'])){
            //return $_POST['message'];
            var_dump($_POST);
            create_room($_POST['room_name']);
        }

        
    }else{
        echo "no pogger";
    }

    function create_room($room_name){
        echo $message;
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
 
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query1 = "INSERT INTO rooms (id, room_uid, room_name) VALUES(?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->execute([null, _uniqid(), $room_name]);


            
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
          $conn = null;
        
    }
?>