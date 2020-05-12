<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
include_once 'config/database.php';
include_once 'models/user.php';

$database = new Database();
$db = $database->getConnection();

//initialize user
$user = new User($db);

//submitted data is here
//posted data
$data = json_decode(file_get_contents('php://input'));

//set property values
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

//create the user (if data packet has required values and the model succeeds)
if (!empty($user->firstname) && !empty($user->email) && !empty($user->password) && $user->create()) {
    //set response code
    http_response_code(200);
    //display success message
    echo json_encode(array('message' => 'User was created'));
}
else {
    //user not created
    http_response_code(400);

    echo json_encode(array('message' => 'Unable to create user'));
}
