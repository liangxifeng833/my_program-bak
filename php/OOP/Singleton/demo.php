<?php
/**
 * 单例模式 demo
 * @author:liangxifeng
 * @date:2015-04-17
 *      
 */

class Singleton {

    /**
     * 静态成品变量 保存全局实例
     *           */
    private static  $_instance = NULL;

    /**
     *  私有化默认构造方法，保证外界无法直接实例化
     */
    private function __construct() { }

    /**
     *静态工厂方法，返还此类的唯一实例
     */
    public static function getInstance() 
    {
        if (is_null(self::$_instance)) 
        {
            self::$_instance = new Singleton();
        }
        return self::$_instance;
    }

    /**
     *防止用户克隆实例
     */
    public function __clone()
    {
        die('Clone is not allowed.' . E_USER_ERROR);
    }

    /**
     *测试用方法
     */
    public function test() 
    {
        echo 'Singleton Test!';
    }


}

/**
 *客户端
 */
class Client {

    /**
     * Main program.
     */
    public static function main() 
    {
        $instance = Singleton::getInstance();
        $instance->test();
    }
}
Client::main();
/*
 * 结果： Singleton Test
 */
