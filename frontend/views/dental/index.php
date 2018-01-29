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
<h1>แฟ้ม DENTAL</h1>
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
            'before'=>'แฟ้ม DENTAL',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
        ],
	    'responsive' => true,
        'hover' => true,	
	'exportConfig' => [
        GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'F43_DENTAL_'.date('Y-d-m')],
        //GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'F43_DENTAL_'.date('Y-d-m')],
        GridView::EXCEL=> ['label' => 'Export as EXCEL', 'filename' => 'F43_DENTAL_'.date('Y-d-m')],
        GridView::TEXT=> ['label' => 'Export as TEXT', 'filename' => 'F43_DENTAL_'.date('Y-d-m')],
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
            return $pid=!empty($model["pid"]) ? $model["pid"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],		
        //'seq:text:SEQ',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'seq',	
          'label' => 'SEQ',  
          'format'=>'raw',
          'value'=>function($model){
            return $seq=!empty($model["seq"]) ? $model["seq"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
        ],			
		
		//'date_serv:text:DATE_SERV',
		[
			'attribute' => 'date_serv',	
			'label' => 'DATE_SERV', 
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,			
			'value'=>function ($model, $key, $index, $widget) 
			{ return $date_serv=!empty($model["date_serv"]) ? $model["date_serv"]: '<span class="label label-danger">ไม่มี</span>';
			},
		],
		[
			'attribute' => 'denttype',	
			'label' => 'DENTTYPE', 
			'format'=>'raw',
			//'width'=>'150px',
			'noWrap'=>true,			
			'value'=>function ($model, $key, $index, $widget) 
			{ return $denttype=!empty($model["denttype"]) ? $model["denttype"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
		],		
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'servplace',	
          'label' => 'SERVPLACE',  
          'format'=>'raw',
			'value'=>function ($model, $key, $index, $widget) 
			{ return $servplace=!empty($model["servplace"]) ? $model["servplace"] : '<span class="label label-danger">ไม่มี</span>';//ถ้า query มีค่าว่างต้องเช็คก่อน},
			},
        ],						
		'pteeth:text:PTEETH',				
		'pcaries:text:PCARIES',
		'pfilling:text:PFILLING',
		'pextract:text:PEXTRACT',
		'dteeth:text:DTEETH',
		'dcaries:text:DCARIES',
		'dfilling:text:DFILLING',
		'dextract:text:DEXTRACT',
		'need_fluoride:text:NEED_FLUORIDE',
		'need_scaling:text:NEED_SCALING',
		'need_sealant:text:NEED_SEALANT',
		'need_pfilling:text:NEED_PFILLING',
		'need_dfilling:text:NEED_DFILLING',
		'need_pextract:text:NEED_PEXTRACT',
		'need_dextract:text:NEED_DEXTRACT',
		'nprosthesis:text:NPROSTHESIS',
		'permanent_perma:text:PERMANENT_PERMA',
		'permanent_prost:text:PERMANENT_PROST',
		'prosthesis_prost:text:PROSTHESIS_PROST',
		'gum:text:GUM',
		'schooltype:text:SCHOOLTYPE',
		//'class:text:CLASS',
        [ // แสดงข้อมูลออกเป็นสีตามเงื่อนไข
          'attribute' => 'class',	
          'label' => 'CLASS',  
          'format'=>'raw',
          'value'=>function($model){
            return $class=!empty($model["class"]) ? $model["class"] : '';//ถ้า query มีค่าว่างต้องเช็คก่อน
          }
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

