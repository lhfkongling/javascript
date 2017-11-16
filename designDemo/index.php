<?php

/**
 * 
 * 
 * */

define('PATH',__DIR__);

include(PATH.'/Common/function.php');

C(load_config(PATH.'/Common/config.php'));

spl_autoload_register($autoload_func);


$db =  Db::conn();

// pr( $db ->table('users') -> getSql('delete')  ) ;

// pr(C()) ;

// pr( $db ->table('users')->limit('5')->select() ) ;

// pr($db ->getSql('delete') );

// $res = $db->row('select name,sex from users ');
//   var_dump($res);


?>