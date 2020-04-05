<?php
/*
 * 自己在数据库创建yii2basic库，和country表后，新建的控制器,从country表中获取数据，并分页显示
 *
 * @author:liangxifeng
 * @date:2014-10-22
 */

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
        $query = Country::find();
        //$query = Country::find()->andWhere(['code'=>'AU']);

        //初始化分页
        $pagination = new Pagination([
            'pageSize'=>2,                   //每页显示两条
            'totalCount' => $query->count(), //总计数据记录数
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index',[
            'countries' => $countries,
            'pagination' =>$pagination
            ]);
    }
}
