<?php
header('Content-type:text/html;charset=utf-8');

//人类 类属性方法 
class Human {
    
    private $cry = '呜呜' ;
    
    private $laugh = '哈哈' ;
    
    public function __construct(){
        
    }
    
    
    
    protected function  br(){
        echo '<br/>' ;
    } 
    
    protected function getCry(){
        echo $this->cry;
        $this->br();
    }
    
    protected function getLaugh(){
        echo $this->laugh;
        $this->br();
    }
    
}

//孩子属性方法 继承 人类  属性方法

class Children extends Human {
    
    public function __construct(){
    
    }
    
    private $agee = FALSE ;
    
    protected  function getLaugh () {
        echo '我可以上学了。好高兴。';
        parent::getLaugh();
    }
    
    public function  wantScool(){
        echo '我要上学';
        $this->br();
    } 
    
    public function setAgee($type = false){
        $this->agee = $type;
    }
    
    public function mood(){
        if($this->agee == false){
           parent::getCry();
          
        }else{
            $this->getLaugh();
//              parent::getLaugh();
            
        }
    }
}

class  Father extends Human{
    
    
    
}

$xiaoming = new Children ();

$xiaoming ->wantScool();

$xiaoming ->setAgee(true);

// print_r($xiaoming) ;
$xiaoming->mood(); 


