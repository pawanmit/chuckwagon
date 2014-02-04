<?php

require_once '../utils/utils.php';
require_once '../utils/db_util.php';

submit_user_response();

function submit_user_response() {
    $response = create_response_object();
    if (isset($response)) {
        try {
        save_user_response($response);
        } catch (Exception $e) {
            write_to_log("Error saving response object");
        }
    }
}

function save_user_response($response) {
    $sql = "INSERT INTO response (user_response, user_name, lunch_date) VALUES ("
                . $response->user_response . ",'" . $response->user_name . "', '" . $response->lunch_date
                . "') ON DUPLICATE KEY UPDATE `user_response` = " . $response->user_response;
    $db_connection = wrapper_mysql_connect(null);
    write_to_log($sql);
    wrapper_mysql_query($sql, $db_connection);
}

function create_response_object() {
    $user_response = $_POST['response'];
    $user_response_bit = $user_response == 'YES' ? 1 : 0;
    $lunch_date = '2014-02-05';
    write_to_log("inside submit_user_response");
    write_to_log("response: " . $user_response_bit . " lunch date: " . $lunch_date);
    $response = new stdClass();
    $response->user_response = $user_response_bit;
    $response->lunch_date = $lunch_date;
    $response->user_name = "Pawan2";
    return $response;
}