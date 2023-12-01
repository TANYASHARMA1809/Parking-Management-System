<?php
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost','root','','mini-project');

    if($conn->connect_error){
        die('Connection Failed :  '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s",$username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
    
            // Verify the password
            if($email === $row['semail']){
                if ($password === strrev($row['password'])) {
                    echo '<script>alert("Login Successfull");
                    window.location.href = "./home.html";</script>';
                    exit();
                }
                else{
                    echo '<script>alert("Incorrect Password");
                    window.location.href = "./index.html";</script>';
                    // header("Location: ./index.html");
                }
            } else {
                echo '<script>alert("Incorrect Email");
                window.location.href = "./index.html";</script>';
            }
        }
        else{
            echo '<script>alert("Incorrect UserName");
            window.location.href = "./index.html";</script>';
        }
    }
?>