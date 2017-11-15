<?php 
/*
 * js 原生态AJAX 测试
 * Author: Lihongfa
 * Time: 2017-09-28 
 * 
 * */

/*
 * 接收文件并合并
 * 如果文件不存在，使用  move_uploaded_file 创建文件
 * 否则 使用 file_put_contents 追加到文件里面 
 * */
session_start();

error_reporting(E_ALL ^ E_DEPRECATED);

if(empty($_FILES)) die('upload failed');



//重命名判断 
$name = $_POST['name'] ;

if( $_POST['rename'] == 1 )
{
    if($_POST['name'] != $_SESSION['name'] ){
        
        $_SESSION['name'] = $_POST['name']  ;
        $_SESSION['part'] = '';
    }
    
    if( empty($_SESSION['part']) ) 
    {
         $name = $_POST['suffix'].rand(100000,900000).'_'.time().'.'.$_POST['suffix'] ;
         $_SESSION['part'] = $name ;
    }
    else
    {
        $name = $_SESSION['part'] ;        
    }
}


if( !file_exists('./upload/'.$name) )
{
    //var_dump('move_uploaded_file');
     move_uploaded_file ($_FILES['part']['tmp_name'],'./upload/'.$name);
}
else
{
   // var_dump('file_put_contents');
    file_put_contents('./upload/'.$name,file_get_contents($_FILES['part']['tmp_name']),FILE_APPEND);
}

echo $name;

//输出 接收的 POST 数据 
// var_dump($_FILES) ;

