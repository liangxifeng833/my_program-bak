<?php
/*
 * php 工厂模式实例代码一( 工厂方法模式)
 *
 * @author: liangxifeng
 * @date  : 2015-12-21
 */

//抽象类Dog为狗的基类，定义所有Dog都应该实现shout方法
interface Dog
{
    public function shout();
}

//红色大狗角色
class RedBigDog implements Dog
{
    public function shout()
    {
        echo "RedBigDog Wao!Wao!Wao! \n";  
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
//红色小狗角色
class RedSmallDog implements Dog
{
    public function shout()
    {
        echo "RedSmallDog Wao!Wao!Wao! \n";  
    }
}
//黑色小狗角色
class BlackSmallDog implements Dog
{
    public function shout()
    {
        echo "BlackSmallDog Wao!Wao!Wao! \n";  
    }
}

//工厂类基类
interface  DogFactory
{
    public function create($color);
}

//小狗工厂
class SmallDogFactory implements DogFactory
{
    public function create($color)
    {

        $dogType = ucfirst(strtolower($color)).'SmallDog';
        if(class_exists($dogType))
        {
            return new $dogType;
        }
    }
}
//大狗工厂
class BigDogFactory implements DogFactory
{
    public function create($color)
    {

        $dogType = ucfirst(strtolower($color)).'BigDog';
        if(class_exists($dogType))
        {
            return new $dogType;
        }
    }
}

//客户端测试
class testDriver
{
    public function run()
    {
        //生产一个小黑狗
        $factory1 = new SmallDogFactory();
        $dog1 = $factory1->create('black');
        $dog1->shout();

        //生产一个大红狗
        $factory2 = new BigDogFactory();
        $dog2 = $factory2->create('red');
        $dog2->shout();
    }
}

$test = new testDriver();
$test->run();

