<?php

include 'config.php';
if (isset($_GET['url']) && $_GET['url'] != '') {
    if (function_exists($_GET['url'])) {
        $_GET['url']();
    }
}

function get_token() {
    if (isset($_POST)) {
        $user_id = trim($_POST['user_id']);
        $client_id = trim($_POST['client_id']);
        $secret = secret();
        if ((isset($user_id) && $user_id != '') && (isset($client_id) && $client_id != '')) {
            $conn = conn();
            $query = 'SELECT 
            *
            FROM
            oauth_users         
            where
            client_id="' . $client_id . '" and user_id=' . $user_id;
            $conn = conn();
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                $start_date = new DateTime(DATETIME);
                $end_date = new DateTime($data['date_time']);
                $interval = $start_date->diff($end_date);
                //print_r($interval);
//                if ($interval->i > 1) {
                if ($interval->i > 0) {
                    $token = md5($user_id . $secret . $client_id . SALT);
                    // token Expired Create a new Token and Update the user
                    $update_token = "update oauth_users set "
                            . "date_time='" . DATETIME . "'"
                            . ",token='$token'"
                            . " where user_id=$user_id";
                    $status = mysqli_query($conn, $update_token);
                    if ($status) {
                        $response['user_id'] = $user_id;
                        $response['access_token'] = $token;
                        $response['expires_in'] = 1;
                        $response['expired'] = true;
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['user_id'] = $user_id;
                    $response['access_token'] = $data['token'];
                    $response['expires_in'] = 1;
                    $response['expired'] = false;
                    echo json_encode($response);
                    exit;
                }
            } else {
                $query = 'SELECT 
                    *
                FROM
                    oauth_clients c
                        left join
                    oauth_access_tokens t on
                        t.client_id = c.client_id
                where
                    c.client_id="' . $client_id . '"';

                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $token = md5($user_id . $secret . $client_id . SALT);
                    $data = mysqli_fetch_assoc($result);
                    $map_user = "INSERT INTO `oauth_users`
                (
                `user_id`,
                `client_id`,
                `secret`,token,date_time) values ($user_id,'$client_id',$secret,'$token','" . DATETIME . "')";
                    $status = mysqli_query($conn, $map_user);
                    if ($status) {
                        // Generate a  user token
                        $response['user_id'] = $user_id;
                        $response['access_token'] = $token;
                        $response['expires_in'] = 1;
                        $response['expired'] = false;
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    echo 'Client Dosent Exist,';
                }
            }
        } else {
            echo 'User and Client Name is Required';
        }
    }
}

function secret() {
    return mt_rand(1000000000, 9999999999);
}

function check_token() {
    $user_id = $_POST['user_id'];
    $token = trim($_POST['token']);
    $client_id = trim($_POST['client_id']);
    if ($user_id && $token && $client_id) {
        $conn = conn();
        $query = "SELECT 
            user_id,date_time
            FROM
            oauth_users         
            where
            client_id='$client_id' and token='$token' and user_id=" . $user_id;
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $start_date = new DateTime(DATETIME);
            $end_date = new DateTime($data['date_time']);
            $interval = $start_date->diff($end_date);
            if ($interval->i == 0) {
                $response['status'] = 'token valid';
                $response['min'] = $interval->i;
                $response['sec'] = $interval->s;

                echo json_encode($response);
                exit;
            } else {
                $response['status'] = 'token expired';
                $response['min'] = $interval->i;
                $response['sec'] = $interval->s;
                echo json_encode($response);
                exit;
            }
        } else
            $response['status'] = 'token expired';
        echo json_encode($response);
        exit;
    }
}
