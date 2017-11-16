<?php

header('Content-type:text/html;charset=utf-8');

/**
 * 静态方法中 没有 $this 
 * 用的是 self ;
 * 
 */

class A {
    static $name = '李四' ;
    
    static function  foo(){
        
//         echo self::$name ;
        if(isset($this)){
            var_dump(get_class($this)) ;
        }else{
            echo '$this 不存在 ' ;
        }
    } 
    
    public  function getName() {
        if(isset($this)){
            var_dump(get_class($this)) ;
        }else{
            echo '$this 不存在 ' ;
        }
    }
    
}

class B {
    
    public $name = '王五' ;
    
    public function getname(){
        $a =  new A() ;
        $a  -> getName() ;

    }
    
}

$b = new B();

$b->getname() ;
