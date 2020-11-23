<?php
require 'utils.php';
    if(isset($_GET)){
        if(isset($_GET['username'])){
            //return $_POST['message'];
            echo json_encode(check_user_exits($_GET['username']));
        }

        
    }else{
        echo "no pogger";
    }

    function check_user_exits($check_username){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$check_username]); 
            $row = $stmt->fetch();
    
            //var_dump($row);

            if($row > 0){
                return true;
            }else{
                return false;
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>