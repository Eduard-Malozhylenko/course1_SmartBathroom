<?require 'inc/Authorization.php';?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Логін
    <br/>
    <input type="text" name="login" value="<?=$login?>" />
    <br/>
    Пароль
    <br/>
    <input type="text" name="password" value="<?=$password?>" /><br />
    <br/>

    <input type="submit" value="<?=$cmd?>" />
</form>