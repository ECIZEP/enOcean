<?php
    include("../db.class.php");
    if(!isset($_SESSION)){
      session_start();
    }
    $account = DBManager::query_account_by_username($_SESSION['username']);
    
  	function get_username(){
  		global $account;
  		if($account["username"]){
  			return $account["username"];
  		}
  	}

  	function get_nickname(){
  		global $account;
  		if($account["nickname"] == ""){
  			return "未设置";
  		}else{
  			return $account["nickname"];
  		}
  	}

  	function get_photoUrl(){
  		global $account;
  		if($account["photoUrl"]){
  			return $account["photoUrl"];
  		}
  	}

  	function get_email($bind = false){
  		global $account;
  		if($bind == true){
  			if($account["email"]){
  				return "已绑定邮箱：".$account["email"];
  			}else{
  				return "未绑定邮箱";
  			}
  		}else{
  			if($account["email"]){
  				return $account["email"];
  			}else{
  				return "未绑定邮箱";
  			}
  		}
  	}

  	function get_phone_number($bind = false){
  		global $account;
  		if($bind == true){
  			if($account["phoneNumber"]){
  				return "已绑定手机：".$account["phoneNumber"];
  			}else{
  				return "未绑定手机";
  			}
  		}else{
  			if($account["phoneNumber"]){
  				return $account["phoneNumber"];
  			}else{
  				return "未绑定手机";
  			}
  		}
  		
  	}

    function get_address(){
      global $account;
      return $account["address"];
    }

    function get_personal(){
      global $account;
      return $account["personal"];
    }

    function get_token(){
      global $account;
      return $account["token"];
    }

    function fileExtName ($fStr) {
      $retval = "";
      $pt = strrpos($fStr, ".");
      if ($pt) $retval = substr($fStr, $pt+1, strlen($fStr) - $pt);
      return ($retval);
    }


    /*profile uodate information*/
    function update_account_all(){
    	if(!isset($_SESSION)){
        session_start();
      }
    	$nickname = $_POST["nickname"];
    	$personal = $_POST["personal"];
    	// get upload directory for storing avatar
    	$uploaddir = "../upload/{$_SESSION["username"]}/";
      // get images extension
    	$ext = fileExtName($_FILES['file']['name']);
    	$ext = strtolower($ext);
      // only jpg,gif,png allowed
    	if($ext!="jpg" && $ext!="gif" && $ext!="png") {
    		echo "file_type_error";
    		return;
    	}
      // can not bigger than 500kb
    	if($_FILES["file"]["size"] > 500000){
    		echo "file_over_size";
    		return;
    	}
      // directory exist?
    	if(!is_dir($uploaddir))
    	{
    		if(!mkdir($uploaddir))
    		{
    			echo "file_folder_create_failed";
    			return;
    		}
    	}
    	$uploadfile = $uploaddir.$_SESSION["username"]."_avatar.".$ext;
      // store the image into dirctory
    	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    		$sql = "update account set nickname = '{$nickname}',personal = '{$personal}',photoUrl = '{$uploadfile}' where username = '{$_SESSION["username"]}'";
    	} else {
    		$sql = "update account set nickname = '{$nickname}',personal = '{$personal}' where username = '{$_SESSION["username"]}'";
    	}
    	// update database
    	if(DBManager::update_mysql($sql)){
    		echo "update_account_success";
    		return;
    	}else{
    		echo "update_account_failed";
    		return;
    	}
    }

    /*safe-setting page —— change email function*/
    function change_email($email){
      $sql = "select  *  from account where email='{$email}'  limit 1 ";
      $result_email = DBManager::query_mysql($sql);
      if($result_email && $result_email["activated"] == "1"){
        echo "change_email_exit";
        return ;
      }else{
        include("../send_email.php");
        $body = "亲爱的用户，您在本站的账号【".get_username()."】申请更换邮箱为：</br>".$email."</br>如果以上您的个人操作，请点击下面的链接确定更换绑定邮箱</br></br>http://enoecan.com/register.php?type=change_email_confirm&email=".$email."&token=".get_token()."</br></br>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问</br>如果此次请求非你本人所发，请忽略本邮件。</br>";
        $subject = "【ICAN CONTROL更改邮箱】";
        if(send_register_email($subject,$body,get_username(),get_email())){
          echo "change_email_send";
          return ;
        }else{
          echo "change_email_failed";
          return ;
        }
      }
    }

    //jquery json example -- safe-setting page
    function change_phoneNumber($phoneNumber){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "update account set phoneNumber = '{$phoneNumber}' where username = '{$_SESSION["username"]}'";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"change_phoneNumber_success"}';
        exit;
      }else{
        echo '{"state":"change_phoneNumber_failed"}';
        exit;
      }
    }

    // change password  --safe-setting page
    function change_password($password,$new_password){
      if(!isset($_SESSION)){
        session_start();
      }
      if($password != DBManager::query_account_by_username($_SESSION["username"])["password"]){
        echo '{"state":"password_incorrect"}';
      }else{
        $sql = "update account set password = '{$new_password}' where username = '{$_SESSION["username"]}'";
        if(DBManager::update_mysql($sql)){
          echo '{"state":"change_password_success"}';
          exit;
        }else{
          echo '{"state":"change_password_failed"}';
          exit;
        }
      }
      
    }

    // change address --safe-setting page
    function change_address($address){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "update account set address = '{$address}' where username = '{$_SESSION["username"]}'";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"change_address_success"}';
        exit;
      }else{
        echo '{"state":"change_address_failed"}';
        exit;
      }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_POST["type"])){
        switch ($_POST["type"]) {
  				//profile update
          case "update_account_all":
              update_account_all();
              break;
          case "update_account_info":
              $sql = $_POST['sql'];
              if(DBManager::update_mysql($sql)){
                echo "update_account_success";
              }else{
                echo "update_account_failed";
              }
              break;
        }
      }
    }elseif($_SERVER['REQUEST_METHOD'] == "GET"){
      if(isset($_GET["type"])){
        switch ($_GET["type"]) {
          case "change_email":
              change_email($_GET["email"]);
              break;
          case "change_phoneNumber":
              change_phoneNumber($_GET["phoneNumber"]);
              break;
          case "change_password":
              change_password($_GET["password"],$_GET["newPassword"]);
              break;
          case "change_address":
              change_address($_GET["address"]);
              break;
        }
      }
    }
?>