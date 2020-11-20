<?php
/*
require 'utils.php';


if(isset($_POST)){
    if((isset($_POST["login-username"])) && (isset($_POST["login-password"]))){

        echo $res = checkLogin($_POST["login-username"], $_POST["login-password"]);
        
      
        exit;

        if($res != "false"){
            //setcookie('uid', $res, time() + 60*60*24*30, '/');
            //setcookie('username', $_POST['login-username'], time() + 60*60*24*30, '/');
            //setcookie('current_room', "", time() + 60*60*24*30, '/');
            //header("Location: chat.html");

            //echo $res;

            exit;
        
        }else{
            //header("Location: login.html");
        }
    }else{
       // header("Location: login.html");

    }


}

/*
if(isset($_GET)){
    if(isset($_GET["login-username"], && isset($_GET['login-password']))){
        $res = checkLogin($_GET["login-username"], $_GET["login-password"]);

        if $res != "false"){

        }

    }
}*/


/*
function checkLogin($login_username, $login_password){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "phpchat";
    $uniqid = _uniqid();
    try {
        $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();


        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? and password=?");
        $stmt->execute([$login_username, $login_password]); 
        $user = $stmt->fetch();

        var_dump($user);

        if($user['uid'] > 0){
            return json_encode($user['uid']);
            var_dump($user);
        }else{
            return "false";
        }
        

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

      $conn = null;
}*/
?>



<?php
require 'utils.php';

    if(isset($_GET)){
        if( (isset($_GET['login_username'])) && (isset($_GET['login_password'])) ){
            $res = checkLogin($_GET["login_username"], $_GET["login_password"]);
            echo json_encode($res);

            

        }
    }

    function checkLogin($login_username, $login_password){
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "phpchat";
        try {
            $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            //$user = $conn->query("SELECT * FROM users WHERE username = '$login_password', password = '$login_password'")->fetch();
    
    
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=? and password=?");
            $stmt->execute([$login_username, $login_password]); 
            $row = $stmt->fetch();
    

            if($row > 0){
                //setcookie('uid', $row['uid'], time() + 60*60*24*30, '/');
                return $row['uid'];
            }else{
                return false;
            }
            
    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    
          $conn = null;
    }

?>