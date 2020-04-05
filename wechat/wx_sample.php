<?php
/**
 * 微信测试程序
 * author: liangxifeng
 * date: 2016-05-24
  */

//引入当前会话类
include_once "SessionResponse.php";
//接入微信
if($_GET["echostr"])
{
    include_once "WechatSignature.php";
    $signature = new WechatSignature($_GET['echostr']);
}else
//微信请求我们开发者
{
    $userMsgObj = xmlToObj();
    $session = new SessionResponse($userMsgObj);
    if( 'CLICK' == $userMsgObj->Event && 'V1001_TODAY_MUSIC' == $userMsgObj->EventKey)
    {
        $paramArr = array(
            array('Title'=>'中国好声音',
            'Description'=>'2016年中国好声音开始选拨了',
            'PicUrl'=>'http://easyread.ph.126.net/Jj4BfpDrEinDuh4sXcLa8w==/7916571680917961259.jpg',
            'Url'=>'http://baike.baidu.com/link?url=PUIV1fH1QgHnakW33iKuD2PI1pXW_hCeEb3F9vtk1WkfcseL0TNIA-9rmp-6_o21im7xkWGW6JpRPy8_52pQI1sDbhCh37CfzlqHANbMPWa'),
            array('Title'=>'我是歌手',
            'Description'=>'真正王者之间的较量',
            'PicUrl'=>'http://www.ah.xinhuanet.com/2016-04/14/1118622582_14606175824631n.jpg',
            'Url'=>'http://baike.baidu.com/link?url=A9zlW2gSZ_8ncQhp1LEzbHgI_CT2vkrOUDCwiLrwDvXihRfzFsKbxxPh3-UsjzmUNoWmIT3VliYreN5swrOjNQOMil-_xoQBc0cBREhFtaC')
        );
        $session->transmitNews($paramArr);
    }elseif('CLICK' == $userMsgObj->Event && 'V1001_GOOD' == $userMsgObj->EventKey)
    {
        $session->responseMsg('谢谢您的参与，恭喜您点赞成功！');
    }
    if(!empty($userMsgObj->Content))
    {
       $param = '<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=o9Te2vxxbeP481iv76ujkJMNr3XA&redirect_uri=http://www.ljlj.cc/wechat/lxf/oauth2.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect">点击体验oAuth2.0网页授权</a>';
        $session->responseMsg($param);
        //返回当前会话数据
        //$session->responseMsg('helloworld-new');
        //调用客服接口异步传输数据给wechat
        /*
        include_once "WechatServerApi.php";
        $wechat = new WechatServerApi();
        $param = '{
                "touser":"'.$userMsgObj->FromUserName.'",
                        "msgtype":"text",
                            "text":
                            {
                                 "content":"我是客服接口发来的数据"
                            }
                }';
        $wechat->serviceSend($param);
         */
    }
}

//记录错误日志
function addLog($msg='',$fileName='errorLog.txt')
{
    $path = './logs';
    if(!is_dir($path))  
    {  
        mkdir($path,0755);  
    } 
    //以追加的形式写入文件数据
    file_put_contents($path.'/'.$fileName,$msg."\n",FILE_APPEND);
    /*
    $myfile = fopen($path.'/'.$fileName, "w") or die("Unable to open file!");
    chmod($path.'/'.$fileName, 0777);
    fwrite($myfile, $msg);
    fclose($myfile);
    */
}
//接收微信传递过来的用户信息
function xmlToObj()
{
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//用来接收PHP不识别的POST数据 比如text/xml,soap

    if(empty($postStr))
    {
        echo "";//返回空串　微信服务器不作任何处理　也不重试请求
        exit;
    }
    $postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    //将收到的信息记录日志
    addLog($postStr."\n<!----- 我是消息分割线 -->",'from_wechat_'.$postObj->ToUserName.'.xml');
    //$postObj->Content = str_replace(" ", "",$postObj->Content);
    return $postObj;
}

?>
