<?php
require 'utils.php';
    //var_dump($_GET);
    if(isset($_GET)){
        if((isset($_GET['user_uid']))){
            //return $_POST['message'];
            echo json_encode(get_user_info($_GET['user_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function get_user_info($user_uid){
        $rooms = [];
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM users WHERE uid=?");
            $stmt->execute([$user_uid]); 
            $row = $stmt->fetch();
    
            $row['password'] = 'redacted';

            if($row > 0){
                return $row;
            }else{
                return false;
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>