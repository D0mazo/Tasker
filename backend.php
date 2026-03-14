<?php

session_start();

if(!isset($_SESSION["user"])){
    exit;
}

$file="tasks.json";

if(!file_exists($file)){
    file_put_contents($file,"[]");
}

$tasks=json_decode(file_get_contents($file),true);

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $data=json_decode(file_get_contents("php://input"),true);

    if($data["action"]=="add"){

        $tasks[]=array(
            "name"=>$data["name"],
            "deadline"=>$data["deadline"],
            "hours"=>$data["hours"],
            "done"=>$data["done"]
        );

        file_put_contents($file,json_encode($tasks));

        echo json_encode(["status"=>"ok"]);

    }

    exit;

}


if($_GET["action"]=="list"){

    $result=[];

    foreach($tasks as $t){

        $progress=0;

        if($t["hours"]>0){
            $progress=round(($t["done"]/$t["hours"])*100);
        }

        $left=$t["hours"]-$t["done"];

        $t["progress"]=$progress;
        $t["left"]=$left;

        $result[]=$t;

    }

    echo json_encode($result);

}
?>