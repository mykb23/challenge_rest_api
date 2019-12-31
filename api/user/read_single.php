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

$user->uid = isset($_GET['uid']) ? $_GET['uid'] : die();

$user->getUserDetails($user->uid);

if ($user->email != null) {
    // create array
    $user_arr = array(
        'id' => $user->id,
        'details' => $user
    );

    http_response_code(200);

    echo json_encode($user_arr);
} else {
    http_response_code(404);

    echo json_encode(array('message' => 'user dose not exist.'));
}
