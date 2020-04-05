var jiafa = function(a,b)
{
    return a+b;
}

var minus = function(a,b)
{
    return a-b;
}

//抛出模块接口方法
exports.add = jiafa;
exports.multi = function(a,b)
{
    return a*b;
}
module.exports.multi = function(a,b)
{
    return a+b;
}
