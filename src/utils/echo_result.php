<?php

function echo_success($message) {
    echo json_encode(array(
        'success' => 'success',
        'message' => $message
    ));
    exit();
}

function echo_fail($message) {
    echo json_encode(array(
        'error' => 'fail',
       'message' => $message
    ));
    exit();
}
