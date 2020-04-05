<?php
/*
 * PHP 策略模式模版
 *
 * @author: liangxifeng
 * @date  : 2015-02-02
 */

//抽象算法类
abstract class Strategy
{
    abstract function AlgorithmInterfac();
}

//具体算法A，策略A
class StrategyA extends Strategy
{
    public function AlgorithmInterfac()
    {
        return '算法A实现';
    }
}
//具体算法B，策略B
class StrategyB extends Strategy
{
    public function AlgorithmInterfac()
    {
        return '算法B实现';
    }
}
//具体算法C，策略C
class StrategyC extends Strategy
{
    public function AlgorithmInterfac()
    {
        return '算法C实现';
    }
}
//Context,用一个ContextInterface来配置，维护一个对Strategy对象的引用
class Context
{
    //初始化时，传入具体的策略对象
    private $strategy;
    public __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    //上下文接口,具体的策略对象，调用其算法的方法
    public function contextInterface()
    {
        return $this->strategy->AlgorithmInterfac();
    }
}
//客户端调用
class testClient
{
    public $content;
    $content = new Context(new StrategyA);
    $content->AlgorithmInterfac();
}
