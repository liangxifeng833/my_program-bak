//index.js
//获取应用实例
var app = getApp()
//搜索电影url
var apiUrl = "https://api.douban.com/v2/movie/search?q=";
Page({
    data: {
       movies: [],
       serviceState:'未返回',
    },
    //搜索操作
    search:function(e){
        if(!e.detail.value)
        { 
            return;
        }
        var that = this;
        //加载层
        wx.showToast({
            title:'加载中...',
            icon:'loading',
            duration:10000
        });
        var searchUrl = apiUrl+e.detail.value;
        console.log(searchUrl);
        wx.request({
            url:searchUrl, //仅为示例，并非真实的接口地址
            data: {lan:'php',y:'w'},
            header: {
                "Content-Type": "application/x-www-form-urlencoded"  
            },
            method:"GET",
            success: function(res) {
                console.log('搜索成功');
                console.log(res.data);
                //关闭加载层
                wx.hideToast();
                var data = res.data;
                that.setData({
                    movies:data.subjects
                });
            }
        });
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
            url:'https://api.douban.com/v2/movie/top250', //仅为示例，并非真实的接口地址
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
