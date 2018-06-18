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

class TotalvisitController extends \yii\web\Controller
{
    public function actionIndex()
    {
		$datenow=date('Y-m-d');
        $data = Yii::$app->request->get();
		$date1 = isset($data['date1']) ? $data['date1'] : '';
		$date2 = isset($data['date2']) ? $data['date2'] : '';		
        $g_year = isset($data['g_year']) ? $data['g_year'] : '';

		if (!empty($date1) && !empty($date2)) {//ถ้ามีการส่งข้อมูลมาแบบช่วงวันที่ให้ทำงานส่วนนี้
			$g_year='';
			$yt1=543+$y1=substr($date1, 0, 4);
			$m1=substr($date1, 5, 2);
			$d1=substr($date1, 8, 2);
			$dq1=$yt1.'-'.$m1.'-'.$d1;
		//$dq1=วันที่เริ่มต้น
			$yt2=543+$y2=substr($date2, 0, 4);
			$m2=substr($date2, 5, 2);
			$d2=substr($date2, 8, 2);
			$dq2=$yt2.'-'.$m2.'-'.$d2;
		//$dq2=วันที่สิ้นสุด

				$yg=$yt2-1;//ปี่ก่อน
				$yg1=$yt2;//ปีปัจจุบัน
				$ym=$yt2;//ปีงบ  
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


			}else {		

		if(!empty($data['g_year'])){//ถ้ามีการส่งข้อมูลมาเป็นแบบปีงบให้ทำงานส่วนนี้
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
					}


			$m_opd = Yii::$app->db->createCommand($m_opd)->queryAll();
			$m_ipd = Yii::$app->db->createCommand($m_ipd)->queryAll();

			
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
				'm_opd' => $m_opd,
				'm_ipd' => $m_ipd,
				'b_year' => $ym,
				'g_year' => $g_year,
				'dataProvider1' => $dataProvider1,
				'dataProvider2' => $dataProvider2,
				'date1' => $date1,
				'date2' => $date2,
			]);		
       // return $this->render('index');
    }

}
