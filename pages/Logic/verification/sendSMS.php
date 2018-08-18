<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;

function sendSMSGateway($rowCheckEmail)
{
    global $connect;

    $codeVerify = rand(1234, 9999);

    $smsContent = "Your verify code is $codeVerify";

    $config = Configuration::getDefaultConfiguration();
    $config->setApiKey('Authorization', "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTUzNDM5OTU4MiwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjUxOTcwLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.sb7RlcxWCR8XAaEhCucaOfp5Vx6Ky9MI9-69sx_ZGK8");
    $apiClient = new ApiClient($config);
    $messageClient = new MessageApi($apiClient);

    $sendMessageRequest = new SendMessageRequest([
        'phoneNumber' => $rowCheckEmail['phone'],
        'message' => $smsContent,
        'deviceId' => 99147
    ]);

    $sendMessage = $messageClient->sendMessages([$sendMessageRequest]);

    if ($sendMessage) {

        $verifyToken = bin2hex(random_bytes(50));

        $sqlUpdateUser = "UPDATE `users` SET `verify_code` = '$codeVerify', `verify_token` = '$verifyToken' WHERE `id` = '$rowCheckEmail[id]'";
        $updateUser = $connect->prepare($sqlUpdateUser);
        $saveUpdateUser = $updateUser->execute();

        if ($saveUpdateUser) {

            $response['isFailed'] = false;
            $response['withVerify'] = true;
            $response['message'] = 'SMS is being sent';
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
        $response['message'] = 'Send SMS is failed';

        echo json_encode($response);
    }
}