console.log('我是common.js');
function sayHello(name)
{
    console.log('hello '+name);
}
//对外暴露接口
module.exports = {
    sayHello:sayHello
}