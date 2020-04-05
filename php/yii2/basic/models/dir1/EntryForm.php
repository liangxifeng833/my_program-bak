<?php
namespace app\models\dir1;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;
    //表单规则
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
    //定义input标签<lable>值
    public function attributeLabels()
    {
        return [
            'name' =>  'newname',
            'email' => \Yii::t('app', 'email地址'),
            ];
    }

}
