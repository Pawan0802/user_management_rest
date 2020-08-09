<?php
error_reporting( 0 );
$sitePath = $_SERVER['DOCUMENT_ROOT']."/user_management_rest/";
require_once($sitePath.'vendor/autoload.php');
// require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function verify_jwt_token(){
$secret_key = "bin2hex(random_bytes(32))";
$jwt = null;

// $authHeader = $_SERVER;
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
//print_r($authHeader);
// echo $_ENV['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);


/*echo json_encode(array(
    "message" => "jwt" .$arr[1]
));*/

$jwt = $arr[1];
// return $jwt;

    if($jwt){

        try {

            $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
            // Access is granted. Add code of the operation here 
            // echo json_encode(array(
            //     "message" => "Access granted:",
            //     // "error" => $e->getMessage()
            // ));
            // echo 1;
            return 1;
            
        }catch (Exception $e){

            // http_response_code(401);
            // echo json_encode(array(
            //     "message" => "Access denied.",
            //     "error" => $e->getMessage()
            // ));
            // echo 0;
            return 0;
            
        }
    }
}

// verify_jwt_token();
?>