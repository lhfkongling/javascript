<?php
header('Content-type:text/html;charset=utf-8');

echo 'php 设计模式练习- 装饰模式：';

echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 装饰模式     低耦合  不修改以前写的代码    对之前的信息 做 装饰性添加优化处理<br/>
 * 5个步骤<br/>

 *  1.  创建基础类 ，对信息做比本处理 <br/>
 *  2   创建一个装饰类继承基础类，并传入（基础类 或者 继承基础类的）对像 <br/>
 *  3   把传进来的类对象赋予给本类的一个属性，方便接下来的方法调用传进来的对象属性信息 <br/>
 *   public function __construct(BaseArt \$art){<br/>
 *      \$this->art = \$art;<br/>
 *   }<br/>
 *  4   用同一方法函数处理 需要装饰的 信息 <br/>
 *    public function decoraty(){<br/>
 *     return  \$this->content = \$this->art -> decoraty(). ' <br /> 小编添加了简介'; <br/>
 *   }<br/>

 *  5   装饰类 为 兄弟并列关系 ，不分先后，使用那个个优先都可以 <br/>
 *  // 实例化<br/>
 *   \$art = new SeoArt( new BianArt( new BaseArt('双十一疯狂请购！')) );<br/>
 *  pr(\$art->decoraty()) ;<br/>
 * */<br/><br/>

EOT;


function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}
//基本类
class BaseArt {
    
    public $content =NULL;
    
    public function __construct($content){
        $this ->content = $content ;
    }
    
    public function decoraty(){
        return $this->content;
    }
}

class BianArt extends BaseArt{
    public function __construct(BaseArt $art){
        $this->art = $art;
    }
    
    public function decoraty(){
      return  $this->content = $this->art -> decoraty(). ' <br /> 小编添加了简介'; 
    }
}

class SeoArt extends BaseArt{
    public function __construct(BaseArt $art){
        $this ->art = $art;
        
    }
    public function decoraty(){
        return $this->content = $this->art ->decoraty(). '<br /> SEO 添加了优化' ;
    }
    
}

// 实例化
$art = new SeoArt( new BianArt( new BaseArt('双十一疯狂请购！')) );

pr($art->decoraty()) ;

