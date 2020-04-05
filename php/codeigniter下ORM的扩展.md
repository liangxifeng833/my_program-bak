## 一，什么是ORM?
* Object Relation Mapping的简写，一般称作“对象关系映射”。
* 在Web开发中最常用于和关系型数据库交互的地方。接口、中间件、库、包，你都可以这么称呼它。
* 比如：MySQL的一张表映射成一个PHP类（模型model），表的字段就是这个类的成员变量。那么这个中间操作就是ORM。


> 相信大家都知道，codeigniter是一个轻量级的框架，并不支持ORM，那么以下是本人根据自己的实际项目，在codeigniter上做的ORM扩展．


## 二，在ci本身连接数据库基础上扩展
* system/database/drivers/mysql 目录下新建　curd_driver.php 让其继承　mysql_driver,也就是扩展mysql的数据库驱动；
* 在curd_driver.php中新增getObj方法，在getObj方法中new具体实体类, 通过调用parent::get()方法查询数据库数据, 然后做到数据库数据映射为实体类对象并返回，使用方式：

```
$this->db->from('wiki_key')->where(array('id'=>$wikiKeyId))->order_by('id','desc')->limit(1)->initAttr(array(1));                          
$rowObj = $this->db->getObj();
```
* 在curd_driver.php中新增save(obj)保存记录,对象id非空则修改,否则新增操作, 新增destory(obj)方法删除对象，使用方式：

```
//保存对象
$rowObj->name='zhangsan';
$res = $this->db->save($rowObj);
//销毁对象
$res = $this->db->destory($rowObj);
```
* 实体类文件写在libraris目录下，统一继承ORM抽象类，每个实体类包含所有数据表属性；

* system/database/DB.php 140修改，判断如果ci使用的数据库驱动是mysql，则将加载mysql_driver修改为加载curd_driver，具体如下：
```
 require_once(BASEPATH.'database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');    
//liangxifeng 2015-06-05  添加ORM控制类
$params['dbdriver_tmp'] = $params['dbdriver'];
if($params['dbdriver']=="mysql")
   {  
      　require_once(BASEPATH.'database/drivers/'.$params['dbdriver'].'/curd_driver.php');
        $params['dbdriver_tmp'] = "curd";
    }   
    // Instantiate the DB adapter
    $driver = 'CI_DB_'.$params['dbdriver_tmp'].'_driver';
    $DB = new $driver($params);
``` 

### 具体实现图解如下：

![ci-orm-class](https://raw.githubusercontent.com/liangxifeng833/my_program/master/images/class/ci-orm-class.jpeg)
![ci-orm-squence](https://raw.githubusercontent.com/liangxifeng833/my_program/master/images/class/ci-orm-squence.png)

## 三，在ci基于REST的三层架构中的BLL层扩展
* 在libraries中新增REST_Curd.php让其继承REST_Client.php, 重写父类的get方法，在get中new具体实体类, 通过调用parent::get()方法调用远程DAL数据, 然后做到DAL数据映射为实体类对象并返回，使用方式：

```
//查询多条数据
$inParamList = array('data'=>array('where'=>array('batch_id >= '=>1), 'order'=>'batch_id asc','limit'=>10));
$inParamList['type'] = 'list';
$batchArrayObj = $this->rest_client->get('ticket/ticket_batchs',$inParamList,1);
//查询单条数据
$batchRowObj = $this->rest_client->get('ticket/ticket_batch',array('id'=>1,'field'=>'batch_id,batch_price,batch_name'),1);
```

* 实体类文件写在libraris目录下，实体类需要包含所有数据表结构字段属性，统一继承ORM抽象类；
* 在ORM类中做对象的保存save() 和　对象销毁destroy()操作，使用方式：

```
//在原有查询数据对象基础上save
$batchRowObj->batch_name='lisi';
$this->batchRowObj->save();
//或new空对象进行save
$this->load->library('ticket/ticket_batch',array(),'batchObj');
$this->batchObj->batch_name = 'test2';
$this->batchObj->save();
//销毁对象
$this->batchObj->destroy();
```

### 具体实现图解如下：

![ci-orm-bll-class](https://raw.githubusercontent.com/liangxifeng833/my_program/master/images/class/ci-orm-bll-class.jpeg)
![ci-orm-bll-squence](https://raw.githubusercontent.com/liangxifeng833/my_program/master/images/class/ci-orm-bll-squence.png)
