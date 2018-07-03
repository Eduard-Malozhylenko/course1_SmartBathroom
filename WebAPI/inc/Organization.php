<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 02.11.2017
 * Time: 3:23
 */

/**
 *	Роутинг: визначення методів, шляхів і дій для роботи з організаціями
 */

/* Вибірка усіх організацій */
$app->get("/organization/", function() use ($app, $db) {
    $organization = [];
    foreach ($db->organization() as $establishment
    ) {
        $organization[]  = [
            "id" => $establishment["id"],
            "name_organization" => $establishment["name_organization"]
        ];
    }
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    echo json_encode($organization);
});

/* Отримання організації використовуючу її ідентификатор */
$app->get("/organization/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $organization = $db->organization()->where("id", $id);
    if ($data = $organization->fetch()) {
        echo json_encode([
            "id" => $data["id"],
            "name_organization" => $data["name_organization"]
        ]);
    }else{
        echo json_encode([
            "status" => 1,
            "message" => "Організацію з ID $id не знайдено"
        ]);
    }
});

/* Додавання нової організації */
$app->post("/organization/", function () use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $organization = $app->request()->post();
    $result = $db->organization()->insert($organization);
    echo json_encode(["id" => $result["id"]]);
});

/* Зміна даних про організацію, використовуючи її ідентифікатор */
$app->put("/organization/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $organization = $db->organization()->where("id", $id);
    if ($organization->fetch()) {
        $post = $app->request()->put();
        $result = $organization->update($post);
        echo json_encode([
            "status" => 1,
            "message" => "Дані про організацію змінено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Організацію з ID $id не знайдено"
        ]);
    }
});

/* Видалення даних про організацію, використовуючи її ідентифікатор */
$app->delete("/organization/:id/", function ($id) use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $organization = $db->organization()->where("id", $id);
    if ($organization->fetch()) {
        $result = $organization->delete();
        echo json_encode([
            "status" => 1,
            "message" => "Дані про організацію видалено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Організацію з ID $id не знайдено"
        ]);
    }
});
