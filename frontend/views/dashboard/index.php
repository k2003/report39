<?php
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'HospitalOS Report';


?>

<div style='display: none'>
    <?=
    Highcharts::widget([
        'scripts' => [
            'highcharts-more'
        ]
    ]);
    ?>
</div>
<div class="site-index">

    <div class="jumbotron">
        <h1>Dashboard HospitalOS Report!</h1>
          <!-- top tiles -->		  
          <!--
		  <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count">2500</div>
              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
              <div class="count">123.50</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
              <div class="count green">2,500</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
              <div class="count">4,567</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
              <div class="count">2,315</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
              <div class="count">7,325</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
          </div>
		  -->
          <!-- /top tiles -->

          <!-- top tiles -->	


<?php  $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="panel-body">
<?php

?>
<div class="col-md-3">
						  
<?php 
$data = Yii::$app->request->get();
$g_year = isset($data['g_year']) ? $data['g_year'] : '';
$items = [
    2561 => '2561', 
    2560 => '2560',
	2559 => '2559',
	2558 => '2558',
	2557 => '2557',
]
?>
<?=Select2::widget([
    'name' => 'g_year',
    'value' => $g_year,
    'data' => $items,
    'options' => ['multiple' => false, 'placeholder' => 'เลือกปีงบประมาณ ...']
]);  
?>
	<br>				  
						<?php echo Html::submitButton('ตกลง', ['class'=> 'btn btn-primary']); 	?>			  
</div>                                   
</div>        
<?php  Activeform::end(); ?>

		  
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>จำนวนคน OPD ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($opd_p,0,".",",") ?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> จำนวนครั้ง OPD ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($opd_v,0,".",",") ?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> จำนวนคน IPD ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($ipd_p,0,".",",") ?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> จำนวนครั้ง IPD ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($ipd_v,0,".",",") ?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> OPD รอที่เวชจำหน่าย</span>
              <div class="count red"><?php echo number_format($opd_vach,0,".",",") ?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> IPD รอที่เวชจำหน่าย</span>
              <div class="count red"><?php echo number_format($ipd_vach,0,".",",") ?></div>
            </div>
          </div>
          <!-- /top tiles -->
		  
          <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Sum Adjrw ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($adjcmilos["0"]["adjrw"],4,".",",");  ?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i>CMI ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($adjcmilos["0"]["cmi"],4,".",","); ?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> จำนวนวันนอน IPD ปีงบ <?= $ym?></span>
              <div class="count"><?php echo number_format($adjcmilos["0"]["los"],0,".",","); ?></div>
            </div>
          </div>
		  
          <!-- /top tiles -->		  
		<!-- start Graph1 -->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-12">
                    <h3> จำนวนผู้ป่วยนอกมารับบริการ (คน/ครั้ง)ปีงบประมาณ <?= $b_year ?></h3>
                  </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div id="chart_plot_01" class="demo-placeholder">
			<!-- box1 -->
			<!-- /. Combining chart types colum and spline -->          
            <div class="box-body">
                 <div id="container-opd"></div>
                    <?php

                    $categ = [];
                    for ($i = 0; $i < count($m_opd); $i++) {
                        $categ[] = $m_opd[$i]['m'];
                    }
                    $js_categ = implode("','", $categ);

                    $data_cc = [];
                    for ($i = 0; $i < count($m_opd); $i++) {
                        $data_cc[] = $m_opd[$i]['cc'];
                    }
                    $js_cc = implode(",", $data_cc);

                    $data_vv = [];
                    for ($i = 0; $i < count($m_opd); $i++) {
                        $data_vv[] = $m_opd[$i]['vv'];
                    }
                    $js_vv = implode(",", $data_vv);

                    $this->registerJs(" $(function () {
                                        $('#container-opd').highcharts({
                                            chart: {
                                               height: 285,
                                               width: 800
                                            }, 
                                            title: {
                                                text: '',
                                                x: -20 //center
                                            },
                                            subtitle: {
                                                text: '',
                                                x: -20
                                            },
                                            xAxis: {
                                                  categories: ['$js_categ'],
                                            },
                                            yAxis: {
                                                title: {
                                                    text: ''
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#808080'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ''
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                type: 'column',
                                                name: 'จำนวนคน',
                                                data: [$js_cc]
                                            }, {
                                                type: 'column',
                                                name: 'จำนวนครั้ง',
                                                data: [$js_vv]
                                            },{
                                                type: 'spline',
                                                name: 'Person',
                                                 data: [$js_cc],
                                                marker: {
                                                    lineWidth: 2,
                                                    lineColor: Highcharts.getOptions().colors[3],
                                                    fillColor: 'white'
                                                }
                                            },{
                                                type: 'spline',
                                                name: 'Visit',
                                                 data: [$js_vv],
                                                marker: {
                                                    lineWidth: 2,
                                                    lineColor: Highcharts.getOptions().colors[3],
                                                    fillColor: 'white'
                                                }
                                            }],


                                        });
                                    });
                         ");
                    ?>

            </div>   

			
				  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider1,
        //'filterModel' => $searchModel,
        'panel'=>[
            'before'=>'จำนวนผู้ป่วยนอก(OPD)มารับบริการ (คน/ครั้ง)',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
               
        ],
    'columns' => [
		'm:text:เดือน',
		'cc:integer:จำนวนคน',
		'vv:integer:จำนวนครั้ง',
	        ],
]);
?>
		  <!-- end Graph1 -->
			</br>
		<!-- start Graph2 -->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                  <div class="col-md-12">
                    <h3> จำนวนผู้ป่วยในมารับบริการ (คน/ครั้ง)ปีงบประมาณ <?= $b_year ?></h3>
                  </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <div id="chart_plot_01" class="demo-placeholder">
			<!-- box1 -->
			<!-- /. Combining chart types colum and spline -->          
            <div class="box-body">
                 <div id="container-ipd"></div>
                    <?php

                    $categ = [];
                    for ($i = 0; $i < count($m_ipd); $i++) {
                        $categ[] = $m_ipd[$i]['m'];
                    }
                    $js_categ = implode("','", $categ);

                    $data_cc = [];
                    for ($i = 0; $i < count($m_ipd); $i++) {
                        $data_cc[] = $m_ipd[$i]['cc'];
                    }
                    $js_cc = implode(",", $data_cc);

                    $data_dd = [];
                    for ($i = 0; $i < count($m_ipd); $i++) {
                        $data_dd[] = $m_ipd[$i]['dd'];
                    }
                    $js_dd = implode(",", $data_dd);

                    $this->registerJs(" $(function () {
                                        $('#container-ipd').highcharts({
                                            chart: {
                                               height: 285,
                                               width: 800
                                            },
                                            title: {
                                                text: '',
                                                x: -20 //center
                                            },
                                            subtitle: {
                                                text: '',
                                                x: -20
                                            },
                                            xAxis: {
                                                  categories: ['$js_categ'],
                                            },
                                            yAxis: {
                                                title: {
                                                    text: ''
                                                },
                                                plotLines: [{
                                                    value: 0,
                                                    width: 1,
                                                    color: '#808080'
                                                }]
                                            },
                                            tooltip: {
                                                valueSuffix: ''
                                            },
                                            legend: {
                                                layout: 'vertical',
                                                align: 'right',
                                                verticalAlign: 'middle',
                                                borderWidth: 0
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                type: 'column',
                                                name: 'จำนวนคน',
                                                data: [$js_cc]
                                            }, {
                                                type: 'column',
                                                name: 'จำนวนครั้ง',
                                                data: [$js_dd]
                                            },
											{
                                                type: 'spline',
                                                name: 'Person',
                                                 data: [$js_cc],
                                                marker: {
                                                    lineWidth: 2,
                                                    lineColor: Highcharts.getOptions().colors[3],
                                                    fillColor: 'white'
                                                }
                                            },{
                                                type: 'spline',
                                                name: 'Visit',
                                                 data: [$js_dd],
                                                marker: {
                                                    lineWidth: 2,
                                                    lineColor: Highcharts.getOptions().colors[3],
                                                    fillColor: 'white'
                                                }
                                            }],
                                        });
                                    });
                         ");
                    ?>

            </div>   

				  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
<?php
echo GridView::widget([
        'dataProvider' => $dataProvider2,
        //'filterModel' => $searchModel,
        'panel'=>[
            'before'=>'จำนวนผู้ป่วยใน(IPD)มารับบริการ (คน/ครั้ง)',
            'after'=>'ประมวลผล ณ '.date('Y-m-d H:i:s'),
               
        ],
    'columns' => [
		'm:text:เดือน',
		'cc:integer:จำนวนคน',
		'dd:integer:จำนวนครั้ง',
	        ],
]);
?>		  
		  <!-- end Graph2 -->		  
   </div> 


   
</div>


