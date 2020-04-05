//index.js
//获取应用实例
var app = getApp()
//豆瓣排名前250名电影
//var apiUrl = "http://guangzheng.ren/test/lxf/returnJson";
var apiUrl = "https://api.douban.com/v2/movie/top250";
//var apiUrlDetail = "https://api.douban.com/v2/movie/subject/";
Page({
    data: {
       title:'加载中...',
       movies: [],
       serviceState:'未返回',
    },
    onLoad:function()
    {
        var that=this;
        //加载层
        wx.showToast({
            title:'加载中...',
            icon:'loading',
            duration:10000
        });
        //请求豆瓣前250名电影
        wx.request({
            url: apiUrl, //仅为示例，并非真实的接口地址
            data: {lan:'php',y:'w'},
            header: {
                "Content-Type": "application/x-www-form-urlencoded"  
            },
            method:"GET",
            success: function(res) {
                console.log(res.data.count);
                console.log(res.data.title);
                //关闭加载层
                wx.hideToast();
                var data = res.data;
                that.setData({
                    title:data.title,
                    movies:data.subjects
                });
            }
        });
    }
})
