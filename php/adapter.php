<?php 
/**
 * ���ģʽ��������
 * 2017-07-26
 * Lihongfa
 * ������ԭ��
 * ��������������߼���Ϣһ�ָ�ʽ���
 * һ��ʱ�������ͬһ���߼���Ϣ��Ҫ��һ�ָ�ʽ�����������Ҫ����ԭ���������ʽ
 * ����ʱ�򴴽�����̳��߼��� ��  ִ�������ģʽ 
 * */

//��ʼ �������
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
//��־���
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

//��������ģʽ��� 404 ����ҳ��

$error = new errorObject("404:Not Found \t\n\n");

//�Ѹոմ����Ĵ�����Ϣ����ļ�

$log = new logToConsole($error);

$log->write();


//������ �Ѵ�����־д�� CSV��

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

//����һ���������� �̳� ԭ���� ���� �� 

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


//���� ������ 

$error = new logToCSVAdapter('404:Not Found') ;

$log = new logToCSV($error);

$log->write() ;


die('������ģʽ');
?>