<?php

function echo_success($message, $data = [])
{
    echo json_encode(array(
        'status' => 'success',
        'message' => $message,
        'data' => $data
    ));
};

function echo_fail($message, $error = [])
{
    echo json_encode(array(
        'status' => 'fail',
        'message' => $message,
        'error' => $error
    ));
    exit();
}
