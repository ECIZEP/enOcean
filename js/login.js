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
		if(username.length < 6 || password.length < 6){
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
		var phoneNumber = document.getElementById('register-phoneNumber').value;
		var verifycode = document.getElementById('register-verify').value;
		if(username.length < 6 || password.length < 6 || verifycode.length != 6){
			toastr.info("请将表单填写完整，并确定用户名和密码不少于6位");
			return false;
		}
		var reg = /^1[3|4|5|7|8][0-9]{9}$/; //验证规则
		if(!reg.test(phoneNumber)){
			toastr.info("手机号码格式不正确！");
			return false;
		}
		ajaxRegisterPost(username,password,phoneNumber,verifycode);
	}
	return false;
}

function ajaxRegisterPost(username,password,phoneNumber,verifycode){
	var xmlHttp = GetXmlHttpObject();
	var data = "type=register&username=" + username + "&password=" + password + "&phoneNumber=" + phoneNumber + "&verifycode=" + verifycode;
	if (xmlHttp == null)
	{
		toastr.error("Browser does not support HTTP Request");
		return;
	}
	var url="./register.php";
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if (xmlHttp.status == 200) {
				toastr.clear();
				switch(xmlHttp.responseText){
					case "register_verifycode_wrong" :
						toastr.error("验证码不正确！");
						break;
					case "register_name_exist" :
						toastr.info("用户名已经被注册");
						break;
					case "register_name_phoneNumber_exist":
						toastr.info("用户名和手机号都已经被注册");
						break;
					case "register_phoneNumber_exist":
						toastr.info("手机号已经被注册");
						break;
					case "register_success" :
						toastr.success("注册成功，你可以登录账户了");
						/*var lis = document.getElementById('tabs').getElementsByTagName('li');
						lis[0].onclick();*/
						break;
					case "register_failed" :
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
	var url="./login.php";
	xmlHttp.onreadystatechange = function(){
		if(xmlHttp.readyState == 4){
			if (xmlHttp.status == 200) {
				console.log(xmlHttp.responseText);
				switch(xmlHttp.responseText){
/*					case "0" :
						toastr.error("该账号未激活,请查收激活邮件");
						break;*/
					case "1" :
						toastr.error("密码不正确");
						document.getElementById('login-pass').value = "";
						break;
					case "2" :
						toastr.error("验证码填写错误");
						document.getElementById('login-verify').value = "";
						break;
					case "3" :
						window.location.href = "./dashboard/index.php";
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
	var sendMessage = document.getElementById('sendMessage');
	if(sendMessage){
		sendMessage.onclick = function(){
			this.disabled = "true";
			$(this).removeClass('btn-success');
			this.innerHTML = "<span id='text'>60</span>秒后发送";

			var phoneNumber = $('#register-phoneNumber').val();
			console.log(phoneNumber);
			var reg = /^1[3|4|5|7|8][0-9]{9}$/; //验证规则
			if(!reg.test(phoneNumber)){
				toastr.info("手机格式不正确！");
				return;
			}

			$.ajax({
				type: "GET",
				url: "./message/sendMessage.php",
				dataType:'json',
				data: {
					type: "sendVerifycode",
					phoneNumber:phoneNumber
				},
				success: function(data){
					if(data.state == "sendVerifycode_success"){
						toastr.success("验证码已发送，请查收");
					}else if(data.state == "sendVerifycode_failed"){
						toastr.success("验证码发送出错，请重试获取");
						document.getElementById('text').innerHTML = 1;
					}
				},
				error: function(){
					toastr.clear();
					toastr.error("验证码请求错误");
				}
			});
			timeCount();
		}


		timeCount = function(){
			time = parseInt(document.getElementById('text').innerHTML) - 1;
			if(time == 0){
				var sendMessage = document.getElementById('sendMessage');
				sendMessage.disabled = false;
				$(sendMessage).addClass('btn-success');
				sendMessage.innerHTML = '发送验证码';
			}else{
				document.getElementById('text').innerHTML = time;
				setTimeout("timeCount()",1000);
			}
		}
	}


	function sendVerifycode(){

	}

})(window.jQuery);