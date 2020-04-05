<?php
require("redis.php");
$uid = $_GET['id'];
//删除key
$redis->del("user:".$uid);
//删除队列中的uid中的元素
$redis->lrem("uid",$uid);
header("location:list.php?rand=".rand(100,999));

