<?php 
/*
 * js 原生态AJAX 测试
 * Author: Lihongfa
 * Time: 2017-09-28 
 * 
 * */

if(empty($_FILES)) die('upload failed');

$name = $_FILES['file']['name'] ;
if($_POST['rename'] = 1){
    $name = $_POST['suffix'].rand(100000,900000).'_'.time().'.'.$_POST['suffix'] ; 
    
}

move_uploaded_file ($_FILES['file']['tmp_name'],'./upload/'.$name);
//输出 接收的 POST 数据 
var_dump($name) ;

