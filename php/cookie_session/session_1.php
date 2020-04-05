<?php
/*
 * session 学习02
 * 浏览器禁用cookie情况，服务器的各个页面间传递session_id
 *
 * @author:liangxifeng
 * @date:2014-12-07
 */

/*
session_id("liangxifengtest"); //手动指定session_id，使下面的session_start()不接收客户端浏览器传递过来的session_id
session_start();     //开启session，session_id='liangxifengtest'，作为用户的唯一标识,同时在服务器端生成/tmp/sess_liangxifengtest文件
$_SESSION['uname'] = 'liangxifeng';
$_SESSION['upass'] = 'fsafda12121236458';
*/


session_start();
$_SESSION['uname'] = 'liangxifeng';
$_SESSION['upass'] = 'fsafda12121236458';

?>
<!-- 使用get地址栏PHPSESSION 方式不同页面之间传送session_id, 前提是php.ini中 session.name='PHPSESSID' 并且session.use_cookies = 0 -->
<.a href="a.php?PHPSESSID=<?php echo session_id();?>"> 去往a页面</a>
<a href="b.php?PHPSESSID=<?php echo session_id();?>"> 去往b页面</a>

<!--php.ini 要开启 session.use_trans_sid = 1, url_rewriter.tags = "a=href,area=href,frame=src,input=src,form=fakeentry" -->
<a href="d.php" > 去往d页面， ,自动为地址栏添加session_id </a>
 

