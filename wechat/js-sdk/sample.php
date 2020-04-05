<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx353001766e113d93", "c95fa7cdfe1888e744c5485a9dbde278");
//$jssdk = new JSSDK("wx087ca61df9e74bb0", "b63d0fdc12be7844b008831c05936c16");
//普通js-sdk签名
$signPackage = $jssdk->getSignPackage(1);
//微信卡券js-sdk签名
$cardId = 'pNKvmjjGdxeYw_SVEnvYM1aHWxWw';//非预存
$cardId = 'pNKvmjh1lHNTIyfkOJlFFeDCKhTs';//预存
//$cardId = 'p4J5DuFjynZwKZ3YIfZUJsDIYOaE';//预存
$cardArr['cardId'] = $cardId;
$code = '';
$cardArr['code'] = $code;
//微信卡券签名
$cardSign = $jssdk->getSignPackage(2,$cardArr);	
$timestamp = $cardSign["timestamp"];
$signature = $cardSign["signature"];
$nonceStr = $cardSign["nonceStr"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>js-sdk-测试</title>
  <!-- 添加适应手机端 -->  
  <meta name="viewport" content="width=device-width,initital-scale-1">
</head>
<body>
    <button id="btn">获取位置信息</button>
    <button id="loc">在地图上显示</button>
    <button id="check">检查接口是否可用</button>
    <button id="shareFriend">分享给朋友</button>
    <button id="shareFriendTimeLine">分享到朋友圈</button>
    <button id="shareQQ">分享到QQ</button>
    <button id="shareWeiBo">分享到微博</button>
    <button id="addCard">添加卡券到卡包</button>
    
</body>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
        "openLocation",
        'checkJsApi',    
        'onMenuShareTimeline',    
        'onMenuShareAppMessage',    
        'onMenuShareQQ',    
        'onMenuShareWeibo',    
        'addCard'
    ]
  });
  wx.ready(function () {
      //添加卡券到卡包
      document.getElementById("addCard").onclick = function()
      {
	 alert("添加卡券");
          wx.addCard({
              cardList:[
                  {
			cardId: '<?php echo $cardId ?>',
                  	cardExt: '{"code":"<?php echo $code;?>","timestamp":"<?php  echo $timestamp;?>","signature":"<?php echo $signature;?>","nonce_str":"<?php echo $nonceStr;?>"}'
		  }
              ],
              success: function (res) {
                          alert('已添加卡券：' + JSON.stringify(res.cardList));
              },
/*
              cancel: function (res) {
                          alert("用户点击取消:"+JSON.stringify(res))
              },
              fail: function(res){
                  alert("调用失败"+JSON.stringify(res))
              }
*/
          });
      }
    // 在这里调用 API
      //点击获取位置触发
      var latitude = '';  //经度
      var longitude = ''; //维度
      document.getElementById("btn").onclick = function()
      {
          wx.getLocation({
              type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                  success: function (res) {
                      latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                      longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                      var speed = res.speed; // 速度，以米/每秒计
                      var accuracy = res.accuracy; // 位置精度
                  }
          });
      }
      //点击在地图上显示触发
      document.getElementById("loc").onclick = function()
      {
          wx.openLocation({
              latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
                  longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
                  name: 'liangxifeng', // 位置名
                  address: '北京北京', // 地址详情说明
                  scale: 10, // 地图缩放级别,整形值,范围从1~28。默认为最大
                  infoUrl: 'http://www.ljlj.cc' // 在查看位置界面底部显示的超链接,可点击跳转
          });
      }
      //检查接口是否可用
      document.getElementById("check").onclick = function()
      {
          wx.checkJsApi({
              jsApiList: ['chooseImage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                  success: function(res) {
                      // 以键值对的形式返回，可用的api值true，不可用为false
                      //         // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                      //             
                  }
          });
      }


 // 2. 分享接口
  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
  document.getElementById("shareFriend").onclick = function () {
    wx.onMenuShareAppMessage({
      title: '互联网之子',
      desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
      trigger: function (res) {
        alert('2用户点击发送给朋友');
      },
      success: function (res) {
        alert('3已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('1已注册获取“发送给朋友”状态事件');
  };
  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
  document.getElementById("shareFriendTimeLine").onclick = function () {
    wx.onMenuShareTimeline({
      title: '互联网之子',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
      trigger: function (res) {
        alert('用户点击分享到朋友圈');
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('1已注册获取“分享到朋友圈”状态事件');
  };
  // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
  document.getElementById("shareQQ").onclick  = function () {
    wx.onMenuShareQQ({
      title: '互联网之子',
      desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
      trigger: function (res) {
        alert('用户点击分享到QQ');
      },
      complete: function (res) {
        alert(JSON.stringify(res));
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('已注册获取“分享到 QQ”状态事件');
  };
  
  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
  document.getElementById("shareWeiBo").onclick = function () {
    wx.onMenuShareWeibo({
      title: '互联网之子',
      desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
      trigger: function (res) {
        alert('用户点击分享到微博');
      },
      complete: function (res) {
        alert(JSON.stringify(res));
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
    alert('已注册获取“分享到微博”状态事件');
  };

  });
</script>
</html>
