<?php
/*
 * PHP装饰模式
 * 经常喜欢吃板面，板面的种类（鸡蛋板面，丸子板面，豆皮板面等等...）
 * 我们知道板面在煮出来就是一碗面，根据客户的需求加入鸡蛋、丸子等组合方式。
 * 本例采用程序的方式实现一下:
 *
 * @author: Liangxifeng
 * @date  : 2015-03-04
 */

//对象接口
interface Component 
{
    function make();
}
//制作出一碗板面
class MakeNoodle implements Component
{
    function make()
    {
        echo "做出一碗板面\n";
    }
}
//装饰抽象类,负责对一碗板面添加附属品
abstract class NoodleType
{
    protected $noodleObj;
    function __construct($noodleObj)
    {
        $this->noodleObj = $noodleObj;
    }

    function make()
    {
        $this->noodleObj->make();
    }
}
//具体装饰添加鸡蛋类
class EggNoodle extends NoodleType
{
    function make()
    {
        parent::make();
        echo "加鸡蛋\n";
    }
}
//具体装饰添加丸子
class BallNoodle extends NoodleType
{
    function make()
    {
        parent::make();
        echo "加丸子\n";
    }
}
//具体装饰添加豆皮
class SkinNoodle extends NoodleType
{
    function make()
    {
        parent::make();
        echo "加豆皮\n";
    }
}
//制作出一碗添加鸡蛋和豆皮面
$noodle = new MakeNoodle();
$noodle = new EggNoodle($noodle);
$noodle = new SkinNoodle($noodle);
$noodle->make();
/*
 * 以上程序结果：
 * 做出一碗面条
 * 加鸡蛋
 * 加豆皮
 */
?>
