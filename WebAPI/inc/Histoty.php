<?php
/* Отримання історії пристрою викорстовуючи id */
$app->post("/employee/", function () use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $his = $app->request()->post();
    $history = $db->employee()->where("id_device", $his['id_p']);
    if ($data = $history->fetch()) {
        echo json_encode([
            "id" => $data["id"],
            "id_device" => $data["id_device"],
            "status" => $data["status"],
            "time" => $data["time"]
        ]);
    }else{
        echo json_encode([
            "status" => 1,
            "message" => "Пристрою  з ID {$his['id_p']} не знайдено"
        ]);
    }
});
$app->get("/history/", function() use ($app, $db) {

    $pdo = new PDO('mysql:host=localhost; dbname=SmartBathroom', 'root', '');
    $sql ="SELECT `history`.`id`,`history`.`id_device`,`device`.`id_organization`,`device`.`type`, `history`.`time`,`history`.`status` FROM device, history WHERE `device`.`id` = `history`.`id_device`";
    $res = $pdo->query($sql);
    $history=[];

    foreach ($res as $IoT){
        $history[]  = [
            "id" => $IoT["id"],
            "id_device" => $IoT["id_device"],
            "type" => $IoT["type"],
            "id_organization"=> $IoT["id_organization"],
            "status" => $IoT["status"],
            "time" => $IoT["time"]
        ];
    }
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    echo json_encode($history);
});