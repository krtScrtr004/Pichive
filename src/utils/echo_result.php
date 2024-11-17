<?php

function echo_success($message, $data = null)
{
    echo json_encode(array(
        'status' => 'success',
        'message' => $message,
        'data' => $data
    ));
};

function echo_fail($message, $error = null)
{
    echo json_encode(array(
        'status' => 'fail',
        'message' => $message,
        'error' => $error
    ));
    exit();
}
