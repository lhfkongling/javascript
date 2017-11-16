<?php

header('Content-type:text/html;charset=utf-8');
// header('Content-type:text/html;charset=utf-8');
/**
 * 多态练习
 * 如果按照PHP本身特点（ 弱类型） 不检测类型
 * 本身就是多态的，甚至变态。
 * 
 *  但是PHP5.3以后，引入了对对象类型的参数检测，
 *  注意 ： 只能检测对象所属的类
 *  
 *  其实，这对于PHP来说，限制了其灵活性 达到了JAVA中的 多态效果 
 *  
 *  反思多态：
 *  其实就是
 *  只抽象的声明父类，具体的工作由子类来完成
 *  这样。不同的子类对象完成，有不同的特点。
 * */

//定义抽象父类
class Glass {
    public function display(){
        
    }
}

class Light{
    //对象所属类的限制 ，使用  继承父类（接口）
    public  function ons(Glass $p){
        $p->display();
    }
    
}

class  GreenGlass extends Glass{
    public  function display(){
        echo '绿光照耀 <br />';
    }
}

class RedGlass extends Glass {
    public function display(){
        echo '红光照耀 <br />' ;
    }
}

class BlueGlass extends Glass{
    public function display(){
        echo '蓝光照耀 <br />' ;
    }
}

class Pig {
    public function display(){
        echo '八戒下凡，哼哼落地 <br />' ;
    }
}

$light = new Light();

$red = new RedGlass();
$green = new  GreenGlass();
$blue = new BlueGlass();



$light ->ons($red) ;
$light->ons($green) ;
$light->ons($blue);

//Pig() 没有继承 Glass , 所以不能 使用 $light -> ons ($pig) 
// $pig = new Pig();
// $light->ons($pig) ;
