<?php
session_start();
header("HTTP/1.0 401 Unauthorized");
require 'inc/cURL.php';
require 'inc/cookie.php';
require 'inc/session.php';
if(isset($_GET['logout'])){
    logOut();
}
?>
    <!DOCTYPE html>
    <html>
<head>
    <title>Історія активності</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="inc/style.css" />
</head>
<body>
<div class="header">
    Smart Bathroom
    <div class="exit">
        <a href='index.php?logout'>Завершити сеанс</a>
    </div>
</div>
<div class="content">
    <div class="menu">
        <a href="index.php">Организації</a>
        <a href="employee.php">Працівники</a>
        <a href="device.php">Розумні пристрої</a>
        <a href="history.php">Історія активності</a>
    </div>
    <div class="cont"
    <? include "inc/history_p.php";?>
</div>

</div>


</body>
</html>