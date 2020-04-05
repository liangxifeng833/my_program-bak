//app.js
App({ //注册一个小程序
  //小程序初始化时候触发
  onLaunch: function () {
    //调用API从本地缓存中获取数据
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)
  },
  //小程序显示的时候触发  
  onShow:function(){
    console.log("生命周期函数，监听小程序显示的时候触发");
    //alert(123);
  },
  //小程序隐藏的时候触发  
  onHide:function(){
    console.log("生命周期函数，监听小程序隐藏的时候触发");
    //alert(123);
  },
  //全局方法
  getUserInfo:function(cb){
    var that = this
    if(this.globalData.userInfo){
      typeof cb == "function" && cb(this.globalData.userInfo)
    }else{
      //调用登录接口
      wx.login({
        success: function () {
          wx.getUserInfo({
            success: function (res) {
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
        }
      })
    }
  },
  //全局属性
  globalData:{
    userInfo:null,
    pass:"123456"
  }
})