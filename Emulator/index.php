<?php
/* Глобальна конфиігурація cURL */
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$host = "http://webserv.loc/";
/* Ініціалізація глобальних змінних */
$errMsg = $id_device = '';
$detector_1 = $detector_2 = $detector_3 = $detector_4 = $detector_5 = "0";

/* Виконання методів POST (на створення) и PUT (на зміну) */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* Перевірка заповнення полів форми */
    if(empty($_POST['id_device'])){
        $errMsg = 'Заповніть id девайсу!';
    }else{
        /* Формування рядка для відправлення для обох методів*/
        $str = "id_device={$_POST['id_device']}&detector_1={$_POST['detector_1']}&detector_2={$_POST['detector_2']}&detector_3={$_POST['detector_3']}&detector_4={$_POST['detector_4']}&detector_5={$_POST['detector_5']}";
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);


            /* Відправлення даних методом POST */
            curl_setopt($curl, CURLOPT_URL, $host.'emulator/');
            curl_setopt($curl, CURLOPT_POST, 1);
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            
            if($result->status){
                echo $result->message;
            }else{
                $errMsg = 'Не вдалося відправити дані';
            }
        }

}
?>

<?php
if($errMsg)
    echo $errMsg;
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    id розумного пристрою<br />
    <input type="text" name="id_device" value="<?=$id_device?>" /><br />
    Значення 5 датчику<br />
    <input type="text" name="detector_5" value="<?=$detector_5?>" /><br />
    Значення 4 датчику<br />
    <input type="text" name="detector_4" value="<?=$detector_4?>" /><br />
    Значення 3 датчику<br />
    <input type="text" name="detector_3" value="<?=$detector_3?>" /><br />
    Значення 2 датчику<br />
    <input type="text" name="detector_2" value="<?=$detector_2?>" /><br />
    Значення 1 датчику<br />
    <input type="text" name="detector_1" value="<?=$detector_1?>" /><br />
    <input type="hidden" name="id" value="<?=$id?>" />

    <br />
    <input type="submit" value="Відправити дані" />
</form>
