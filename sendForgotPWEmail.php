<?php

include "functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendmail($email, $resettoken) {

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);



    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 1;
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'careercafeteam@gmail.com';           //SMTP username
        $mail->Password   = 'ryonuaqbqeuznyzq';                         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                                  //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('careercafeteam@gmail.com', 'CareerCafe');
        $mail->addAddress($email, 'CareerCafe User');     //Add a recipient

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset your password';
        $mail->Body    = "We received a request from you to reset your password! If this was not you, please check your account security. <br> <br> Click the link bellow: <br>
    <a href='http://localhost/project-azipis/resetPassword.php?email=$email&resettoken=$resettoken'>Reset Password</a> <br>
    <br> Best regards, <br> CareerCafe Team";
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['email']) && (!empty($_POST['email']))){

    $email = get_sanitized_string_param($_POST,'email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $error = '';

    if (!$email) {

        $error .= "Invalid email address please enter a valid email address!";

    } else {

        $result = php_select("SELECT * FROM users WHERE email = '".$email. "'");
        $row = mysqli_num_rows($result);

        if ($row == ""){
            $error .= "No user is registered with this email address!";
        }
    }

    if ($error != ""){
        echo $error;
    } else {

        $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $key = md5(strval(2418*2).$email);
        $addKey = substr(md5(uniqid(rand(),1)),3,10);
        $resettoken = $key . $addKey;



        $query = "INSERT INTO passwordreset VALUES (?,?,?) ON DUPLICATE KEY UPDATE resettoken = VALUES(resettoken), resettokenexp = Values(resettokenexp) ";
        $types = "sss";
        php_insert($query, $types, $email, $resettoken, $expDate);


        sendmail($email, $resettoken);


    }

} else {
    echo "Not post";
}

?>