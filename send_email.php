<?php
    function send_register_email($subject,$body,$username,$email){
        require_once("assets/phpmail/class.phpmailer.php");
        require_once("assets/phpmail/class.smtp.php"); 
        $mail  = new PHPMailer(); 
        $mail->CharSet    ="UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
        $mail->IsSMTP();                            // 设定使用SMTP服务
        $mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
        $mail->SMTPKeepAlive=true;
        $mail->SMTPSecure = "ssl";                  // SMTP 安全协议
        $mail->Host       = "smtp.qq.com";       // SMTP 服务器
        $mail->Port       = 465;                    // SMTP服务器的端口号
        $mail->Username   = "839435418@qq.com";  // SMTP服务器用户名
        $mail->Password   = "ikzfldeshyltbeaa";        // SMTP服务器密码
        $mail->SetFrom('839435418@qq.com', 'WGCX物联官方安全中心');    // 设置发件人地址和名称
        $mail->AddReplyTo("邮件回复人地址","邮件回复人名称"); 
                                                    // 设置邮件回复人地址和名称
        $mail->Subject    = $subject;          // 设置邮件标题
        $mail->AltBody    = $body; 
                                                    // 可选项，向下兼容考虑
        $mail->MsgHTML($body);                         // 设置邮件内容
        $mail->AddAddress($email, $username);
        //$mail->AddAttachment("images/phpmailer.gif"); // 附件 
        return $mail->Send();
    }

?>