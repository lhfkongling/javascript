<?php
header('Content-type:text/html;charset=utf-8');

class Human {
    
    private $money =NULL;
    
    //设置有多少钱 
    public function __construct($money){
        $this->money = $money ;
    }
    
    //支出
    private function send($money){
        if($this->money >= $money){
            $this->money -=$money;           
        }else{
            $money =  $this->money ;
            $this->money = 0 ;            
        }
        return $money ;
    }
    //收入
    private function add($money){
        $this->money += $money;
    }
    
    //显示有多少钱
    public function  showMoney(){
        return $this -> money;
    } 
    
//     告诉被人 某某 有多少钱
    public function tellMoney($person){
       return  $person -> showMoney();
    }
//     拿别人的钱
    public function sendMoney($person,$money){
        $m = $person ->send($money);
        $this->add ($m) ;
        return $m;
    }
    
    
}

$zhansan = new Human(50000);

$lisi = New Human(1000);

echo '张三有：', $zhansan ->showMoney();

echo '<br />' ; 

echo '李四有：', $lisi ->showMoney();

echo '<br />' ;

echo '李四打听到张三还有：', $lisi ->tellMoney($zhansan) ;

echo '<br />' ;

echo '李四 第一次想偷了张三  500 ，偷到了', $lisi ->sendMoney($zhansan,500) ;
echo '<br />' ;

echo '张三变成有  ', $zhansan ->showMoney() ;
echo '<br />' ;
echo '李四第二次 想偷了张三  5000 ，偷到了', $lisi ->sendMoney($zhansan,5000) ;
echo '<br />' ;

echo '张三变成有  ', $zhansan ->showMoney() ;
echo '<br />' ;
echo '李四 第三次想偷了张三  50000 ，偷到了', $lisi ->sendMoney($zhansan,50000) ;

echo '<br />' ;

echo '张三变成有  ', $zhansan ->showMoney() ;

echo '<br />' ;

echo '李四变成 有  ', $lisi ->showMoney() ;

