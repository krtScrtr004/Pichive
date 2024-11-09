<?php
/*
    OTP Sender API 

    Req:
    OBJ = {
        email,
        username, 
        otp_code
    }
*/

require_once '../config/load_env.php';
require '../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Data cannot be parsed!'
    ));
    exit();
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    // Server settings
    // $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                  // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = $_ENV['ML_HOST'];                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $_ENV['ML_USERNAME'];                   // SMTP username
    $mail->Password   = $_ENV['ML_PASSWORD'];                   // SMTP password; enable 2factor authentication and use app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
    $mail->Port       = $_ENV['ML_PORT'];                       // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom($_ENV['ML_USERNAME'], 'pichive.com');
    $mail->addAddress($data['email'], $data['username']);       // Name is optional

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'One Time Password';
    $mail->Body    =    '<h1>OTP for Password Reset</h1>
                        <h3>Pichive</h3> <br>
                        <p><strong>Do not share</strong> this OTP!</p>
                        <p>This is only valid for 5 minutes.</p>
                        <h2>' . $data['otp_code'] . '</h2>';
    $mail->AltBody = 'One Time Password for password reset';

    $mail->send();
    echo json_encode(array(
       'status' =>'success',
       'message' => 'OTP sent successfully!'
    ));
} catch (Exception $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Message could not be sent. Mailer Error: ' . $e->getMessage(),
    ));
}