<?php
    include 'conn.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $name;
    $password;
    $email;
    if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email'])){
        $mysqli = openConnection();
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name,$email,$hash);
        if($stmt->execute()){
            $_SESSION["email"]=$email;
            $_SESSION["name"]=$name;
            $data['success'] = true;
            $data['msg'] = "OK";
            $data['data'] = 'Success';
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
?>