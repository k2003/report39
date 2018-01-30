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
<h1>แฟ้ม PERSON</h1>
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
            'before'=>'แฟ้ม PERSON',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
        ],
	    'responsive' => true,
        'hover' => true,
	'exportConfig' => [
        GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'F43_PERSON_'.date('Y-d-m')],
        //GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'F43_PERSON_'.date('Y-d-m')],
        GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'F43_PERSON_'.date('Y-d-m')],
        GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'F43_PERSON_'.date('Y-d-m')],
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
				/*[ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          //'attribute' => 'hospcode',
          'label' => 'ผู้บันทึก',
					'format'=>'raw',
					'width'=>'150px',
					'noWrap'=>true,
					'value'=>function($model){
					if (isset($model["lastmodify"])) {
						$namemodify = Bemployee::findOne($model["lastmodify"]);
						$fname=$namemodify->employee_firstname;
						$lastname=$namemodify->employee_lastname;
			            return $fname.' '.$lastname ;
					}else {
						return '<span class="label label-danger">ไม่มี</span>';
					}
          },
        ],*/
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
				
        //'cid:text:CID',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'cid',
          'label' => 'CID',
          'format'=>'raw',
          'value'=>function($model){
            return $cid=!empty($model["cid"]) ? $model["cid"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
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
        'hid:text:HID',
		//'prename:text:PRENAME',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'prename',
          'label' => 'PRENAME',
          'format'=>'raw',
          'value'=>function($model){
            return $prename=!empty($model["prename"]) ? $model["prename"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],

		//'name:text:NAME',
		[
			'attribute' => 'name',
			'label' => 'NAME',
			'format'=>'raw',
			'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $name=!empty($model["name"]) ? $model["name"]: '<span class="label label-danger">ไม่มี</span>';
			},
		],
		//'lname:text:LNAME',
		[
			'attribute' => 'lname',
			'label' => 'LNAME',
			'format'=>'raw',
			'width'=>'150px',
			'noWrap'=>true,
			'value'=>function ($model, $key, $index, $widget)
			{ return $lname=!empty($model["lname"]) ? $model["lname"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],
		//'hn:text:HN',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'hn',
          'label' => 'HN',
          'format'=>'raw',
					'value'=>function ($model, $key, $index, $widget)
					{ return $hn=!empty($model["hn"]) ? $model["hn"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
					},
        ],
		//'sex:text:SEX',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'sex',
          'label' => 'SEX',
          'format'=>'raw',
          'value'=>function($model){
            return $sex=!empty($model["sex"]) ? $model["sex"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
		//'birth:text:BIRTH',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'birth',
          'label' => 'BIRTH',
          'format'=>'raw',
          'value'=>function($model){
            return $birth=!empty($model["birth"]) ? $model["birth"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
		'mstatus:text:MSTATUS',
		'occupation_old:text:OCCUPATION_OLD',
		'occupation_new:text:OCCUPATION_NEW',
		'race:text:RACE',
		//'nation:text:NATION',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'nation',
          'label' => 'NATION',
          'format'=>'raw',
          'value'=>function($model){
            return $nation=!empty($model["nation"]) ? $model["nation"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
		'religion:text:RELIGION',
		'education:text:EDUCATION',
		'fstatus:text:FSTATUS',
		'father:text:FATHER',
		'mother:text:MOTHER',
		'couple:text:COUPLE',
		'vstatus:text:VSTATUS',
		'movein:text:MOVEIN',
		'discharge:text:DISCHARGE',
		'ddischarge:text:DDISCHARGE',
		'abogroup:text:ABOGROUP',
		'rhgroup:text:RHGROUP',
		'labor:text:LABOR',
		//'passport:text:PASSPORT',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'passport',
          'label' => 'PASSPORT',
          'format'=>'raw',
          'value'=>function($model){
            return $passport=!empty($model["passport"]) ? $model["passport"] : '';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
		//'typearea:text:TYPEAREA',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'typearea',
          'label' => 'TYPEAREA',
          'format'=>'raw',
          'value'=>function($model){
            return $typearea=!empty($model["typearea"]) ? $model["typearea"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
		//'d_update:text:D_UPDATE',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'd_update',
          'label' => 'D_UPDATE',
          'format'=>'raw',
          'value'=>function($model){
            return $d_update=!empty($model["d_update"]) ? $model["d_update"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
				[ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'telephone',
          'label' => 'TELEPHONE',
          'format'=>'raw',
          'value'=>function($model){
            return $telephone=!empty($model["telephone"]) ? $model["telephone"] : '';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],
				[ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'mobile',
          'label' => 'MOBILE',
          'format'=>'raw',
          'value'=>function($model){
            return $mobile=!empty($model["mobile"]) ? $model["mobile"] : '';//ถ้า query มีค่าว่างต้องเช็คก่อน
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
