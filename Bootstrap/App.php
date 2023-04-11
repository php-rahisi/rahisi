<?php

use Rahisi\Token\token as TokenToken;
use support\token\token;

    $token = new TokenToken(); 
    $token->setTocken();
    include "App/Helper.php";
    lastTwoUrl();
   
    if(!isset($_COOKIE['language'])){
        setcookie('language',$_ENV['APP_LANGUAGE']);
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit();
    }