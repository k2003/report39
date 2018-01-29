<?php
$session = Yii::$app->session;
$session->destroy();
		echo $session->get('name1').'<br>';
		echo $session['name2'].'<br>';
		//echo $_SESSION['name3'].'<br>';
//echo $info;
