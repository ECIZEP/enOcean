<?php
	include("../db.class.php");
	if(!empty($_SESSION['username'])){
		$account = DBManager::query_account_by_username($_SESSION['username']);
	}else{
		header("../index.html");
	}

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

  	function get_personal(){
  		global $account;
  		return $account["personal"];
  	}

  	function fileExtName ($fStr) {
        $retval = "";
        $pt = strrpos($fStr, ".");
        if ($pt) $retval = substr($fStr, $pt+1, strlen($fStr) - $pt);
        return ($retval);
    }

    function update_account_all(){
    	session_start();
    	$nickname = $_POST["nickname"];
    	$personal = $_POST["personal"];
    	
    	$uploaddir = "../upload/{$_SESSION["username"]}/";
    	$ext = fileExtName($_FILES['file']['name']);
    	$ext = strtolower($ext);
    	if($ext!="jpg" && $ext!="gif" && $ext!="png") {
    		echo "file_type_error";
    		return;
    	}
    	if($_FILES["file"]["size"] > 500000){
    		echo "file_over_size";
    		return;
    	}
    	if(!is_dir($uploaddir))
    	{
    		if(!mkdir($uploaddir))
    		{
    			echo "file_folder_create_failed";
    			return;
    		}
    	}
    	$uploadfile = $uploaddir.$_SESSION["username"]."_avatar.".$ext;

    	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    		$sql = "update account set nickname = '{$nickname}',personal = '{$personal}',photoUrl = '{$uploadfile}' where username = '{$_SESSION["username"]}'";
    	} else {
    		$sql = "update account set nickname = '{$nickname}',personal = '{$personal}' where username = '{$_SESSION["username"]}'";
    	}
    	
    	if(DBManager::update_mysql($sql)){
    		echo "update_account_success";
    		return;
    	}else{
    		echo "update_account_failed";
    		return;
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
		
	}
?>