<?php
require 'utils.php';
    if(isset($_GET)){
        if( (isset($_GET['user_uid'])) && (isset($_GET['room_uid']))){
            //return $_POST['message'];
            echo json_encode(get_unread_messages($_GET['user_uid'], $_GET['room_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function get_unread_messages($user_uid, $room_uid){
        $rooms = [];
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM unread_messages WHERE user_uid=? and room_uid=?");
            $stmt->execute([$user_uid, $room_uid]); 
            $row = $stmt->fetchAll();
    
            //array_push($rooms, $current_room['current_room_uid'])

   

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