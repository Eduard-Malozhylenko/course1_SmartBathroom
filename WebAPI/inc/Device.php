<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 02.11.2017
 * Time: 21:13
 */

/**
 *	Роутинг: визначення методів, шляхів і дій для роботи з ІоТ
 */

/* Вибірка усіх розумних пристроїв */
$app->get("/device/", function() use ($app, $db) {
    $device = [];
    foreach ($db->device() as $IoT) {
        $device[]  = [
            "id" => $IoT["id"],
            "id_organization" => $IoT["id_organization"],
            "type" => $IoT["type"],
            "status" => $IoT["status"],
            "last_activity" => $IoT["last_activity"]
        ];
    }
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    echo json_encode($device);
});

/* Отримання розумного пристрою використовуючу його ідентификатор */
$app->get("/device/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $device = $db->device()->where("id", $id);
    if ($data = $device->fetch()) {
        echo json_encode([
            "id" => $data["id"],
            "id_organization" => $data["id_organization"],
            "type" => $data["type"],
            "status" => $data["status"],
            "last_activity" => $data["last_activity"]
        ]);
    }else{
        echo json_encode([
            "status" => 1,
            "message" => "Розумий пристрій з ID $id не знайдено"
        ]);
    }
});

/* Додавання нового розумного пристрою*/
$app->post("/device/", function () use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $device = $app->request()->post();
    $result = $db->device()->insert($device);
    echo json_encode(["id" => $result["id"]]);
});

/* Зміна даних про розумий пристрій, використовуючи його ідентифікатор */
$app->put("/device/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $device = $db->device()->where("id", $id);
    if ($device->fetch()) {
        $post = $app->request()->put();
        $result = $device->update($post);
        echo json_encode([
            "status" => 1,
            "message" => "Дані про розумий пристрій змінено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Розумий пристрій з ID $id не знайдено"
        ]);
    }
});

/* Видалення даних про розумий пристрій, використовуючи його ідентифікатор */
$app->delete("/device/:id/", function ($id) use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $device = $db->device()->where("id", $id);
    if ($device->fetch()) {
        $result = $device->delete();
        echo json_encode([
            "status" => 1,
            "message" => "Дані про розумий пристрій видалено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Розумий пристрій з ID $id не знайдено"
        ]);
    }
});
