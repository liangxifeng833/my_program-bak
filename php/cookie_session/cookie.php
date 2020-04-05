1212121
<?php
/*
 * cookie 客户在第一次请求test.php的时候，setcookie会在客户端浏览器中种下cookie（在response的时候），
 * 那么当第二次请求的时候浏览器会在头信息中自动包含该域下未过期的cookie发送给server,正式因为这个原因在第一次访问的时候并获取不到cookie，第二次访问的时候才能获取到，因为第一次只是服务器端向客户端注册cookie，request的头信息中并没有cookie，第二次就出现了。
 * 默认：cookie 的作用路径在本目录及本目录一下路径
 * setcookie 被是放在http协议响应头信息发送的服务器的，所以在setcookie之前不允许有输出内容，否则会被浏览器作为正文内容发送
 * 
 * @date: 2014-12-05
 */
/*
for($i=1;$i<10;$i++)
{
    echo $i.'<br>';
    sleep($i+1);
}
exit;
 */

//setcookie("web","liangxifeng_test_cookie");            //没有设置过期时间，那么生命周期是浏览器关闭失效，是一个会话，存在内存浏览器进程中
//setcookie("web","liangxifeng_test_cookie",time()+3600); //设置过期时间，那么生命周期指定的过期时间1小时，cookie存在于物理硬盘中
//ob_start(); //激活output_buffering机制。一旦激活，脚本输出不再直接出给浏览器，而是先暂时写入php buffer内存区域,等到php buffer内存区满后在输出给客户端浏览器
//setcookie("web","liangxifeng_test_cookie",time()+3600,'/'); //设置作用路径，在网站根目录
//setcookie("web","liangxifeng_test_cookie",time()+3600,'/','.yii2.loc'); //设置作用阈
//setcookie("web","liangxifeng_test_cookie",time()+3600,'/','.yii2.loc',1); //最后一个参数，1代表使用https加密协议传输

/*
//cookie存数组1
$arr = array('php','mysql','linux');
setcookie("web[0]",$arr[0]);
setcookie("web[1]",$arr[1]);
//cookie存数组2
setcookie("web",serialize($arr[1]));
$web = $_COOKIE["web"];
var_dump($web);
*/

//使用header函数注册cookie
header("Set-Cookie:web=phplanguage");

//echo $_COOKIE['web'];
