/*
 * 事件监听练习
 */

var events = require("events");
//创建事件监听器的一个对象
var emitter = new events.EventEmitter();
//监听事件some_event

emitter.on("some_event",function(){
    console.log("listen1:事件触发,调用此回调函数");
})
emitter.on("some_event",function(){
    console.log("linsten2:事件触发,调用此回调函数");
})
//触发事件
emitter.emit("some_event");
