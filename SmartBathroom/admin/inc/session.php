<?
session_start();
if(!isset($_SESSION['admin'])){
    header('Location: /');
    exit;
}

function logOut(){
    session_destroy();
    header('Location: /');
    exit;
}