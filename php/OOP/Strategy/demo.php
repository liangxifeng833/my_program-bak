<?php
/*
 * PHP 策略模式demo
 * 商场收银系统，营业员根据客户所购买商品的单价和数量收费
 *
 * @author: liangxifeng
 * @date  : 2015-02-03
 */

//现金收费抽象类，（抽象策略角色）
abstract class CashSuper
{
    //参数为原价，返回为当前价格
    abstract function acceptCash($srcMoney);
}
//正常收费子类, （具体策略角色）
class CashNormal extends CashSuper
{
    //返回原价
    public function acceptCash($srcMoney)
    {
        return $srcMoney;
    }
}
//打折收费子类, （具体策略角色）
class CashRebate extends CashSuper
{
    private $rebate; //折扣,如98折，参数输入应为：0.98
    function __construct($rebate)
    {
        if($rebate>1 || $rebate<0)
        {
            return 'rebate param error';
        }
        $this->rebate = $rebate;
    }
    public function acceptCash($srcMoney)
    {
        return $srcMoney * $this->rebate;
    }
}
//满反收费子类, （具体策略角色）
class CashReturn extends CashSuper
{
    private $moneyCondition; //满反条件
    private $moneyReturn;    //反给顾客的金额
    function __construct($moneyCondition,$moneyReturn)
    {
        $this->moneyCondition = $moneyCondition;
        $this->moneyReturn = $moneyReturn;
    }
    public function acceptCash($srcMoney)
    {
        $result = '';
        if($srcMoney >= $this->moneyCondition)
        {
            $result = $srcMoney - floor($srcMoney/$this->moneyCondition) * $this->moneyReturn;
        }
        return $result;
    }
}
//CashContext类, （环境角色）,持有一个策略类的引用，最终给客户端调用
class CashContext
{
    public $cs = null; //声明一个CashSuper对象
    //构造方法，参数$type为具体的收费类型
    public function __construct($type)
    {
        switch($type)
        {
            case "normal": //正常收费
                $this->cs = new CashNormal;
                break;
            case "return": //满300反100
                $this->cs = new CashReturn("300","100");
                break;
            case "rebate": //打八折
                $this->cs = new CashRebate('0.8');
                break;
        }
    }
    //获取最终结算后的金额
    public  function getResult($srcMoney)
    {
        return $this->cs->acceptCash($srcMoney);
    }
}

//终端用户调用测试
$cash = new CashContext('return');
echo $cash->getResult('500')."\n";
//以上满300减100，结果是400
$cash = new CashContext('rebate');
echo $cash->getResult('500')."\n";
//以上打8折,结果是400
$cash = new CashContext('normal');
echo $cash->getResult('500')."\n";
//以上正常收款,结果是500
