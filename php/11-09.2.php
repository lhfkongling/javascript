<?php
header('Content-type:text/html;charset=utf-8');

/*
 * 静态属性 存在于类中 ，被所有对象所共享  在内存中 只有一个 ，
 * 普通属性 存在于对象中，new 多少个不同的类对象 ，在内存中就有多少个 不同属性 
 * 
 * 普通方法 ，存放于类内的，只有一份
 * 静态方法 ，也是存放在类内的，只有一份
 * 
 * 区别在于：普通方法需要对象去调用，需要绑定 $this
 * 即，普通方法，必须要有对象，用对象调动
 * 
 * 而静态方法，不属于那个对象，而是属于类，因而不需要去绑定$this 
 * 即。静态方法 ，通过类名就可以调用
 * 
 * 静态方法 不能调用 非 静态方法
 * 静态方法方式： 可以访问静态方法 ， 不能访问动态方法 （在方法没有this的情况下可以，但逻辑上行不通，不支持使用这种方式） 
 * 动态方法方式 ： 可以访问动态方法， 也 可以访问静态方法 
 * 
 */

error_reporting(E_ALL|E_STRICT) ;//严格报错模式

echo '静态属性 <br />';

class Human {
    static public function cry(){
        echo '555 <br />' ;
    }
    
    public function ect (){
        echo '吃饭';
    }
    
}
Human::cry();

$xm = new Human();
$xm ->cry();
$xm->ect();