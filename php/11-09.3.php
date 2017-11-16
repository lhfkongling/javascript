<?php
header('Content-type:text/html;charset=utf-8');

/**
 * 魔术方法 
 * 
 * 
 * */

class Human {
    private $money = '3000元' ;
    
    protected $age = '22岁' ;
    
    public  $name = 'lili' ;
    
    //构造函数 类被 new 实例 的时候调用 
    public function __construct(){
        
    }
    
    //实例调用没有被允许调用的属性方法时 调用 返回提示  
    public function __get($action){
        echo '您调用的'.$action. '为 私有/被保护的属性 方法 ，禁止访问  <br />';
    }
    
    //为了避免当调用的方法不存在时产生错误，而意外的导致程序中止
    function __call($fn,$arguments){
        echo '你所调用的属性方法:'.$fn. ' (参数：';
        print_r($arguments) ;
        echo ')不存在!  <br />' ;
    }
    
    /* __set 用法 
     * 当为无权操作的属性赋值时
     * 或者不存在的属性赋值时
     * 此方法自动调用
     * 传入两个值 分别是 属性 与 属性值 
     * */
    function __set($a,$b){
        
    }
    
    //外面判断是否有改类是否存在的时候 ，如果没有该属相的时候自动调用 
    
    public function __isset($act){
        echo '你想判断我的属性'.$act.'存不存在 <br />';
    }
    
    
    //类对象被克隆的时候 自动调用 
    public function __clone(){
        echo ' 我被克隆了 <br />' ;
    }
    
    //析构函数  类对象 等于  false  ，unset ，等销毁完成 的时候调用 
    function  __destruct(){
        echo '我被销毁掉，内存中没有我的影子了 <br />' ;
    }
}

$lisi = new Human();

// echo $lisi -> name;

if(isset($lisi->name)){
  echo  '对象以存在  <br />' ;
}

if(isset($lisi->leg)){
    echo  '对象以存在  <br />' ;
}

echo $lisi -> age;

echo $lisi -> money;

$lisi  ->eat('菠萝') ;

echo '<hr />' ;




