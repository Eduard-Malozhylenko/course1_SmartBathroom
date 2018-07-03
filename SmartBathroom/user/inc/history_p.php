<?php
/* Ініціалізація глобальних змінних */
$errMsg = $id_p = '';
/* для отримання всіх розумних пристроїв */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Перевірка заповнення полів форми */
    if(empty($_POST['id_p']) ){
        $errMsg = 'Заповніть поле іD';
    }else {
        /* Формування рядка для відправлення для обох методів*/
        $str = "id_p={$_POST['id_p']}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);
        /* Відправлення даних методом POST */
        curl_setopt($curl, CURLOPT_URL, $host . 'history/');
        curl_setopt($curl, CURLOPT_POST, 1);
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
        if ($result->status) {
            var_dump($result);
        } else {
            $errMsg = 'Не вдалося відправити запит';
        }
    }
}?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Пошук історії пристою зa id<br />
    <input type="text" name="id_p" value="<?=$id_p?>" >
    <input type="submit" value="Знайти" />
</form>
<?php
foreach ($result as $empl) {
if ($empl->id_organization == $idOrg) {
echo <<<BOOK
<hr>
<p> id запису <strong>{$empl->id}</strong></p>
<p> id пристрою <strong>{$empl->id_device}</strong></p>
<p> Час <strong>{$empl->time}</strong></p>
<p> Наповненість  <strong>{$empl->status}</strong></p>

BOOK;
} else continue;
}

