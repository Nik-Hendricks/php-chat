<?php
require 'utils.php';


if(isset($_POST)){
    if((isset($_POST["user_uid"])) && (isset($_POST["user_cookies"]))){
        //var_dump($_POST['user_cookies']["current_room_uid"]);
        setcookie("current_room_uid", $_POST['user_cookies']["current_room_uid"],  time() + 60*60*24*30, '/');
        setcookie("user_uid", $_POST["user_uid"], time() + 60*60*24*30, '/');
        //header("Location: chat.html");
        echo true;
    }
}
?>