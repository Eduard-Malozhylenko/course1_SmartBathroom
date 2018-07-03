<?php
require "NotORM.php";
$pdo = new PDO('mysql:host=localhost; dbname=SmartBathroom', 'root', '');



$id_device=2;
$today = date("Y-m-d H:i:s");
$status = 0;
$emulator['id_device'] = 1;
$emulator['time'] = $today;

$sqlUP = "UPDATE `device` SET `status`= $status,`last_activity`= '$today'  WHERE id = $id_device";

$res =$pdo->query($sqlUP);
echo "yes";