<?php
require 'utils.php';
    if(isset($_GET)){
        if( (isset($_GET['room_uid'])) && (isset($_GET['offset'])) && (isset($_GET['limit'])) ){
            //return $_POST['message'];
            echo json_encode(getMessages($_GET['room_uid'], $_GET['offset'], $_GET['limit']));
            
            
        }

        
    }else{
        echo "no pogger";
    }

    function getMessages($room_uid, $offset, $limit){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            //$stmt = $conn->prepare("SELECT * FROM unread_messages WHERE user_uid=? and room_uid=?");

            //SELECT * FROM `messages` ORDER BY `messages`.`id` DESC
            //SELECT * FROM `messages` WHERE room_uid = 'ce4f9e305a4ab' ORDER BY `id` DESC LIMIT 10
            $stmt = $conn->prepare("SELECT * FROM messages WHERE room_uid = ? ORDER BY id DESC LIMIT ? ");

           
         

            $stmt->execute([$room_uid, (int)$limit]); 


            $row = $stmt->fetchAll();
    
            if($row > 0){
                return $row;
            }else{
                return "false";
            }
            
    
        } catch(PDOException $e) {

            echo json_encode($e->getMessage());
        }
    
          $conn = null;
    }
?>