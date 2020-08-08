<?php
require 'vendor/autoload.php';
include_once('config/include.php');
include_once('helper/email.php');

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
    
    //Registration Email already used validation
    $useremail_already_present = $user->useremailavailibility($useremail);
    
    try {
      //checking for valid email
      // $useremail = 'pawan88.lamba@gmailcom';
      if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)){
        Flight::json(array('result' => $useremail.' is not a valid email address'),400);      
      }
      elseif($useremail_already_present > 0 ){
        Flight::json(array('result' => 'The provided email has already been used'),409);
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

          //send email for user confirmation
          send_email($data['useremail']);

          // Flight::halt(201, 'User Created Successfully.. Please check your email '. $useremail.' to activate your account');
          // Flight::redirect('/api/login');
          // http_response_code(201);
        }
      }

    } catch (\Throwable $th) {
      //throw $th;
    }   
});


//email activation route
Flight::route('GET|PUT /api/email_activation/@email', function($email) {
    // Instantiate DB & connect 
    $database = new Database();
    $db= $database->connect();
  
    //Instantiate user object
    $user = new User($db);

    //Calling the activation function
    $useremail_activated = $user->activateemail($email);
    if($useremail_activated) {
      Flight::json(array(
        'message' => 'Account activated for email - '. $email,
        'status_code' => '200'
      ),200);
    }
  });


//User Login Route
Flight::route('POST /api/login', function() {   
    // Instantiate DB & connect 
    $database = new Database();
    $db= $database->connect();

    //Instantiate user object
    $user = new User($db);


    $data = Flight::request()->data;  // we only want the data sent to this request so we access it's 'data' member variable
    $useremail = $data['useremail'];
    $userpassword = $data['userpassword'];
    $res = $user->login($useremail,$userpassword);
    
    try {
      
      if($res == 1){
        Flight::json(array('result' => 'Wrong Credentials Email - '.$useremail.' is not matching with our records'),401);      
      }
      elseif($res == 2){
        Flight::json(array('result' => 'Wrong Credentials Password - '.$userpassword.' is not matching with our records'),401);      
      }
      /**
           * Since api is not live, so purposely commenting it for now.
           * But it is working in my local machine
           */
      // elseif($res == 'User Inactive'){
      //   Flight::json(array('result' => 'User still inactive. Check your email.'),401);      
      // }
      else{
          Flight::json(array(
            'login_details' => array(
              "email" => $useremail,
              "password" => $userpassword,
            ),
            'message' => 'Successful login. Use the token for subsequent requests in the API',
            'status_code' => '200'
          ),200);   
      }
      
    } catch (\Throwable $th) {
      //throw $th;
    }

});


Flight::start();
?>