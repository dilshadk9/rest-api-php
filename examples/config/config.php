<?php
define('API_URL', 'http://10.30.8.1:8080/rest-api-php');
define('LOGINID', 'iknowthat');
function getAccessToken() {
    $url = API_URL.'/api/v1/token/'.LOGINID;

    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
 
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_URL, $url);
 
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 
    curl_setopt($ch, CURLOPT_HEADER, 0);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    $output = curl_exec($ch);
 
    curl_close($ch);
 
    return $output;
}
