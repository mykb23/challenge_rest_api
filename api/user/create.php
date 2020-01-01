<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data  = json_decode(file_get_contents("php://input"));


if (
    !empty($data->firstname) &&
    !empty($data->lastname) &&
    !empty($data->phoneNo) &&
    !empty($data->email)
) {
    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->phoneNo = $data->phoneNo;
    $user->email = $data->email;
    $uuid = mt_rand();
    $user->uid = $uuid;


    if ($user->create()) {
        $to = $data->email;
        $subject = 'Your Unique Ten digit pin';
        $from = 'userCrud@000.webhost.com';
        
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        // Compose a simple HTML email message
        $message = '<html><body>';
        $message .= '<h1 style="color:#f40;">Hi ' .$data->firstname. '!</h1>';
        $message .= '<p style="color:#080;font-size:18px;">Here is your Unique PIN: ' .$user->uid.'</p>';
        $message .= '</body></html>';

        // Sending email
        if (mail($to, $subject, $message, $headers)) {
            $msg = 'Your mail has been sent successfully!';
        }
        // http_response_code(201);
        echo json_encode("Details successfully saved! $user->firstname, Kindly check your email for your 10 digit unique pin!");
    } else {
        // http_response_code(503);
        $user_arr = array(
            "status" => false,
            "message" => "Email already in use by another user!",
        );
        echo json_encode("Email already in use by another user! Please use another Email address!");
    }
} else {
    // http_response_code(404);
    echo json_encode('Unable to create user. Data in Complete!');
}
