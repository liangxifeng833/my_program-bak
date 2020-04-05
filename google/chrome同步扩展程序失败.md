### 同步扩展程序失败解决办法
>  * 公司电脑: ubuntu 14.04
>  * 家里电脑：ubuntu 12.04
 
两台电脑同样安装 google-chrome-stable_current_i386.deb, 可是回到家里的电脑的chrome登录google后，书签同步正常，可扩展却无法同步，也没有任何错误提示，等了很久也没有同步成功，于是查看了一下家里电脑的chrome版本是
```
sudo dpkg -l google-chrome-stable
ii  google-chrome-stable                         45.0.2454.85-1                              The web browser from Google
```

[chrome 各个版本下载地址](http://mirror.pcbeta.com/google/chrome/deb/pool/main/g/google-chrome-stable/)

* 于是我下载了 google-chrome-stable_35.0.1916.114-1_i386.deb 
* 卸载 45.0.2454.85-1

```
sudo dpkg -P google-chrome-stable
rm -rf  ~/.config/google-chrome/
``` 
* 安装 35.0.1916.114-1

```
sudo dpkg -i google-chrome-stable_35.0.1916.114-1_i386.deb 
```

* 启动chrome, 登录google账号，同步的顺序是 先书签 后扩展，ok搞定, 这个问题纠结了我半天的时间，所以再次分析一下原因；

> 为什么会出现以上情况，自己分析以下，最开始用chrome的时候可能是 ubuntu12.04 google-chrome-stable_35.0.1916.114-1_i386.deb 这个版本，后来公司换电脑新装了 ubuntu 14.04，对应chrome是chrome-stable_current_i386.deb也就是当前最新版本，在后来因为家里pc配置低安装了ubuntu12.04，对应的chrome也安装了 chrome-stable_current_i386.deb，这个时候同步就无法同步扩展了，最终感觉是因为ubuntu12.04不适合google的最新版本，所以我将ubuntu12.04下的chrome降级为35.0.1916.114-1就一切正常了。
