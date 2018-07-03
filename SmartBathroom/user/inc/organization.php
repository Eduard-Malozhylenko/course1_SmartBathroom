<?php

curl_setopt($curl, CURLOPT_URL, $host . "organization/$idOrg/");
$result = json_decode(curl_exec($curl));
$name = $result->name_organization;
curl_setopt($curl, CURLOPT_URL, $host . "org_employee/$idOrg/");
$resultORG = json_decode(curl_exec($curl));
curl_close($curl);


?>
<h1 style="font-size: 24px" > Ваша компанія: <? echo $name ?></h1>

