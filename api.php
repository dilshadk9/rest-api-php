<?php
/**
 * To demonstrate the REST API using Slim Micro Framework
 * @version  1.0
 * @author  Dilshad.Khan <dilshad.khan.in@gmail.com>
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '/vendor/autoload.php';
require_once 'config/config.php';

// create new instance of Slim application
$app = new \Slim\App;
// To get access token
$app->get('/api/v1/token/{loginid}', 'getToken');
// list user by id / list all users
$app->get('/api/v1/user[/{id}]', 'getUsers')->add('authenticate');
// add new user
$app->post('/api/v1/user/create', 'createUser')->add('authenticate');
// update existing user
$app->put('/api/v1/user/update/{id}', 'updateUser')->add('authenticate');
// delete existing user
$app->delete('/api/v1/user/delete/{id}', 'deleteUser')->add('authenticate');
// run the application
$app->run();

/**
 * To get the unique token
 * @param  Request  $request  Request object
 * @param  Response $response Response object
 * @return object
 */
function getToken(Request $request, Response $response) {
	global $DBH;
	$param = array();
	$data = array();
	$id = $request->getAttribute('loginid');
	$param['loginid'] = $id;
	$sql = 'SELECT token,expire_datetime FROM token WHERE loginid = :loginid';
	$STH = $DBH->prepare($sql);
	$STH->execute($param);
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	$tokenvalid = $STH->fetch();
	$key = md5(ENCRYPTION_KEY.$id);
	$token = hash('sha256', $key);
	$data['token'] = $token;
	$data['loginid'] = $id;
	if(empty($tokenvalid)) {
		try {
			$STH = $DBH->prepare("INSERT INTO token(token,expire_datetime,loginid) VALUES(:token, date_add(now(), interval 10 minute), :loginid)");
			$STH->execute($data);
			$DBH = null;
		    $response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'token' => $token, 'message' => TOKEN_CREATED_MSG)));

		}
		catch(PDOException $e) {
			$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => $e->getMessage())));
		}
	}
	else if(!empty($tokenvalid) && $tokenvalid['token'] == $token) {
			$response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'token' => $token, 'message' => TOKEN_ALREADY_EXIST_MSG)));
	}
	else {
		$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'message' => INVALID_ERROR_MSG)));
	}
	return $response;
}

/**
 * To list all the users
 * @param  Request  $request  Request object
 * @param  Response $response Response object
 * @return object
 */
function getUsers(Request $request, Response $response) {
	global $DBH;
	$param = array();
	$id = $request->getAttribute('id'); // userid
	$sql = 'SELECT id,firstname,lastname,email,address,mobile FROM users WHERE 1=1';
	if(!empty($id)) { 
		$sql .= ' AND id = :id';
		$param['id'] = $id;
	}
	try {
		$STH = $DBH->prepare($sql);
		$STH->execute($param);
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$data = $STH->fetchAll();
		$DBH = null;
	    $response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'data' => $data)));
	}
	catch(PDOException $e) {
		$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => $e->getMessage())));
	}
    return $response;
}

/**
 * To create new users
 * @param  Request  $request  Request object
 * @param  Response $response Response object
 * @return object
 */
function createUser(Request $request, Response $response) {
	global $DBH;
	$param = $request->getParams();
    $data['firstname'] = $param['firstname'];
    $data['lastname'] = $param['lastname'];
    $data['email'] = $param['email'];
    $data['address'] = $param['address'];
    $data['mobile'] = $param['mobile'];
	try {
		$STH = $DBH->prepare("INSERT INTO users(firstname,lastname,email,address,mobile) VALUES(:firstname, :lastname, :email, :address, :mobile)");
		$STH->execute($data);
		$DBH = null;
		$response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'message' => USER_CREATED_MSG)));
	}
	catch(PDOException $e) {
		$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => $e->getMessage())));
	}
    return $response;
}

/**
 * To update existing user
 * @param  Request  $request  Request object
 * @param  Response $response Response object
 * @return object
 */
function updateUser(Request $request, Response $response) {
	global $DBH;
    $id = $request->getAttribute('id');
    $param = $request->getParams();
    $data['id'] = $id;
    $data['firstname'] = $param['firstname'];
    $data['lastname'] = $param['lastname'];
    $data['email'] = $param['email'];
    $data['address'] = $param['address'];
    $data['mobile'] = $param['mobile'];
	try {
		$STH = $DBH->prepare('UPDATE users SET firstname = :firstname,lastname = :lastname,email = :email, address = :address, mobile= :mobile WHERE id = :id');
		$STH->execute($data);
		$DBH = null;
	    $response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'message' => USER_UPDATED_MSG)));
	}
	catch(PDOException $e) {
		$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => $e->getMessage())));
	}
    return $response;
}

/**
 * To delete existing user
 * @param  Request  $request  Request object
 * @param  Response $response Response object
 * @return object             
 */
function deleteUser(Request $request, Response $response) {
	global $DBH;
    $id = $request->getAttribute('id');
    $data['id'] = $id;
	try {
		$STH = $DBH->prepare('DELETE FROM users WHERE id = :id');
		$STH->execute($data);
		$DBH = null;
	    $response->getBody()->write(json_encode(array('status' => SUCCESS_STATUS_CODE, 'message' => USER_DELETED_MSG)));
	}
	catch(PDOException $e) {
		$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => $e->getMessage())));
	}
    return $response;
}

/**
 * To validate the existing token
 * @param  [type] $request  Request object
 * @param  [type] $response Response object
 * @return bool        		true/false
 */
function validateToken($request, $response) {
	global $DBH;
	$authHeader = current($request->getHeader('HTTP_AUTHORIZATION'));
	$authHeader = json_decode($authHeader,TRUE);
	$token = $authHeader['token'];
	$sql = 'SELECT COUNT(1) AS count FROM token WHERE token = :token AND expire_datetime > NOW()';
	$STH = $DBH->prepare($sql);
	$STH->execute(array('token' => $token));
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	$tokenvalid = $STH->fetch();
	if($tokenvalid['count']) {
		return true;
	}
	else {
		$STH = $DBH->prepare('DELETE FROM token WHERE token = :token');
		$STH->execute(array('token' => $token));
		$DBH = null;
		return false;
	}
}

/**
 * Middleware to authenticate if token is valid for each request
 * @param  [type] $request  Request object
 * @param  [type] $response Response object
 * @param  [type] $next     callback
 * @return object           
 */
function authenticate($request, $response, $next) {
	$response->withHeader('Content-type', 'application/json');
    $isValidToken = validateToken($request,$response);
    if($isValidToken === false) {
    	$response->getBody()->write(json_encode(array('status' => ERROR_STATUS_CODE, 'error' => TOKEN_EXPIRED)));
    	return $response;
    }
    $response = $next($request, $response);
    return $response;
};