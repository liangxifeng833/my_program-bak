//index.js
//获取应用实例
var app = getApp()
//豆瓣排名前250名电影
var apiUrl = "https://api.douban.com/v2/movie/subject/";
Page({
    data: {
       movie: []
    },
    onLoad:function(params)
    {
        console.log('参数id='+params.id);
        var that=this;
        //加载层
        wx.showToast({
            title:'加载中...',
            icon:'loading',
            duration:10000
        });
        //请求豆瓣电影详情页
        wx.request({
            url: apiUrl+params.id, //仅为示例，并非真实的接口地址
            header: {
                'content-type': 'application/x-www-form-urlencoded'
            },
            method:"GET",
            success: function(res) {
                console.log(res.data);
                //关闭加载层
                wx.hideToast();
                that.setData({movie:res.data});
            }
        });
    }
});
