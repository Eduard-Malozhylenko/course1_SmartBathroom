<?php
/* Ініціалізація глобальних змінних */
$errMsg = $id = $type = '';
$cmd = 'Додати новий розумний пристрій'; // Напис на кнопці форми

/* Виконання методів POST (на створення) и PUT (на зміну) */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Перевірка заповнення полів форми */
    if(empty($_POST['type'])){
        $errMsg = 'Заповніть всі поля!';
        curl_setopt($curl, CURLOPT_URL, $host.'device/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);

    }else{
        $today = date("Y-m-d H:i:s");
        $s = 'Порожня';
        /* Формування рядка для відправлення для обох методів*/
        $str = "id_organization={$idOrg}&type={$_POST['type']}&status={$s}&last_activity={$today}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);


        if(!empty($_POST['id'])){
            /* Відправлення даних методом PUT */
            $id = abs((int)$_POST['id']);
            curl_setopt($curl, CURLOPT_URL, $host."device/$id/");
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PUT']);
            $result = json_decode(curl_exec($curl));
            if($result->status){
                header('Location: /user/device.php');exit;
            }else{
                $errMsg = 'Не вдалося обновити дані про розумний пристрій';
            }
        }else{
            /* Відправлення даних методом POST */
            curl_setopt($curl, CURLOPT_URL, $host.'device/');
            curl_setopt($curl, CURLOPT_POST, 1);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->id){
                header('Location: /user/device.php');exit;
            }else
                $errMsg = 'Не вдалося додати дані про новий розумний пристрій';
            }
        }
    }else{
    /* Виконання методів GET (на отримання) и DELETE (на виделення) */
    if(isset($_GET['del'])){
        /* Отправка данных методом DELETE */
        $id = abs((int)$_GET['del']);
        if($id){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_URL, $host."device/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->status){
                header('Location: /user/device.php');exit;
            }else{
                $errMsg = 'Не вдалося видалит дані про розумний пристрій';
            }
        }
    }elseif(isset($_GET['update'])){
        /*Відправлення даних методом GET для отримання одного працівника */
        $id = abs((int)$_GET['update']);
        if($id){
            curl_setopt($curl, CURLOPT_URL, $host."device/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if(!isset($result)){
                $errMsg = 'Не вдалося отримати дані про розумний пристрій';
            }else{
                $cmd = 'Змінити дані про розумний пристрій';
                $id_organization = $result->id_organization;
                $type = $result->type;
                $status = $result->status;
                $last_activity = $result->last_activity;
                $id = $result->id;

            }
        }
    }else{
        /* Відправлення даних методом GET для отримання всіх працівників */
        curl_setopt($curl, CURLOPT_URL, $host.'device/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);


    }
}
?>

<h1>Додавання нового пристрою</h1>

<?php
if($errMsg)
    echo $errMsg;
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Тип розумного пристрою:<br />
    <input type="text" name="type" value="<?=$type?>" /><br />
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
	<p> id розумного пристрою  <strong>{$empl->id}</strong></p>
    <p> Тип розумного пристрою  <strong>{$empl->type}</strong></p>
	<p> Статус  <strong>{$empl->status}</strong></p>
	<p> Остання активність  <strong>{$empl->last_activity}</strong></p>
	<p align="right">
		<a href="/user/device.php?del={$empl->id}">Видалити</a>&nbsp;
		<a href="/user/device.php?update={$empl->id}">Змінити дані</a>
	</p>	
BOOK;
    }else continue;
}
?>




