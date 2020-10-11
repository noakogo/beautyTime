<?php
    $servername = "localhost";
    $username = "noakois_project";
    $password = "123456";
    $dbname = "noakois_memiq";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("DB connection failed: ".$conn->connect_error);
    }
?>
