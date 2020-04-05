###MyISAM存储引擎
* MyISAM 的索引不论是 Primary Key 还是普通 Index，存储结构都基本一样，基本结构都是B-Tree；
* MyISAM一个表生成3个文件，分别是（如表：test）：test.frm(表结构)、test.MYD（数据，就是数据库中的每个行）、test.MYI（索引）；
* mysql服务器会先到test.MYI文件中找出数据存储的位置指针 (主键和普通索引结构`一致`，也就是说在索引文件的所有结构中的所有结点都不存真实数据，分支结点存索引`主键`或`普通`索引，叶子结点存 `索引值+数据物理地址指针`)，根据索引文件中叶子存放的指针地址再到test.MYD中取出数据。
* MyISAM主键索引原理：
![MyISAM-1](http://7xirg5.com1.z0.glb.clouddn.com/myisam-1.png)
 + 这里设表一共有三列，假设我们以Col1为主键，则图8是一个MyISAM表的主索引（Primarykey）示意。可以看出MyISAM的索引文件仅仅保存数据记录的地址。在MyISAM中，`主索引和辅助索引`（Secondarykey）在结构上 `没有任何区别`，只是主索引要求key是唯一的，而辅助索引的key可以重复。

* MyISAM普通索引原理: 如果我们在Col2上建立一个辅助索引，则此索引的结构如下图所示：
![MyISAM-2](http://7xirg5.com1.z0.glb.clouddn.com/myisam-2.png)
 + 同样也是一颗B+Tree，data域保存数据记录的地址。因此，MyISAM中索引检索的算法为首先按照B+Tree搜索算法搜索索引，如果指定的Key存在，则取出其data域的值，然后以data域的值为地址，读取相应数据记录。

* MyISAM的索引方式也叫做 `非聚集` 的，之所以这么称呼是为了与InnoDB的聚集索引区分。

###InnoDB存储引擎
* 虽然InnoDB也使用B+Tree作为索引结构，但具体实现方式却与MyISAM截然不同。
* InnoDB的数据文件本身就是索引文件
* 表数据文件本身就是按B+Tree组织的一个索引结构，这棵树的叶节点data域保存了完整的数据记录。这个索引的key是数据表的主键，因此InnoDB表数据文件本身就是主索引。
* InnoDB主健索引原理：
![InnoDB-1](http://7xirg5.com1.z0.glb.clouddn.com/innodb-1.png)
 + 以上是InnoDB主索引（同时也是数据文件）的示意图，可以看到叶节点包含了完整的数据记录。这种索引叫做 `聚集索引`。因为InnoDB的数据文件本身要按主键聚集，所以InnoDB要求表必须有主键（MyISAM可以没有），如果没有显式指定，则MySQL系统会自动选择一个可以 `唯一` 标识数据记录的列作为`主键`，如果不存在这种列，则MySQL自动为InnoDB表生成一个`隐含字段作为主键`，这个字段长度为6个字节，类型为长整形。
* InnoDB普通索引原理：引用主键作为data域。例如下图定义在Col3上的一个辅助索引
![InnoDB-2](http://7xirg5.com1.z0.glb.clouddn.com/innodb-2.png)
 + 聚集索引这种实现方式使得按主键的搜索十分高效，但是辅助索引（普通索引）搜索需要 `检索两遍索引`：*首先检索辅助索引获得主键，然后用主键到主索引中检索获得记录*

###什么是聚集索引和非聚集索引？
数据记录本身被存于索引（一颗B+Tree）的叶子节点上，这种索引叫聚集索引，InnoDB使用聚集索引。反之则为非聚集索引，MyISAM使用非聚集索引，它的叶子节点的data域指向数据记录的地址，而不是存储数据记录本身；

###聚集索引还需注意：
 1. 如果声声明了主键(primary key)，则这个列会被做为聚集索引。
 2. 如果没有声明主键，则会用一个唯一且不为空的索引列做为主键，成为此表的聚集索引。 
 3. 上面二个条件都不满足，InnoDB会自己产生一个虚拟的字段作为聚集索引，这个字段长度为6个字节，类型为长整形。

###MySql有几种索引？
* 主键索引； 
* 唯一索引；
* 普通索引；
* 联合索引；
* 全文索引。

###参考资料
[[MySQL索引背后的数据结构及算法原理](http://blog.codinglabs.org/articles/theory-of-mysql-index.html)](http://blog.codinglabs.org/articles/theory-of-mysql-index.html)

