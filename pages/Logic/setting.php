<?php

require "../../config/connection.php";

global $connect;

if (isset($_POST['action']) && $_POST['action'] == 'setting') {

    $userId = isset($_POST['userId']) ? strip_tags(trim($_POST['userId'])) : null;
    $verification2 = isset($_POST['verification']) ? strip_tags(trim($_POST['verification'])) : null;
    $verifyAccess = isset($_POST['verifyAccess']) ? strip_tags(trim($_POST['verifyAccess'])) : null;
    $phone = isset($_POST['phone']) ? strip_tags(trim($_POST['phone'])) : null;

    if (!empty($userId)) {

        $sqlUpdateUser = "UPDATE `users` SET `verification_2` = '$verification2', `access_verify` = '$verifyAccess', `phone` = '$phone' WHERE `id` = '$userId'";
        $updateUser = $connect->prepare($sqlUpdateUser);

        if ($updateUser->execute()) {

            $response['isFailed'] = false;
            $response['message'] = 'Update data successfully';

            echo json_encode($response);
        } else {

            $response['isFailed'] = true;
            $response['message'] = 'Update data failed';

            echo json_encode($response);
        }

    } else {

        $response['isFailed'] = true;
        $response['message'] = 'Data request is empty';

        echo json_encode($response);
    }

}

elseif (isset($_POST['action']) && $_POST['action'] == "getUser") {

    $sqlGetUser = "SELECT * FROM `users` WHERE `access_token` = '$_POST[accessToken]'";
    $getUser = $connect->prepare($sqlGetUser);
    $getUser->execute();
    $rowGetUser = $getUser->fetch();

    if ($rowGetUser) {

        $response['isFailed'] = false;
        $response['message'] = 'Get user success';
        $response['result'] = $rowGetUser;

        echo json_encode($response);
    } else {

        $response['isFailed'] = true;
        $response['message'] = 'Get user failed';

        echo json_encode($response);
    }

}