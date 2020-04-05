<?php
/*
 * session 学习
 * 和cookie一样都是能够在多个页面之间共享一些数据
 * 原理：信息存在server端,一个网站没有会有很多人访问，所以会产生很多session信息，
 *       所以在第一次注册session的时候，会为对应客户在客户端浏览器的cookie中
 *       注册一个唯一标识session_id,注册成功后再次访问时，
 *       浏览器会在响应头信息中加入以“PHPSESSID”(默认)为名的session_id发送给服务器，服务器会根据唯一标识
 *       PHPSESSID来区分每个用户的权限等等session信息
 *
 * @author:liangxifeng
 * @date:2014-12-07
 */

session_start();     //开启session，以响应头信息的形式，在客户端浏览器注册比如：PHPSESSID='8c8sr01vhi9rjgp99u9lgqpt95'的cookie，
                    //作为用户的唯一标识,同时在服务器端生成/tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95文件，
                    //php.ini中的session.save_handler = files可以配置session文件生成的位置，默认在/tmp目录下，
                    //当客户端第二次访问服务器的时候，在http的请求头信息中带着cookie的PHPSESSID传递的server端，
                    //server会查找以sess_PHPSESSID为文件名的文件，找到后就可以获取该用户存储在服务器端的session信息了,
                    //以上这些都是session_start()做的事情. php.ini中的session.auto_start=1和session_start()效果是一样的，
                    //如果开启该配置，那么在页面中就可以不写session_start(),不过不建议这么做,默认不开启。

//echo session_name(); //该函数返回"PHPSESSID",作为在客户端浏览器生成session_id的字段名
//echo session_id();     //获取session_id的值，"8c8sr01vhi9rjgp99u9lgqpt95"
//echo $_COOKIE['PHPSESSID']; //获取客户端传递过来的session_id

//$_SESSION['lanage'] = 'php';  //session信息序列化后写入到/tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95文件中。


/*
session_name('NEW_PHPSESSID'); //修改默认session_id的字段名，默认是PHPSESSID,改为NEW_PHPSESSID,一定要在start的前面 
session_start();
*/


$_SESSION['web'] = '我的网站';
$_SESSION['web_url'] = 'http://www.ljlj.cc';
//以下两种方式是把session文件中存放的信息删除，而文件依然还存在
//unset($_SESSION['web']); //单独删除session中一条记录，相当与把lanage变量信息从/tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95文件中删除掉
//$_SESSION = array();     //把session中所有数据删除掉,清空文件/tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95的内容

/*
 * 卸载session顺序
//session_unset(); //根据session_id,/删除session_start放在内存中的session数据
//会删除/tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95文件
 session_destroy();  //删除server端session文件而已客户端PHPSESSID="8c8sr01vhi9rjgp99u9lgqpt95"依然存在，
                    //所以如果其他页面再次使用session_start(),client端会传递过来PHPSESSION,
                    //服务器session_start()会判断有没有session文件的存在，如果没有，那么自动创建，
                    ///tmp/sess_8c8sr01vhi9rjgp99u9lgqpt95 ,删除session_id的功能
setcookie(session_name(),'',time()-3600,'/'); //删除客户端的session_id,第4个参数根路径一定要写，
                                              //否则cookie会按着本php文件当前路径下的cookie删除，会找不到
*/

echo $_SESSION['web']; //在删除完毕session和cookie session_id后接下来依然可以获取到web内容，
                       //因为session_start()，把第一次读取到的session文件内容先放到内存中了,要在session_destory之前使用session_unset();





