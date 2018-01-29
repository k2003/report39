<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class AncController extends \yii\web\Controller
{
    public function actionIndex()
    {
          $data = Yii::$app->request->get();
          $date1 = isset($data['date1']) ? $data['date1'] : '';
          $date2 = isset($data['date2']) ? $data['date2'] : '';


          $sql = "
SELECT  distinct
	b_site.b_visit_office_id AS HOSPCODE 				
    ,t_health_family.health_family_hn_hcis as PID 	
    ,case when t_health_anc.is_anc_place_other = '1' then '' 
                else t_visit.visit_vn end AS SEQ 		
    , case  when  t_health_anc.health_anc_survey is not null and trim(t_health_anc.health_anc_survey) <> ''
                then (to_number(substring(t_health_anc.health_anc_survey,1,5),'9999')-543)
                        || substring(t_health_anc.health_anc_survey,6,2)
                        || substring(t_health_anc.health_anc_survey,9,2)
               else (to_number(substring(t_health_anc.modify_date_time,1,5),'9999')-543)
                        || substring(t_health_anc.modify_date_time,6,2)
                        || substring(t_health_anc.modify_date_time,9,2)
     end AS DATE_SERV 
    , t_health_pregnancy.health_pregnancy_gravida_number AS GRAVIDA
    , t_health_anc.f_health_anc_section AS ANCNO
    , t_health_anc.health_anc_gravida_week AS  GA
    , case when t_health_anc.health_anc_exam ='1'
		then '1'
		when t_health_anc.health_anc_exam ='2'
		then '2'
		else '9' end AS ANCRESULT
    ,case when t_health_anc.is_anc_place_other = '1' 
            then (case when t_health_anc.anc_place_hcode <> '' then t_health_anc.anc_place_hcode else '00000' end)
            else (case when t_health_pregnancy.b_visit_office_id <> '' then t_health_pregnancy.b_visit_office_id else '00000' end) end AS ANCPLACE
    ,b_employee.provider as PROVIDER
    ,(case  when length(t_visit.visit_staff_doctor_discharge_date_time) >= 10
                then case when length(cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) = 14
                                  then (cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':',''))
                                  when length(cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) =12
                                  then (cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) || '00'
                                  when length(cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) =10
                                  then (cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) || '0000'
                                  when length(cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) = 8
                                  then (cast(substring(t_visit.visit_staff_doctor_discharge_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_visit.visit_staff_doctor_discharge_date_time,5),'-',''),',',''),':','')) || '000000'
                                  else '' end
  when length(t_health_anc.modify_date_time) >= 10
                then case when length(cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) = 14
                                  then (cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':',''))
                                  when length(cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) =12
                                  then (cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) || '00'
                                  when length(cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) =10
                                  then (cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) || '0000'
                                  when length(cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) = 8
                                  then (cast(substring(t_health_anc.modify_date_time,1,4) as numeric) - 543
                                                || replace(replace(replace(substring(t_health_anc.modify_date_time,5),'-',''),',',''),':','')) || '000000'
                                  else ''
                           end            
                else ''
       end)  as D_UPDATE 



FROM t_health_anc 			
	INNER JOIN t_health_family ON t_health_anc.t_health_family_id = t_health_family.t_health_family_id      			
	INNER JOIN t_visit ON t_health_anc.t_visit_id = t_visit.t_visit_id 		
        INNER JOIN t_health_pregnancy ON t_health_anc.t_health_pregnancy_id = t_health_pregnancy.t_health_pregnancy_id and t_health_pregnancy.health_pregnancy_active='1'
        LEFT JOIN b_employee ON t_health_anc.health_anc_staff_record = b_employee.b_employee_id 

        left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
                                    and t_death.death_active = '1'

	,b_site
WHERE  
        t_health_anc.health_anc_active = '1'         
        AND t_health_family.health_family_active = '1' 
        AND t_visit.f_visit_type_id <> 'S' 
        AND t_visit.f_visit_status_id ='3'
        AND t_visit.visit_money_discharge_status='1'
        AND t_visit.visit_doctor_discharge_status='1' 
          ";
                if (!empty($date1) && !empty($date2)) {
          $yt1=543+$y1=substr($date1, 0, 4);
          $m1=substr($date1, 5, 2);
          $d1=substr($date1, 8, 2);
          $dq1=$yt1.'-'.$m1.'-'.$d1;

          $yt2=543+$y2=substr($date2, 0, 4);
          $m2=substr($date2, 5, 2);
          $d2=substr($date2, 8, 2);
          $dq2=$yt2.'-'.$m2.'-'.$d2;
                $sql.= "
        AND substr( t_visit.visit_staff_doctor_discharge_date_time,1,10) between '$dq1' and '$dq2'
						";

}else {
            $date1=date('Y-m-d');
            $date2=date('Y-m-d');
            $yt1=543+$y1=substr($date1, 0, 4);
            $m1=substr($date1, 5, 2);
            $d1=substr($date1, 8, 2);
            $dq1=$yt1.'-'.$m1.'-'.$d1;

            $yt2=543+$y2=substr($date2, 0, 4);
            $m2=substr($date2, 5, 2);
            $d2=substr($date2, 8, 2);
            $dq2=$yt2.'-'.$m2.'-'.$d2;
                  $sql.= " 
        AND substr( t_visit.visit_staff_doctor_discharge_date_time,1,10) between '$dq1' and '$dq2'				  
						";
          }
                  $sql .="
        and (case when t_death.t_death_id is not null 
                    then true 
               when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                    then true 
                    else false end)
                  ";

			$query = Yii::$app->db->createCommand($sql)->queryAll();           
			$dataProvider = new ArrayDataProvider([ 
              'allModels' => $query,
            //  'pagination' => FALSE,
              'pagination' => true,
              'pagination' => ['pagesize' => 10],
			]);             
			
                  return $this->render('index', [
                      'dataProvider' => $dataProvider,
                      'query' => $query,
                      'sql' => $sql,
                      'data' => $data,
                      'date1' => $date1,
                      'date2' => $date2,
					  
          ]);  
    }

}
