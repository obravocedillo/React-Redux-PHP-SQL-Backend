<?php
    include 'conn.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $password;
    $email;
    if(isset($_POST['password']) && isset($_POST['email'])){
        $mysqli = openConnection();
        $password = $_POST['password'];
        $email = $_POST['email'];
        $stmt = $mysqli->prepare("SELECT id,name,email,password FROM users WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $user;
            while($row = $result->fetch_assoc()) {
                $tempId = $row["id"];
                $tempName = $row["name"];
                $tempEmail = $row["email"];
                $tempPassword = $row["password"];
                if (password_verify($password, $tempPassword)) {
                    $_SESSION["email"]=$tempEmail;
                    $_SESSION["name"]=$tempName;
                    $user = array("id"=>$tempId,"name"=>$tempName, "email"=>$tempEmail);
                    $data['success'] = true;
                    $data['msg'] = "OK";
                    $data['data'] = $user;
                    echo json_encode($data);
                } else {
                    $data['success'] = false;
                    $data['msg'] = "Error";
                    $data['data'] = 'Wrong password';
                    echo json_encode($data);
                }
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