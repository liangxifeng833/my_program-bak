<?php
/*
 * php操作redis测试
 *
 * @author:liangxifeng
 * @date:2014-11-20
 */

//实例化
$redis = new Redis();
//连接redis 端口：6379
$redis->connect('127.0.0.1','6379');
//授权
$redis->auth('123456');

