<?php
    header("Content-Type: text/plain;charset=utf-8"); 
    include("send_email.php");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
    //来自注册的post请求
        $password = $_POST["password"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        if($password && $username && $email){
            register_func();
        }
    }elseif($_SERVER['REQUEST_METHOD'] == "GET"){
    //来自激活的get请求
        if(isset($_GET["verify"])){
            activate_account($_GET["verify"]);
        }

    //来自更换邮箱的get请求
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
        global $password,$username,$email;
        include("db.class.php");
        //用户名是否已经存在并已经激活
        $sql_1 = "select  *  from account where username='{$username}'  limit 1 ";
        $result_username = DBManager::query_mysql($sql_1);
        //邮箱是否已经注册
        $sql_2 = "select  *  from account where email='{$email}'  limit 1 ";
        $result_email = DBManager::query_mysql($sql_2);
        if($result_username && $result_username["0"]["activated"] == 1 && $result_email){
            echo "register_name_email_exist";
            exit;
        } elseif ($result_username && $result_username["0"]["activated"] == 1) {
            echo "register_name_exist";
            exit;
        } elseif ($result_email){
            echo "register_email_exist";
            exit;
        }
        return true;
    }

    


    function register_func(){
        global $password,$username,$email;
        if(check_account()){
            $regitserData = date("Y-m-d H:i:s");
            $nowtime = time();
            $token_exptime = $nowtime+60*60*24;//过期时间为24小时后
            $token = md5($username.$email.$nowtime); //创建用于激活识别码
            $sql = "insert into account (username,password,nickname,address,phoneNumber,email,registerDate,lastLoginDate,activated,token,token_exptime) ";
            $sql .= " values ('{$username}','{$password}','','','','{$email}','{$regitserData}','','0','{$token}','{$token_exptime}')";
            DBManager::register_account($sql,$username);
            $body = "亲爱的用户，感谢您在我站注册了新帐号：".$username."请点击链接激活您的帐号，并及时登录网站完善个人信息</br></br>
            http://enoecan.com/register.php?verify=".$token."</br></br>
            如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效</br>
            如果此次激活请求非你本人所发，请忽略本邮件。</br>";
            $subject = "【ICAN CONTROL账号激活】";
            if(send_register_email($subject,$body,$username,$email)){
                echo "activated_sendmail_success";
                exit;
            }else{
                echo "activated_sendmail_failed";
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
    function activate_account($token){
         include("db.class.php");
         $sql = "select username,token_exptime from account where activated = '0' and token='{$token}'";
         $result = DBManager::query_mysql($sql);
         $nowtime = time();
         if($result){
            if($result['0'][token_exptime] < $nowtime){
                header("Location:index.php?m=activated_exptime");
                exit;
            }else{
                $sql = "update account set activated = '1' where token = '{$token}'";
                $success = DBManager::update_mysql($sql);
                if($success){
                    header("Location:index.php?m=actived_finished");
                    exit;
                }else{
                    header("Location:index.php?m=actived_failed");
                    exit;
                }
            }
         }
    }
    
?>
