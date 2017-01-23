<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<link rel="stylesheet" type="text/css" href="css/initial.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/toastr/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="css/login.css?v=2.1">
	<title>智能家居管理系统</title>
	<!--[if lt IE 9]>
	 <script type="text/javascript">
		window.location="http://www.baidu.com";
	 </script>
    <![endif]-->
</head>
<body>
	<div class="header">
		<span class="logo font-art">I CONTROL</span>
	</div>
	<div class="container">
		<div class="login">
			<div class="login-screen">
				<div class="login-icon">
		            <img src="images/Compas.png" alt="Welcome to I Control">
		            <h4>Welcome to <small>I Control</small></h4>
		        </div>
		        <ul class="tab" id="tabs">
		        	<li class="">登录</li>
		        	<li class="inactive">注册</li>
		        </ul>
		       
		        <div class="login-form" id="login">
		            <div class="form-group">
		              <input type="text" class="form-control login-field" value="" placeholder="输入用户名" id="login-name">
		              <label class="login-field-icon fa fa-user" for="login-name"></label>
		            </div>

		            <div class="form-group">
		              <input type="password" class="form-control login-field" placeholder="输入密码" id="login-pass">
		              <label class="login-field-icon fa fa-lock" for="login-pass"></label>
		            </div>
					
					<div class="form-group">
		              <input style="width: 60%" type="text" class="form-control login-field" value="" placeholder="输入验证码" id="login-verify">
		              <label style="right: 140px" class="login-field-icon fa fa-eye"></label>
		              <img style="padding:0px 5px;" src="checks.php" align="top">
		            </div>
		            <button value="登录" class="btn btn-primary btn-large btn-block" onclick="validate_form(this);" type="submit" >登录</button>
		            <a class="login-link" href="#">忘记密码?</a>
          		</div>

          		<div class="login-form none" id="register">
		            <div class="form-group">
		              <input type="text" class="form-control login-field" value="" placeholder="输入用户名" id="register-name">
		              <label class="login-field-icon fa fa-user" ></label>
		            </div>
		            <div class="form-group">
		              <input type="password" class="form-control login-field"  placeholder="输入密码" id="register-pass">
		              <label class="login-field-icon fa fa-lock" ></label>
		            </div>
		            <div class="form-group">
		              <input type="email" class="form-control login-field" value="" placeholder="输入手机号" id="register-phoneNumber">
		              <label class="login-field-icon fa fa-tablet" style="font-size: 17px;"></label>
		            </div>
		            <div class="form-group">
		              <input style="width: 60%" type="text" class="form-control login-field" value="" placeholder="输入验证码" id="register-verify">
		              <label style="right: 140px" class="login-field-icon fa  fa-keyboard-o"></label>
		              <button style="float: right;" class="btn btn-success" id="sendMessage" type="button">发送验证码</button>
		            </div>
		            <button value="注册" class="btn btn-primary btn-large btn-block" onclick="validate_form(this);" type="submit">注册</button>
          		</div>
			</div>
		</div>
	</div>
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script src="assets/toastr/toastr.min.js"></script>
  <script src="js/login.js?v=1.3"></script>
  <?php 
  	$msg = "";
  	if(isset($_GET["m"])){
  		switch($_GET["m"]) {
  			case    "activated_exptime"  :
  			$msg = "激活有效期已过，请重新注册账号";
  			break;
  			case    "actived_finished"  :
  			$msg = "邮箱激活成功，可以正常使用了<br />";
  			break; 
  			case    "actived_failed"  :
  			$msg = "邮箱激活失败，请重试<br />";
  			break; 
  			case    "change_email_success":
  			$msg = "邮箱更换成功！";
  			break; 
  			case    "change_email_failed":
  			$msg = "邮箱更换失败，请重试！";
  			break;
  			default:
  			$msg = "";
  			break;
  		}
  	}
	
    if($msg != ""){
    	echo "<script type='text/javascript'>toastr.info('{$msg}');</script>";
    }
    
  ?>
</body>
</html>