/*
 * js回调函数
 */
function testA(param)
{
    console.log(param);
}

function we(fun,param)
{
    param = param + 'is cool!';
    fun(param);
}
//匿名回调
we(function(param){
    console.log(param);
},'lisi '); //输出：　lisi is cool

//指定函数名回调
we(testA,'zhangsan ');//输出： zhangsan is cool
