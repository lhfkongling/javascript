<?php
namespace Library;

Db::conn();

class Db
{
    static protected $_host;
    static protected $_user;
    static protected $_pass;
    static protected $_name;
    static protected $_prefix;
    
    static private $mydb = NULL;
    static private $link = NULL;
    
    final private function __construct(){
        self::$_host = C('DB_HOST');
        self::$_user = C('DB_USER');
        self::$_pass = C('DB_PASSWORD');
        self::$_name = C('DB_NAME');
        self::$_prefix = C('DB_PREFIX');
        
        self::$mydb = mysql_connect(self::$_host,self::$_user,self::$_pass); 
        if (!self::$mydb)
        {
            die('Could not connect: ' . mysql_error());
        }
        pr(self::$mydb) ;
        
    }
    
    public static function conn (){
       if(self::$link == null){
           self::$link = new self();
       } 
       return self::$link;
    }
    
    final private function __clone(){}
    
}

?>