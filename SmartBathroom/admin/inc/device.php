<?php
/* для отримання всіх розумних пристроїв */
        curl_setopt($curl, CURLOPT_URL, $host.'device/');
        $result = json_decode(curl_exec($curl));
        curl_close($curl);


?>


<?
if($id)
    exit;
?>
<h3>Всього розумних пристроїв: <?=count($result)?></h3>
<?php
/* Відображення розумних пристроїв */
foreach($result as $empl){
    echo <<<BOOK
	<hr>
	
	<p> id розумного пристрою <strong>{$empl->id}</strong></p>
	<p> id органызації <strong>{$empl->id_organization}</strong></p>
	<p> тип розумного пристрою <strong>{$empl->type}</strong></p>

	
BOOK;
}
?>
