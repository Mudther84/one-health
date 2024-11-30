<?php
require_once('vendor/autoload.php');
require_once('db/src/db.php');

use DB\DB;

header("Access-Control-Allow-Origin:*");

header("Content-Type: application/json; charset=UTF-8");

header('Access-Control-Allow-Headers:*');

$ultramsg_token = "todsqd1jt18loqqs";

$instance_id = "instance96041";

$client = new UltraMsg\WhatsAppApi($ultramsg_token, $instance_id);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $token = $input['token'];
    if (!empty($token)) {

        $user = DB->table('users')->where('token', $token)->get();
        if (!empty($user)) {
            $user = $user[0];

            DB->table('messages')->create([
                '`from`' => $token,
                'message' => $input['message'],
                '`birth-date`' => $input['date'],
            ]);
            $to = '+249969926518';

            $birthDate = substr($input['date'], 0, strpos($input['date'], ':'));

            $body = "
Name: {$user['name']}
   
Email: {$user['email']}
   
birth-date : {$birthDate}
   
general-health : {$input['general-health']}    
   
Message : {$input['message']}";


            $api =  $client->sendChatMessage($to, $body);

            echo json_encode(['Message' =>  'Check Whatsapp Messages']);
            http_response_code(201);
        } else {
            http_response_code(401);
            echo json_encode(['Error' =>  'User Not Registerd']);
        }
    } else {
        echo json_encode(['error' =>  'Invalid Data ']);
        http_response_code(400);
    }
} else {
    echo json_encode(["error" => "METHOD {$_SERVER['REQUEST_METHOD']} IS NOT SUPPORTED"]);
}

exit();
