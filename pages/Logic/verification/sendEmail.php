<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;

function sendPHPMailer($rowCheckEmail)
{
    global $connect;

    $codeVerify = rand(1234, 9999);

    $mail = new PHPMailer;

    $mail->IsSMTP();
    $mail->SMTPDebug = 1; // set mailer to use SMTP
    $mail->Timeout = 120; // set longer timeout for latency or servers that take a while to respond

    //smtp.dps.globalxtreme.net
    $mail->Host = "202.58.203.26"; // specify main and backup server
    $mail->Port = 2505;
    $mail->SMTPAuth = false; // turn on or off SMTP authentication

    $mail->From = "yuswa@globalxtreme.com";
    $mail->FromName = "Bali Yuswa Yuswa";
    $mail->addAddress($rowCheckEmail['email'], $rowCheckEmail['username']);
    $mail->isHTML(true);
    $mail->Subject = "Verification code";
    $mail->Body = "Your code verification $codeVerify";

    if ($mail->send()) {

        $verifyToken = bin2hex(random_bytes(50));

        $sqlUpdateUser = "UPDATE `users` SET `verify_code` = '$codeVerify', `verify_token` = '$verifyToken' WHERE `id` = '$rowCheckEmail[id]'";
        $updateUser = $connect->prepare($sqlUpdateUser);
        $saveUpdateUser = $updateUser->execute();

        if ($saveUpdateUser) {

            $response['isFailed'] = false;
            $response['withVerify'] = true;
            $response['message'] = 'Check your email';
            $response['result'] = ['token' => $verifyToken];

            echo json_encode($response);
        } else {

            $response['isFailed'] = true;
            $response['withVerify'] = null;
            $response['message'] = 'Save code is failed';

            echo json_encode($response);
        }
    } else {

        $response['isFailed'] = true;
        $response['withVerify'] = null;
        $response['message'] = 'Send Email is failed';

        echo json_encode($mail);
    }
}