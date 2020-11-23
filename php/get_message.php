<?php
require 'utils.php';
    //var_dump($_GET);
    if(isset($_GET)){
        if((isset($_GET['message_uid'])) && (isset($_GET['user_uid']))){
            //return $_POST['message'];
            echo json_encode(get_message($_GET['message_uid'], $_GET['user_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function get_message($message_uid, $user_uid){
        $rooms = [];
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM messages WHERE uid=?");
            $stmt->execute([$message_uid]); 
            $row = $stmt->fetchAll();
    
            $delsql = $conn->prepare("DELETE FROM unread_messages WHERE message_uid=? and user_uid =?");
            $delsql->execute([$message_uid, $user_uid]);
            // use exec() because no results are returned
            //$conn->exec($delsql);

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