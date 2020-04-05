### vim配置说明

* 参考资料：
  * http://www.cnblogs.com/RandyXu/p/3279090.html 
  * http://www.cnblogs.com/yjjptr/p/3385067.html
* 将目录 `.vim` 和配置文件 `.vimrc` 放到家目录 ~/  下；
* 自己新建文件文件，执行以下脚本 solarized.sh：
```
#!/bin/sh
case "$1" in 
    "dark")      PALETTE="#070736364242:#D3D301010202:#858599990000:#B5B589890000:#26268B8BD2D2:#D3D336368282:#2A2AA1A19898:#EEEEE8E8D5D5:#00002B2B3636:#CBCB4B4B1616:#58586E6E7575:#65657B7B8383:#838394949696:#6C6C7171C4C4:#9393A1A1A1A1:#FDFDF6F6E3E3"
        BG_COLOR="#00002B2B3636"
        FG_COLOR="#65657B7B8383"
        ;;
    "light")  PALETTE="#EEEEE8E8D5D5:#D3D301010202:#858599990000:#B5B589890000:#26268B8BD2D2:#D3D336368282:#2A2AA1A19898:#070736364242:#FDFDF6F6E3E3:#CBCB4B4B1616:#9393A1A1A1A1:#838394949696:#65657B7B8383:#6C6C7171C4C4:#58586E6E7575:#00002B2B3636"
        BG_COLOR="#FDFDF6F6E3E3"
        FG_COLOR="#838394949696"
        ;;
    *)
    echo "Usage: solarize [light | dark]"
    exit
    ;;
esac
gconftool-2 --set "/apps/gnome-terminal/profiles/Default/use_theme_background" --type bool false
gconftool-2 --set "/apps/gnome-terminal/profiles/Default/use_theme_colors" --type bool false
gconftool-2 --set "/apps/gnome-terminal/profiles/Default/palette" --type string "$PALETTE"
gconftool-2 --set "/apps/gnome-terminal/profiles/Default/background_color" --type string "$BG_COLOR"
gconftool-2 --set "/apps/gnome-terminal/profiles/Default/foreground_color" --type string "$FG_COLOR"
```
* bash solarized.sh dark
* vim ~/.bashrc ，加入export TERM=xterm-256color；
* source ~/.bashrc 
* ok...

### linux 终端的配色使用 solarized
* git clone git://github.com/seebi/dircolors-solarized.git
* cp dircolors-solarized/dircolors.256dark ~/.dircolors
* eval 'dircolors ~/.dircolors'
* 接下来下载 Solarized 的 Gnome-Terminal 配色：
```
git clone git://github.com/sigurdga/gnome-terminal-colors-solarized.git
cd gnome-terminal-colors-solarized 
bash install.sh
/set_dark.sh 或./set_light.sh，可以自由切换深色和浅色。
```

