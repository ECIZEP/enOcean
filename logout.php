<?php
    session_start();
    include("db.class.php");
    $username = $_SESSION["username"];
    //更新登陆时间
    $time_now=date("Y-m-d H:i:s");
    DBManager::update_mysql("update account set lastLoginDate='{$time_now}' where username='{$username}'");
    session_unset();
    header("Location:index.php");
?>
