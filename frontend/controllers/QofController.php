<?php

namespace frontend\controllers;

class QofController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionIndex2()
    {
        return $this->render('index2');
    }
}
