//initial toastr
toastr.options = {
	"closeButton": false,
	"progressBar": true,
	"debug": false,
	"positionClass": "toast-top-right",
	"onclick": null,
	"showDuration": "300",
	"hideDuration": "1000",
	"timeOut": "3000",
	"extendedTimeOut": "1000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
};


// custom sidebar scrollbar
$(".sidebar").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: '', scrollspeed: 60});


//sidebar show/hide animate
$('div.sidebar').ready(function(){
	if(document.body.clientWidth <= 768){
		var top = 59 - parseInt($('div.sidebar').css("height"));
		$('div.sidebar').css("top",top+"px");
		setTimeout("$('div.sidebar').css('display','block');",100);
	}
});

$('.sidebar-toggle').click(function(){
	if(document.body.clientWidth > 768){
		if($('div.content').css("marginLeft") == "0px"){
			$('div.content').animate({marginLeft:'210px'},400);
			$('div.sidebar').animate({marginLeft:'0px'},400);
		}else{
			$('div.content').animate({marginLeft:'0px'},400);
			$('div.sidebar').animate({marginLeft:'-210px'},400);
		}
	}else{
		if($('div.sidebar').css("top") == "60px"){
			var top = 59 - parseInt($('div.sidebar').css("height"));
			$('div.sidebar').animate({top:top + "px"},200);
		}else{
			$('div.sidebar').animate({top:"60px"},200);
		}
	}
});

//add and delete device
$('#addDeviceModalConfirm').click(function(){
  var deviceName = $('#deviceName').val();
  var deviceRemark = $('#deviceRemark').val();
  if(deviceName == "" || deviceRemark == ""){
    toastr.info("请把表单输入完整!");
  }else{
    var selectCon = document.getElementById('select-device');
    var initialName = selectCon.options[selectCon.selectedIndex].text;
    $.ajax({
          type: "GET",
          url: "./functions.php",
          dataType:'json',
          data: {
            type: "add_device",
            deviceName: deviceName,
            deviceRemark: deviceRemark,
            initialName:initialName
          },
          success: function(data){
            if(data.state == "add_device_success"){
              $('#addDeviceModal').modal('hide');
              toastr.success("设备添加成功，刷新页面即可加载新数据！");
            }else if(data.state == "add_device_failed"){
              toastr.error("设备添加成功，刷新页面即可加载新数据！");
            }
          },
          error: function(){
            toastr.clear();
            toastr.error("发生错误：");
          }
        });
  }
});

//add controller
$('#controllerType').change(function(){
  switch(this.selectedIndex){
    case 0:
      $('.selectMode').addClass('hide');
      $('.sliderMode').addClass('hide');
      break;
    case 1:
      $('.selectMode').removeClass('hide');
      $('.sliderMode').addClass('hide');
      break;
    case 2:
      $('#modeName').text("输入滑块控制范围");
      $('.selectMode').addClass('hide');
      $('.sliderMode').removeClass('hide');
      break;
    case 3:
      $('#modeName').text("输入数值正常范围");
      $('.selectMode').addClass('hide');
      $('.sliderMode').removeClass('hide');

  }
});

//sidebar menu animate
(function(){
	var sidebarItems = document.getElementById('sidebar').getElementsByTagName('li');
	for (var i = 0; i < sidebarItems.length; i++) {
		sidebarItems[i].index = i;
		sidebarItems[i].addEventListener('click',function(){
			for(var j = 0;j < sidebarItems.length;j++){
				if(j != this.index){
					sidebarItems[j].className = "subitem";
				}else{
					sidebarItems[j].className = "subitem active";
				}
			}

			var submenu;
			for (var j = 0; j < sidebarItems.length; j++) {
				if(this.index != j){
					sidebarItems[j].getElementsByTagName('a')[0].className = "";
					submenu = sidebarItems[j].getElementsByTagName('ul')[0];
					if(submenu){
						submenu.style.display = "none";
					}
				}
			}
			submenu = this.getElementsByTagName('ul')[0];
			if(submenu){
				if(submenu.style.display == "block"){
					submenu.style.display = "none";
				}else{
					submenu.style.display = "block";
				} 
			}
		},false);
	}
})();

/*panel animate---device*/
jQuery('.panel .tools .fa-chevron-down').click(function () {
	var el = jQuery(this).parents(".panel").children(".panel-body");
	if (jQuery(this).hasClass("fa-chevron-down")) {
		jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
		el.slideUp(200);
	} else {
		jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
		el.slideDown(200);
	}
});

jQuery('.fa.fa-times').click(function () {
	var el = this.parentNode.parentNode.parentNode.parentNode;
	el.style.display = 'none'
});


$('.switch-animate').click(function(){
	if(jQuery(this).hasClass("switch-on")){
		jQuery(this).removeClass("switch-on").addClass("switch-off");
	}else{
		jQuery(this).removeClass("switch-off").addClass("switch-on");
	}
});


/*panel slider animate---device*/
var startX;
var animate = false;
var rangeWidth;

$('.ui-slider-handle').mousedown(function(event){
	var target = event.target?event.target:event.srcElement;
	if(!startX){
		startX = event.clientX;
		rangeWidth = jQuery(target).parents(".slider").children(".ui-slider-range")[0].offsetWidth;
	}
	jQuery(this).addClass("ui-state-move");
	animate = true;
});

document.onmousemove = function(event){
	var target = event.target?event.target:event.srcElement;
	if(startX && animate){
		var offsetX = event.clientX - startX;
		var leftValue = offsetX/rangeWidth * 100;
		if(leftValue >= 0 && leftValue <= 100){
			$('.ui-state-move')[0].style.left = leftValue + "%";
			$('#slider-amount')[0].innerHTML = Math.floor(leftValue);
		}
	}
}

document.onmouseup = function(event){
	animate = false;
	$('.ui-slider-handle').removeClass("ui-state-move");
}

var modify = document.getElementById('modify');
if(modify){
	modify.onclick = function(){
		var modal = document.getElementById('myModal4');
		$(modal).addClass('in');
	}
}




/*content modified--profile */

(function(){

	var btnUpdate = document.getElementById('profile-update');
	if(!btnUpdate){
		return ;
	}
	var inputNickname = document.getElementById('nickname-profile');
	var inputPersonal = document.getElementById('personal-profile');
	var inputFile = document.getElementById('file');
	var btnRemove = document.getElementById('photo-remove');
	inputNickname.onkeypress = inputNickname.onchange = enableUpdate;
	inputPersonal.onkeypress = inputPersonal.onchange = enableUpdate;

	inputFile.onchange = function(){
		enableUpdate();
		console.log(inputFile.value);
	}

  //delete input file
  btnRemove.onclick = function(){
  	$('.fileupload-preview').empty();
  	$('.fileupload.fileupload-exists').removeClass('fileupload-exists').addClass('fileupload-new');
  	inputFile.value = "";
  }

  function enableUpdate(){
  	btnUpdate.disabled = false;
  }

  function disableUpdate(){
  	btnUpdate.disabled = true;
  }

  btnUpdate.onclick = function(){
  	if(inputNickname && inputPersonal){
  		var nickname = inputNickname.value;
  		var personal = inputPersonal.value;
  		var username = document.getElementById('username-profile').value;
  		ajaxUpdateProfile(username,nickname,personal);
  	}
  }


  //ajax post update user infomation
  function ajaxUpdateProfile(username,nickname,personal){
  	var xmlHttp = GetXmlHttpObject();
  	var sql = "update account set nickname = '" + nickname + "',personal = '" + personal + "' where username = '" + username + "'";
  	var data = "type=update_account_info&sql=" + sql;
  	if(xmlHttp == null)
  	{
  		toastr.error("Browser does not support HTTP Request");
  		return;
  	}
  	var url="./functions.php";
  	xmlHttp.onreadystatechange = function(){
  		if(xmlHttp.readyState == 4){
  			if(xmlHttp.status == 200){
  				switch(xmlHttp.responseText){
  					case "update_account_success" :
  					if(inputFile.value != ""){
  						var photoUrl = "../upload/" + username + "/" + username +"_avatar." + inputFile.files[0].type.split("/")[1];
  						console.log(photoUrl);
  						$('.photoUrl').attr("src",photoUrl);
  					}
  					$('.nickname').html(nickname);
  					toastr.clear();
  					toastr.success("个人信息更新成功！");
  					disableUpdate();
  					break;
  					case "update_account_failed" :
  					toastr.error("更新失败，请重试！");
  					break;
  					case "file_type_error" :
  					toastr.error("上传文件格式错误，请上传jpg,gif或者png格式的图片");
  					break;
  					case "file_over_size" :
  					toastr.error("上传文件太大，请上传小于500kb的图片");
  					break;
  					case "file_folder_create_failed" :
  					toastr.error("服务器出了点问题，文件夹创建失败，请重试");
  					break;
  				}
  			}else{
  				toastr.error("请求出错，错误信息：" + xmlHttp.status);
  			}
  		}
  	}
  	if(window.FormData) {
  		if(inputFile.value == ""){
  			xmlHttp.open("POST",url);
  			xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  			xmlHttp.send(data);
  		}else{
  			var formData = new FormData();
  			formData.append('type',"update_account_all");
  			formData.append('nickname',nickname);
  			formData.append('personal',personal);
  			formData.append('file', inputFile.files[0]);
  			xmlHttp.open("POST",url);
  			xmlHttp.send(formData);
  			toastr.info("请求正在提交中......");
  		}
  	}else{
  		toastr.error("您的浏览器不支持FormData方式上传头像文件，无法更新头像，请使用Chrome等现代浏览器");
  		xmlHttp.open("POST",url);
  		xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  		xmlHttp.send(data);
  	}

  }

})();


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

/*safe setting*/

(function(){
  //change email
  var modal1 = document.getElementById('myModal1Confirm');
  if(modal1){
  	modal1.onclick = function(){
  		var inputValue = document.getElementById('myModal1Input').value;
  		var reg = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
  		if(inputValue == "" || !reg.test(inputValue)){
  			toastr.info("请输入正确的邮箱地址");
  		}else{
  			var xmlHttp = GetXmlHttpObject();
  			if(xmlHttp == null)
  			{
  				toastr.error("Browser does not support HTTP Request");
  				return;
  			}
  			var url = "./functions.php?type=change_email&email=" + inputValue;
  			xmlHttp.onreadystatechange = function(){
  				if(xmlHttp.readyState == 4){
  					if(xmlHttp.status == 200){
  						toastr.clear();
  						switch(xmlHttp.responseText){
  							case "change_email_exit":
  							toastr.info("该邮箱已被注册，请换一个试试");
  							break;
  							case "change_email_send":
  							toastr.success("新邮箱激活认证邮件已发送到原邮箱，请查收激活！");
  							$('#myModal1').modal('hide');
  							break;
  							case "change_email_failed":
  							toastr.error("不可知的原因，激活邮件发送失败，请重试！");
  							break;
  						}
  					}else{
  						toastr.error("发生错误：" + request.status);
  					}
  				}
  			}
  			xmlHttp.open("GET",url);
  			xmlHttp.send(null);
  			toastr.info("请求正在提交中......");
  		}
  	};
  }

  //change phonenumber
  var sendMessage = document.getElementById('sendMessage');
  if(sendMessage){
  	sendMessage.onclick = function(){
      var inputValue = document.getElementById('changePhoneInput').value;
      var phoneNumber = $('#phoneLabel > span').text();
      var reg = /^1[3|4|5|7|8][0-9]{9}$/; //验证规则
      if(!reg.test(inputValue)){
        toastr.info("手机格式不正确！");
        return;
      }
  		this.disabled = "true";
  		this.innerHTML = "<span class='Secondtext'>60</span>秒再发送";
  		sendVerifycode("change_phoneNumber",phoneNumber);
      timeCount();
  	}

  	timeCount = function(){
  		time = parseInt($('.Secondtext').text()) - 1;
  		if(time == 0){
  			document.getElementById('sendMessage').disabled = false;
  			document.getElementById('sendMessage').innerHTML = '发送验证码';
  		}else{
  			$('.Secondtext').text(time);
  			setTimeout("timeCount()",1000);
  		}
  	}

  	document.getElementById('changePhoneConfirm').onclick = function(){
  		var inputValue = document.getElementById('changePhoneInput').value;
  		if(inputValue == "" || inputValue.length != 11){
  			toastr.info("请填写正确的手机号码！");
  		}else{
  			$.ajax({
  				type: "GET",
  				url: "./functions.php",
  				dataType:'json',
  				data: {
  					type: "change_phoneNumber",
            verifycode:$('.verifycodeInput').val(),
  					phoneNumber:inputValue
  				},
  				success: function(data){
  					if(data.state == "change_phoneNumber_success"){
  						$('#changePhoneModal').modal('hide');
  						$('#phoneLabel > span').text(inputValue);
  						toastr.success("手机绑定成功！");
  					}else if(data.state == "change_phoneNumber_failed"){
  						toastr.success("手机绑定失败，请重试！");
  					}else if(data.state == "phoneNumber_exit"){
              toastr.info("手机号已存在");
            }else if(data.state == "verifycode_wrong"){
              toastr.info("验证码错误");
            }
  				},
  				error: function(){
  					toastr.clear();
  					toastr.error("发生错误：");
  				}
  			});
  		}
  	};
  }

  //send verifycode
  //type:the action
  //phoneNumber:the receiver
  function sendVerifycode(type,phoneNumber){
    $.ajax({
        type: "GET",
        url: "../message/sendMessage.php",
        dataType:'json',
        data: {
          type: type,
          phoneNumber:phoneNumber
        },
        success: function(data){
          if(data.state == "sendVerifycode_success"){
            toastr.success("验证码已发送，请查收");
          }else if(data.state == "sendVerifycode_failed"){
            toastr.success("验证码发送出错，请重试获取");
            $('.Secondtext').text("1");
          }
        },
        error: function(){
          toastr.clear();
          toastr.error("验证码请求错误");
        }
      });
  }

  //change password
  var modal3 =  document.getElementById('myModal3Confirm');
  if(modal3){
  	modal3.onclick = function(){
  		if($('#newPassword').val() != $('#newPassword2').val()){
  			toastr.info("两次输入的新密码不一致");
  			$('#newPassword2').val("");
  		}else{
  			var password = document.getElementById('password');
  			$.ajax({
  				type: "GET",
  				url: "./functions.php",
  				dataType:'json',
  				data: {
  					type: "change_password",
  					password:password.value,
  					newPassword:$('#newPassword2').val()
  				},
  				success: function(data){
  					if(data.state == "change_password_success"){
  						$('#myModal3').modal('hide');
  						toastr.success("密码修改成功！");
  					}else if(data.state == "change_password_failed"){
  						toastr.error("密码修改失败，请重试！");
  					}else if(data.state == "password_incorrect"){
  						toastr.error("原密码输入错误");
  						password.value = "";
  					}
  				},
  				error: function(){
  					toastr.clear();
  					toastr.error("发生错误：");
  				}
  			});
  		}

  	}
  }

  //change address
  if($('#address')){
  	$('#address').keypress(function(){
  		$('#addressBtn').attr("disabled",false);
  	});
  	$('#address').change(function(){
  		$('#addressBtn').attr("disabled",false);
  	});

  	$('#addressBtn').click(function(){
  		if($('#address').val() == ""){
  			toastr.info("地址不能为空");
  		}else{
  			$.ajax({
  				type: "GET",
  				url: "./functions.php",
  				dataType:'json',
  				data: {
  					type: "change_address",
  					address: $('#address').val()
  				},
  				success: function(data){
  					if(data.state == "change_address_success"){
  						$('#myModal3').modal('hide');
  						toastr.success("地址修改成功！");
  					}else if(data.state == "change_address_failed"){
  						toastr.error("地址修改失败，请重试！");
  					}
  				},
  				error: function(){
  					toastr.clear();
  					toastr.error("发生错误：");
  				}
  			});
  		}
  	});
  }

})(jQuery);



/*logbook page*/


(function(){
  //check box animation
  $('#logTable > tr').click(function(event){
    if($('.label_check',this).hasClass('c_on')){
      $('.label_check',this).removeClass('c_on').addClass('c_off');
    }else{
      $('.label_check',this).removeClass('c_off').addClass('c_on');
    }
  });

  //fix event propagation
  $('.label_check > input').click(function(event){
    event.stopPropagation();
  });

  //check all and not check
  $('#checkall').click(function(){
    if($('#checkall > i').hasClass('fa-check')){
      $('#checkall > i').removeClass('fa-check').addClass('fa-remove');
      $('#checkall > span').html("全不选");
      $('.label_check > input').parent().removeClass('c_off').addClass('c_on');
    }else{
      $('#checkall > i').removeClass('fa-remove').addClass('fa-check');
      $('#checkall > span').html("全选");
      $('.label_check > input').parent().removeClass('c_on').addClass('c_off');
    }
  });

  //pass the logDate to the modal
  $('.btn.btn-danger.btn-sm').click(function(){
    $('#deletePasswordButton')[0].dataset.logdate = this.dataset.logdate;
    
  });

  //delete all log
  $('#deleteMore').click(function(){
    if($('.label_check').hasClass('c_on')){
      $(this).addClass('clicked');
      $('#deletePasswordConfirm').modal('show');
    }else{
      toastr.info("请勾选要删除的操作记录！");
    }
  });

  //modal confirm 
  $('#deletePasswordButton').click(function(){
    var password = $('#deletePasswordInput').val(); 
    if(password.length < 6){
      toastr.info("密码位数不正确，至少6位");
    }else{
      if($('#deleteMore').hasClass('clicked')){
        console.log("批量删除");
        var logDateArray = new Array();
        $('#deleteMore').removeClass('clicked');
        $('.label_check.c_on').parent().next().each(function(){
          logDateArray.push(this.innerHTML);
        });
        $.ajax({
          type: "GET",
          url: "./functions.php",
          dataType:'json',
          data: {
            type: "batch_delete_log",
            password: password,
            logDate: JSON.stringify(logDateArray)
          },
          success: function(data){
            if(data.state == "password_wrong"){
              toastr.error("密码错误，请重新输入");
              $('#deletePasswordInput').val("");
            }else if(data.state == "batch_delete_log_success"){
              toastr.success("删除成功");
              $('#deletePasswordConfirm').modal('hide');
              //delete the logdate in view
              $('#logTable').children().each(function(){
                //save this object reference using that
                var that = this;
                $(this).children('td.td_check').each(function(that){
                  return function(){
                    if($(this).children('label').hasClass('c_on')){
                      //set remove-flag for remove them
                      //setTimeout will lose this local context scope chain
                      $(that).addClass("remove-flag");
                      $(that).animate({"opacity":"0"},1000);
                      setTimeout("$('.remove-flag').remove();",1000);
                    }
                  }
                }(that));
              });
              //reset the password in modal input
              $('#deletePasswordInput').val("");
            }else if(data.state == "batch_delete_log_failed"){
              $('#deletePasswordConfirm').modal('hide');
              toastr.error("删除失败，请重试");
            }
          },
          error: function(){
            $('#deletePasswordConfirm').modal('hide');
            toastr.clear();
            toastr.error("发生错误：");
          }
        });
      }else{
        $.ajax({
          type: "GET",
          url: "./functions.php",
          dataType:'json',
          data: {
            type: "delete_single_log",
            password: password,
            logDate: this.dataset.logdate
          },
          success: function(data){
            if(data.state == "password_wrong"){
              toastr.error("密码错误，请重新输入");
              $('#deletePasswordInput').val("");
            }else if(data.state == "delete_single_log_success"){
              toastr.success("删除成功");
              $('#deletePasswordConfirm').modal('hide');
              //delete the logdate in view
              $('.btn.btn-danger.btn-sm').each(function(){
                if(this.dataset.logdate == $('#deletePasswordButton')[0].dataset.logdate){
                  window.one = $(this).parent().parent();
                  $(this).parent().parent().animate({"opacity":"0"},1000);
                  setTimeout("$(window.one).remove();window.one = null;",1000);
                  //reset the dateset logdate value of the dialog confirm button
                  $('#deletePasswordButton')[0].dataset.logdate = "";
                }
              });
              //reset the password in modal input
              $('#deletePasswordInput').val("");
            }else if(data.state == "delete_single_log_failed"){
              toastr.error("删除失败，请重试");
            }
          },
          error: function(){
            toastr.clear();
            toastr.error("发生错误：");
          }
        });
      }
    }
  });
})(jQuery);



