<?php

require "../../../config/connection.php";

global $connect;

if (isset($_POST['action']) && $_POST['action'] == 'verifyCode') {

    $verification = isset($_POST['verification']) ? strip_tags(trim($_POST['verification'])) : null;
    $verifyToken = isset($_POST['verifyToken']) ? strip_tags(trim($_POST['verifyToken'])) : null;

    if (!empty($verification) && !empty($verifyToken)) {

        $sqlUser = "SELECT * FROM `users` WHERE `verify_token` = '$verifyToken'";
        $user = $connect->prepare($sqlUser);
        $user->execute();
        $rowUser = $user->fetch();

        if ($rowUser) {

            if ($rowUser['verify_code'] == $verification) {

                $accessToken = bin2hex(random_bytes(500));

                $sqlUpdateUser = "UPDATE `users` SET `access_token` = '$accessToken', `verify_token` = NULL WHERE `id` = '$rowUser[id]'";
                $updateUser = $connect->prepare($sqlUpdateUser);
                $updateUser->execute();

                $response['isFailed'] = false;
                $response['message'] = 'Login success';
                $response['result'] = ['token' => $accessToken];

                echo json_encode($response);
            } else {

                $response['isFailed'] = true;
                $response['message'] = 'Failed. Pleases check again your verify code';

                echo json_encode($response);
            }
        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Your token not found';

            echo json_encode($response);
        }

    } else {

        $response['isFailed'] = true;
        $response['message'] = 'Data request is empty';

        echo json_encode($response);
    }

}