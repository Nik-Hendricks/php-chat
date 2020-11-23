<?php
require 'utils.php';
    if(isset($_GET)){
        if(isset($_GET['user_uid'])){
            //return $_POST['message'];
            echo get_cookie_data($_GET['user_uid']);
        }

        
    }else{
        echo "error";
    }

    function get_cookie_data($user_uid){

        $cookies = [];

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT `current_room_uid` FROM users WHERE uid=?");
            $stmt->execute([$user_uid]); 
            $current_room = $stmt->fetch();
    
           // var_dump($current_room['current_room_uid']);

            if($current_room > 0){
                $cookies["current_room_uid"] = $current_room['current_room_uid'];
                //array_push($cookies, $current_room['current_room_uid']);
                return json_encode($cookies);
            }else{
                return "false";
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>