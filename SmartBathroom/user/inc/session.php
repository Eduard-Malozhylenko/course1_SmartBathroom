<?
session_start();
if(!isset($_SESSION['user'])){
    header('Location: /');
    exit;
}

function logOut(){
    session_destroy();
    header('Location: /');
    exit;
}