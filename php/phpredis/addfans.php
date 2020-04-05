<?php
/*
 *使用redis集合关注用户
 *
 * @author:liangxifeng
 * @date:2014-12-20
 */

//关注的用户id
$id = $_GET['id'];
//当前登录用户id
$uid = $_GET['uid'];
require("redis.php");
//登录者都关注了谁,用集合表示
$redis->sadd("user:".$uid.":following",$id);
//被关注者的粉丝有谁
$redis->sadd("user:".$id.":follows",$uid);
header("location:list.php?rand=".rand());
