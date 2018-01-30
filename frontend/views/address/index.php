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
<h1>แฟ้ม ADDRESS</h1>
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
            'before'=>'แฟ้ม ADDRESS',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
        ],
	    'responsive' => true,
        'hover' => true,
	'exportConfig' => [
        GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'F43_ANC_'.date('Y-d-m')],
        //GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'F43_ANC_'.date('Y-d-m')],
        GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'F43_ANC_'.date('Y-d-m')],
        GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'F43_ANC_'.date('Y-d-m')],
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
			if (isset($model["lastmodify"])) {
				$namemodify = Bemployee::findOne($model["lastmodify"]);
				$fname=$namemodify->employee_firstname;
				$lastname=$namemodify->employee_lastname;
	            return $hospcode=!empty($model["hospcode"]) ?
				Html::tag('span', $model["hospcode"], [
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
        //'pid:text:PID',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'pid',
          'label' => 'PID',
          'format'=>'raw',
          'value'=>function($model){
            return $pid=!empty($model["pid"]) ? $model["pid"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'addresstype',
          'label' => 'ADDRESSTYPE',
          'format'=>'raw',
          'value'=>function($model){
            return $addresstype=!empty($model["addresstype"]) ? $model["addresstype"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],

		'house_id:text:HOUSE_ID',
		[
			'attribute' => 'housetype',
			'label' => 'HOUSETYPE',
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $housetype=!empty($model["housetype"]) ? $model["housetype"]: '<span class="label label-danger">ไม่มี</span>';
			},
		],
		'roomno:text:ROOMNO',
    'condo:text:CONDO',
    'houseno:text:HOUSENO',
    'soisub:text:SOISUB',
    'soimain:text:SOIMAIN',
    'road:text:ROAD',
    'villaname:text:VILLANAME',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'village',
          'label' => 'VILLAGE',
          'format'=>'raw',
			'value'=>function ($model, $key, $index, $widget)
			{ return $village=!empty($model["village"]) ? $model["village"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
        ],
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'tambon',
          'label' => 'TAMBON',
          'format'=>'raw',
          'value'=>function($model){
            return $tambon=!empty($model["tambon"]) ? $model["tambon"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'ampur',
          'label' => 'AMPUR',
          'format'=>'raw',
          'value'=>function($model){
            return $ampur=!empty($model["ampur"]) ? $model["ampur"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'changwat',
          'label' => 'CHANGWAT',
          'format'=>'raw',
          'value'=>function($model){
            return $changwat=!empty($model["changwat"]) ? $model["changwat"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'd_update',
          'label' => 'D_UPDATE',
          'format'=>'raw',
          'value'=>function($model){
            return $d_update=!empty($model["d_update"]) ? $model["d_update"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
				[ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'cid',
          'label' => 'CID',
          'format'=>'raw',
          'value'=>function($model){
            return $cid=!empty($model["cid"]) ? $model["cid"] : '<span class="label label-warning">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
        ],

]);
?>
<script type="text/javascript">
				function showhide(id) {
				var e = document.getElementById(id);
				e.style.display = (e.style.display == 'block') ? 'none' : 'block';
				}
</script>
<ul class="nav nav-pills"><li role="presentation" class="active"><a href="javascript:showhide('sql')">code sql</a></li></ul>
<div id="sql" style="display:none;">
	<p><div class="alert alert-danger"><?php echo $sql ?></div></p>
</div>
