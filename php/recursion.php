<?php
/*
 * desc:递归算法的练习
 * author:liangxifeng
 * date:2013-01-30
 */
function sum($n)
{
    if($n>1)
    {
        $tmp = sum($n-1)+$n;
        echo $n.' ';
        return $tmp;
    }else
    {
        echo '1 ';
        return 1;
    }
}
//echo sum(15);

//递归打印层级目录
function path($path,$lev=1)
{
    $dh = opendir($path);
    while($row = readdir($dh))
    {
        if('.'==$row || '..'==$row)
        {
            continue;
        }
        echo str_repeat('&nbsp;&nbsp;',$lev).$row.' ';
        if(is_dir($path.'/'.$row))
        {
            path($path.'/'.$row,$lev+1);
        }
    }
    closedir($dh);
}
//path('./');
//递归创建级联目录
function mk_dir($path)
{
    //运气好，如果该目录存在，直接返回
    if(is_dir($path))
    {
        return;
    }
    //运气一般，目录的父目录存在，那么就直接创建
    if(is_dir(dirname($path)))
    {
        return mkdir($path);
    }
    //运气不好，父目录也不存在，那么就先创建父目录
    mk_dir(dirname($path));
    return mkdir($path);
}
//echo mk_dir('./aa/bb')?'ok':'no';
//递归删除目录
function del_dir($path)
{
    if(!is_dir($path))
    {
        return null;
    }
    $dh = opendir($path);
    while(($row = readdir($dh))!==false)
    {
        if($row == '.' || $row == '..')
        {
            continue;
        }
        if(is_dir($row))
        {
            del_dir($path.'/'.$row);
        }else
        {
            unlink($path.'/'.$row);
        }
    }
    closedir($dh);//打开的目录必须关闭，否则无法删除
    rmdir($path);

    echo '删除了'.$path.'
        ';
    return true;
}

/*
 * desc: 递归练习无限级分类
 * date:2013-01-31
 * */
header("Content-type:text/html;charset=utf-8");
$arr = array(
    0 => array('id' => 1, 'name' => '新闻', 'fid' => 0),
    1 => array('id' => 2, 'name' => '小说', 'fid' => 0),
    2 => array('id' => 3, 'name' => '中国', 'fid' => 0),
    3 => array('id' => 4, 'name' => '国内新闻', 'fid' => 1),
    4 => array('id' => 5, 'name' => '国外新闻', 'fid' => 1),
    5 => array('id' => 6, 'name' => '体育新闻', 'fid' => 4),
    6 => array('id' => 7, 'name' => '篮球新闻', 'fid' => 6),
    7 => array('id' => 8, 'name' => '综艺新闻', 'fid' => 6),
    8 => array('id' => 9, 'name' => '美食新闻', 'fid' => 5),
    9 => array('id' => 10, 'name' => '长篇小说', 'fid' => 2),
    10 => array('id' => 11, 'name' => '短篇小说', 'fid' => 2),
    11 => array('id' => 12, 'name' => '如果你也听说过', 'fid' => 3)
);
show_cate($arr,0);

function show_cate($arr,$fid,$lev=1)
{
    foreach( $arr as $k=>$v )
    {
        if( $v['fid'] == $fid )
        {
            echo str_repeat('&nbsp;&nbsp;',$lev).$v['name'].' ';
            show_cate($arr,$v['id'],$lev+1);
        } 

    }
}

