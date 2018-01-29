<?php

namespace frontend\controllers;
use Yii;

class LogoutController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$session = Yii::$app->session;
		$session->destroy();		
        return $this->render('index');
    }

}
