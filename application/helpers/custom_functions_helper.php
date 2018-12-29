<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function cus_nice_timestamp($time) {

    return date('d M y G:i', strtotime($time));
}

function cus_nice_date($time) {

    return date('d M y', strtotime($time));
}

function cus_nice_short_date($time) {

    return date('d M', strtotime($time));
}

function lz($num) {
    $num = floor($num);
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

function cus_is_weekend($date) {
    return (date('N', strtotime($date)) >= 6);
}

function cus_get_seconds_from_hrs_mns_secs($str_time) {

    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

    return $time_seconds;
}

function cus_random_password() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function cus_print_r($input) {
    echo "<pre>";
    print_r($input);
}

function cus_price_form($price) {
    return number_format($price, 0, '.', ',');
}

function cus_price_form_french($price) {
    return number_format($price, 2, '.', '&nbsp;');
}

function cus_get_session_expire_json() {

    return json_encode([
        'status' => [
            'error' => TRUE,
            'error_type' => 'pop',
            "error_msg" => 'Your Session has expired, Please Login again',
            'redirect' => true,
        ],
        'url' => site_url('user/index')
    ]);
}

function cus_time_ago($timestamp = 0, $now = 0) {

    // Set up an array of time intervals.
    $intervals = array(
        60 * 60 * 24 * 365 => 'year',
        60 * 60 * 24 * 30 => 'month',
        60 * 60 * 24 * 7 => 'week',
        60 * 60 * 24 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second',
    );

    // Get the current time if a reference point has not been provided.
    if (0 === $now) {
        $now = time();
    }

    // Make sure the timestamp to check predates the current time reference point.
    if ($timestamp > $now) {
        throw new \Exception('Timestamp postdates the current time reference point');
    }

    // Calculate the time difference between the current time reference point and the timestamp we're comparing.
    $time_difference = (int) abs($now - $timestamp);

    // Check the time difference against each item in our $intervals array. When we find an applicable interval,
    // calculate the amount of intervals represented by the the time difference and return it in a human-friendly
    // format.
    foreach ($intervals as $interval => $label) {

        // If the current interval is larger than our time difference, move on to the next smaller interval.
        if ($time_difference < $interval) {
            continue;
        }

        // Our time difference is smaller than the interval. Find the number of times our time difference will fit into
        // the interval.
        $time_difference_in_units = round($time_difference / $interval);

        if ($time_difference_in_units <= 1) {
            $time_ago = sprintf('one %s ago', $label
            );
        } else {
            $time_ago = sprintf('%s %ss ago', $time_difference_in_units, $label
            );
        }

        return $time_ago;
    }
}

function cus_get_file_extension($filename) {
    $file_array = explode('.', $filename);
    return end($file_array);
}

function cus_is_json($string) {

    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
}

function cus_json_error($msg) {
    echo json_encode([
        'status' => [
            'error' => TRUE,
            'error_type' => 'pop',
            "error_msg" => $msg
        ]
    ]);
    die();
}

function cus_preciding_zeros($number) {
    return str_pad($number, PRECIDING_ZEROZ, '0', STR_PAD_LEFT);
}

function cus_phone_with_255($phone_number, $prefix = '255') {
    return $prefix . substr($phone_number, -9);
}

function cus_status_template($status) {

    $status_template = "";

    switch ($status) {
        case 'NEW':
            $status_template = '<h5><span class="badge badge-info">NEW</span></h5>';
            break;

        
        case 'INPROGRESS':
            $status_template = '<h5><span class="badge badge-danger">INPROGRESS</span></h5>';
            break;
        
        case 'PENDING':
            $status_template = '<h5><span class="badge badge-danger">PENDING</span></h5>';
            break;

        case 'COMPLETED':
            $status_template = '<h5><span class="badge badge-info">COMPLETED</span></h5>';
            break;

        case 'APPROVED':
            $status_template = '<h5><span class="badge badge-success">APPROVED</span></h5>';
            break;

        case 'PAUSED':
            $status_template = '<h5><span class="badge badge-secondary">PAUSED</span></h5>';
            break;
        
        case 'DISAPPROVED':
            $status_template = '<h5><span class="badge badge-danger">DISAPPROVED</span></h5>';
            break;
        
        case 'REJECTED':
            $status_template = '<h5><span class="badge badge-danger">REJECTED</span></h5>';
            break;


        default:
            break;
    }
    
    return $status_template;
}


function cus_ionic_color($status) {

    $status_template = "";

    switch ($status) {
        case 'NEW':
            $status_template = 'primary';
            break;

        case 'PENDING':
            $status_template = 'danger';
            break;

        case 'COMPLETED':
            $status_template = 'primary';
            break;

        case 'APPROVED':
            $status_template = 'secondary';
            break;

        case 'PAUSED':
            $status_template = 'dark';
            break;
        
        case 'DISAPPROVED':
            $status_template = 'danger';
            break;
        
        case 'REJECTED':
            $status_template = 'danger';
            break;


        default:
            break;
    }
    
    return $status_template;
}

function cus_ellipsis($in, $lenght){
    return strlen($in) > $lenght ? substr($in,0,$lenght)."..." : $in;;
}
