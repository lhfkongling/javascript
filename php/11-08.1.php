<?php

header('Content-type:text/html;charset=utf-8');

class Clock{
	public function __construct(){
	    echo '出生了';
		
	}
	
	public $name = '张三' ;
	
	Public function getName(){
	    echo $this->name ,'<br/>';
	}
	public function __destruct(){
	    echo '逆天不了 ' ;
	}
	
}

$clock = new Clock();
$a = $b =  $c = $clock ;
$a -> getName();
$b -> getName();
$c -> getName();
// $clock ->name = '王五';

$a -> getName();
$b -> getName();
$clock -> getName();

unset($clock) ;
$c = true ;
$a -> getName();
$b -> getName();
// $clock -> getName();
echo '<hr />' ;
unset($a) ;
echo '<hr />' ;
unset($b) ;
echo '<hr />' ;



echo '<hr />' ;

?>