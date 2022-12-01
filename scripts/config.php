<?php
    if(empty($_SESSION))
        $_SESSION["user"] = "localhost";
    $DB = new mysqli('localhost', 'root', '', 'market');
    
    if ($DB -> connect_errno)
    {
        header('Location:landing.php?method=error');
    }
?>