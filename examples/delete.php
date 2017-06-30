<?php
require_once 'config/config.php';
function getCURL($url){
 
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }

    $header = array();
    $header[] = 'Authorization:'.getAccessToken();
 
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_URL, $url);
 
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
 
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    $output = curl_exec($ch);
 
    curl_close($ch);
 
    return $output;
}

$response = getCURL(API_URL.'/api/v1/user/delete/2'); // Provide the user id to delete
print_r($response);
