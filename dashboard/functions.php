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

    function IndexOfModeName($modeNames,$index){
       return explode(" ",$modeNames)[$index]; 
    }

    //show unbinded device for binding device
    function getUnbindDeviceOption(){
      $sql = "select devicename from devices where owner = 'root'";
      $resultArray = DBManager::query_mysql($sql);
      foreach ($resultArray as $key => $value) {
        echo "<option>".$value["devicename"]."</option>";
      }
    }

    //add device
    function addDevice($initialName,$devicename,$remark){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "update devices set devicename = '{$devicename}',remark = '{$remark}',owner = '{$_SESSION["username"]}' where devicename = '{$initialName}' and owner = 'root'";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"add_device_success"}';
      }else{
        echo '{"state":"add_device_failed"}';
      }
    }

    //modify device
    function modifyDevice($deviceId,$devicename,$remark){
      $sql = "update devices set devicename = '{$devicename}',remark = '{$remark}' where deviceId = '{$deviceId}'";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"modify_device_success"}';
      }else{
        echo '{"state":"modify_device_failed"}';
      }
    }

    //delete device
    function deleteDevice($deviceId){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "selete devices where deviceId='{$deviceId}' and owner = '{$_SESSION["username"]}'";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"delete_device_success"}';
      }else{
        echo '{"state":"delete_device_failed"}';
      }
    }

    //show device
    function getDeviceString($templet){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "select * from devices where owner = '{$_SESSION["username"]}'";
      $resultArray = DBManager::query_mysql($sql);
      foreach ($resultArray as $key => $value) {
        if($templet == "header"){
          echo "<li><a href='device.php?unique=".$value["deviceId"]."'>{$value["devicename"]}</a></li>";
        }else if($templet == "addController"){
          echo "<option value='{$value["deviceId"]}'>{$value["devicename"]}</option>";
        }else if($templet == "table"){
          echo "<tr><td>{$value["devicename"]}</td><td>{$value["remark"]}</td>";
          if($value["connectState"] == "0"){
            echo "<td><span class='label label-info label-mini'>已断开</span></td>";
          }else if($value["connectState"] == "1"){
            echo "<td><span class='label label-success label-mini'>已连接</span></td>";
          }
          echo '<td><button data-toggle="modal" data-target="#modifyDevice" data-deviceid="'.$value["deviceId"].'" class="btn btn-primary btn-xs modifyDevice"><i class="fa fa-pencil"></i></button>&nbsp;<button data-toggle="modal" data-target="#deleteDevice" data-deviceid="'.$value["deviceId"].'" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button></td></tr>';
        }
        
      }
    }

    //add controller
    function addController($controllerType,$controllerName,$deviceId,$modeNames,$minValue,$maxValue){
      $sql = "insert into controller(deviceId,controName,typeId,minValue,maxValue_,modeNames) values('{$deviceId}','{$controllerName}','{$controllerType}','{$minValue}','{$maxValue}','$modeNames')";
      if(DBManager::update_mysql($sql)){
        echo '{"state":"add_controller_success"}';
      }else{
        echo '{"state":"add_controller_failed"}';
      }
    }


    function getControllerTypeName(){
      $sql = "select typeName from type";
      return DBManager::query_mysql($sql);
    }

    /*profile update information*/
    function update_account_all(){
    	if(!isset($_SESSION)){
        session_start();
      }
    	$nickname = $_POST["nickname"];
    	$personal = $_POST["personal"];
    	// get upload directory for storing avatar
    	$uploaddir = "../upload/{$_SESSION["username"]}/";
      // get image extension name
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
      // directory exist? otherwise create it
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
        if(!isset($_SESSION)){
          session_start();
        }
        if(get_email() == "未绑定邮箱"){
          $target_email = $email;
          $nowtime = time();
          $token_exptime = $nowtime+60*60*24;//过期时间为24小时后
          $token = md5(get_username().$email.$nowtime); //创建用于激活识别码*/
          $body = "亲爱的用户，您在本站的账号【".get_username()."】绑定邮箱，请点击链接激活绑定</br></br>
            <a href='http://sunriseteam.cn/enOcean/register.php?verify=".$token."&email=".$email."'>http://sunriseteam.cn/enOcean/register.php?verify=".$token."&email=".$email."</a></br></br>
            如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效</br>
            如果此次激活请求非你本人所发，请忽略本邮件。</br>";
          $subject = "【WGCX物联-邮箱绑定】";
          $username = get_username();
          $sql = "update account set token = '{$token}',token_exptime = '{$token_exptime}' where username = '{$username}'";
          DBManager::update_mysql($sql);
        }else{
          $target_email = get_email();
          $body = "亲爱的用户，您在本站的账号【".get_username()."】申请更换邮箱为：</br>".$email."</br>如果以上您的个人操作，请点击下面的链接确定更换绑定邮箱</br></br><a href='http://sunriseteam.cn/enOcean/register.php?type=change_email_confirm&email=".$email."&token=".get_token()."'>http://sunriseteam.cn/enOcean/register.php?type=change_email_confirm&email=".$email."&token=".get_token()."</a></br></br>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问</br>如果此次请求非你本人所发，请忽略本邮件。</br>";
          $subject = "【WGCX物联-更改邮箱】";
        }
        if(send_register_email($subject,$body,get_username(),$target_email)){
          echo "change_email_send";
          return ;
        }else{
          echo "change_email_failed";
          return ;
        }
      }
    }

    //jquery json example -- safe-setting page
    function change_phoneNumber($verifycode,$phoneNumber){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "select username from account where phoneNumber = '{$phoneNumber}'";
      if(DBManager::query_mysql($sql)){
        echo '{"state":"phoneNumber_exit"}';
        exit;
      }
      if($verifycode != $_SESSION["verifycode"]){
        echo '{"state":"verifycode_wrong"}';
        exit;
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

    //delete logbook --logbook page
    function delete_single_log($logDate,$password){
      if(!isset($_SESSION)){
        session_start();
      }
      if(!check_password($password)){
        echo '{"state":"password_wrong"}';
      }else{
        $sql = "delete from logbook where username = '{$_SESSION["username"]}' and logDate = '{$logDate}'";
        if(DBManager::update_mysql($sql)){
          echo '{"state":"delete_single_log_success"}';
        }else{
          echo '{"state":"delete_single_log_failed"}';
        }
      }
    }

    //batch delete logbook 
    function batch_delete_log($logDateString,$password){
      $logDateString = str_replace('[','(',$logDateString);
      $logDateString = str_replace(']',')',$logDateString);
      if(!isset($_SESSION)){
        session_start();
      }
      if(!check_password($password)){
        echo '{"state":"password_wrong"}';
      }else{
        $sql = "delete from logbook where logDate in {$logDateString} and username = '{$_SESSION["username"]}'";
        if(DBManager::update_mysql($sql)){
          echo '{"state":"batch_delete_log_success"}';
        }else{
          echo '{"state":"batch_delete_log_failed"}';
        }
      }
    }

    //logbook page 
    function check_password($password){
      if(!isset($_SESSION)){
        session_start();
      }
      $sql = "select password from account where username = '{$_SESSION["username"]}'";
      return DBManager::query_mysql($sql)["0"]["password"] == $password;
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
              change_phoneNumber($_GET["verifycode"],$_GET["phoneNumber"]);
              break;
          case "change_password":
              change_password($_GET["password"],$_GET["newPassword"]);
              break;
          case "change_address":
              change_address($_GET["address"]);
              break;
          case "delete_single_log":
              delete_single_log($_GET["logDate"],$_GET["password"]);
              break;
          case "batch_delete_log":
              batch_delete_log($_GET["logDate"],$_GET["password"]);
              break;
          case "add_device":
              addDevice($_GET["initialName"],$_GET["deviceName"],$_GET["deviceRemark"]);
              break;
          case "delete_device":
              delete_device($_GET["deviceId"]);
              break;
          case "add_controller":
              addController($_GET["controllerType"],$_GET["controllerName"],$_GET["deviceId"],$_GET["modeNames"],$_GET["minValue"],$_GET["maxValue"]);
              break;
          case "modify_device":
              modifyDevice($_GET["deviceId"],$_GET["deviceName"],$_GET["deviceRemark"]);
              break;
        }
      }
    }

?>