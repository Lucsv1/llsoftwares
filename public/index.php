<?php

require_once '../vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

switch($request){
    case '/':
        require_once __DIR__ . '/../src/Views/Login/login.view.php';
        exit;
}