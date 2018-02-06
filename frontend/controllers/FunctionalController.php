<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class FunctionalController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $data = Yii::$app->request->get();
      $date1 = isset($data['date1']) ? $data['date1'] : '';
      $date2 = isset($data['date2']) ? $data['date2'] : '';


      $sql = "
      select
              b_site.b_visit_office_id as HOSPCODE
              , t_health_family.health_family_hn_hcis as PID
              , t_visit.visit_vn SEQ
              , to_char(t_health_functional.survey_date,'YYYYMMDD') as DATE_SERRV
              , f_functional_test.f_functional_test_id as FUNCTIONAL_TEST
              , t_health_functional.test_result::text as TESTRESULT
              , f_functional_dependent.f_functional_dependent_id as DEPENDENT
              , b_employee.provider as PROVIDER
              , to_char(t_health_functional.update_date_time,'YYYYMMDDHH24MISS') as D_UPDATE
      				,t_health_family.patient_pid as CID
      				,t_health_functional.user_update_id as lastmodify
      from
              t_health_functional inner join t_visit on t_health_functional.t_visit_id = t_visit.t_visit_id
              inner join t_patient on t_visit.t_patient_id = t_patient.t_patient_id
              inner join t_health_family on t_health_family.t_health_family_id = t_patient.t_health_family_id
              inner join f_functional_test on t_health_functional.f_functional_test_id = f_functional_test.f_functional_test_id
              left join f_functional_dependent on t_health_functional.f_functional_dependent_id = f_functional_dependent.f_functional_dependent_id

              left join b_employee on t_health_functional.user_update_id = b_employee.b_employee_id
              left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
                                          and t_death.death_active = '1'
              cross join b_site

      where
              t_health_family.health_family_active = '1'
              and t_visit.f_visit_status_id ='3'
              and t_visit.visit_money_discharge_status ='1'
              and t_visit.visit_doctor_discharge_status ='1'
              and substr(t_visit.visit_staff_doctor_discharge_date_time,1,10) between '?' and '?' 
              and t_health_functional.active = '1'

              and (case when t_death.t_death_id is not null
                          then true
                     when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                          then true
                          else false end)
      order by
              D_UPDATE asc
      ";

            if (!empty($date1) && !empty($date2)) {
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
}else {
        $date1=date('Y-m-d');
        $date2=date('Y-m-d');
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
      }
//แทนค่า ? ด้วยวันที่
      while ($ps=strpos($sql,"?")) {
      $ps=strpos($sql,"?");
      if($ps!==FALSE){  $qr = substr_replace($sql, $dq1, $ps ,1);  }
      $ps2=strpos($qr,"?");
      if($ps2!==FALSE){  $qr2 = substr_replace($qr, $dq2, $ps2 ,1);  }
      $sql=$qr2;
      }
//แทนค่า ? ด้วยวันที่
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
