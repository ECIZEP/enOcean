<?php
    header("Content-Type: text/plain;charset=utf-8"); 
    include("send_email.php");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //register post request
        if(isset($_POST["type"]) && $_POST["type"] == "register"){
            $password = $_POST["password"];
            $username = $_POST["username"];
            $phoneNumber = $_POST["phoneNumber"];
            $verifycode = $_POST["verifycode"];
            if($password && $username && $verifycode && $phoneNumber){
                register_func();
            }
        }
        
    }elseif($_SERVER['REQUEST_METHOD'] == "GET"){
        //email activating request
        if(isset($_GET["verify"])){
            activate_account($_GET["verify"],$_GET["email"]);
        }

        //change email request
        if(isset($_GET["type"]) && $_GET["type"] == "change_email_confirm"){
            change_email_confirm($_GET["email"],$_GET["token"]);
        }
    }

    function change_email_confirm($email,$token){
      include("db.class.php");
      if($email && $token){
        $sql = "update account set email = '{$email}' where token = '{$token}'";
        if(DBManager::update_mysql($sql)){
          header("Location:index.php?m=change_email_success");
          exit;
        }else{
          header("Location:index.php?m=change_email_failed");
          exit;
        }
      }else{
        header("Location:index.php?m=change_email_failed");
        exit;
      }

    }

    /*
    response text:
    register_name_email_exist  邮箱和用户名已经存在
    register_name_exist     用户名存在
    register_email_exist     邮箱存在
    activated_sendmail_success  账号激活邮件发送成功
    activated_sendmail_failed   账号激活邮件发送失败
    */
    function check_account(){
        global $password,$username,$verifycode,$phoneNumber;
        include("db.class.php");
        //is username existing?
        $sql_1 = "select  *  from account where username='{$username}'  limit 1 ";
        $result_username = DBManager::query_mysql($sql_1);
        //have phoneNumber been registered?
        $sql_2 = "select  *  from account where phoneNumber='{$phoneNumber}'  limit 1 ";
        $result_phoneNumber = DBManager::query_mysql($sql_2);
        if($result_username && $result_phoneNumber){
            echo "register_name_phoneNumber_exist";
            exit;
        } elseif ($result_username) {
            echo "register_name_exist";
            exit;
        } elseif ($result_phoneNumber){
            echo "register_phoneNumber_exist";
            exit;
        }
        if(!isset($_SESSION)){
          session_start();
        }
        if(isset($_SESSION["verifycode"]) && $_SESSION["verifycode"] == $verifycode){
            return true;
        }else{
            echo "register_verifycode_wrong";
            exit;
        }
        return true;
    }

    
    function register_func(){
        global $password,$username,$phoneNumber;
        if(check_account()){
            $regitserData = date("Y-m-d H:i:s");
            $sql = "insert into account (username,password,phoneNumber,registerDate) ";
            $sql .= " values ('{$username}','{$password}','{$phoneNumber}','{$regitserData}')";
            if(DBManager::register_account($sql,$username)){
                echo "register_success";
                exit;
            }else{
                echo "register_failed";
                exit;
            }
            
        }
    }


    /*
    账号激活
    activated_exptime  激活时间超时
    actived_finished   激活成功
    actived_failed     激活失败
    */
    function activate_account($token,$email){
         include("db.class.php");
         $sql = "select username,token_exptime from account where activated = '0' and token='{$token}'";
         $result = DBManager::query_mysql($sql);
         $nowtime = time();
         if($result){
            if($result['0']["token_exptime"] < $nowtime){
                header("Location:index.php?m=activated_exptime");
                exit;
            }else{
                $sql = "update account set activated = '1',email = '{$email}' where token = '{$token}'";
                if(DBManager::update_mysql($sql)){
                    header("Location:index.php?m=actived_finished");
                    exit;
                }else{
                    header("Location:index.php?m=actived_failed");
                    exit;
                }
            }
         }else{
            echo "sdf";
         }
    }
    
?>
