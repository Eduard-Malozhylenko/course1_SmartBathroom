<?php
/* Ініціализація глобальних змінних */
$errMsg = $login = $password = '';
$cmd = 'Вхід';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* Перевірка заповнення полей форми */
    if (empty($_POST['login']) or empty($_POST['password'])) {
        echo 'Заполните все поля!';
    } else {
        /* Формування рядка для відправлення методом POST*/
        $str = "login={$_POST['login']}&password={$_POST['password']}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        /* Отправка данных методом POST */
        curl_setopt($curl, CURLOPT_URL, $host . 'authorization/');
        curl_setopt($curl, CURLOPT_POST, 1);
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
        $status = $result->status;
        $loginT = trim(strip_tags($_POST["login"]));
        $pwT = trim(strip_tags($_POST["pw"]));

    // Авторизація та надання прав
        switch ($status){
            case 0:
                $_SESSION['admin'] = true;
                header("Location: /admin/");
                exit;

                break;
            case 1:
                $user = [
                    'id_organization' =>$result->id_organization
                ];
                $str = base64_encode( serialize($user) );
                setcookie("user", $str);
                $_SESSION['user'] = true;
                header("Location: /user/");

                break;
            case 2:
                echo $result->message;
                break;
            }
        }
}
