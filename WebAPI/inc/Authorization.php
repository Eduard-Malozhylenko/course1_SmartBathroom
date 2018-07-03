<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 04.11.2017
 * Time: 20:01
 */

$app->post("/authorization/", function () use($app, $db) {
    $res = $app->response();
    $res["Content-Type"] = "application/json";
    $authorization = $app->request()->post();
    $data = $db->employee()->where("login", $authorization["login"]);
    $dataP = $data->fetch();
    $hash = getHash($authorization["password"]);

    if ($dataP!= false || $hash == $dataP["password"]){
        if ($dataP["id_organization"] == 1){
            echo json_encode(["status" => 0]);
        }
        else{
            echo json_encode(["status" => 1,
                "id_organization" =>$dataP["id_organization"]
            ]);
        }

    }else{
        echo json_encode([
            "status" => 2,
            "message" => "Користува з таким логіном та паролем не існує."
        ]);
    }

});