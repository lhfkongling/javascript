<?php
/**
 * 
 * 
 * */

define('PATH',__DIR__);


include(PATH.'/Common/function.php');
C(load_config(PATH.'/Common/config.php'));

spl_autoload_register($autoload_func);

pr(C()) ;

Db::conn();

?>