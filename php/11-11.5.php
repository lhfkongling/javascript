<?php
header ('Content-type:text/html;charset=utf-8');

/**
 * php 责任链设计模式
 * 发布消息  
 * 根据权限级别  自己判断 ，如果自己可以处理就处理，处理不了 就 仍给上级处理
 * 最后一级 拥有最大权限 必须处理
 * 版主 -> 管理员 ->老板 -> 警察  根据自己的权限 处理事务
 * */

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


//版主处理类
class Board {
    private $power = 1;
    private $top = 'Admin';
    
    public function process($lev){
        if($this->power >= $lev){
            pr($lev.'级别问题,删除');
        }else{
            $top = new $this->top;
            $top->process($lev);
        }
    }
}


//管理员处理类
class Admin {
    private $power = 3;
    private $top = 'Boss';

    public function process($lev){
        if($this->power >= $lev){
            pr($lev.'级别问题,封号');
        }else{
            $top = new $this->top;
            $top->process($lev);
        }
    }
}

//老板处理类
class Boss {
    private $power = 4;
    private $top = 'Police';

    public function process($lev){
        if($this->power >= $lev){
            pr($lev.'级别问题,追查收集证据，警告处分');
        }else{
            $top = new $this->top;
            $top->process($lev);
        }
    }
}



//警察处理类
class Police {
    private $power = 5;
    private $top = 'Police';

    public function process($lev){
        pr($lev.'级别问题,抓起来');
//         if($this->power >= $lev){
//             pr('封号');
//         }else{
//             $top = new $this->top;
//             $top->process($lev);
//         }
    }
}

$handle = new Board();
$handle ->process(1);

$handle ->process(2);
$handle ->process(3);
$handle ->process(4);
$handle ->process(5);
