var order = ["a1","b1","c1"];
var index = 0;
var processNum = 0; //进度条定时器
Page({
    data:{
        toView:"a1",
        imgUrls:["../../images/swiper-1.jpg",
                "../../images/swiper-2.jpg",
                "../../images/swiper-3.jpg"
        ],
        inter:1000,
        iconTypes:[
                'success', 'info', 'warn', 'waiting', 'safe_success', 'safe_warn',
                'success_circle', 'success_no_circle', 'waiting_circle', 'circle', 'download',
                'info_circle', 'cancel', 'search', 'clear'
        ],
        process:0,
        buttonBlo:true,
        country: [
            {name: 'USA', value: '美国'},
            {name: 'CHN', value: '中国', checked: 'true'},
            {name: 'BRA', value: '巴西'},
            {name: 'JPN', value: '日本'},
            {name: 'ENG', value: '英国'},
            {name: 'TUR', value: '法国'}
        ]
    },
    //滚动条滚到上或左的时候触发
    scrolltoupper:function(event)
    {
        console.log("出发了toupper");
        console.log(event);
    },
    //滚动条滚到下或右的时候触发
    scrolltolower:function(event)
    {
        console.log("触发了tolower");
        console.log(event);
    },
    //点击切换按钮触发
    tapChange:function()
    {
        index++;
        if(index > order.length-1)
        {
            index = 0;
        }
        this.setData({
            toView:order[index]
        });
    },
    //swiper 的bindchange滚动图片触发
    swiperChange:function(e)
    {
        //console.log(e);
    },
    //滑动组件事件触发
    sliderChange:function(e)
    {
        var sliderValue = e.detail.value;
        this.setData({
            inter:sliderValue
        });
    },
    //onload初始化进度条效果
    onLoad:function()
    {
        
        var that = this;
        var timer = setInterval(function(){
            processNum++;
            if(processNum>=100)
            {
                clearInterval(timer)
            }
            that.setData({
                process:processNum
            });
        },30);
    },
    //控制按钮显示
    changeButton:function()
    {
        this.setData({
            buttonBlo:!this.data.buttonBlo
        });
    },
    //表单提交触发
    doSubmit:function(e)
    {
        console.log("已提交表单,内容是:",e.detail.value);
    },
    //点击重置按钮触发
    doReset:function()
    {
        console.log("点击了重置按钮");
    },
    //点击去往表单组件
    toFormMod:function()
    {
        wx.navigateTo({
            url: '../lxfTest/form'
        })
    }
});