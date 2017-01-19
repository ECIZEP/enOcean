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



	if($_SERVER['REQUEST_METHOD'] == "GET"){
		if(isset($_GET["type"])){
			switch ($_GET["type"]) {
				//profile update
				case "update_account":
					$sql = $_GET["sql"];
					if(DBManager::update_mysql($sql)){
						echo "update_account_success";
					}else{
						echo "update_account_failed";
					}
					break;
				default:
					
					break;
			}
		}
		
	}
?>