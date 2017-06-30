<?php
require_once 'config/config.php';
function getCURL($url){
 
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }

    $header = array();
    $header[] = 'Authorization:'.getAccessToken();

    // Provide the data to create new user
    $data = array(
      'firstname' => 'User Firstname updated',
      'lastname' => 'User Lastname updated',
      'email' => 'useremailupdated@gmail.com updated',
      'address' => 'User address updated',
      'mobile' => '1234567891'
    );
 
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_URL, $url);
 
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    $output = curl_exec($ch);
 
    curl_close($ch);
 
    return $output;
}

$response = getCURL(API_URL.'/api/v1/user/update/5'); //Provide the user id along with above data ($data) to update the user
print_r($response);