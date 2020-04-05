<?php
/**
 * 微信接口封类
 *@author   liangxifeng
 *@date     2016-05-24
 */
class WechatServerApi
{
    public $appid        = "wx429ce494c34b4673";  //开发者应用ID
    public $appsecret    = "efa9031aa84cccd1515bc32c96332a64";  //开发者应用密钥
    public $access_token = "";  //全局标识符
    
    //构造函数
    public function __construct ($appid = null ,$appsecret = null )
    {
        $this->getAccessToken();
    }

    /**
     * 获取和更新access_token值封装函数
     *@return           String -  返回token值
     */
    function getAccessToken()
    {
        //获取access_token值的接口
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
        include_once "RedisClient.php";
        $config = array('port'=>6379,'host'=>'192.168.0.6','auth'=>'redis-179');
        $redis = new RedisClient($config);

        $tokens   = $redis->hGetAll("wechat_token_lxf");//获取token值
        if($tokens) //token值和token值的生命期 都存在　都获取到
        {
            $timeNow    = time();
            $remainTime = $timeNow - $tokens['tokenTime'];              
            if(6900 < $remainTime)   //总的有效期是7200秒　如果离token的到期时间不足300秒　则更新token值
            {
                $res = $this->https_request($url);//GET 请求
                $res = json_decode($res, TRUE);   //解码json数据成数组
                $this->access_token = $res['access_token'];
                $tokenArr = array('tokenValue'=>$this->access_token,'tokenTime'=>time());
                $redis->hMset("wechat_token_lxf", $tokenArr);
                //2小时过期
                $redis->expire("wechat_token_lxf",7200);
            }
            else
            {
                $this->access_token = $tokens['tokenValue'];
            }
        }
        else
        {
            $res  = $this->https_request($url);//GET请求
            $res  = json_decode($res, TRUE);
            $this->access_token = $res["access_token"];
            $tokenArr = array('tokenValue'=>$this->access_token,'tokenTime'=>time());
            $redis->hMset("wechat_token_lxf", $tokenArr);
            //2小时过期
            $redis->expire("wechat_token_lxf",7200);
        }
   	}

    /**
     * 微信接口请求封装函数
     *@param   $url     String -  请求数据的url地址
     *@param   $data    Json   -  Json格式的数据　get请求默认为空　post请求不能为空
     *@return  $output  Json   -  返回Json格式的数据
     */
    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data))//data为空　则是post请求
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 获取用户基本信息封装函数
     *@param   $openid  int    - 用户ID标识符  
     *@return           array  - 用户基本信息数组
     */
    function getUserInfo($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);
        return json_decode($res, TURE);
    }
    /**
     * 拉图片
     *@param   $mediaID String -微信服务器图片的ID
     *         $id      Int    -数据表的图片主键ID
     *         $path    String -图片的路径
     *@return           String -本地服务器上的原图路径
     */
    function getUserImg($mediaID,$id,$path)
    {
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->access_token."&media_id=$mediaID";//获取图片的接口
        copy($url, $path."/". $id .".jpg");//拷贝远程图像到本地
        return $path."/". $id .".jpg";//返回本地原图的路径
    }
    /**                                                                                                                          
     * 新增临时素材封装函数(多媒体文件上传)                                                                                      
     *@param   $fileName  String    -  文件绝对路径                                                                              
     *         $type      String    -  文件类型                                                                                  
     *@return  Array  {                                                                                               
     *              "type":      //媒体文件类型分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb，主要用于视频与音乐格式
     *                      的缩略图）
     *              "media_id":  //媒体文件上传后，获取时的唯一标识                                               
     *              "created_at"://媒体文件上传时间戳                                                             
     *                   }                                                                                                        
     **/                                                                                                                          
    function postFile($fileName,$type = "image")                                                                                 
    {                                                                                                                            
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->access_token."&type=".$type;                
        $fields['media'] = '@'.$fileName;                                                                                        
        $res = $this->https_request($url,$fields);                                                                               
        return json_decode($res, TRUE);                                                                                          
    }

    /**
     * * 调用客服接口,给用户发送信息
     */
    function serviceSend($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
        $res = $this->https_request($url,$data);
        return json_decode($res, TRUE);

    }

}
