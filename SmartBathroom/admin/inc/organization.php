<?php
/* Ініціалізація глобальних змінних */
$errMsg = $name_organization = '';
$cmd = 'Додати нову організацію'; // Напис на кнопці форми

/* Виконання методів POST (на створення) и PUT (на зміну) */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Перевірка заповнення полів форми */
    if(empty($_POST['name_organization']) ){
        $errMsg = 'Заповніть всі поля!';
        curl_setopt($curl, CURLOPT_URL, $host.'organization/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);

    }else{
        /* Формування рядка для відправлення для обох методів*/
        $str = "name_organization={$_POST['name_organization']}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);

        if(!empty($_POST['id'])){
            /* Відправлення даних методом PUT */
            $id = abs((int)$_POST['id']);
            curl_setopt($curl, CURLOPT_URL, $host."organization/$id/");
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PUT']);
            $result = json_decode(curl_exec($curl));
            if($result->status){
                header('Location: /admin/');exit;
            }else{
                $errMsg = 'Не вдалося обновити дані про організацію';
            }
        }else{
            /* Відправлення даних методом POST */
            curl_setopt($curl, CURLOPT_URL, $host.'organization/');
            curl_setopt($curl, CURLOPT_POST, 1);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->id){
                header('Location: /admin/');exit;
            }else{
                $errMsg = 'Не вдалося добавити дані про нову організацію';
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
            curl_setopt($curl, CURLOPT_URL, $host."organization/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if($result->status){
                header('Location: /admin/');exit;
            }else{
                $errMsg = 'Не вдалося видалит дані про організацію';
            }
        }
    }elseif(isset($_GET['update'])){
        /* Відправлення даних методом GET для отримання однієї організації  */
        $id = abs((int)$_GET['update']);
        if($id){
            curl_setopt($curl, CURLOPT_URL, $host."organization/$id/");
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if(!isset($result)){
                $errMsg = 'Не вдалося отримати дані про організацію';
            }else{
                $cmd = 'Змінити дані про організацію';
                $name_organization = $result->name_organization;
                $id = $result->id;

            }
        }
    }else{
        /* Відправлення даних методом GET для отримання всіх організацій */
        curl_setopt($curl, CURLOPT_URL, $host.'organization/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
    }
}
?>
<h1>Додавання нової організації</h1>

<?php
if($errMsg)
    echo $errMsg;
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Назва організації:<br />
    <input type="text" name="name_organization" value="<?=$name_organization?>" /><br />

    <br />
    <input type="hidden" name="id" value="<?=$id?>" />
    <input type="submit" value="<?=$cmd?>" />
</form>
<?
if($id)
    exit;
?>
<h3>Всього організацій: <?=count($result)?></h3>
<?php
/* Відображення працівників */
foreach($result as $empl){
    echo <<<BOOK
	<hr>
	<p> id організації <strong>{$empl->id}</strong></p>
	<p> Назва організації <strong>{$empl->name_organization}</strong></p>
	<p align="right">
		<a href="/admin/index.php?del={$empl->id}">Видалити</a>&nbsp;
		<a href="/admin/index.php?update={$empl->id}">Змінити дані</a>
	</p>	
BOOK;
}
?>
