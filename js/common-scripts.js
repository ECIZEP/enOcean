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
  inputNickname.onchange = enableUpdate;
  inputPersonal.onchange = enableUpdate;

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

  function ajaxUpdateProfile(username,nickname,personal){
    var xmlHttp = GetXmlHttpObject();
    var sql = "update account set nickname = '" + nickname + "',personal = '" + personal + "' where username = '" + username + "'";
    console.log(sql);
    if (xmlHttp == null)
    {
      toastr.error("Browser does not support HTTP Request");
      return;
    }
    var url="../htmls/functions.php?type=update_account&sql=" + sql;
    xmlHttp.onreadystatechange = function(){
      if(xmlHttp.readyState == 4){
        if(xmlHttp.status == 200){
          if(xmlHttp.responseText == "update_account_success"){
            $('.nickname').html(nickname);
            toastr.success("个人信息更新成功！");
            disableUpdate();
          }else if(xmlHttp.responseText == "update_account_failed"){
            toastr.error("更新失败，请重试！");
          }
        }else{
          toastr.error("请求出错，错误信息：" + xmlHttp.status);
        }
      }
    }
    xmlHttp.open("GET",url);
    xmlHttp.send(null);
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