<html>
<head>
    <style>
        ul
        {
            list-style-type: none;
        }
    </style>
</head>
<?php

require_once 'utils/utils.php';
require_once 'utils/db_util.php';

//get unique dates from database in reverse cron:

//create a html page with those unique date clickable

//when user clicks on a date, take him to admin.php?date=mm/dd/yyyy

//On this page she can see the number of yes and nos

//List of users with special instructions


$db_connection = wrapper_mysql_connect(null);

$dateString =  getDateFromQueryString();

if ($dateString) {
    display_summary_by_date($dateString);
    display_details_by_date($dateString);
} else {
    display_available_dates();

}

function display_summary_by_date($date)  {
    echo '<h4>Summary for date ' . $date . '</h4><br>';
    echo '<ul><li><span class="label">Total people who replied YES: ' . get_count_by_response($date, 1) . '</li></ul>';
    //echo '<li>><span class="label">Total people who replied NO' . get_count_by_response($date, 1) . '</li>';
}

function display_details_by_date($date) {
    $details = get_details($date);
    $count = mysql_num_rows ( $details );
    echo $count;
}
function get_count_by_response($date, $response) {
    $query = "SELECT COUNT(1) FROM response WHERE lunch_date='" . $date . "' AND user_response=" . $response;
    //echo $query; die;
    global $db_connection;
    $result  = wrapper_mysql_query($query, $db_connection);
    return mysql_result($result,0);
}

function get_details($date) {
    $query = "SELECT user_name, user_instructions FROM response WHERE lunch_date='" . $date . "' AND user_response=" . 1;
    global $db_connection;
    $result  = wrapper_mysql_query($query, $db_connection);
    return $result;
}

function display_available_dates() {
    echo "Available Dates";
    $avalable_dates = get_available_dates();
    if ($avalable_dates) {
        $count = mysql_num_rows ( $avalable_dates );
        $last_result_index = --$count;
        $html = '<ul>';
        for($i = 0; $i <= $last_result_index ; $i++) {
            $date = mysql_result($avalable_dates, $i);
            $html .= get_date_li($date);
        };
        $html .= '</ul>';
    }
    echo $html;
}

function get_date_li($date) {
    $date_li = '<li class="date">';
    $date_li .= '<a href=admin.php?date='.$date .'>' . $date . '</a></li>';
    return $date_li;
}
function get_available_dates() {
    $query = "SELECT DISTINCT lunch_date FROM response ORDER BY lunch_date DESC";
    global $db_connection;
    $result  = wrapper_mysql_query($query, $db_connection);
    return $result;
}

function getDateFromQueryString() {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryStringArray = explode("=", $queryString);
    if ( count($queryStringArray) == 2 && $queryStringArray[0] == 'date') {
       return $queryStringArray[1];
    } else {
        return false;
    }
 }
?>
</html>