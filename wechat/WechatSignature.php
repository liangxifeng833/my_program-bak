<?php
/**
 *微信接入签名类
 *@author:   liangxifeng
 *@date  :   2016-05-24
 */
class WechatSignature
{
    public function __construct($echoStr = null)
    {
        $this->valid($echoStr);
    }
    /**
     *@param   $echoStr String -随机字符串
     *@return  $echoStr String -返回随机字符串
     */
    public function valid($echoStr)
    {
        if($this->checkSignature())
        {
            echo $echoStr;//原路返回验证的随机字符串
            exit;
        }
    }
    /**
     * 校验signature
     *@param   String   -$signature 微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数
     *         String   -$timestamp  时间戳
     *         String   -$nonce      随机数
     *@return  Boolean  -true/false  
     */
   private function checkSignature()
   {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = 'weixin';//前面定义的常量
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr);//将数组进行字典序排序
        $tmpStr    = implode( $tmpArr );
        $tmpStr    = sha1( $tmpStr );
        if($tmpStr == $signature)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
