<?php
header('Content-type:text/html;charset=utf-8');

echo 'php 设计模式练习- 策略模式：';

echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 策略模式 工厂模式的一种变形（两者及其类似）   低耦合  不修改以前写的代码 <br/>
 * 6个步骤<br/>

 *  1.  声明驱动接口<br/>
 *  2   添加建立详细驱动类继承 驱动接口<br/>
 *  3   建立虚拟类，在构造方法中拼接字符串实现 实体工厂类接口<br/>
 *  4   在虚拟类中 根据实现的新类 ，实现所有需要的方法 <br/>
 *  4.1     在虚拟类中 ，要做好 如果驱动类不存在的异常处理，判断该类是否存在 <br/>
 *  4.2     在虚拟类对外方法中，添加上if条件 判断 驱动类是否存在  <br/>
 *  5   客户端根据 虚拟类对外开放的 工厂接口调用驱动方法<br/>
 *  6   如果添加新的类驱动方法，直接创建相应的驱动类 继承驱动接口就可以了  <br/>
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


class PC {

    protected $_pay = null ;
    public function __construct($name){
        $class =  $name.'Pay' ;
        if(class_exists($class)){
            $this ->_pay = new $class();
        }else{
            pr('对不起，'.$name.'驱动还没有安装');
        }
    }
    
    public function setPay(){
        if( $this -> _pay) $this -> _pay ->pay();
    }
    
    public function responsePay(){
        if( $this -> _pay) $this ->_pay -> responsePay();
    }
}

/***********************************************/
//客户端  对外开放了  Factory 接口    的 setPay 方法

$pc = new PC('Wetach');
$pc ->setPay();
$pc ->responsePay();
