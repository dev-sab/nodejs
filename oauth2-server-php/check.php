<?php
include 'config.php';



if (isset($_GET['access_token'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . "resource.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $GET['access_token']);
    curl_setopt($ch, CURLOPT_POST, 1);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    print_r($result);
    $result = json_decode($result);
} else
    echo 'Require Access Token ';
