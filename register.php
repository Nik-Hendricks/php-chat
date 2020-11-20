<?php
       include 'utils.php';


        if(isset($_POST)){
            if((isset($_POST["username"])) && (isset($_POST["password"]))){

                

                echo json_encode(register());
            }else{
                //error please complete form
        
            }
        
        
        }

        
        function register(){
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "phpchat";
            $uniqid = _uniqid();
            try {
                $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO users (id, uid, username, password, current_room_uid) VALUES(?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);

                $user_uid = _uniqid();

                $stmt->execute([null, $user_uid , $_POST['username'], $_POST['password'], '6406c009a098c']);
                
                return $user_uid;

            } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

              $conn = null;
        }
?>


