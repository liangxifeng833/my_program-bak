<?php
namespace app\models;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' =>  'newname',
            'email' => \Yii::t('app', 'email地址'),
            ];
    }

}
