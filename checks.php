<?php
/*$image_width=70;                      //设置图像宽度
$image_height=18;                     //设置图像高度
srand(microtime()*100000);            //设置随机数的种子
for($i=0;$i<4;$i++){                  //循环输出一个4位的随机数
   $new_number.=dechex(rand(0,15));
}
session_start();
$_SESSION["check_checks"]=$new_number;    //将获取的随机数验证码写入到SESSION变量中     

$num_image=imagecreate($image_width,$image_height);  //创建一个画布
imagecolorallocate($num_image,255,255,255);          //设置画布的颜色
for($i=0;$i<strlen($_SESSION["check_checks"]);$i++){  //循环读取SESSION变量中的验证码
   $font=mt_rand(3,5);                              //设置随机的字体
   $x=mt_rand(1,8)+$image_width*$i/4;               //设置随机字符所在位置的X坐标
   $y=mt_rand(1,$image_height/4);                   //设置随机字符所在位置的Y坐标
   $color=imagecolorallocate($num_image,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));       //设置字符的颜色
   imagestring($num_image,$font,$x,$y,$_SESSION["check_checks"][$i],$color);                   //水平输出字符
}
ob_clean();
header ('Content-type: image/png');
imagepng($num_image);               //生成PNG格式的图像
imagedestroy($num_image);           //释放图像资源*/ 

//验证码类
class ValidateCode {
    private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';    //随机因子
    private $code;                            //验证码
    private $codelen = 4;                    //验证码长度
    private $width = 110;                    //宽度
    private $height = 40;                    //高度
    private $img;                                //图形资源句柄
    private $font;                                //指定的字体
    private $fontsize = 20;                //指定字体大小
    private $fontcolor;                        //指定字体颜色

    //构造方法初始化
    public function __construct() {
        $this->font = ROOT_PATH."/fonts/elephant.ttf";
    }

    //生成随机码
    private function createCode() {
        $_len = strlen($this->charset)-1;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->code .= $this->charset[mt_rand(0,$_len)];
        }
    }

    //生成背景
    private function createBg() {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
    }

    //生成文字
    private function createFont() {    
        $_x = $this->width / $this->codelen;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
        }
    }

    //生成线条、雪花
    private function createLine() {
        for ($i=0;$i<6;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
        }
    }

    //输出
    private function outPut() {
        ob_clean();
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    //对外生成
    public function doimg() {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }

    //获取验证码
    public function getCode() {
        return strtolower($this->code);
    }
}


define('ROOT_PATH', dirname(__FILE__));
$_vc = new ValidateCode(); //实例化一个对象
$_vc->doimg();
if(!isset($_SESSION)){
  session_start();
}
$_SESSION['check_checks'] = $_vc->getCode();//验证码保存到SESSION中

?>