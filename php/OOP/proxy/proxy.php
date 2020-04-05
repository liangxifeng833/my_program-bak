<?
/*
 * 使用代理模式回忆2012年的一瞬间
 * 地点： 窄岭高中
 * 人物：lxf  zhj  sln
 * 流程：lxf 让zhj 帮忙送sln礼物及书信
 *
 * @author: Liangxifeng
 * @date  : 2015-03-30
 *
 */
//送东西接口
Interface GiveGift
{
    //写情书
    function writeLetter();
    //送衣服
    function giveClothes();
}
//lxf送礼物，实现接口
class lxf implements GiveGift
{
    private $name = null;
    function __construct($name)
    {
        $this->name = $name;
    }
    //写情书
    function writeLetter()
    {
        echo '这是lxf真正用心给'.$this->name.'写的第一封情书，当时酝酿了好久，写了将近2个课，终于写完了，送给'.$this->name.' 吧... ';
    }
    //送衣服
    function giveClothes()
    {
        echo "\n这是lxf第一次送给女孩生日礼物，还真不知道送什么好，于是叫上我的同桌lgd意思去了丰宁，\n
            选择了一个下午终于在（美特斯邦威）选中了一件上衣, 当时可是花了我半个月的生活费啊...，\n
            不过是为了心爱的人，值了，买了当天晚上下自习就送给了".$this->name."\n";
    }

}
//zhj帮我送礼物，实现接口
class ProxyZhj implements GiveGift
{
    private $lxfObj = null;
    function __construct($name)
    {
        $this->lxfObj = new lxf($name);
    }
    public function writeLetter()
    {
        $this->lxfObj->writeLetter();
    }
    public function giveClothes()
    {
        $this->lxfObj->giveClothes();
    }
}

//测试类
class client 
{
    function __construct()
    {
        $obj = new ProxyZhj('sln');
        $obj -> writeLetter();
        $obj -> giveClothes();
    }
}

$test = new client;
