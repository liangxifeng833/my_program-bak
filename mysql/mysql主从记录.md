### 一，主从的工作原理
![master-slave](https://raw.githubusercontent.com/liangxifeng833/my_program/master/images/mysql/master-slave.gif)
* 1. master将改变记录到二进制日志(binary log)中（这些记录叫做二进制日志事件，binary log events）, Slave根据本机的master.info文件中记录的Master的日志文件名程和具体位置，通过IO进程连接上Master并请求从指定日志文件的指定位置（或者从最开始的日志）之后的日志内容；      
* 2. Master接收到来自Slave的IO进程的请求后，通过负责复制的IO进程根据请求信息读取制定日志指定位置之后的日志信息，返回给Slave 的IO进程。返回信息中除了日志所包含的信息之外，还包括本次返回的信息已经到Master端的bin-log文件的名称以及bin-log的位置；
* 3. slave将master的binary log events拷贝到它的中继日志(relay log)；        
* 4. slave中的sql进程发现relay-log日志有改动后，根据relay.info中的relay位置，从relay-log的该位置开始重做中继日志中的事件，将sql语句在本地数据库执行。
```
[root@service mysql]# cat relay-log.info
./service-relay-bin.000002
3007731 ------------->代表relay-log文件执行的位置
mysql-bin.000008----->代表远程master端binlog
338489392----------->执行到远程master端binlog的具体位置
[root@service mysql]# cat master.info
18
mysql-bin.000008-->代表远程master端binlog
338493827--------->执行到远程master端binlog的具体位置
192.168.15.15----->远程master端ip
username---------->远程master端mysql的replication用户名
userpassword----->远程master端mysql的replication密码
3306------------->远程master端mysql端口
```

* 5. [主从配置请点击](http://blog.csdn.net/hguisu/article/details/7325124)

### 二，使用中遇到的问题
* 公司采用 A:主-> B:从(blackhole)->C:从 架构;
* 12月1日运维重启了一下C机，过了一周后12月8号发现，A机的数据已经一周没有同步到C机了，去C机器一看：
```
slave status\G
无任何信息
```
* 于是想到在C机主动连接B，先登录B机：
```
mysql> show master status;
+-------------------+----------+--------------+------------------+
| File              | Position | Binlog_Do_DB | Binlog_Ignore_DB |
+-------------------+----------+--------------+------------------+
| mysql-bin.000008 | 338242604 |              |                  |
+-------------------+----------+--------------+------------------+
```
* 然后登录C
```
CHANGE MASTER TO MASTER_HOST='B',
    -> MASTER_USER='repl',
    -> MASTER_PASSWORD='p4ssword',
    -> MASTER_LOG_FILE='mysql-bin.000008',
    -> MASTER_LOG_POS=338242604;
START SLAVE;
```
* 原本以为问题解决了，可是又一想从12.1到12.8这7天的数据并没有同步到C机，但是此时已经过去几分钟了，赶快执行
```
STOP SLAVE
```

* 后来仔细回忆主从原理，在C机的master.info文件中会保存最后一次请求B的binlog文件和位置，重启C后，会在对应目录自动生成master.info_bak文件，于是查看C机的master.info_bak 
```
[root@service mysql]# cat master.info_bak 
18
mysql-bin.000008
335481914
192.168.15.15
repl
p4ssword
3306
```
可以看到12.1最后连接B的位置是`335481914`，而我们刚刚start slave的点是　`338242604`, 两个点有差异，本以为在 start slave 到stop slave 之间在A机会有用户操作产生很多数据, 如果此时在C上从`335481914`开始请求担心会和刚刚同步的数据有冲突；

* 于是想到查看
```
mysqlbinlog service-relay-bin.000002 > /tmp/relay.sql
cat /tmp/relay.sql
151202 12:02:40 server id 1  end_log_pos 335482146     Query   thread_id=281429        exec_time=4294964863    error_code=0
use ljyun_754_merchant/*!*/;
SET TIMESTAMP=1449028960/*!*/;
INSERT INTO role (role_name, role_leader) VALUES (店长, 0)
```
可以看到在servicw-relay-bin.000002 中会记录在C上start slave 和stop　slave 之间的所有C机数据库的操作，　查看对应`end_log_pos 335482146`到B机的master的位置，根据该文件位置及具体的sql的分析，与master.info文件的对比判断从start 到　stop之间C机的所有数据库操作，然后确定只有一条数据产生，原本根据位置的加减判断有200条数据产生，最后分析binglog中的end_log_pos 335482146　并不是以１为单位累加的，`所以不要以binlog中的位置差判断数据记录的数量`；

* 最后可以放心的从12.1那天的断点开始从C上发起请求，登录C:
```
mysql> CHANGE MASTER TO MASTER_HOST='B',
    -> MASTER_USER='repl',
    -> MASTER_PASSWORD='p4ssword',
    -> MASTER_LOG_FILE='mysql-bin.000008',
    -> MASTER_LOG_POS=335481914;
mysql> START SLAVE;
mysql> show slave status\G
*************************** 1. row ***************************
               Slave_IO_State: Waiting for master to send event
                  Master_Host: 192.168.15.15
                  Master_User: repl
                  Master_Port: 3306
                Connect_Retry: 0
              Master_Log_File: mysql-bin.000008-->远程master端binlog文件名
          Read_Master_Log_Pos: 338500476----->执行到master的binlog位置
               Relay_Log_File: service-relay-bin.000002-->relay-log文件名
                Relay_Log_Pos: 3018815-->本地执行到relay-log的位置
        Relay_Master_Log_File: mysql-bin.000008
             Slave_IO_Running: Yes------------>slave向master发起请求的io进程，正常=Yes 异常=No
            Slave_SQL_Running: Yes---------->slave在本地执行sql的sql进程,正常=Yes 异常=No
              Replicate_Do_DB: 
          Replicate_Ignore_DB: mysql
           Replicate_Do_Table: 
       Replicate_Ignore_Table: 
      Replicate_Wild_Do_Table: 
  Replicate_Wild_Ignore_Table: 
                   Last_Errno: 0
                   Last_Error: 
                 Skip_Counter: 0
          Exec_Master_Log_Pos: 338500476
              Relay_Log_Space: 3018973
              Until_Condition: None
               Until_Log_File: 
                Until_Log_Pos: 0
           Master_SSL_Allowed: No
           Master_SSL_CA_File: oduct w
           Master_SSL_CA_Path: 
              Master_SSL_Cert: 
            Master_SSL_Cipher: 
               Master_SSL_Key: 
        Seconds_Behind_Master: 0
Master_SSL_Verify_Server_Cert: No
                Last_IO_Errno: 0
                Last_IO_Error: 
               Last_SQL_Errno: 0
               Last_SQL_Error: 
  Replicate_Ignore_Server_Ids: 
             Master_Server_Id: 4
1 row in set (0.00 sec)
```


**总结：mysql在赋值的时候，insert语句虽然在binlog中没有主键，但是根据本次事故的观察，insert操作是在真实数据库操作的时候，却与A机保持一致；比如有t1表为空表，则：**
 > 1. 现在断开同步，在A机上插入表t1一条记录id=1, 此时在C上t1是空表;
 > 2. 在从最新点连接同步后，id=1的记录没有同步，因为连接的点不是当时的断点; 此时在A上再次插入表t1一条记录id=2, 查看C已经同步成功，并且在C上t1表只有一条记录id=2和A保持一致;
 > 3. 在C上断点出连接成功后，查看C上的t1表有两条记录，id分别和A上t1表保持一致；
