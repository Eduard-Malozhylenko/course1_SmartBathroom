<?php
session_start();
header("HTTP/1.0 401 Unauthorized");
require 'inc/cURL.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Smart Bathroom</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="inc/style.css" />
</head>
<body>
<div class="header">
        Smart Bathroom
</div>
<div class="content">
    <div class="about">
         <p> SmartBathroom - це сервіс, який дозволить користувачам відстежувати рівні сміття, рідкого мила, паперових
             рушників, виконати вчасне прибирання, поновлення запасів мила та рушників, а також переглядати загальну
             інформацію за попередні дні.
         </p>
    </div>

    <div class="authorization">
        <?php
        require 'inc/start.php';
        ?>
    </div>
</div>

    <div class="footer">
        Smart Bathroom
        <br>
        <?=  date('Y')?>
    </div>



</body>
</html>