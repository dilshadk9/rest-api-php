<?php
ini_set('error_reporting', 1);
define('HOST', 'localhost');
define('USER', 'root');
define('PWD', '');
define('DATABASE', 'restapi');
define('ENCRYPTION_KEY', 'ToMjZqxKQq1jyhGoGI56zn1J83NIioBV');
define('SUCCESS_STATUS_CODE', 200);
define('ERROR_STATUS_CODE', 400);
define('TOKEN_CREATED_MSG', 'Token created successfully');
define('TOKEN_ALREADY_EXIST_MSG', 'Token already exist');
define('USER_CREATED_MSG', 'User created successfully');
define('USER_UPDATED_MSG', 'User updated successfully');
define('USER_DELETED_MSG', 'User deleted successfully');
define('TOKEN_EXPIRED', 'Token expired');
define('INVALID_ERROR_MSG', 'Invalid error');
define('DEFAULT_TIMEZONE', 'Asia/Kolkata');
date_default_timezone_set(DEFAULT_TIMEZONE);
try {
  # MySQL with PDO_MYSQL
  $DBH = new PDO("mysql:host=".HOST.";dbname=".DATABASE."", USER, PWD);
  $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e) {
	$data = array('error' => $e->getMessage());
	echo json_encode($data);
}