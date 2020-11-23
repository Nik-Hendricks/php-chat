<?php
require 'utils.php';
    //var_dump($_GET);
    if(isset($_GET)){
        if((isset($_GET['to_uid'])) && (isset($_GET['from_uid']))){
            //return $_POST['message'];
            echo json_encode(check_pm_exists($_GET['to_uid'], $_GET['from_uid']));
        }

        
    }else{
        echo "no pogger";
    }

    function check_pm_exists($to_uid, $from_uid){
        $rooms = [];
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM private_rooms WHERE to_uid=? AND from_uid=?");
            $stmt->execute([$to_uid, $from_uid]); 
            $row = $stmt->fetch();

            if($row > 0){
                return $row['room_uid'];
            }else{
                return false;
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>