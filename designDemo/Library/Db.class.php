<?php
//namespace Library;

class Db
{
    static protected $_host;
    static protected $_user;
    static protected $_pass;
    static protected $_name;
    static protected $_prefix;
    
    static protected $table = NULL;
    static protected $pri   = NULL;    
    static protected $sql   = NULL;
    static private $mydb    = NULL;
    static private $link    = NULL;
    
    static protected $options = array();
    static protected $order = NULL;
    static protected $wh = 1;
    static protected $limit = NULL;

    final private function __construct(){
        
       
        self::$_host    = C('DB_HOST');
        self::$_user    = C('DB_USER');
        self::$_pass    = C('DB_PASSWORD');
        self::$_name    = C('DB_NAME');
        self::$_prefix  = C('DB_PREFIX');
        
        self::$mydb     = $link =  mysqli_connect(self::$_host,self::$_user,self::$_pass,self::$_name); 
        
        if (!$link)  die('Could not connect: ' . mysqli_error($link));
         
    }
    
    final private function __clone(){}
    
    public static function conn (){
       if(self::$link == null){
           self::$link = new self();
       } 
      
       return self::$link;
    }
    public function table($table=NULL){
        self::$table = $table ;
        self::getPri();
        self::data();
        self::order();
        self::where();
        self::limit();
        return self::$link;
    }
    public function data($data=array()){
        if(is_string($data)){
            self::$options  = explode(',', $data) ;
        }else{
            self::$options = $data ;
        }
        
        return self::$link;
    }
    
    public function where($wh=1){
        self::$wh = $wh ;
        return self::$link;
    }
    public function order($order=NULL){
        if($order) self::$order = $order ;
        else self::$order = self::$pri .' DESC' ;
        return self::$link;
    }
    public function limit($limit=NULL){
        self::$limit = $limit ;
       
        return self::$link;
    }
    
    //获取主键 
    public function getPri (){
       $_result =  self::query('desc '.self::$table) ;
       while ($row = mysqli_fetch_assoc($_result)){
           if($row['Key'] == 'PRI') self::$pri = $row['Field'] ;
       }
       return self::$pri ;
    }
    
    //组建 sql 语句
    public function getSql ($type='select'){
        
        switch ($type){
            case 'select':
                self::setSelectSql();
                break;
            case 'row':
                self::setRowSql();
                break;
                
            case 'insert':
                self::setInsertSql();
                break;
                
            case 'update':
                self::setUpdateSql();
                break;
            case 'delete':
                    self::setDeleteSql();
                    break;
                
            default:
                self::$sql = null;
        }
        
        return self::$sql ;
        
    }
    //组建 select  语句
    protected static function setSelectSql(){
        $sql = "select " ;
        if(count( self::$options ) > 0){
            $sql .= implode(',', self::$options);
        }else{ 
            $sql .= " * " ;
        }       
        $sql .= ' from '.self::$table ;
        $sql .= ' where '.self::$wh ;
        $sql .= ' order by ' . self::$order ;
        if(self::$limit)  $sql .= ' limit ' . self::$limit ;
        return self::$sql = $sql ;
    }
    //组建 Update 语句
    protected static function setRowSql(){
        $sql = "select " ;
        if(count(self::$options) > 0){
            $sql .= implode(',', self::$options);
        }else{
            $sql .= " * " ;
        }
        $sql .= ' from '.self::$table ;
        $sql .= ' order by ' . self::$order ;
        $sql .= ' limit 1 ' ;
        return self::$sql = $sql ;
    }
    //组建 Insert 语句
    protected static function setInsertSql(){
        $sql = '';
        if(count(self::$options) > 0){
            $sql .= "INSERT INTO  " .self::$table .' ( `';
            $sql .= implode('`,`', array_keys(self::$options));
            $sql .='` ) VALUES ( \'';
            $sql .= implode("','", self::$options);
            $sql .= '\' ) ' ;    
        }      
         
        return self::$sql = $sql ;
    }
    //组建 UPDATE  语句
    protected static function setUpdateSql(){
        $sql = '';
        if(count(self::$options) > 0){
            $sql .= "UPDATE " .self::$table .' set ';
            $smg = '';
            foreach (self::$options as $k => $v){
                $sql .= $smg ." `$k` = '$v' "  ;  
                $smg = ',';
            }
            $sql .= 'WHERE '.self::$wh;
        }
        return self::$sql = $sql ;
    }
    //组建 UPDATE  语句
    protected static function setDeleteSql(){
        $sql = '';
        if( self::$wh ){
            $sql .= "DELETE FROM " .self::$table .'  ';            
            $sql .= 'WHERE '.self::$wh;
        }        
        return self::$sql = $sql ;
    }
    
    
    //执行SQL 语句
    public function query($sql){
        if($sql) return mysqli_query(self::$mydb, $sql) ;
        else return false ;
    }
    //查询一行 数据
    public  function row($sql=null){
        
        if($sql != null) self::$sql = $sql ;
        else self::getSql('row');
        
        if(self::$sql){
            $_result = self::query(self::$sql) ;                 
            $row = mysqli_fetch_assoc($_result) ;
            self::close();
            return  $row ;                  
        }
    
    }
    //查询多行数据    
   public  function select($sql=null){
        if($sql != null) self::$sql = $sql ;
        else self::getSql('select');
       
       $_result = self::query(self::$sql) ;
       $arr = array() ;
       while ( $res = mysqli_fetch_assoc($_result) ) {
           $arr[] = $res ; 
       }
       self::close();
       return  $arr ;
      
   }
   //输入数据
   public function insert($sql=null){
       
       if($sql != null) self::$sql = $sql ;
       else self::getSql('insert');
       return self::query(self::$sql) ;
   }
   //修改数据
   public function update($sql=null){
       if($sql != null) self::$sql = $sql ;
       else self::getSql('update');
       return self::query(self::$sql) ;
   }
   //修改数据
   public function delete($id=null){
       
       if($id != null){
           self::$wh = "`".self::$pri ."`=" . $id ;
       }

       return self::query(self::$sql) ;
       
   }
   
   
   
   private static function close(){
       mysqli_close(self::$mydb) ;
   }
  
}

?>