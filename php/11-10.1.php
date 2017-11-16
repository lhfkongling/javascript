<?php
header('Content-type:text/html;charset=utf-8');

echo 'php 设计模式练习- 工厂模式：';

echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 工厂模式   低耦合  不修改以前写的代码 <br/>
 * 6个步骤<br/>

 *  1.  声明驱动接口<br/>
 *  2   声明工厂接口 （对外）<br/>
 *  3   建立详细驱动类继承 驱动接口<br/>
 *  4   建立详细工厂类集成工厂接口 <br/>
 *  5   客户端根据 对外开放的 工厂接口调用驱动方法<br/>
 *  6   如果新添加新的方法，直接创建相应的驱动类和工厂类继承驱动接口和工厂接口就可以了  <br/>
 * */<br/><br/>

EOT;


function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}

//声明支驱动付接口
interface pay{
    //设置支付参数
    public function setParam();
    //发起支付
    public function  pay();
    //支付返回相应
    public function responsePay();
}

//声明工厂接口
interface Factory {
    public function setPay();
}
/***********************************************/

//银行支付驱动 
class BankPay implements pay{
    public function setParam(){
        pr('设置银行支付参数');
    }
    public function pay(){
        pr('发起银行支付');
    }
    public function responsePay(){
        pr('响应银行支付') ;
    }
}
/***********************************************/
//银行支付工厂
class BankFactory implements Factory {
    
    static private $obj = NULL ;
    
    public function __construct (){
      self::$obj = new BankPay();
    }
    
    public function setPay(){
        self::$obj->pay();
    }
    
}


// class PC {
// //     public function __construct($db_class_name){
// //         $db_class_name = strtolower($db_class_name);
        
// //         return new $db_class_name;
// //     }
    
//     public function factory($db_class_name){
// //         $db_class_name = strtolower($db_class_name);
        
//         return new $db_class_name;
//     }
// }

/***********************************************/
//客户端  对外开放了  Factory 接口    的 setPay 方法

$pay = new BankFactory();
$r = $pay -> setPay();

// pr($r);

// $pay ->setPay();

// $pay ->responce();
