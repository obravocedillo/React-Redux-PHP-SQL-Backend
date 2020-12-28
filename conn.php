<?php
    function openConnection(){
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "react_to_do";
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
        return $conn;
    }

    function closeConnection($conn){
        $conn -> close();
    }
    
?>