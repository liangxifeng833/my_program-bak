### 一，语法：
```
create procedure 存储过程名字()   
(   
[in|out|inout] 参数 datatype   
)   
begin   
MySQL 语句;   
end;
```  

> MySQL 存储过程参数如果不显式指定“in”、“out”、“inout”，则默认为“in”。习惯上，对于是“in” 的参数，我们都不会显式指定。

### 二，规则

* 输入参数例子，我们选择了会话变量@x证明成功的将参数传入了改变量．


```
mysql> CREATE PROCEDURE p2(p INT) SET @x = p ;//  
Query OK, 0 rows affected (0.02 sec)  
   
mysql> CALL p2(123)//  
Query OK, 0 rows affected (0.00 sec)  
   
mysql> SELECT @x//  
+------+  
| @x   |  
+------+  
|  123 |  
+------+  
1 row in set (0.01 sec)  
```


* 输出参数的例子，我们选择会话变量@y去接收存储过程p3


```
mysql> CREATE PROCEDURE p3(OUT p INT)  
    -> SET p = -5;//  
Query OK, 0 rows affected (0.00 sec)  
   
mysql> CALL p3(@y)//  
Query OK, 0 rows affected (0.01 sec)  
   
mysql> SELECT @y//  
+------+  
| @y   |  
+------+  
|   -5 |  
+------+  
1 row in set (0.00 sec)  
```



* MySQL 存储过程名字后面的“()”是必须的，即使没有一个参数，也需要“()”

* MySQL 存储过程参数，不能在参数名称前加“@”，如：“@a int”。下面的创建存储过程语法在 MySQL 中是错误的（在 SQL Server 中是正确的）。 MySQL 存储过程中的变量，不需要在变量名字前加“@”，虽然 MySQL 客户端用户变量要加个“@”。
* MySQL 存储过程的参数不能指定默认值。
* 如果 MySQL 存储过程中包含多条 MySQL 语句，则需要 begin end 关键字。
* MySQL 存储过程中的每条语句的末尾，都要加上分号 “;”
* MySQL 存储过程中的注释：

```
/*   
这是个   
多行 MySQL 注释。   
*/ 
```
```  
declare c int; -- 这是单行 MySQL 注释 （注意 -- 后至少要有一个空格）   
if a is null then # 这也是个单行 MySQL 注释   
set a = 0;   
end if;   
...   
end; 
```

* 不能在 MySQL 存储过程中使用 “return” 关键字：

```
set c = a + b;   
select c as sum;   
/*   
return c; -- 不能在 MySQL 存储过程中使用。return 只能出现在函数中。   
*/   
end;  
```

* 调用 MySQL 存储过程时候，需要在过程名字后面加“()”，即使没有一个参数，也需要“()”

```
call pr_no_param();  
```

### 三，实例：
* 批量添加数据（预制原始券）

```
/*
* 预制原始券
-- @author: liangxifeng
-- @date  : 2015-11-25
-- @param : int - @ticketCount  - 要预制的券数量
-- @return: 成功返回:成功预制数量, 失败:返回具体信息
-- @php调用: mysql_fetch_assoc(mysql_query("CALL initTicket(100)"));
*/
DELIMITER $$
DROP PROCEDURE IF EXISTS `initTicket` $$
CREATE PROCEDURE initTicket( IN ticketCount INT ) 
    BEGIN 
    DECLARE i INT DEFAULT 0;              	-- 计数器
    DECLARE returnMsg VARCHAR(50) DEFAULT '';   -- 返回值信息
    DECLARE rowCount int DEFAULT 0;             -- 操作sql的时候影响行数
    IF ticketCount >= 10000 || ticketCount=0 THEN
	  SET returnMsg = 'paramError';
          SELECT returnMsg;
    ELSE
	  outer_label:BEGIN
	  START TRANSACTION;
	  WHILE i < ticketCount DO
		SET i=i+1;
		INSERT INTO `ticket_main`   (`ticket_status`,`ticket_add_time`) VALUES (0,now());
		SELECT row_count() INTO rowCount;
		IF rowCount<=0 THEN
			LEAVE outer_label;			
		END IF; 				
	  END WHILE;
	
	  END outer_label;  -- 只要是在outer_label代码块内 任意位置 Leave outer_label,那么Leave后的代码将不再执行 

	  IF i=ticketCount THEN
		COMMIT;
		SET returnMsg = i;
          ELSE
		ROLLBACK;
		SET returnMsg = 'error';
   	  END IF;
	  SELECT returnMsg;
    END IF;
END $$
DELIMITER ;
```
[代码实例](https://github.com/liangxifeng833/my_program/blob/master/mysql/procedure_demo.sql)
