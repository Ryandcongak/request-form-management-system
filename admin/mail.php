<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'it.indolinen@gmail.com';                     //SMTP username
    $mail->Password   = 'Indolinen2020';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('it.indolinen@gmail.com', 'IT Request Form Need Approval');
    $mail->addAddress('it.indolinen@gmail.com','IT Dept and Director');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('it.dept@indolinen.com');
    $mail->addCC('agus@indolinen.co.id');
    $mail->addCC('congakryand@gmail.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Indolinen IT Request Form';
    // ob_start();
    // include('data_mail_staff.php');
    // $mail->Body = ob_get_contents();
    // ob_end_clean();
    $body = "<h1>Indolinen IT Request Form</h1><hr><br><h3>Hi, You have notification need to approval</h3>";
    $body .= "Requestors Name : " . strtoupper($_POST['requestors_name']) . "<br>";
    $body .= "Needed Date : " . $_POST['date_needed'] . "<br>";
    $body .= "Type Request : " . implode(',',$_POST['requests_choose']) . "<br>";
    $body .= "Note for Sharing file : " . $_POST['notes_sharing'] . "<br>";
    $body .= "Others Notes : " . $_POST['notes_others'] . "<br>";
    
    $body .= "<p>Please click link below for login and Approve</p><br>";
    $body .= "<a href='http://192.168.1.151/it-request-form/' style='padding:5px;background-color:lightblue;color:#fff;border-radius:2px;'> View Request </a>";
    $mail->Body = $body;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>