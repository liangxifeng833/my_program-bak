//获取小程序全局实例
var app = getApp();

//获取豆瓣上的一本书地址
var apiUrl="https://book.douban.com/subject/26933142/?icn=index-editionrecommend";
Page({
  data: {
    poster: 'http://y.gtimg.cn/music/photo_new/T002R300x300M000003rsKF44GyaSk.jpg?max_age=2592000',
    name: '此时此刻',
    author: '许巍',
    src: 'http://ws.stream.qqmusic.qq.com/M500001VfvsJ21xFqb.mp3?guid=ffffffff82def4af4b12b3cd9337d5e7&uin=346897220&vkey=6292F51E1E384E06DCBDC9AB7C49FD713D632D313AC4858BACB8DDD29067D3C601481D36E62053BF8DFEAF74C0A5CCFADD6471160CAF3E6A&fromtag=46',
    array: [
        {
            mode: 'scaleToFill',
            text: 'scaleToFill：不保持纵横比缩放图片，使图片完全适应'
        }, 
        { 
            mode: 'aspectFit',
            text: 'aspectFit：保持纵横比缩放图片，使图片的长边能完全显示出来'
        }, 
        { 
            mode: 'aspectFill',
            text: 'aspectFill：保持纵横比缩放图片，只保证图片的短边能完全显示出来'
        }, 
        { 
            mode: 'top',
            text: 'top：不缩放图片，只显示图片的顶部区域' 
        }, 
        {      
            mode: 'bottom',
            text: 'bottom：不缩放图片，只显示图片的底部区域'
        }, 
        { 
            mode: 'center',
            text: 'center：不缩放图片，只显示图片的中间区域'
        }, 
        { 
            mode: 'left',
            text: 'left：不缩放图片，只显示图片的左边区域'
        }, 
        { 
            mode: 'right',
            text: 'right：不缩放图片，只显示图片的右边边区域'
        }, 
        { 
            mode: 'top left',
            text: 'top left：不缩放图片，只显示图片的左上边区域' 
        }, 
        { 
            mode: 'top right',
            text: 'top right：不缩放图片，只显示图片的右上边区域'
        }, 
        { 
            mode: 'bottom left',
            text: 'bottom left：不缩放图片，只显示图片的左下边区域'
        }, 
        { 
            mode: 'bottom right',
            text: 'bottom right：不缩放图片，只显示图片的右下边区域'
        }
    ],
    src: 'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png'
  },
  imageError: function(e) {
      console.log('image3发生error事件，携带值为', e.detail.errMsg)
  },
  onReady: function (e) {
     // 使用 wx.createAudioContext 获取 audio 上下文 context
     this.audioCtx = wx.createAudioContext('myAudio')
               
  },
    //点击播放语音
    audioPlay: function () {
            this.audioCtx.play()
      
    },
    //点击暂停语音
    audioPause: function () {
            this.audioCtx.pause()
      
    },
    //将语音跳转到14秒的地方
    audio14: function () {
            this.audioCtx.seek(14)
                  
    },
    //将语音回复到0秒的地方
    audioStart: function () {
            this.audioCtx.seek(0)
    }
})
