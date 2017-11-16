<?php 
/**
 * 设计模式：适配器
 * 2017-07-26
 * Lihongfa
 * 适配器原理：
 * 正常情况走流程逻辑信息一种格式输出
 * 一段时间后需求同一种逻辑信息需要换一种格式输出，但还需要保留原来的输出格式
 * 这种时候创建新类继承逻辑类 后  执行新输出模式 
 * */

//初始 错误输出
class errorObject
{
    private $_error ;
    
    public function __construct($error)
    {
        $this->_error = $error ;
    }
    
    public function getError()
    {
        return $this->_error;
    }
}
//日志输出
class logToConsole{
    
    private $_errorObject ;
    
    public function __construct($errorObject)
    {
        $this->_errorObject = $errorObject ;
    }
    
    public function write()
    {
        file_put_contents('log/log.txt' ,  $this->_errorObject -> getError() , FILE_APPEND) ;
        
    }
}

//调用以上模式输出 404 错误页面

$error = new errorObject("404:Not Found \t\n\n");

//把刚刚创建的错误信息输出文件

$log = new logToConsole($error);

$log->write();


//创建类 把错误日志写入 CSV中

class logToCSV
{
    const CSV_LOCATION = 'log/log.csv';
    
    private $_errorObject ;
    
    public function __construct($errorObject)
    {
        $this->_errorObject  = $errorObject;
    }
    
    public function write()
    {
        $line = $this->_errorObject -> getErrorNumber();
        
        $line .= ',';
        
        $line .= $this->_errorObject->getErrorText();
        
        $line .= "\n";
        
        file_put_contents(self::CSV_LOCATION , $line , FILE_APPEND) ;
        
    }
}

//创建一个是适配器 继承 原来的 错误 类 

class logToCSVAdapter extends errorObject
{
    private $_errorNumber , $_errorText ;
    
    public function __construct($error)
    {
        parent::__construct($error) ;
        
        $parts = explode(':',$this->getError()) ;
        
        $this->_errorNumber = $parts[0];
        
        $this->_errorText = $parts[1];
    }
    
    public function getErrorNumber()
    {
        return $this->_errorNumber ;
    }
    
    public function getErrorText()
    {
        return $this->_errorText ;
    }
}


//测试 适配器 

$error = new logToCSVAdapter('404:Not Found') ;

$log = new logToCSV($error);

$log->write() ;


die('适配器模式');
?>