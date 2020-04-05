<?php
/*
 * 使用工厂模式制作计算器demo
 *
 * @author: Liangxifeng
 * @date  : 2015-01-23
 *
 */

//抽象获取计算结果类
abstract class Result
{
    public $a=0;
    public $b=0;
    abstract  function getRes();
}

//加法类
class Jia extends Result
{
    public function getRes()
    {
        return (int)$this->a + (int)$this->b;
    }
}
//减法类
class Jian extends Result
{
    public function getRes()
    {
        return (int)$this->a - (int)$this->b;
    }
}
//乘法和除法类似省略...

//实例化计算机对象的工厂类
class Factory 
{
    public static function create($operate)
    {
        return new $operate;
    }
}

//测试终端类
class Test
{
    function run()
    {
        //10+20=30
        $operate = Factory::create('Jia');
        $operate->a=10;
        $operate->b=20;
        echo $operate->getRes()."\n";

        //100-20=80
        $operate = Factory::create('Jian');
        $operate->a=100;
        $operate->b=20;
        echo $operate->getRes()."\n";
    }
}

//调用测试
$a = new Test;
$a->run();
