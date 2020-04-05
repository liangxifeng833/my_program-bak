<?php
namespace app\controllers\dir1;
use Yii;
use yii\web\Controller;

class PostCommentController extends Controller
{
    //修改默认控制器
    public $defaultAction = 'param';

    public function actionIndex($id,$version=null)
    {

        //重定向
        //return $this->redirect('/index.php?r=site/index');
        //察看数据库连接
        $db = \Yii::$app->db;
        //var_dump($db);
        //查看缓存
        $cache = \Yii::$app->cache;
        //var_dump($cache);exit;
        echo '<br>this is a test controller!';
        $name = $this->getName();
        var_dump($name);exit;

    }
    //action参数以字符串的形式
    public function actionParam($id,$version=null)
    {
        var_dump($id);exit;
    }
    //action参数以数组的形式
    public function actionParamArray(array $id,$version=null)
    {
        var_dump($id);exit;
    }
    //私有方法必须在类内部调用，不能在路由规则内访问
    private function getName()
    {
        return 'my name is liangxifeng';
    }
}
