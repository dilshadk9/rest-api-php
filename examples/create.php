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
      'firstname' => 'User Firstname',
      'lastname' => 'User Lastname',
      'email' => 'useremail@gmail.com',
      'address' => 'User address',
      'mobile' => '1234567890'
    );
 
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_URL, $url);
 
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

    curl_setopt($ch, CURLOPT_POST, 1);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
 
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);    
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
    $output = curl_exec($ch);

    if($output === false)
    {
        return curl_error($ch);
    }
 
    curl_close($ch);
 
    return $output;
}

$response = getCURL(API_URL.'/api/v1/user/create');
print_r($response);