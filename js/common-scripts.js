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
$('i.fa-bars').click(function(){
  if($('div.content').css("marginLeft") == "0px"){
    $('div.content').animate({marginLeft:'210px'},400);
    $('div.sidebar').animate({marginLeft:'0px'},400);
  }else{
    $('div.content').animate({marginLeft:'0px'},400);
    $('div.sidebar').animate({marginLeft:'-210px'},400);
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

/*$('ul#sidebar').on('click','li',function(e){
      var ul = this.getElementsByTagName('ul')[0];

      if(ul){
        if($(ul).css("display") == 'block'){
          $(ul).animate({height:'0px'},400,function(){
            $(ul).css("display","none");
            $(ul).css("height","");
          });
        }else{
          myheight = $(ul).css('height');
          $(ul).css("display","block");

          $(ul).animate({height: myheight + 'px'},400,function(){
            $(ul).css("display","block");
          });
          
        }
      }
      
    });
*/
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
  console.log(this);
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
  inputNickname.onchange = enableUpdate;
  inputPersonal.onchange = enableUpdate;

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
    var url="../htmls/functions.php";
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
  document.getElementById('myModal1Confirm').onclick = function(){
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
        var url = "../htmls/functions.php?type=change_email&email=" + inputValue;
        xmlHttp.onreadystatechange = function(){
          if(xmlHttp.readyState == 4){
            if(xmlHttp.status == 200){
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
})();