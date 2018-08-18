<?php

require "../../config/connection.php";
require "verification/sendSMS.php";
require "verification/sendEmail.php";

global $connect;

if (isset($_POST['action']) && $_POST['action'] == 'login') {

    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? strip_tags(trim($_POST['password'])) : null;

    if (!empty($email) && !empty($password)) {

        $sqlCheckEmail = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkEmail = $connect->prepare($sqlCheckEmail);
        $checkEmail->execute();

        if ($checkEmail->rowCount() == 1) {

            $rowCheckEmail = $checkEmail->fetch();

            $passwordVerify = password_verify($password, $rowCheckEmail['password']);

            if ($passwordVerify) {

                $response['isFailed'] = false;
                $response['withVerify'] = false;
                $response['message'] = 'Login success Testing';


                $sqlSelectLogIP = "SELECT * FROM `log_ip` WHERE `user_id` = '$rowCheckEmail[id]'";
                $selectLogIp = $connect->prepare($sqlSelectLogIP);
                $selectLogIp->execute();
                $rowLogIP = $selectLogIp->fetch();

                $server = $_SERVER['REMOTE_ADDR'];

                $accessToken = bin2hex(random_bytes(500));

                if ($rowCheckEmail['verification_2']) {

                    if ($rowLogIP['last_ip'] == $server) {

                        checkIP($rowLogIP, $rowCheckEmail, $server);

                        $sqlUpdateUser = "UPDATE `users` SET `access_token` = '$accessToken' WHERE `id` = '$rowCheckEmail[id]'";
                        $updateUser = $connect->prepare($sqlUpdateUser);
                        $updateUser->execute();

                        $response['isFailed'] = false;
                        $response['withVerify'] = false;
                        $response['message'] = 'Login success';
                        $response['result'] = ['token' => $accessToken];

                        echo json_encode($response);
                    } else {

                        checkIP($rowLogIP, $rowCheckEmail, $server);

                        if ($rowCheckEmail['access_verify'] == 1) { // Send via SMS

                            sendSMSGateway($rowCheckEmail);
                        } else { // Send via email

                            sendPHPMailer($rowCheckEmail);
                        }
                    }
                } else {

                    checkIP($rowLogIP, $rowCheckEmail, $server);

                    $sqlUpdateUser = "UPDATE `users` SET `access_token` = '$accessToken' WHERE `id` = '$rowCheckEmail[id]'";
                    $updateUser = $connect->prepare($sqlUpdateUser);
                    $updateUser->execute();

                    $response['isFailed'] = false;
                    $response['withVerify'] = false;
                    $response['message'] = 'Login success';
                    $response['result'] = ['token' => $accessToken];

                    echo json_encode($response);
                }

            } else {

                $response['isFailed'] = true;
                $response['withVerify'] = null;
                $response['message'] = 'Login failed. Check email or password';

                echo json_encode($response);
            }
        } else {

            $response['isFailed'] = true;
            $response['withVerify'] = null;
            $response['message'] = 'Email not found';

            echo json_encode($response);
        }
    } else {

        $response['isFailed'] = true;
        $response['withVerify'] = null;
        $response['message'] = 'Data request is empty';

        echo json_encode($response);
    }

}

function checkIP($rowLogIP, $rowCheckEmail, $server)
{
    global $connect;

    if ($rowLogIP) {

        $sqlLogIP = "UPDATE `log_ip` SET `last_ip` = '$server' WHERE `user_id` = '$rowCheckEmail[id]'";
        $logIP = $connect->prepare($sqlLogIP);
        $logIP->execute();
    } else {

        $sqlLogIP = "INSERT INTO `log_ip` (`id`, `user_id`, `last_ip`)
        VALUES (NULL, '$rowCheckEmail[id]', '$server')";
        $logIP = $connect->prepare($sqlLogIP);
        $logIP->execute();
    }
}

if (isset($_POST['action']) && $_POST['action'] == "checkLogin") {

    $sqlCheckLogin = "SELECT * FROM `users` WHERE `access_token` = '$_POST[accessToken]'";
    $checkLogin = $connect->prepare($sqlCheckLogin);
    $checkLogin->execute();
    $rowCheckLogin = $checkLogin->fetch();

    if ($rowCheckLogin) {

        $response['isFailed'] = false;
        $response['message'] = 'Your status is now logged in';

        echo json_encode($response);
    } else {

        $response['isFailed'] = true;
        $response['message'] = 'Your status is now not logged';

        echo json_encode($response);
    }
}