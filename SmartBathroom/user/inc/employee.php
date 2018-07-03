<?php
/* Ініціалізація глобальних змінних */
$errMsg = $id = $login = $password = $full_name = $status = '';
$cmd = 'Додати нового працівника'; // Напис на кнопці форми

/* Виконання методів POST (на створення) и PUT (на зміну) */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Перевірка заповнення полів форми */
    if(empty($_POST['login']) or empty($_POST['password']) or empty($_POST['full_name']) or empty($_POST['status'])){
        $errMsg = 'Заповніть всі поля!';
        curl_setopt($curl, CURLOPT_URL, $host.'employee/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);

    }else{
        /* Формування рядка для відправлення для обох методів*/
        $str = "id_organization={$idOrg}&login={$_POST['login']}&password={$_POST['password']}&full_name={$_POST['full_name']}&status={$_POST['status']}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);

        if(!empty($_POST['id'])){
            /* Відправлення даних методом PUT */
            $id = abs((int)$_POST['id']);
            curl_setopt($curl, CURLOPT_URL, $host."employee/$id/");
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PUT']);
            $result = json_decode(curl_exec($curl));
            if($result->status){
                header('Location: /user/employee.php');exit;
            }else{
                $errMsg = 'Не вдалося обновити дані про працівника';
            }
        }else{
            /* Відправлення даних методом POST */
            curl_setopt($curl, CURLOPT_URL, $host.'employee/');
            curl_setopt($curl, CURLOPT_POST, 1);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->id){
                header('Location: /user/employee.php');exit;
            }else{
                $errMsg = 'Не вдалося добавити дані про нового працівника';
            }
        }
    }
}else{
    /* Виконання методів GET (на отримання) и DELETE (на виделення) */
    if(isset($_GET['del'])){
        /* Отправка данных методом DELETE */
        $id = abs((int)$_GET['del']);
        if($id){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_URL, $host."employee/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->status){
                header('Location: /user/employee.php');exit;
            }else{
                $errMsg = 'Не вдалося видалит дані про працівника';
            }
        }
    }elseif(isset($_GET['update'])){
        /*Відправлення даних методом GET для отримання одного працівника */
        $id = abs((int)$_GET['update']);
        if($id){
            curl_setopt($curl, CURLOPT_URL, $host."employee/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if(!isset($result)){
                $errMsg = 'Не вдалося отримати дані про працівника';
            }else{
                $cmd = 'Змінити дані про працівника';
                $id_organization = $result->id_organization;
                $login = $result->login;
                $password = $result->password;
                $full_name = $result->full_name;
                $status = $result->status;
                $id = $result->id;

            }
        }
    }else{
        /* Відправлення даних методом GET для отримання всіх працівників */
        curl_setopt($curl, CURLOPT_URL, $host.'employee/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}
?>

<h1>Додавання нового працівника</h1>

<?php
if($errMsg)
    echo $errMsg;
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    Логін:<br />
    <input type="text" name="login" value="<?=$login?>" /><br />
    Пароль:<br />
    <input type="text" name="password" value="<?=$password?>" /><br />
    ПІП:<br />
    <input type="text" name="full_name" value="<?=$full_name?>" /><br />
    Статус:<br />
    <input type="text" name="status" value="<?=$status?>" /><br />

    <br />
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="submit" value="<?=$cmd?>" />
</form>
<?
if($id)
    exit;

?>

<?php

/* Відображення працівників */
foreach($result as $empl) {
    if ($empl->id_organization == $idOrg) {

        echo <<<BOOK
	<hr>
	
	<p> ПІП <strong>{$empl->full_name}</strong></p>
	<p> Логін <strong>{$empl->login}</strong></p>
	<p> id організації <strong>{$empl->id_organization}</strong></p>
	<p> Статус  <strong>{$empl->status}</strong></p>
	<p align="right">
		<a href="/user/employee.php?del={$empl->id}">Видалити</a>&nbsp;
		<a href="/user/employee.php?update={$empl->id}">Змінити дані</a>
	</p>	
BOOK;
    }else continue;
}
?>
