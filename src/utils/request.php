<?php

function sendData($url, $obj)
{
    $obj = json_encode($obj);
    if ($obj === null) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Data cannot be parsed!'
        ));
        exit();
    }

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => $obj,
            'header' =>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    if ($response === null) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Data cannot be parsed!'
        ));
        exit();
    }

    return $response;
}