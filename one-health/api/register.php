<?php
require_once('db/src/db.php');
use DB\DB;

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8"); 
header('Access-Control-Allow-Headers:*');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $checkIfEmailNotUsed = DB->table('users')->where('email' , $input['email'])->first();

    if (empty($checkIfEmailNotUsed)){
        
    DB->table('users')->create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => $input['password'], 
        'token' => sha1(date('d-s-y-m')) . substr($input['name'], 3) . md5(date('d-y-s-m')) . substr($input['email'], 0 , 4 ),
    ]);

  echo json_encode(["success" => "User created successfully."]);
  http_response_code(200);        
}else{
        echo json_encode(["error" => "User With This Email Is Already Registerd"]);
        http_response_code(400);
    }

} else {
    echo json_encode(["error" => "METHOD {$_SERVER['REQUEST_METHOD']} IS NOT SUPPORTED"]);
}
