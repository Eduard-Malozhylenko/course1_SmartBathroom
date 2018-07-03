<?php

        curl_setopt($curl, CURLOPT_URL, $host.'history/');
        $result = json_decode(curl_exec($curl));
    curl_close($curl);


?>


<?
if($id)
    exit;
?>


<h3>Історія активності розумних пристроїв</h3> 
    <?php
    /* Відображення працівників */foreach($result as $empl) {
    if ($empl->id_organization == $idOrg) {
            echo <<<BOOK
	<hr>
	
	<p> id запису <strong>{$empl->id}</strong></p>
	<p> id пристрою <strong>{$empl->id_device}</strong></p>
	<p> Тип пристрою <strong>$empl->type</strong></p>
	<p> Час <strong>{$empl->time}</strong></p>
	<p> Наповненість  <strong>{$empl->status}</strong></p>
		
BOOK;
    }else continue;
    }
    ?>


