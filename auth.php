<?php

session_start();

$admin="admin";
$password="admin123";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $data=json_decode(file_get_contents("php://input"),true);

    if($data["username"]==$admin && $data["password"]==$password){

        $_SESSION["user"]="admin";

        echo json_encode(["status"=>"ok"]);

    }else{

        echo json_encode(["status"=>"error"]);

    }

    exit;

}

if(isset($_GET["action"]) && $_GET["action"]=="logout"){

    session_destroy();

}

?>
