<?php
header('Content-type:text/html;charset=utf-8');

echo 'php 设计模式练习- 适配器模式：';

echo <<<EOT
<br/><br/><br/>
/**<br/>
 * 适配器模式  相同的信息 原来按照一定的格式输出，但是后台因业务发展需要 ，而需要到另外一种格式输出，但要求原来的模式不发生改变<br/>
 * 3个步骤<br/>    
 *  <br/>
 *  1.  创建格式输出类 ，对信息做比本处理 <br/>
 *  2   创建新的一个适配器类继承原始类， <br/>
 *  3   使用相同的方法对数据柑橘要求进行转换，并返回 <br/>
 *   <br/>
 * */<br/><br/>

EOT;


class Weather {
    public static  function show(){
        $arr = ['tmp'=>'16℃','wind'=>'7级','sun'=>'sunny'];
        
        return serialize($arr) ;
    }
}



class AdapterWeather extends Weather{
    public static function show(){
        $tq = unserialize( parent::show());
        $tq = json_encode($tq);
        return  $tq ;
    }
}



function  pr($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}

pr(unserialize(Weather::show() ) );

pr(json_decode( AdapterWeather::show()) );