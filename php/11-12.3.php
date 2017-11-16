<?php
header('Content-type:text/html;charset=utf-8');

echo 'php 设计模式练习- 桥接模式：';

echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 桥接模式  给不同的对象发送信息 如 站内信 ， 手机短信，邮箱 等 <br/>
 * 信息级别分为 普通 ，紧急 ，特级 三种紧急程度
 * 对这些信息进行组合发送
 * 3个步骤<br/>    
 *  抽象类，抽象方法的使用
 *   <br/>
 * */<br/><br/>

EOT;



function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}

abstract class Info {
    function __construct($send){
        $this ->send = $send ;
    }

    abstract public function smg( $content );

    function send ($to,$content){
        
        $content = $this->smg($content) ;
       return $this ->send->send($to,$content);
    }

}



class PtInfo extends Info{
    public function smg($content){
        return '普通：'.$content;
    }
}
class JjInfo extends Info{
    public function smg($content){
        return '紧急：'.$content;
    }
}
class TjInfo extends Info{
    public function smg($content){
        return '特急：'.$content;
    }
}

class Zn {
    public function send($to,$content){
        return '站内给：'.$to .'发送：'.$content;
    }
}
class Sms {
    public function send($to,$content){
        return '手机短信给：'.$to .'发送：'.$content;
    }
}
class Email {
    public function send($to,$content){
        return '邮件给：'.$to .'发送：'.$content;
    }
}



//********** 客户端 **********//


 $info =  new PtInfo( new Zn());
 echo $info ->send('小李','回家吃饭');
 
 
 
 