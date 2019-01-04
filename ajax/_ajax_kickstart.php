<?php

$xtreme_bootstrap = '../xtreme/library/bootstrap.php';
if (is_file($xtreme_bootstrap)) {
    include $xtreme_bootstrap;
} else if ('../' . $xtreme_bootstrap) {
    include '../' . $xtreme_bootstrap;
}

$_PAYLOAD = $_PAYLOAD_RAW = @json_decode(file_get_contents('php://input'), true);

validate_payload($_PAYLOAD);

$response = array(
    'status' => 400,
    'response' => array(),
    'errors' => array(),
    'error_code' => 0,
        //'debug_PAYLOAD' => $_PAYLOAD
);

if (!X_LOGIN || X_LOGIN_ID <= 0) {
    $_PAYLOAD = null;
    response_error('You are not logged in.', 7);
}

//
function response_error($error_string = null, $error_code = null) {
    global $response;
    if (is_numeric($error_code)) {
        $response['error_code'] = $error_code;
    }
    if (is_string($error_string)) {
        array_push($response['errors'], $error_string);
    }
}

function check_string($string = null, $min_length = 2) {
    return isset($string) && is_string($string) && strlen($string) >= @intval($min_length);
}

function ajax_deliver($response, $json = true) {
    if ($json) {
        App::$mime = 'application/json';
    }
    Response::deliver(json_encode($response));
}

function validate_payload(&$payload) {
    if (is_bool($payload) || is_int($payload)) {
        //No Manipulation
    } else if (is_string($payload)) {
        $payload = Utilities::validate($payload);
    } else if (is_numeric($payload)) {
        $payload = intval($payload);
    } else if (is_array($payload)) {
        foreach ($payload as &$payload_item) {
            validate_payload($payload_item);
        }
    } else {
        $payload = null;
    }
}
