<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 02.11.2017
 * Time: 20:30
 */

/**
 *	Роутинг: визначення методів, шляхів і дій для роботи з працівниками
 */

/* Вибірка усіх працівників */
$app->get("/employee/", function() use ($app, $db) {
    $employee = [];
    foreach ($db->employee() as $worker) {
        $employee[]  = [
            "id" => $worker["id"],
            "id_organization" => $worker["id_organization"],
            "login" => $worker["login"],
            "password" => $worker["password"],
            "full_name" => $worker["full_name"],
            "status" => $worker["status"]
        ];
    }
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    echo json_encode($employee);
});

/* Отримання працівника використовуючу його ідентификатор */
$app->get("/employee/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $employee = $db->employee()->where("id", $id);
    if ($data = $employee->fetch()) {
        echo json_encode([
            "id" => $data["id"],
            "id_organization" => $data["id_organization"],
            "login" => $data["login"],
            "password" => $data["password"],
            "full_name" => $data["full_name"],
            "status" => $data["status"]
        ]);
    }else{
        echo json_encode([
            "status" => 1,
            "message" => "Працівника з ID $id не знайдено"
        ]);
    }
});
/* Отримання працівника використовуючу ідентификатор комранії */
$app->get("/org_employee/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";

    $employee = $db->employee()->where("id_organization", $id);
    if ($data = $employee->fetch()) {
        echo json_encode([
            "id" => $data["id"],
            "login" => $data["login"],
            "password" => $data["password"],
            "full_name" => $data["full_name"],
            "status" => $data["status"]
        ]);
    }else{
        echo json_encode([
            "status" => 1,
            "message" => "Працівника з ID $id не знайдено"
        ]);
    }
});

/* Додавання нового працівник */
$app->post("/employee/", function () use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $employee = $app->request()->post();
    $data = $db->employee()->where("login", $employee["login"]);
    $dataL = $data->fetch();
    $login = $dataL["login"];
    if($dataL == false){
        $password = $employee["password"];
        $hash = getHash($password);
        $employee['password'] = $hash;
        $result = $db->employee()->insert($employee);
        echo json_encode(["id" => $result["id"]]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Працівник з $login вже існує. Выберіть інше імя."
        ]);

    }
});

/* Зміна даних про працівника, використовуючи його ідентифікатор */
$app->put("/employee/:id/", function ($id) use ($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $employee = $db->employee()->where("id", $id);
    if ($employee->fetch()) {
        $post = $app->request()->put();
        $result = $employee->update($post);
        echo json_encode([
            "status" => 1,
            "message" => "Дані про працівника змінено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Працівника з ID $id не знайдено"
        ]);
    }
});

/* Видалення даних про працівника, використовуючи його ідентифікатор */
$app->delete("/employee/:id/", function ($id) use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $employee = $db->employee()->where("id", $id);
    if ($employee->fetch()) {
        $result = $employee->delete();
        echo json_encode([
            "status" => 1,
            "message" => "Дані про працівника видалено"
        ]);
    }else{
        echo json_encode([
            "status" => 0,
            "message" => "Працівника з ID $id не знайдено"
        ]);
    }
});