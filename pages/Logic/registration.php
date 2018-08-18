<?php

require "../../config/connection.php";

global $connect;

if (isset($_POST['action']) && $_POST['action'] == 'registration') {

    $username = isset($_POST['username']) ? strip_tags(trim($_POST['username'])) : null;
    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : null;
    $password = isset($_POST['password']) ? strip_tags(trim($_POST['password'])) : null;
    $phone = isset($_POST['phone']) ? strip_tags(trim($_POST['phone'])) : null;

    if (!empty($username) && !empty($email) && !empty($password) && !empty($phone)) {

        $sqlCheckEmail = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkEmail = $connect->prepare($sqlCheckEmail);
        $checkEmail->execute();

        if ($checkEmail->rowCount() > 0) {

            $response['isFailed'] = true;
            $response['message'] = 'Email already exist';

            echo json_encode($response);
        } else {

            $optionHash = ['cost', 10];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT, $optionHash);

            $sqlRegister = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`)
                VALUES(NULL, '$username', '$email', '$passwordHash', '$phone')";
            $register = $connect->prepare($sqlRegister);

            if ($register->execute()) {

                $response['isFailed'] = false;
                $response['message'] = 'Registration successfully';

                echo json_encode($response);
            } else {

                $response['isFailed'] = true;
                $response['message'] = 'Registration failed';

                echo json_encode($response);
            }
        }
    } else {

        $response['isFailed'] = true;
        $response['message'] = 'Data request is empty';

        echo json_encode($response);
    }

}