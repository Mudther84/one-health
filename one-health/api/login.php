<?php
require_once('db/src/db.php');
use DB\DB;

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8"); 
header('Access-Control-Allow-Headers:*');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $token = DB->table('users')->where('email' , $input['email'])->andWhere('password' , $input['password'])->get(['token']);
    if (!empty($token)){
        echo json_encode(['data' => $token[0]]);
    http_response_code(200);        
    }else{
        echo json_encode(['error' =>  'Invalid Login Data']);
    http_response_code(400);
    }

    } else {
    echo json_encode(["error" => "METHOD {$_SERVER['REQUEST_METHOD']} IS NOT SUPPORTED"]);
}

exit();