<?php

namespace app\models\dir1;

use Yii;

/**
 * This is the model class for table "admin_user".
 *
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_password
 * @property string $user_starttime
 * @property integer $user_personid
 * @property integer $user_status
 */
class AdminUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['user_name']);
        $fields['user_password'] = 'password';
        return $fields;
        /*
        return [
            'id',
            'user_name'=>'liangxifeng',
            'user_password'=>'123456',
            'user_personid'=>function(){
                return '123';
            }
        ];
         */
    }

    //验证可以分为多种情况,比如：登录和验证的验证规则不一样
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login']=['!user_name','user_password']; //!user_name 代表在view 可以经过验证但是在controller中无法使用$model->attributes接受到
        $scenarios['register'] = ['user_name', 'user_personid', 'user_password'];
        return $scenarios;
        /*
        return [
            'login'=>['user_name','user_password'],
            'register'=>['username','email','password']
            ];
         */
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'user_password', 'user_starttime', 'user_personid', 'user_status','message'=>'aaa'], 'required','message'=>'no', 'on'=>'register'],
            [['user_name', 'user_password'], 'required','on'=>'login'],
            /*
            [['user_starttime'], 'safe'],
            [['user_personid', 'user_status'], 'integer'],
            [['user_name', 'user_password'], 'string', 'max' => 100]
            */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户主键',
            'user_name' => '用户名称',
            'user_password' => '用户命名',
            'user_starttime' => '用户时间',
            'user_personid' => '用户关联人员id',
            'user_status' => 'User Status',
        ];
    }

}
