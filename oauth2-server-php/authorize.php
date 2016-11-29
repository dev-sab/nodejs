<?php

// include our OAuth2 Server object
require_once 'config.php';
require_once __DIR__ . '/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST)) {
    exit('
<form method="post">
  <label>Do You Authorize TestClient?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized);
if ($is_authorized) {
    // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
    $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
    //exit("SUCCESS! Authorization Code: $code");
    if ($code) {
        $client = getClientDetails($_GET['client_id']);
        if ($client != null) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . "token.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=$code");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $client['client_id'] . ":" . $client['client_secret']);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            print_r($result); exit;
        }
    }
}

function getClientDetails($client_id) {
    global $conn;
    $query = "select * from oauth_clients where client_id='$client_id'";
    $result = mysqli_query($conn, $query);
    return (mysqli_num_rows($result) > 0 ) ? mysqli_fetch_assoc($result) : null;
}

$response->send();
