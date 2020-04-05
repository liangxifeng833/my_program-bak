//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    motto: '你好',
    userInfo: {}
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  //点击按钮触发轻巧事件，修改motto内容
  changeContent:function(){
    this.setData({
      motto:'我是修改后的内容'
    });
  },
  //页面加载完毕执行
  onLoad: function () {
    console.log('onLoad')
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function(userInfo){
      //更新数据
      that.setData({
        userInfo:userInfo
      })
    })
  }
})
