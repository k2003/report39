<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\db\ActiveQuery;
//check สิทธการเข้าใช้
use frontend\models\Bemployee;

	$session = Yii::$app->session;
	$checklogin = Bemployee::findOne(['b_employee_id'=>$session['userid'],]);
	if(!$checklogin){
		echo "<script>window.location='index.php?r=site/login';</script>";
	}
//check สิทธการเข้าใช้

/* @var $this yii\web\View */
?>
<h1>แฟ้ม DEATH</h1>
    <div class='well'>
<?php  $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="panel-body">
    <div class="col-lg-3">
<?php
echo '<label class="control-label">ระหว่างวันที่:</label>';
echo DatePicker::widget([
    'name' => 'date1',
    'language' => 'th',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => $date1,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]);
?>

    </div>
    <div class="col-lg-3">
<?php
echo '<label class="control-label">ถึง:</label>';
echo DatePicker::widget([
    'name' => 'date2',
    'language' => 'th',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => $date2,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]);
?>
    </div>
    <div class="col-lg-3"><br><button class='btn btn-success'> ค้นหา </button> </div>




</div>

<?php  Activeform::end(); ?>
</div>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'panel'=>[
            'before'=>'แฟ้ม DEATH',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
        ],
	    'responsive' => true,
        'hover' => true,
	'exportConfig' => [
        GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'F43_DEATH_'.date('Y-d-m')],
        //GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'F43_DEATH_'.date('Y-d-m')],
        GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'F43_DEATH_'.date('Y-d-m')],
        GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'F43_DEATH_'.date('Y-d-m')],
        ],
        // set your toolbar
            'toolbar' =>  [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'รีเซ็ต')])
                ],
                '{toggleData}',
                '{export}',
            ],
        // set export properties
            'export' => [
                'fontAwesome' => true
            ],
            'pjax' => true,
            'pjaxSettings' => [
                'neverTimeout' => true,
                'beforeGrid' => '',
                'afterGrid' => '',
            ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'hospcode:text:HOSPCODE',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'hospcode',
          'label' => 'HOSPCODE',
          'format'=>'raw',
          'value'=>function($model){
            return $hospcode=!empty($model["hospcode"]) ? $model["hospcode"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        //'pid:text:PID',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'pid',
          'label' => 'PID',
          'format'=>'raw',
					'value'=>function($model){
			if (isset($model["lastmodify"])) {
				$namemodify = Bemployee::findOne($model["lastmodify"]);
				$fname=$namemodify->employee_firstname;
				$lastname=$namemodify->employee_lastname;
	            return $pid=!empty($model["pid"]) ?
				Html::tag('span', $model["pid"], [
				'title'=> $fname.' '.$lastname,
				'data-toggle'=>'tooltip',
				'style'=>'text-decoration:underline;cursor:pointer;'
				])
				: '<span class="label label-danger">ไม่มี</span>';
			}else {
				return '<span class="label label-danger">ไม่มี</span>';
			}
          },
        ],
				'hospdeath:text:HOSPDEATH',
				'an:text:AN',
				//'seq:text:SEQ',
				[ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'seq',
          'label' => 'SEQ',
          'format'=>'raw',
					'value'=>function ($model, $key, $index, $widget)
					{ return $seq=!empty($model["seq"]) ? $model["seq"] : '';//ถ้า query มีค่าว่างต้องเช็คก่อน},
					},
        ],
		[
			'attribute' => 'ddeath',
			'label' => 'DDEATH',
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $ddeath=!empty($model["ddeath"]) ? $model["ddeath"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],

		//'cdeath_a:text:CDEATH_A',
		[
			'attribute' => 'cdeath_a',
			'label' => 'CDEATH_A',
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $cdeath_a=!empty($model["cdeath_a"]) ? $model["cdeath_a"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],
		'cdeath_b:text:CDEATH_B',
		'cdeath_c:text:CDEATH_C',
		'cdeath_d:text:CDEATH_D',
		'odisease:text:ODISEASE',
		//'cdeath:text:CDEATH',
		[
			'attribute' => 'cdeath',
			'label' => 'CDEATH',
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $cdeath=!empty($model["cdeath"]) ? $model["cdeath"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],
		'pregdeath:text:PREGDEATH',
		//'pdeath:text:PDEATH',
		[
			'attribute' => 'pdeath',
			'label' => 'PDEATH',
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $pdeath=!empty($model["pdeath"]) ? $model["pdeath"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],
		'provider:text:PROVIDER',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'd_update',
          'label' => 'D_UPDATE',
          'format'=>'raw',
          'value'=>function($model){
            return $d_update=!empty($model["d_update"]) ? $model["d_update"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        ],
]);
?>
<div class="alert alert-danger">
    <?= $sql ?>
</div>
