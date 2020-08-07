<?php
require 'vendor/autoload.php';
include_once('config/include.php');

Flight::route('/', function(){
    echo 'hello world!';
});


//start with registration only post for now




Flight::start();
?>