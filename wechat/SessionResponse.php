<?php
/**
 * wechat当前会话返回类
 *@author:   liangxifeng
 *@date  :   2016-05-24
 */
class SessionResponse
{
    public $userMsgObj = null;
    public function __construct($userMsgObj=null)
    {
        $this->userMsgObj = $userMsgObj;
    }
    /**
     * 回复文本信息
     *@param  $fromUsername  String -要发送的对象
     *        $toUsername    String -发送方的账号　即公众号
     *        $time          String -发送时间
     *        $msgType       String -消息类型 默认是text类型
     *        $contentStr    String -回复内容
     *@return $resultStr        String -XML格式的内容 
     */
    public function responseMsg($contentStr = null,$msgType="text")
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $time         = date("Y-m-d H:i:s");
        $resultStr  = sprintf($textTpl, $this->userMsgObj->FromUserName, $this->userMsgObj->ToUserName, $time, $msgType, $contentStr);//组织XML格式的回复内容
        echo $resultStr;
    }

    /**
     *回复图文信息
     *@param   $msgType        String  -消息类型 默认是图文信息
     *         $newsArray      Array   -包含图片相关信息的数组
     *@return  $resultStr      String  -XML格式的内容 
     */
    public function transmitNews($newsArray,$msgType="news")
    {
        if(!is_array($newsArray))//判断是否是数组
        {
            return;
        }
        //图文信息XML模板
        $itemTpl = "<item>
                    <Title><![CDATA[%s]]></Title> 
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>";
        $itemStr = "";
        foreach($newsArray as $item)
        {
            $itemStr .= sprintf($itemTpl, $item["Title"], $item["Description"], $item["PicUrl"], $item["Url"]);//格式化XML图文信息数据
        }
        //回复信息模板
        $xmlTpl =" <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>%s</ArticleCount>
                    <Articles>$itemStr</Articles>
                    </xml> ";
        $time         = date("Y-m-d H:i:s");
        $resultStr = sprintf($xmlTpl, $this->userMsgObj->FromUserName, $this->userMsgObj->ToUserName,$time, count($newsArray));//格式XML图文信息回复数据
        echo $resultStr;
    }
}
