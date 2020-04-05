<?php
/*
 * Model学习测试
 *
 * @author:liangxifeng
 * @date: 2014-11-24
 */
namespace app\controllers\dir1;
use Yii;
use yii\web\Controller;
use app\models\dir1\AdminUser;

class TestModelController extends Controller
{
    //调用公共单独的action， 实现多次输出不同的页面,访问路径：http://nginx.yii2.loc:8000/index.php?r=dir1/test-model/page&view=about 
    //在@app/views/dir1/test-model/pages/about.php
    public function actions()
    {
        return [
            'page'=>[
                'class'=>'yii\web\ViewAction',
            ],
        ];
    }
    //public $layout = false; //该控制器不使用任何布局layout
    //public $layout = 'main'; //该控制器使用@app/views/layout/main.php脚本布局
    //测试属性,ContactForm是在model中已经建立好的，并且属性名必须是对应数据表字段名
    public function actionAttr()
    {
        $model = new \app\models\ContactForm;
        //以对象形式使用
        $model->name = 'liangxifeng';
        var_dump($model->name);
        //以数组形式使用
        $model['name'] = 'zhangsan';
        var_dump($model['name']);exit;
    }
    //验证用户输入的表单数据
    public function actionEntry()
    {
        $model = new \app\models\dir1\EntryForm;
        //获取表单中lable标签值
        $model->getAttributeLabel('name');

        //input name='name' value='liangxifeng'
        $model->name="liangxifeng";
        if ($model->load(Yii::$app->request->post())  &&  $model->validate()) 
        {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
                                
        } else 
        {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
            //return $this->render('entry');

        }
    }
    //测试一个model针对不同需求自定义选择不同规则
    public function actionScenario()
    {
        $model = new AdminUser;
        //$model->scenario = 'login';
        $model = new AdminUser(['scenario' => 'login']); //和以上一行功能相同
        //var_dump($model->fields());
        //exit;
        //$array = $model->toArray([], ['user_password', 'user_name']);
        if($model->attributes = \Yii::$app->request->post('AdminUser')) //该属性批量接收用户输入的数据，注意：只能接收model中scenarios配置的字段值
        {
            var_dump($model);exit;
            echo $model->user_name;
        }
        //echo \Yii::$app->view->renderFile('@app/views/site/about.php');
        
        //return $this->render('adminUser', ['model' => $model]);
        //return $this->render('//dir1/test-model/adminUser', ['model' => $model]);
        return $this->render('/dir1/test-model/adminUser', ['model' => $model]);
    }
}
