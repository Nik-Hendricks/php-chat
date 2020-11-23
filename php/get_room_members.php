<?php
require 'utils.php';
    if(isset($_GET)){
        if(isset($_GET['room_uid'])){
            echo json_encode(get_room_member($_GET['room_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function get_room_member($room_uid){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM room_subscribers WHERE room_uid=?");
            $stmt->execute([$room_uid]); 
            $row = $stmt->fetchAll();
 
            if($row > 0){
                return $row;
            }else{
                return "false";
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>