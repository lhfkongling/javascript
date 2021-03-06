<?php
	
	
/**
 * FUNCTION pr
 * 打印输出参数
 * @param $name 
 */
function pr($name=null){
	echo '<pre>';
	print_r($name);
	echo '</pre>';
}
/**
 * FUNCTION load_config
 * 加载配置文件
 * @param $file 文件路径
 * */
function load_config($file=null,$parse=''){
    
	$ext = pathinfo($file,PATHINFO_EXTENSION);
	
	switch($ext){
		case 'php':
			return include $file;
		case 'ini':
			return parse_ini_file($file);
		case 'yaml':
			return yaml_parse_file($file);
		case 'json':
			return json_decode(file_get_contents($file));
		case 'xml':
			return (array)simplexml_load_file($file);
		default:
		if(function_exists($parse)){
			return $parse($file);
		} else{
			pr('错误格式:'.$ext);
		}
	}
}
/**
 * FUNCTION C
 * 配置参数
 * 
 * */
function C($key=null,$val=null,$default=null){
	static $_config = array();	
	if(empty($key)){
		return  $_config ;
	}
	if(is_string($key)){
		if(!strpos($key,'.')){
			$key=strtoupper($key);
			if(is_null($val))
				return isset($_config[$key])?$_config[$key]:$default;
			$_config[$key]=$val;
			return false;
		}
		$key = explode('.',$key);
		$key[0]=strtoupper($key[0]);
		if(is_null($val))
			return isset($_config[$key[0]][$name[1]])?$_config[$key[0][$key[1]]]:$default;
		$_config[$key[0]][$key[1]]=$val;
		return null; 
	}
	if(is_array($key)){
		$_config = array_merge($_config,array_change_key_case($key,CASE_UPPER));
		return null;
	}
	return null;
}

/**
 * 注册自动加载函数
 * 
 * */
$autoload_func = function($class){
    $class = str_replace("\\" , "/" , $class);
    $file_name = PATH ."/Library/" .$class . ".class.php" ;
    include $file_name;
}

?>