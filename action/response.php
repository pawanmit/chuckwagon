<?php

require_once '../utils/utils.php';
require_once '../utils/db_util.php';

if (submit_user_response()) {
    echo "Your response was submitted!";
} else {
    echo "Error submitting form. Please try again";
};

function submit_user_response() {
    $success = true;
    $response = create_response_object();
    if (isset($response)) {
        try {
        save_user_response($response);
        } catch (Exception $e) {
            print_r($e);
            $success = false;
            //write_to_log("Error saving response object");
        }
    }
    return $success;
}

function save_user_response($response) {
    $sql = "INSERT INTO response (user_response, user_name, user_instructions, lunch_date) VALUES ("
                . $response->user_response . ",'" . $response->user_name . "'," .
                "'" . $response->user_instructions . "'," . "'" . $response->lunch_date
                . "') ON DUPLICATE KEY UPDATE `user_response` = " . $response->user_response;
    $db_connection = wrapper_mysql_connect(null);
    //write_to_log($sql);
    wrapper_mysql_query($sql, $db_connection);
}

function create_response_object() {

    $user_response = $_POST["user_response"];
    $user_name = $_POST["user_name"];
    $instructions = $_POST["user_instructions"];
    $user_response_bit = $user_response == 'yes' ? 1 : 0;
    $current_date = date('Y-m-d');
    $lunch_date = date('Y-m-d', strtotime($current_date . ' + 1 day') );
    //write_to_log("inside submit_user_response");
    //write_to_log("response: " . $user_response_bit . " lunch date: " . $lunch_date);
    $response = new stdClass();
    $response->user_response = $user_response_bit;
    $response->lunch_date = $lunch_date;
    $response->user_name = "$user_name";
    $response->user_instructions = $instructions;
    return $response;
}