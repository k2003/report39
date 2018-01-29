<?php

namespace frontend\controllers;
use yii\data\ArrayDataProvider;
use yii;


class NcdController extends \yii\web\Controller
{
     public function actionIndex()
    {
        return $this->render('index');
    }    
}
