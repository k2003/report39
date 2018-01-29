<?php
use yii\helpers\Html;
use frontend\models\Bemployee;
use yii\db\ActiveQuery;
/* @var $this yii\web\View */
?>
<h1>test/index</h1>
<hr>
<h1 style="align-items: center;background-color: yellow"> Hello Yii2</h1>
<?php
$route1 = Yii::$app->urlManager->createUrl('test/test1');
$route2 = Yii::$app->urlManager->createUrl(['test/test2','name'=>'ninja','lname'=>'JO']);
?>
<hr>
<a href="<?=$route1?>">ไปที่ Test 1</a>  
<hr>
<a href="<?=$route2?>">ไปที่ Test 2</a>   
<hr>
<?=
yii\helpers\Html::a('ลิงค์แบบที่ 3', ['test/test1','a'=>'1']);
?>
<hr>
<?=
Html::a('ลิงค์แบบที่ 4', ['test/test1','a'=>'1']);
?>
<hr>
<h1 style="align-items: center;background-color: orange"> Test SESSION</h1>

<?php
		$session = Yii::$app->session;
		$session->open();
		if($session->isActive){
			echo 'Session is active<br>';
		}else{
			echo 'Session is not active<br>';
		}
		$session->remove('name1');
		echo $session->get('name1').'<br>';
		echo $session['name2'].'<br>';
		echo $_SESSION['name3'].'<br>';
		//echo $session['name3']['lifetime'].'<br>';
		//$session->destroy();
		echo Html::a('Delete Session', ['test/test2']);		
?>

<hr>
<?php
			$namemodify = Bemployee::findOne(['employee_login'=>'jo','employee_password'=>md5('ninjax55')]);
			echo $fname=$namemodify->employee_firstname." ".$lastname=$namemodify->employee_lastname;
			
?>