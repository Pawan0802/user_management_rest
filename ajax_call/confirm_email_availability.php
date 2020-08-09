<?php
$sitePath = $_SERVER['DOCUMENT_ROOT']."/user_management_rest/";
include_once($sitePath.'config/include.php');

// Instantiate DB & connect 
$database = new Database();
$db= $database->connect();


//Instantiate user object
$user = new User($db);

//$email = 'pawan88.lamba@gmail.com';
$email = $_POST['useremail'];
$result = $user->useremailavailibility($email);
// echo $result;

if($result > 0)
{
echo "<span style='color:red'>Email already taken.</span>";
// echo "<script>$('#submit').prop('disabled',true);</script>";
} 

// else{
// echo "<span style='color:green'>Email available for Registration.</span>";
// echo "<script>$('#submit').prop('disabled',false);</script>";
// }
?>