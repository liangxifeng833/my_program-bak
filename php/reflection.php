<?php
class Person 
{    
/**  
** For the sake of demonstration, we"re setting this private 
**/   
    private $_allowDynamicAttributes = false;  

    /** type=primary_autoincrement */  
    protected $id = 0;  

    /** type=varchar length=255 null */  
    protected $name;  

    /** type=text null */  
    protected $biography;  
    public $ex = 12;

    public function getId()  
    {  
        return $this->id;  
    }  
    public function setId($v)  
    {  
        $this->id = $v;  
    }  
    public function getName()  
    {  
        return $this->name;  
    }  
    public function setName($v)  
    {  
        $this->name = $v;  
    }  
    public function getBiography()  
    {  
        return $this->biography;  
    }  
    public function setBiography($v)  
    {  
        $this->biography = $v;  
    }  
} 
$class = new ReflectionClass('Person');//建立 Person这个类的反射类  
$obj = $class->newInstanceArgs();  //相当于实例化Person类


//给属性赋值
$properties = $class->getProperties();  
$b = $properties[4]->name;
$obj->$b = 13;
var_dump($obj->$b);
echo "\n";

//执行类的方法
$obj->setBiography(22);
echo $obj->getBiography(); //执行Person里面的方法getBiography

//或者
//获得所有方法
$ec = $class->getMethods();
//获得单个方法
$ec = $class->getMethod('setName');
$ec->invoke($obj,'xlc');
echo "\n".$obj->getName();



exit;
print_r($properties);exit;
foreach($properties as $property) {  
    echo $property->getName()."\n";  
}  
//var_dump($class);
/*
$instance  = $class->newInstanceArgs($args);//相当于实例化Person 类  
 */
