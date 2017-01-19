<?php
    switch($_GET["m"]) {
        case    "register_success"  :
            $msg = "恭喜，帐号注册成功。<br />现在您可以使用您的用户名和密码登陆本系统了。<br />";
            $href = "<a href='index.html'>返回</a>";
            break;
        case    "register_name_exist"   :
            $msg = "用户名已存在。<br />";
            $href = "<a href='index.html'>返回</a>";
            break;
        case    "register_mail_exist"   :
            $msg = "该邮箱已注册。<br />";
            $href = "<a href='index.html'>返回</a>";
            break;
        case    "register_name_mail_exist"  :
            $msg = "用户名已存在，且该邮箱已注册。<br />";
            $href = "<a href='index.html'>返回</a>";
            break;
        case    "update_success"    :
            $msg = "帐号信息更新成功。<br />";
            $href = "<a href='account.php'>返回</a>";
            break;
        case    "upload_success"    :
            $msg = "照片上传成功。<br />";
            $href = "<a href='account.php'>返回</a>";
            break;
        case    "del_success"   :
            $msg = "帐号信息删除成功，请返回。<br />";
            $href = "<a href='admin.php'>返回</a>";
            break;
        case    "del_facility_success"  :
            $msg = "设备删除成功，请返回。<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        case    "facility_name_exist"   :
            $msg = "设备名已存在，请返回重填。<br />";
            $href = "<a href='add_facility.php'>返回</a>";
            break;
        case    "add_facility_success"  :
            $msg = "添加设备成功!<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        case    "update_facility_success"  :
            $msg = "设备信息更新成功!<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        
        
        case    "del_fac_property_success"  :
            $msg = "设备属性删除成功，请返回。<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        case    "fac_property_name_exist"   :
            $msg = "属性名已存在，请返回重填。<br />";
            $href = "<a href='add_facility.php'>返回</a>";
            break;
        case    "add_fac_property_success"  :
            $msg = "添加设备属性成功!<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        case    "update_fac_property_success"  :
            $msg = "设备属性信息更新成功!<br />";
            $href = "<a href='facility.php'>返回</a>";
            break;
        
        case    "mail_success"  :
            $msg = "修改密码确认邮件已经发送到您的信箱，请注意查收。<br />";
            $href = "<a href='index.html'>返回</a>";
            break;
        case    "login_error"   :
            $msg = "对不起，用户名或密码填写错误。<br />请返回重新填写。<br />";
            $href = "<a href='login.html'>返回</a>";
            break;
        case    "verification_lack" :
            $msg = "对不起，验证码不能为空。<br />请返回重新填写。<br />";
            $href = "<a href='login.html'>返回</a>";
            break;
        case    "verification_error"    :
            $msg = "对不起，验证码错误。<br />请返回重新填写。<br />";
            $href = "<a href='login.html'>返回</a>";
            break;
        case    "activated_sendmail_success"  :
            $msg = "邮件已发送，请查收并激活账号。<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break;
        case    "activated_sendmail_failed"  :
            $msg = "激活邮件发送失败，请联系程序员<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break;
        case    "actived_finished"  :
            $msg = "邮箱激活成功，可以正常使用了<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break; 
        case    "actived_failed"  :
            $msg = "邮箱激活失败，请重试<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break; 
        case    "un_activated":
            $msg = "账户未激活，请激活账号<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break;
        case    "activated_exptime":
            $msg = "激活有效期已过，请重新注册账号<br />";
            $href = "<a href = 'index.html'>返回</a>";
            break;
    }
?>
 <table id="content">
  <tr>
   <td id="main">
<div class="breadcrumb"><a href="./">主页</a></div><h2>消息</h2>
<!-- begin content -->

<?php echo $msg; ?>
<?php echo $href; ?>

<!-- end content -->
   </td>
  </tr>
 </table>
 </div>
 </body>
</html>

