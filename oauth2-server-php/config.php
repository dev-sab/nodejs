<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_get('Asia/Kolkata');
$url = "http://192.168.2.18/my-oauth2-walkthrough/oauth2-server-php/";
define('SALT', '@!#$%^*&#$^');
define('DATETIME', date('Y-m-d H:i:s'));

/**
 * Data Base Connection
 */
function conn() {
    return mysqli_connect('localhost', 'root', 'root', 'oauth');
}
