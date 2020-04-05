<?php
require("redis.php");
//接收参数
$username = $_POST['username'];
$password = $_POST['password'];
$age = $_POST['age'];
$uid = $redis->incr("userid");
//批量增加/修改hash table
$res = $redis->hmset("user:".$uid,array("username"=>$username,"password"=>$password,"age"=>$age,"uid"=>$uid));

//插入队列uid,用来做分页
$redis->rpush("uid",$uid);

//用户注册的时候容易找到该用户，否则找不到
$redis->set("username:".$username,$uid);
//删除用 $redis->del("user:".$uid);
if($res)
{
    header("location:list.php?random=".rand(100,999));
}


