<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';
?>
<style>input {padding: 5px;}
    .container{margin-left : 500px; padding: 10px; border: 2px solid #ddd; width: 184px;}
    h2{color : red;}
</style>
<div class='container'>
    <form method="post">
        <h3>Create New Client</h3><br />
        <input  name='client_id'  type="text" placeholder="Client name Ex: Appiness"/><br/><br/>
        <input  name='client_secret'    type="text" placeholder="Client secret Ex: Appy"/><br/><br/>
        <input  name='redirect_uri'    style="width: 270px;"
                type="text" placeholder="Ex: http://google.com"/><br/><br/>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<?php

if (isset($_POST['submit']) && isset($_POST['client_id'])) {
    global $conn;
    $client_id = santize($_POST['client_id']);
    $client_secret = santize($_POST['client_secret']);
    $redirect_uri = santize($_POST['redirect_uri']);

    if ((isset($client_id) && $client_id != '') &&
            (isset($redirect_uri) && $redirect_uri != '') && (isset($client_secret) && $client_secret != '')) {
        $query = 'INSERT INTO oauth_clients '
                . '(client_id, client_secret, redirect_uri) VALUES '
                . '("' . $client_id . '", "' . $client_secret . '", "' . $redirect_uri . '");';
        $status = mysqli_query($conn, $query);
        if ($status) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . "token.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_USERPWD, "testclient" . ":" . "testpass");
            curl_setopt($ch, CURLOPT_USERPWD, "$client_id" . ":" . "$client_secret");
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $result=json_decode($result);
            print_r($result);
            echo '<br>';
            if ($result->access_token != '') {
                // Access Api Check
                // Redirect For Authorisation
                //authorize.php?response_type=code&client_id=testclient&state=xyz
            }
        }
    } else {
        echo "<h2>Pelase Fill all the fields.<h2>";
    }
}

function santize($str) {
    $str = strip_tags(trim($str));
    return $str;
}
