<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: access');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = isset($_GET['email']) ? $_GET['email'] : die();

$user->getUserUID($user->email);

// if ($user->email != null) {
// echo $user->uid;
// exit;
// create array

$user_arr = array(
    'userDetails' => $user
);

http_response_code(200);

echo json_encode($user_arr);
// } else {
//     http_response_code(404);

//     echo json_encode(array('message' => 'user dose not exist.'));
// }
