<a href="add.php">注册</a> |
<?php
require("redis.php");
if(!empty($_COOKIE['auth']))
{
    $id = 0;
    $id = $redis->get('auth:'.$_COOKIE['auth']);
    $name = $redis->hget("user:".$id,'username');
    echo '欢迎您,'.$name.' <a href=\'logout.php\'>退出</a><br />';
}else
{
?>
<a href="login.php">登录</a><br />
<?php
}
//用户总数
$count =  $redis->lsize("uid");
//每页显示3条记录
$perPage = 3;
//当前页码
$curPage = (!empty($_GET['page'])) ? $_GET['page']:1;
//总页数
$pageCount = ceil($count/$perPage);

$fromPage = ($curPage-1)*$perPage;
$ids = $redis->lrange("uid",$fromPage,$fromPage+$perPage-1);

/*
for($i=1;$i<=($redis->get("userid"));$i++)
{
    $data[] = $redis->hgetall("user:".$i);
}
*/
foreach($ids as $v)
{
    $data[] = $redis->hgetall("user:".$v);
}
$data = array_filter($data);
?>


<table border=1>
    <tr>
        <th>uid</th>
        <th>username</th>
        <th>age</th>
        <th>操作</th>
    </tr>
<?php foreach($data as $v){?>
    <tr>
    <td><?php echo $v['uid'];?></td>
    <td><?php echo $v['username'];?></td>
    <td><?php echo $v['age'];?></td>
    <td><a href="del.php?rand=<?php echo rand(100,9999)?>&id=<?php echo $v['uid'];?>">删除</a> 
    | 
    <?php if(!empty($_COOKIE['auth'])&&$id!=$v['uid']){?>
    <a href="addfans.php?id=<?php echo $v['uid'];?>&uid=<?php echo $id;?>">加关注</a></td>
    <?php }?>
    </tr>
<?php }?>
<tr>
<td colspan="4">
<a href="?page=1">首页</a>
<a href="?page=<?php echo $curPage-1<=1?1:$curPage-1;?>">上一页</a>
<a href="?page=<?php echo $curPage+1>=$pageCount?$pageCount:$curPage+1;?>">下一页</a>
<a href="?page=<?php echo $pageCount;?>">尾页</a>
总记录数: <?php echo $count;?>
总页数: <?php echo $pageCount;?>
</td>
</tr>
</table>

<table border=1>
<caption> 我关注了谁： </caption>
<?php 
$ids = $redis->smembers("user:".$id.":following"); 
foreach($ids as $v)
{
    $row = $redis->hgetall("user:".$v);
?>
<tr>
<td><?php echo $row['uid']?></td>
<td><?php echo $row['username']?></td>
<td><?php echo $row['age']?></td>
</tr>
<?php
}
?>
</table>

<table border=1>
<caption> 我的粉丝： </caption>
<?php 
$ids = $redis->smembers("user:".$id.":follows"); 
foreach($ids as $v)
{
    $row = $redis->hgetall("user:".$v);
?>
<tr>
<td><?php echo $row['uid']?></td>
<td><?php echo $row['username']?></td>
<td><?php echo $row['age']?></td>
</tr>
<?php
}
?>
</table>


