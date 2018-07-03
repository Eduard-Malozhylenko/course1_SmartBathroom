<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 02.11.2017
 * Time: 19:01
 */
require "Slim/Slim.php";
require "NotORM.php";

function getHash($password){
    $hash = password_hash($password, PASSWORD_BCRYPT);
    return $hash;
}

/* Ініціалізація автозавантажувача */
\Slim\Slim::registerAutoloader();

/* Ініціалізація з'єднання бази даних для NotORM */
$pdo = new PDO('mysql:host=localhost; dbname=SmartBathroom', 'root', '');
$db = new NotORM($pdo);

/* Створення екземпляра класу Slim */
$app = new \Slim\Slim();

/* Дія за замовчуванням */
$app->get("/", function() {
    echo "Дія за замовчуванням";
});
require "inc/Authorization.php";
require "inc/Organization.php";
require "inc/Employee.php";
require "inc/Device.php";
require "inc/Emulator.php";
require "inc/Histoty.php";





$app->run();