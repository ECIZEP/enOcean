<?php
    include "TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 

    function sendVerifycode($action,$phoneNumber){
        $appkey = "23614142";
        $secret = "b31f1b850e9d85ea7fe31f587ff221d2";
        $verifycode = (String)rand(111111,999999);
        $param = array('action' => $action,'verifycode'=>$verifycode);
        if(!isset($_SESSION)){
          session_start();
        }
        $_SESSION["verifycode"] = $verifycode;
        $c = new TopClient;
        $c ->appkey = $appkey;
        $c ->secretKey = $secret;
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req ->setSmsType("normal");
        $req ->setSmsFreeSignName("WGCX物联");
        $req ->setSmsParam(json_encode($param));
        $req ->setRecNum($phoneNumber);
        $req ->setSmsTemplateCode("SMS_44190061");
        $resp = $c ->execute($req);
        if($resp->result->success){
            $_SESSION["verifycodeResult"] = "success";
            echo '{"state":"sendVerifycode_success"}';
        }else{
            echo '{"state":"sendVerifycode_failed"}';
        }
    }


    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET["type"]) && $_GET["type"] == "sendVerifycode"){
            sendVerifycode("注册账号操作",$_GET["phoneNumber"]);
        }elseif(isset($_GET["type"]) && $_GET["type"] == "change_phoneNumber"){
            sendVerifycode("修改绑定手机号码操作",$_GET["phoneNumber"]);
        }elseif(isset($_GET["type"]) && $_GET["type"] == "delete_device") {
            sendVerifycode("删除设备操作",$_GET["phoneNumber"]);
        }
    }
    
?>