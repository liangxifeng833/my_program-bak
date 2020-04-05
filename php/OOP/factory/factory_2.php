<?php
/*
 * php 工厂模式实例代码二( 抽象方法模式 )
 * 使用抽象工厂模式，抽象出创建工厂的基类AnimalFactory
 * 使用两个具体工厂类实现真正的猪和狗的创建
 *
 * @author: liangxifeng
 * @date  : 2015-12-22
 */

//抽象类Dog为狗的基类，定义所有Dog都应该实现shout方法
interface Dog
{
    public function shout();
}

//黑色小狗角色
class BlackSmallDog implements Dog
{
    public function shout()
    {
        echo "BlackSmallDog Wao!Wao!Wao! \n";  
    }
}
//黑色大狗角色
class BlackBigDog implements Dog
{
    public function shout()
    {
        echo "BlackBigDog Wao!Wao!Wao! \n";  
    }
}

//Pig接口，定义所有Pig都应该实现shout方法
interface Pig
{
    public function shout();
}

//黑色小猪角色
class BlackSmallPig implements Pig
{
    public function shout()
    {
        echo "BlackSmallPig Zhi!Zhi!Zhi! \n";  
    }
}
//黑色大猪角色
class BlackBigPig implements Pig
{
    public function shout()
    {
        echo "BlackBigPig Zhi!Zhi!Zhi! \n";  
    }
}

//抽象工厂(Abstract Factory)角色,它声明一个创建抽象产品对象的接口,所有的具体工厂类必须实现这个接口或继承这个类
interface AnimalFactory
{
    public function createDog($color);
    public function createPig($color);
}

//--------------------------------------------------------
//具体工厂(Concrete Factory)角色：实现创建产品对象的操作。客户端直接调用这个角色创建产品的实例。
//大动物工厂类
class BigAnimalFactory implements AnimalFactory  
{
    //生产大狗
    public function createDog($color)
    {
        $dogType = ucfirst(strtolower($color)).'BigDog';
        if(class_exists($dogType))
        {
            return new $dogType();
        }

    }
    //生产大猪
    public function createPig($color)
    {
        $pigType = ucfirst(strtolower($color)).'BigPig';
        if(class_exists($pigType))
        {
            return new $pigType();
        }

    }
}
//小动物工厂类
class SmallAnimalFactory implements AnimalFactory
{
    //生产小狗
    public function createDog($color)
    {
        $dogType = ucfirst(strtolower($color)).'SmallDog';
        if(class_exists($dogType))
        {
            return new $dogType();
        }

    }
    //生产小猪
    public function createPig($color)
    {
        $pigType = ucfirst(strtolower($color)).'SmallPig';
        if(class_exists($pigType))
        {
            return new $pigType();
        }

    }
}
//--------------------------------------------------------

//客户端测试
class testDriver
{
    public function run()
    {
        //实例化大动物类
        $bigFactory = new BigAnimalFactory();
        //生产一个大黑狗
        $dog1 = $bigFactory->createDog('black');
        $dog1->shout();
        //生产一个大黑猪
        $pig1 = $bigFactory->createPig('black');
        $pig1->shout();

        //实例化小动物类
        $smallFactory = new SmallAnimalFactory();
        $dog2 = $smallFactory->createDog('black');
        //生产一个小黑狗
        $dog2->shout();
        //生产一个小黑猪
        $pig2 = $smallFactory->createPig('black');
        $pig2->shout();

    }
}

$test = new testDriver();
$test->run();


/* 输出结果：
    BlackBigDog Wao!Wao!Wao! 
    BlackBigPig Zhi!Zhi!Zhi! 
    BlackSmallDog Wao!Wao!Wao! 
    BlackSmallPig Zhi!Zhi!Zhi! 
 */

