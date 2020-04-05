//获取小程序全局实例
var app = getApp();
//require包含指定路径js文件
var common = require("../../common/common.js");
Page({
    data: {
        name: 'liangxifeng',
        pass:null,
        bol:false,
        chengji:76,
        id:18,
        arr:[1,2,3,4,5,6],
        obj:{a:'wangwu',b:'zhaoliu'},
        objectArray:[
            {id:1,unique:'unique_1'},
            {id:2,unique:'unique_2'},
            {id:3,unique:'unique_3'}
        ]
    },
    //页面加载后执行
    onLoad:function(){
        this.setData ({
            pass:app.globalData.pass
        });
    },
    //跳转到首页
    toIndex:function(){
        wx.navigateTo({
          url: '../navi/navi',
          success: function(res){
            // success
          },
          fail: function() {
            // fail
          },
          complete: function() {
            // complete
          }
        });
    },
    say:function(){
        common.sayHello(this.data.name)
    },
    //点击页面是否显示按钮出发
    show:function(){
        console.log("isShow")
        this.setData({
            bol:!this.data.bol
        })
    },
    switch:function(e){
        const length = this.data.objectArray.length;
        for(let i=0; i<length; ++i)
        {
            const x = Math.floor(Math.random()*length);
            const y = Math.floor(Math.random()*length);
            const temp = this.data.objectArray[x];
            this.data.objectArray[x] = this.data.objectArray[y];
            this.data.objectArray[y] = temp;
        }
        this.setData({
            objectArray:this.data.objectArray
        })
        console.log(this.data.objectArray);
    },
    outerTap:function(){
        console.log('事件触发了outer Tap');
    },
    innerTap:function(){
        console.log('事件触发了inner Tap');
    },
    middleTap:function(){
        console.log('事件触发了middle Tap');
    }
})