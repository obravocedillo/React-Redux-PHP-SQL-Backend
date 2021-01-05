<?php
    include 'conn.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $item;
    if($_SESSION["email"] && $_SESSION["id"]){
        if(isset($_POST['item'])){
            $mysqli = openConnection();
            $item = json_decode($_POST['item']);
            $stmt = $mysqli->prepare("INSERT INTO tasks (name, description, user_id, lane_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $item['title'],$item['descripton'],$_SESSION["id"],$item['lane_id']);
            $addItem = $stmt->execute();
            if($addItem){
                $data['success'] = true;
                $data['msg'] = "OK";
                $data['data'] = "Success";
                echo json_encode($data);
            } else {
                $data['success'] = false;
                $data['msg'] = "Error";
                $data['data'] = 'Error';
                echo json_encode($data);
            }
           
        } else {
            $data['success'] = false;
            $data['msg'] = "Error";
            $data['data'] = 'Error';
            echo json_encode($data);
        }
    } else {
        $data['success'] = false;
        $data['msg'] = "Error";
        $data['data'] = 'Error';
        echo json_encode($data);
    }
?>