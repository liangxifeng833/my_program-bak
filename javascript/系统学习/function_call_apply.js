/*
 * ECMAScript规范给所有函数都定义了Call()与apply()两个方法，
 * call与apply的第一个参数都是需要调用的函数对象，在函数体内这个参数就是this的值，改变this的上下文
 * 就是为了改变函数体内部 this 的指向而存在的
 * 剩余的参数是需要传递给函数的值，call与apply的不同就是call传的值可以是任意的，而apply传的剩余值必须为数组
 */
//在javascript OOP中，我们经常会这样定义：
function cat()
{

}
//初始化函数原型
cat.prototype = {
    food:"fish",
    say:function()
    {
        console.log("I love "+this.food);
    }
}

var blackCat = new cat;
//blackCat.say();

/*
 * 但是如果我们有一个对象whiteDog = {food:"bone"},我们不想对它重新定义say方法
 * 那么我们可以通过call或apply用blackCat的say方法：blackCat.say.call(whiteDog);
 * 所以，可以看出call和apply是为了动态改变this而出现的，
 * 当一个object没有某个方法，但是其他的有，我们可以借助call或apply用其它对象的方法来操作
 */
var whiteDog = {
    food:"bone"
};
blackCat.say.call(whiteDog);
//函数的三种调用方式
/*
obj.myFunc(); 
myFunc.call(obj, arg); 
myFunc.apply(obj, [arg1, arg2..]); 
*/

/*
 * 继承所用
 */
function Pet(words)
{
    this.words = words; 
    this.speak = function()
    {
        console.log('speak:' + this.words); 
    }
}
//Dog对象继承Pet对象的方法和属性
function Dog(words)
{
    Pet.call(this, words); 
}
var dog = new Dog('wang'); 
console.log(dog.words); //输出:wang
dog.speak();            //输出:speak: wang
