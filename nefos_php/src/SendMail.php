<?php
function MailTo($to, $username, $db){
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    $subject = "University of the Aegean registration";
    $message = "Welcome aboard !!!! :) To complete your registration click the link below:\n"
            . "http://localhost/nefos_php/Validate.php?token=$token&user=$username";
    $headers = "From: noreplyUoTARegister@test.test.com";
    $sql = "UPDATE users SET token='$token' WHERE username='$username'";
    $result = $db->query($sql);
    $sent = mail($to, $subject, $message, $headers);
//	echo $to;
    if($sent){

            echo '<script language="javascript">';
            echo 'alert("message successfully sent")';
            echo '</script>';
    }
    else{
            echo '<script language="javascript">';
            echo 'alert("Error wrong email")';
            echo '</script>';
    }
}
