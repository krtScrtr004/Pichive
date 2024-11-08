<?php
// HTTP Operation Functions

function send_data($url, $obj)
{
    $obj = json_encode($obj);
    if ($obj === null) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Data cannot be processed!'
        ));
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);
    if (!$response) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Data cannot be processed!'
        ));
    }
    return json_decode($response);
}

function send_file($url, $obj) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);

    // Execute the request and handle errors
    $response = curl_exec($ch);
    curl_close($ch);
    if (!$response) {
        return json_encode(array(
            'status' => 'fail',
            'message' => 'Data cannot be processed!'
        ));
    }
    return json_decode($response);
}
