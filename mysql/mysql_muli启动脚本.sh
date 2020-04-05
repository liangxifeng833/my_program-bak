 #!/bin/sh

   ##############################################################

  # Program

  #   多端口(3306,3307)mysqld_multi启动脚本

  # History

  #   2012//09/24 arkulo

  ##############################################################

  

  export PATH=$PATH:/usr/local/mysql/bin

  

  multi="/usr/local/mysql/bin/mysqld_multi --defaults-extra-file=/etc/mysqld_multi.cnf"

  

  if [ -z “$1” ];then

      echo "Please input param(start/stop/restart) with script-file!"

      exit 0

  fi

  

  case $1 in

  "start")

      `${multi} start`

      exit 0

      ;;

  "stop")

      `${multi} stop`

      exit 0

      ;;

  "restart")

       `${multi} stop`

       if [ "$?" -eq 0 ];then

          `${multi} start`

          exit 0

       else

          echo "Start is error"

          exit 0

       fi

       ;;

  *)

      echo "Your input param is not in (start/stop/restart)"

      exit 0

      ;;

  esac

  

  exit 0    

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

把以上内容存放的/etc/init.d/mysql_multid文件中
chmod -R 755 /etc/mysql_multid 
chkconfig --add mysql_multid  //目的是在 /etc/rc.d/rcN.d文件中自动创建自启动软件文件。
lxf@lxf-desktop:~$ ll /etc/rc2.d | grep mysql_multid
lrwxrwxrwx   1 root root    22 2012-10-25 23:38 S02mysql_multid -> ../init.d/mysql_multid*
ubuntu系统中只有一个init.d文件，也就是/etc/init.d ,而centos系统中却有两个，/etc/init.d 和 /etc/rc.d/init.d,其实都是一样的，没区别：
/etc/init.d是/etc/rc.d/init.d软链接(soft link). ll /etc/init.d lrwxrwxrwx 1 root root init.d -> rc.d/init.d
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

chkconfig 使用范例：
chkconfig --list        #列出所有的系统服务
chkconfig --add httpd        #增加httpd服务
chkconfig --del httpd        #删除httpd服务
chkconfig --level httpd 2345 on        #设置httpd在运行级别为2、3、4、5的情况下都是on（开启）的状态
chkconfig --list        #列出系统所有的服务启动情况
chkconfig --list mysqld        #列出mysqld服务设置情况
chkconfig --level 35 mysqld on        #设定mysqld在等级3和5为开机运行服务，--level 35表示操作只在等级3和5执行，on表示启动，off表示关闭
chkconfig mysqld on        #设定mysqld在各等级为on，“各等级”包括2、3、4、5等级

如何增加一个服务：
1.服务脚本必须存放在/etc/ini.d/目录下；
2.chkconfig --add servicename
    在chkconfig工具服务列表中增加此服务，此时服务会被在/etc/rc.d/rcN.d中赋予K/S入口了；
3.chkconfig --level 35 mysqld on
    修改服务的默认启动等级。
