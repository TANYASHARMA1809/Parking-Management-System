<?php
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Email = $_POST['Email'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Message = $_POST['Message'];
    
    $conn = new mysqli('localhost','root','','mini-project');
    if($conn->connect_error){
        die('Connection Failed :  '.$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("INSERT INTO contactus (FirstName, LastName, Email, PhoneNumber, Message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss",$FirstName, $LastName, $Email, $PhoneNumber, $Message);
        $stmt->execute();
        echo '<script>alert("Email Sent Successfully");
            window.location.href = "./thankyou.html";</script>';
    }
    // ini_set('SMTP', 'smtp.gmail.com');
    // ini_set('smtp_port', 587);
    // $to = "sagarsharmakosi@gmail.com";
    // $subject = "Test Email";
    // $message = $Message;
    // $headers = "From: $Email";

    // // Use the mail() function to send the email
    // $mailSuccess = mail($to, $subject, $message, $headers);

    // // Check if the email was sent successfully
    // if ($mailSuccess) {
    //     echo "Email sent successfully!";
    // } else {
    //     echo "Failed to send email.";
    // }
?>
