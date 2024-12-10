<?php
require_once('db/src/db.php');
use DB\DB;
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8"); 
header('Access-Control-Allow-Headers:*');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $data = DB->table('users')->where('token' , $input['token'])->get(['name' , 'email' , 'password']);
        if (!empty($data)){
            echo json_encode(['data' => $data[0]]);
            http_response_code(200);                    
        }else{
            echo json_encode(['Erorr' => 'Invalid Token']);
            http_response_code(400);                                
        }
} else {
    echo json_encode(["error" => "METHOD {$_SERVER['REQUEST_METHOD']} IS NOT SUPPORTED"]);
    http_response_code(402);                                
}

exit();