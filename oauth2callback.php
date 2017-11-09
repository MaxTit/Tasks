<?php
/**
 * Created by PhpStorm.
 * User: Maxim Titarenko
 * Date: 07.11.2017
 * Time: 20:13:27
 * Callback for login Google Service Drive
 */
session_start();
/**
 * @import Google lib for Google Service Drive
 */
require_once ('protected/vendor/GoogleLib/vendor/autoload.php');

$client = new Google_Client();

// verify for local web server Windows
//$client->setHttpClient(new \GuzzleHttp\Client(array(
//    'verify' => 'C:\Windows\ca-bundle.crt',
//)));

$client->setAuthConfigFile('protected/vendor/GoogleLib/credentials.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/yii/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
    $_SESSION['access_token'] = $access_token;
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] .'/yii/index.php?r=googleDisk/index';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}