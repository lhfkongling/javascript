<?php
/**
 * php 观察者模式
 * php5 中提供观察者 observer 接口 和被观察者 subject 接口
 * 被观察者 实现接口 SplSubject 三个方法
 *  attach :添加观察者 ， 限制 SplObserver 接口 观察者对象作为参数 传参
 *  detach ：删除观察者， 限制 SplObserver 接口观察者对象作为参数 传参
 *  notify ：通知调用观察者update 方法
 *  
 *  保存记录   观察者对象 为    new SplObjectStorage()  如下 ：
 *  $this->_observers = new SplObjectStorage();
 *  
 * 观察者 实现接口 SplObserver 接口 一个方法
 *  update ：通知修改的执行方法   限制 SplSubject 接口 被观察者 对象作为参数 传参
 * */

header ('Content-type:text/html;charset=utf-8');

$msg = <<<EOT
/**<br />
 * php 观察者模式<br />
 * php5 中提供观察者 observer 接口 和被观察者 subject 接口<br />
 * 被观察者 实现接口 SplSubject 三个方法<br />
 *  attach :添加观察者 ， 限制 SplObserver 接口 观察者对象作为参数 传参<br />
 *  detach ：删除观察者， 限制 SplObserver 接口观察者对象作为参数 传参<br />
 *  notify ：通知调用观察者update 方法<br />
 *  <br />
 *  保存记录   观察者对象 为    new SplObjectStorage()  如下 ：<br />
 *  \$this->_observers = new SplObjectStorage();<br />
 *   <br />
 * 观察者 实现接口 SplObserver 接口 一个方法<br />
 *  update ：通知修改的执行方法   限制 SplSubject 接口 被观察者 对象作为参数 传参<br />
 * */<br />
<br /><br />

EOT;

pr($msg) ;

function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}
//被观察者 继承  
class User implements SplSubject  {
    
    public  $_loginNum;
    
    public  $_hobby ;
    
    private  $_observers = NULL;
    
    public function __construct($hobby){
        
        $this->_loginNum = rand(1, 10);
        
        $this->_hobby = $hobby ;
        
        $this->_observers = new SplObjectStorage();
    }
    
    public function login(){
        //session 登录处理
        $this ->notify();
    }
    
    public function attach(SplObserver $observer) {
        $this->_observers->attach($observer);
    }
    //删除观察者
    public function detach(SplObserver $observer){
        $this->_observers->detach($observer);
    }
    //通知观察者执行
    public function notify(){
        
        foreach ($this->_observers as $observer){
            $observer ->update($this);
        }
//         $this->observers->rewind();
    }
    
}


//登录安全提示  观察者 
class Secrity implements SplObserver  {
    
    public function update(SplSubject $subject){
        if($subject->_loginNum <4){
            pr('这是第'.$subject->_loginNum.'次安全登录');
        }else{
            pr('这是第'.$subject->_loginNum.'次登录，危险');
        }
    }
    
}

//广告商务 观察者 
class Ad implements SplObserver {
    public function update(SplSubject $subject){
        if($subject ->_hobby == 'sports'){
            pr('打篮球去');
        }else{
            pr('网吧走起');
        }
    }
}

$user = new User('study') ;
$user->attach(new Ad()) ;
$user->attach(new Secrity());


$user ->login();
