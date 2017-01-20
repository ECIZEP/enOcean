<?php
  session_start();
  header("Content-Type: text/plain;charset=utf-8"); 
  /*
    return value:
    0——账号未激活
    1——密码不正确
    2——验证码输入错误
    3——登录成功
  */
  function check_login(){
    $checks=$_POST["verification"];
    if($checks==$_SESSION["check_checks"]){
      include("db.class.php");

      $username = $_POST["username"];
      $password = $_POST["password"];
      $sql = "select  *  from account where username='{$username}'  limit 1 ";
      $result_array = DBManager::query_mysql($sql);
      //账号未激活
      if($result_array['0']["activated"] == 0){
        echo "0";
        exit;
      }
      //密码不正确
      if($password != $result_array['0']["password"]) {
        echo "1";
        exit;
      }   
      $_SESSION["username"] = $username;
      echo "3";
      exit;
    }else{
      echo "2";
      exit;
    }
  }

  check_login();

?>


