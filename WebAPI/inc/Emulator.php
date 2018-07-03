<?php
$app->post("/emulator/", function () use($app, $db) {
    $status='';
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $emulator = $app->request()->post();
    $detector_1 = $emulator['detector_1'];
    $detector_2 = $emulator['detector_2'];
    $detector_3 = $emulator['detector_3'];
    $detector_4 = $emulator['detector_4'];
    $detector_5 = $emulator['detector_5'];
    $today = date("Y-m-d H:i:s");
    $id_device = $emulator['id_device'];
    if ($detector_1 == 0) {
        $status = "Порожня";
    } elseif ($detector_1 == 1 && $detector_2 == 0) {
        $status = "Меньше 25";
    } elseif ($detector_2 == 1 && $detector_3 == 0) {
        $status = 25;
    } elseif ($detector_3 == 1 && $detector_4 == 0) {
        $status = 50;
    } elseif ($detector_4 == 1 && $detector_5 == 0) {
        $status = 75;
    } elseif ($detector_5 == 1) {
        $status = 100;
    }




    $pdo = new PDO('mysql:host=localhost; dbname=SmartBathroom', 'root', '');

    $sql ="SELECT * FROM `device` WHERE id = $id_device";
    $res =$pdo->query($sql);
    foreach ($res as $re) {
        $id = $re['id'];
    }

    if ($id == $id_device){
        $sqlUP = "UPDATE `device` SET `status`= '$status',`last_activity`= '$today'  WHERE id = $id_device";
        $sqlIN = "INSERT INTO `history`( `id_device`, `time`, `status`) VALUES ($id_device, '$today', '$status')";
        $resUP = $pdo->query($sqlUP);
        $resIN = $pdo->query($sqlIN);
        echo json_encode([
            "status" => 1,
            "message" => "Дані відправлено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Трапилася помилка на сервері"
        ]);
    }

});
