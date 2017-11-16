<?php

header('Content-type:text/html;charset=utf-8');


echo 'php 设计模式练习- 单利模式：';

function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}
echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 单例模式 <br/>
 * 6个步骤<br/>
    
 *  1.  创建一个类<br/>
 *  2   __construct 设置  protected 权限 封闭  防止外部  new 对象<br/> 
 *  3   设置conn 静态方法  在内部 实例化对象 <br/>
 *  4.1 设置变量  让变量记录 对象是否已经实例化<br/>
 *  4.2 判断是否已经实例化，如果实例化，直接返回本身，否则  new 一个实例化<br/> 
 *  5   方法前加  final 禁止继承 初始化<br/>
 *  6   方法前加  final 禁止克隆  <br/>
 * */<br/><br/>

EOT;

class MysqlDb {
    
    //4.1 设置变量  让变量记录 对象是否已经实例化
    static private $link = null;
   
    //3  设置conn 静态方法  在内部 实例化对象 
    static public function conn(){
       //4.2 判断是否已经实例化，如果实例化，直接返回本身，否则  new 一个实例化 
      if(self::$link == null){
          self::$link  = new self ;         
      } 
      return self::$link ;
     
    }
    //2 __construct 设置  protected 权限 封闭  防止外部  new 对象
    //5 方法前加  final 禁止继承 初始化
     final protected function __construct(){    
    }
    //6  方法前加  final 禁止克隆   设置  protected 权限 
    final protected  function __clone(){}
      
}

$db1 = MysqlDb::conn();

$db2 = MysqlDb::conn();

if($db1 === $db2){
    pr('是一个对象') ;
}
else {
    pr('不是一个对象') ;
}

/*

//测试继承  
class db extends MysqlDb{
    public function __construct(){
        
    }
}

$db1 =  new db();

$db2 = new db();

if($db1 === $db2){
    pr('是一个对象') ;
}else{
    pr('不是一个对象') ;
}
*/


/*
 //测试克隆 
$db2 = clone $db1 ;

if($db1 === $db2){
    pr('是一个对象') ;
}else{
    pr('不是一个对象') ;
}

*/


