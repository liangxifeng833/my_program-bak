<?php

namespace app\controllers;

class TestController extends \yii\web\Controller
{
    public function actionAutotest()
    {
        return $this->render('autotest');
    }

}
