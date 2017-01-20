//初始化toastr
toastr.options = {
  "closeButton": false,
  "progressBar": true,
  "debug": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "2500",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

function tabSwitcher(){
	var lis = document.getElementById('tabs').getElementsByTagName('li');
	var login = document.getElementById('login');
	var register = document.getElementById('register');
	for (var i = 0; i < lis.length; i++) {
		$(lis[i]).bind("click",function(index){
			return function(){
				if(index == 0){
					lis[0].className = "";
					lis[1].className = "inactive";
					login.className = "login-form";
					register.className = "login-form none"
				}else{
					lis[0].className = "inactive";
					lis[1].className = "";
					login.className = "login-form none";
					register.className = "login-form"
				}
			}
		}(i));
	}
}

function validate_form(obj){
	if(obj.value == "登录"){
		var username = document.getElementById('login-name').value;
		var password = document.getElementById('login-pass').value;
		var verification = document.getElementById('login-verify').value;
		if(username.length < 5 || password.length < 6){
			toastr.info("用户名或者密码位数少于6位！");
			return false;
		}
		if(verification.length != 4){
			toastr.info("验证码位数不正确！");
			return false;
		}
		ajaxLoginPost(username,password,verification);
	}else if(obj.value == "注册"){
		var username = document.getElementById('register-name').value;
		var password = document.getElementById('register-pass').value;
		var passAgain = document.getElementById('register-passagain').value;
		var email = document.getElementById('register-email').value;
		if(username.length < 6 || password.length < 6 || passAgain.length < 6 || email.length < 6){
			toastr.info("请将表单填写完整，并确定用户名和密码不少于6位");
			return false;
		}
		if(password != passAgain){
			toastr.info("两次密码输入不一致，请核实");
			return false;
		}
		var reg = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
		if(!reg.test(email)){
			toastr.info("邮箱格式不正确！");
			return false;
		}
		ajaxRegisterPost(username,password,email);
	}
	return false;
}

function ajaxRegisterPost(username,password,email){
	var xmlHttp = GetXmlHttpObject();
	var data = "username=" + username + "&password=" + password + "&email=" + email;
	if (xmlHttp == null)
	{
		toastr.error("Browser does not support HTTP Request");
		return;
	}
	var url="../register.php";
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if (xmlHttp.status == 200) {
				toastr.clear();
				switch(xmlHttp.responseText){
					case "register_name_email_exist" :
						toastr.info("邮箱和用户名已经存在");
						break;
					case "register_name_exist" :
						toastr.error("用户名已经存在");
						break;
					case "register_email_exist" :
						toastr.error("邮箱已经存在");
						break;
					case "activated_sendmail_success" :
						toastr.success("注册成功，激活邮件已发送，请检查邮件并激活账号");
						/*var lis = document.getElementById('tabs').getElementsByTagName('li');
						lis[0].onclick();*/
						break;
					case "activated_sendmail_failed" :
						toastr.error("注册失败，请重试");
						break;
				}
			}else{
				toastr.error("请求出错，错误信息：" + xmlHttp.status);
			}
		}	
	}
	xmlHttp.open("POST",url);
	xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp.send(data);
	toastr.info("请求正在提交中......");
}

function ajaxLoginPost(username,password,verification){
	var xmlHttp = GetXmlHttpObject();
	var data = "username=" + username + "&password=" + password + "&verification=" + verification;              
	if (xmlHttp==null)
	{
		toastr.error("Browser does not support HTTP Request");
		return;
	} 
	var url="../login.php";
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if (xmlHttp.status == 200) {
				console.log(xmlHttp.responseText);
				switch(xmlHttp.responseText){
					case "0" :
						toastr.error("该账号未激活,请查收激活邮件");
						break;
					case "1" :
						toastr.error("密码不正确");
						document.getElementById('login-pass').value = "";
						break;
					case "2" :
						toastr.error("验证码填写错误");
						document.getElementById('login-verify').value = "";
						break;
					case "3" :
						window.location.href = "../htmls/profile.php";
						window.event.returnValue = false;
						break;
				}
			}else{
				toastr.error("请求出错，错误信息：" + xmlHttp.status);
			}
		}	
	}
	xmlHttp.open("POST",url);
	xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp.send(data);
}

function GetXmlHttpObject()
{ 
	var objXMLHttp = null;
	if (window.XMLHttpRequest)
	{
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}

(function() {  
	tabSwitcher();
})(window.jQuery);