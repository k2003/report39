<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use frontend\models\Bemployee;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$datenow=date('Y-m-d');
        $data = Yii::$app->request->get();
		
        $g_year = isset($data['g_year']) ? $data['g_year'] : '';
		
		if(!empty($data['g_year'])){
			$yt=$g_year;
			$ys=$yt-1;
			$ye=$yt;
			$ym=$g_year; //ปีงบ
			$yg=$yt-1; //59 ต.ค.-ธค
			$yg1=$yt; //60 ม.ค.-ก.ย.			
		}else{
            $yt=543+$y1=substr($datenow, 0, 4);
			$m1=substr($datenow, 5, 2);
			
			if($m1<=9){
				$ys=$yt-1;
				$ye=$yt;
				$ym=$yt; //ปีงบ
				$yg=$yt-1; //60 ต.ค.-ธค
				$yg1=$yt; //60 ม.ค.-ก.ย.
			}
			if($m1>=10){
				$ys=$yt;
				$ye=$yt+1;	
				$ym=$yt+1; //ปีงบ
				$yg=$yt;//61 ต.ค.-ธค
				$yg1=yt+1;//61 ม.ค.-ก.ย.
			}			
		}
		
			
			$opd_p = "
					select count(distinct t_visit.visit_hn) as opd_p FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";
			$opd_v = "
					select count(distinct t_visit.visit_vn) as opd_v FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";
			$ipd_p = "
					select count(distinct t_visit.visit_hn) as ipd_p FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";
			$ipd_v = "
					select count(distinct t_visit.visit_vn) as ipd_v FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";
			$adjcmilos = "
					select sum(t_diag_tdrg.adjrw) as adjrw, round(sum(t_diag_tdrg.adjrw)/(count(t_diag_tdrg.adjrw)),4) as CMI,
				sum(case when (to_date(substring(visit_staff_doctor_discharge_date_time,1,10),'YYYY-MM-DD') - 
						to_date(substring(t_visit.visit_begin_admit_date_time,1,10),'YYYY-MM-DD')) = 0
								then 1
								else (to_date(substring(visit_staff_doctor_discharge_date_time,1,10),'YYYY-MM-DD') - 
						to_date(substring(t_visit.visit_begin_admit_date_time,1,10),'YYYY-MM-DD'))
						end) as los
				FROM t_visit 
					left join t_diag_tdrg on t_visit.t_visit_id = t_diag_tdrg.t_visit_id
					WHERE  t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";				
			$opd_vach = "
					SELECT count(DISTINCT t_visit.visit_vn) as visit FROM t_visit
						LEFT JOIN t_patient ON t_visit.t_patient_id = t_patient.t_patient_id
						LEFT JOIN f_patient_prefix ON t_patient.f_patient_prefix_id = f_patient_prefix.f_patient_prefix_id
					WHERE t_visit.f_visit_status_id = '2' -- 1 = เข้าสู่กระบวนการ, 2 = ค้างบันทึก, 3 = จบกระบวนการ , 4 = ยกเลิกกระบวนการ
							and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			"; 
			$ipd_vach = "
					SELECT count(DISTINCT t_visit.visit_vn) as visit FROM t_visit
						LEFT JOIN t_patient ON t_visit.t_patient_id = t_patient.t_patient_id
						LEFT JOIN f_patient_prefix ON t_patient.f_patient_prefix_id = f_patient_prefix.f_patient_prefix_id
					WHERE t_visit.f_visit_status_id = '2' -- 1 = เข้าสู่กระบวนการ, 2 = ค้างบันทึก, 3 = จบกระบวนการ , 4 = ยกเลิกกระบวนการ
							and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$ys-10-01',1,10) and substring('$ye-09-30',1,10))
			";  
			$m_opd = "
					SELECT q.m,q.cc,q.vv
					from
					(				
					select '10-ต.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-10-01',1,10) and substring('$yg-10-31',1,10))
					UNION
					select '11-พ.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-11-01',1,10) and substring('$yg-11-30',1,10))
					UNION
					select '12-ธ.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-12-01',1,10) and substring('$yg-12-31',1,10))				
					UNION
					select '1-ม.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-01-01',1,10) and substring('$yg1-01-31',1,10))
					UNION
					select '2-ก.พ' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-02-01',1,10) and substring('$yg1-02-29',1,10))
					UNION
					select '3-มี.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-03-01',1,10) and substring('$yg1-03-31',1,10))
					UNION
					select '4-เม.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-04-01',1,10) and substring('$yg1-04-30',1,10))
					UNION
					select '5-พ.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-05-01',1,10) and substring('$yg1-05-31',1,10))
					UNION
					select '6-มิ.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-06-01',1,10) and substring('$yg1-06-30',1,10))
					UNION
					select '7-ก.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-07-01',1,10) and substring('$yg1-07-31',1,10))
					UNION
					select '8-ส.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-08-01',1,10) and substring('$yg1-08-31',1,10))
					UNION
					select '9-ก.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as vv FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '0' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-09-01',1,10) and substring('$yg1-09-30',1,10))
					) as q
					ORDER BY q.m					
			"; 
			$m_ipd = "
					SELECT q.m,q.cc,q.dd
					from
					(				
					select '10-ต.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-10-01',1,10) and substring('$yg-10-31',1,10))
					UNION
					select '11-พ.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-11-01',1,10) and substring('$yg-11-30',1,10))
					UNION
					select '12-ธ.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg-12-01',1,10) and substring('$yg-12-31',1,10))				
					UNION
					select '1-ม.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-01-01',1,10) and substring('$yg1-01-31',1,10))
					UNION
					select '2-ก.พ' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-02-01',1,10) and substring('$yg1-02-29',1,10))
					UNION
					select '3-มี.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-03-01',1,10) and substring('$yg1-03-31',1,10))
					UNION
					select '4-เม.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-04-01',1,10) and substring('$yg1-04-30',1,10))
					UNION
					select '5-พ.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-05-01',1,10) and substring('$yg1-05-31',1,10))
					UNION
					select '6-มิ.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-06-01',1,10) and substring('$yg1-06-30',1,10))
					UNION
					select '7-ก.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-07-01',1,10) and substring('$yg1-07-31',1,10))
					UNION
					select '8-ส.ค' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-08-01',1,10) and substring('$yg1-08-31',1,10))
					UNION
					select '9-ก.ย' as m, count(distinct t_visit.visit_hn) as cc, count(distinct t_visit.visit_vn) as dd FROM t_visit 
					WHERE t_visit.f_visit_status_id <> '4' and t_visit.f_visit_type_id = '1' 
					and (substr(visit_staff_doctor_discharge_date_time,1,10)Between substring('$yg1-09-01',1,10) and substring('$yg1-09-30',1,10))
					) as q
					ORDER BY q.m					
			"; 			
			
			$opd_p = Yii::$app->db->createCommand($opd_p)->queryScalar();		
			$opd_v = Yii::$app->db->createCommand($opd_v)->queryScalar();
			$ipd_p = Yii::$app->db->createCommand($ipd_p)->queryScalar();		
			$ipd_v = Yii::$app->db->createCommand($ipd_v)->queryScalar();
			$opd_vach = Yii::$app->db->createCommand($opd_vach)->queryScalar();
			$ipd_vach = Yii::$app->db->createCommand($ipd_vach)->queryScalar();
			$m_opd = Yii::$app->db->createCommand($m_opd)->queryAll();
			$m_ipd = Yii::$app->db->createCommand($m_ipd)->queryAll();
			$adjcmilos = Yii::$app->db->createCommand($adjcmilos)->queryAll();

			$dataProvider1 = new ArrayDataProvider([ 
              'allModels' => $m_opd,
              'pagination' => FALSE,
            /*  'pagination' => true,
              'pagination' => ['pagesize' => 10], */
			]); 
			$dataProvider2 = new ArrayDataProvider([ 
              'allModels' => $m_ipd,
              'pagination' => FALSE,
            /*  'pagination' => true,
              'pagination' => ['pagesize' => 10], */
			]); 			
		    return $this->render('index', [
				'ym' => $ym,
				'opd_p' => $opd_p,
				'opd_v' => $opd_v,
				'ipd_p' => $ipd_p,
				'ipd_v' => $ipd_v,
				'opd_vach' => $opd_vach,
				'ipd_vach' => $ipd_vach,
				'm_opd' => $m_opd,
				'm_ipd' => $m_ipd,
				'b_year' => $ym,
				'g_year' => $g_year,
				'dataProvider1' => $dataProvider1,
				'dataProvider2' => $dataProvider2,
				'adjcmilos' => $adjcmilos,

			]);		
       // return $this->render('index');
    }

}
