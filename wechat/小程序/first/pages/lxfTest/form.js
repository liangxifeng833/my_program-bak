//获取小程序全局实例
var app = getApp();
const date = new Date();
const years = [];
const months = [];
const days = [];
for (let i = 1990; i <= date.getFullYear(); i++) {
      years.push(i)
}
for (let i = 1 ; i <= 12; i++) {
      months.push(i)
}
for (let i = 1 ; i <= 31; i++) {
      days.push(i)
}

//获取豆瓣上的一本书地址
var apiUrl="https://book.douban.com/subject/26933142/?icn=index-editionrecommend";
Page({
  data: {
    focus: false,
    inputValue: '',
    citys:["北京","上海","广州","深圳"],
    index:0,
    time:"09:01",
    date:"2016-11-01",
    years: years,
    year: date.getFullYear(),
    months: months,
    month: 2,
    days: days,
    day: 2,
    year: date.getFullYear(),
    value: [9999, 1, 1]
  },
  bindButtonTap: function() {
    this.setData({
      focus: true
    })
  },
  bindKeyInput: function(e) {
    this.setData({
      inputValue: e.detail.value
    })
  },
  bindReplaceInput: function(e) {
    var value = e.detail.value
    var pos = e.detail.cursor
    if(pos != -1){
      //光标在中间
      var left = e.detail.value.slice(0,pos)
      //计算光标的位置
      pos = left.replace(/11/g,'2').length
    }

    //直接返回对象，可以对输入进行过滤处理，同时可以控制光标的位置
    return {
      value: value.replace(/11/g,'2'),
      cursor: pos
    }

    //或者直接返回字符串,光标在最后边
    //return value.replace(/11/g,'2'),
  },
  bindHideKeyboard: function(e) {
    if (e.detail.value === '123') {
      //收起键盘
      wx.hideKeyboard()
    }
  },
  //下拉选框选择城市
  bindPickerChange:function(e) {
      console.log(e.detail.value);
      this.setData({
          index:e.detail.value
      });
  },
  //下拉选框选择时间
  bindTimeChange:function(e) {
      console.log(e.detail.value);
      this.setData({
          time:e.detail.value
      });
  },
  //下拉选框选择日期
  bindDateChange:function(e) {
      console.log(e.detail.value);
      this.setData({
          date:e.detail.value
      });
  },
  bindChange: function(e) {
      const val = e.detail.value
      console.log(val);
      this.setData({
          year: this.data.years[val[0]],
          month: this.data.months[val[1]],
          day: this.data.days[val[2]]
    });
  },
  //confirm消息提示框
  showConfirm:function(e){
      wx.showModal({
        title: '提示',
        content: '这是一个模态弹窗',
        success: function(res) {
          console.log(res);
          if (res.confirm) {
                console.log('用户点击确定');
          }else{
              console.log('用户点击了取消');
          }
        }
      });
  },
  //消息提示框
  showToast:function(e){
      wx.showToast({
        title: '正在读取',
        icon: 'loading',
        duration: 10000
      });
      //请求豆瓣读书
      wx.request({
          url: apiUrl, //仅为示例，并非真实的接口地址
          data: {},
          header: { 'content-type': 'application/json'},
          success: function(res) {
             console.log(res.data)
             //数据成功取回，去掉加载层
             wx.hideToast();
          }
      });
  }


})
