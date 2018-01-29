<?php

namespace frontend\controllers;
use yii;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$session = Yii::$app->session;
		$session->set('name1','Ninja YII PHP Framework 1');
		$session['name2'] = 'Ninja YII PHP Framework 2';
		$_SESSION['name3'] = 'Ninja YII PHP Framework 3';
        return $this->render('index');
    }
    public function actionTest1() {

        $a = 3;
        $b = 5;
        $sum = $a + $b;
        $param = ['sum' => $sum, 'a' => $a, 'b' => $b];
        return $this->render('test1', $param);
    }

//จบ test1

    public function actionTest2($name = null, $lname = null) {


        $info = "Your name is $name $lname";
        return $this->render('test2', ['info' => $info]);
    }
}
