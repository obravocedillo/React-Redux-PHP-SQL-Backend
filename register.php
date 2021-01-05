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

        $stmtLogin = $mysqli->prepare("SELECT id,name,email,password FROM users WHERE email=?");
        $stmtLogin->bind_param("s",$email);
        $stmtLogin->execute();
        $resultLogin = $stmtLogin->get_result();
        
        if($resultLogin->num_rows == 0){
            $registerId = $stmt->execute();
            if($registerId){
                $_SESSION["email"]=$email;
                $_SESSION["name"]=$name;
                $_SESSION["id"]=$registerId->insert_id;
                $tempResponse = array("id"=>$registerId->insert_id,"email"=>$email,"name"=>$password);
                $data['success'] = true;
                $data['msg'] = "OK";
                $data['data'] = $tempResponse;
                echo json_encode($data);
            } else {
                $data['success'] = false;
                $data['msg'] = "Error";
                $data['data'] = 'Error';
                echo json_encode($data);
            }
        }else{
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