<?php
require 'vendor/autoload.php';
include_once('config/include.php');

//User Registration Route
Flight::route('POST /api/signup', function() {
    
    // echo "signup";

    // $request = Flight::request();
    // echo "<pre>";
    // print_r($request);
    // echo "</pre>";
    // exit;
    // header('Content-Type: application/json');
    $data = Flight::request()->data;
    
    $username = $data['username'];
    $useremail = $data['useremail'];
    $userpassword = $data['userpassword'];
    $userdob = $data['userdob'];

    /**
     * variable db undefined error when creating an instance in include.php
     * So creating an object in flight api
     */
    // Instantiate DB & connect 
    $database = new Database();
    $db= $database->connect();

    //Instantiate user object
    $user = new User($db);
    
    try {
      //checking for valid email
      // $useremail = 'pawan88.lamba@gmailcom';
      if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)){
        Flight::json(array('result' => $useremail.' is not a valid email address'),400);      
      }
      elseif($username == '' || $useremail == '' || $userpassword == '' || $userdob == ''){
        Flight::json(array('result' => 'Please specify all the fields'),400);
      }
      elseif($username != '' && $useremail != '' && $userpassword != '' && $userdob != ''){
        // saving in the db
        $user->name = $data['username'];
        $user->email = $data['useremail'];
        $user->password = $data['userpassword'];
        $user->dob = $data['userdob'];

        if($user->register()) {
          // sending json reponse
          Flight::json(array(
            'login_details' => array(
              "email" => $data['useremail'],
              "password" => $data['userpassword'],
            ),
            'message' => 'User Successfully Created.. Please check your email '. $data['useremail'].' to activate your account',
            'status_code' => '201'
          ),201);

          // Flight::halt(201, 'User Created Successfully.. Please check your email '. $useremail.' to activate your account');
          // Flight::redirect('/api/login');
          // http_response_code(201);
        }
      }

    } catch (\Throwable $th) {
      //throw $th;
    }   
});


Flight::start();
?>