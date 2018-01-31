<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class DisabilityController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $data = Yii::$app->request->get();
      $date1 = isset($data['date1']) ? $data['date1'] : '';
      $date2 = isset($data['date2']) ? $data['date2'] : '';


      $sql = "
      select distinct
      b_site.b_visit_office_id as HOSPCODE
      ,case when t_health_disability.health_disability_number <> ''
      then  t_health_disability.health_disability_number
      else '' end as DISABID
      ,t_health_family.health_family_hn_hcis as PID
      ,b_health_maim.health_maim_number as DISABTYPE
      ,case when t_health_maim.disability_cause='0'
      then ''
      else t_health_maim.disability_cause end as DISABCAUSE
      ,replace(b_icd10.icd10_number,'.','') as DIAGCODE
      ,case when t_health_maim.health_maim_survey_date <> ''
      then (to_number(substring(t_health_maim.health_maim_survey_date,1,4),'9999') - 543)
                          || substring(t_health_maim.health_maim_survey_date,6,2)
                          || substring(t_health_maim.health_maim_survey_date,9,2)
      else '' end AS DATE_DETECT

      ,case when t_health_maim.health_maim_date <> ''
      then (to_number(substring(t_health_maim.health_maim_date,1,4),'9999') - 543)
                          || substring(t_health_maim.health_maim_date,6,2)
                          || substring(t_health_maim.health_maim_date,9,2)
      else '' end AS DATE_DISAB
      , case when length(t_health_maim.health_maim_modify_date_time) >= 10
                      then cast(substring(t_health_maim.health_maim_modify_date_time,1,4) as numeric) - 543
                               || replace(replace(replace(substring(t_health_maim.health_maim_modify_date_time,5),'-',''),',',''),':','')
                      when length(t_health_maim.health_maim_record_date_time) >= 10
                      then cast(substring(t_health_maim.health_maim_record_date_time,1,4) as numeric) - 543
                               || replace(replace(replace(substring(t_health_maim.health_maim_record_date_time,5),'-',''),',',''),':','')
                      else ''
      end as D_UPDATE
      ,t_health_family.patient_pid as CID
      ,t_health_disability.user_modify_id as lastmodify
      from
              t_health_maim inner join t_health_family
              on t_health_maim.t_health_family_id = t_health_family.t_health_family_id
              inner join b_health_maim on t_health_maim.b_health_maim_id = b_health_maim.b_health_maim_id
              left join t_health_disability on t_health_family.t_health_family_id=t_health_disability.t_person_id
              left join b_icd10  on t_health_maim.b_icd10_id = b_icd10.icd10_number

              left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
                                          and t_death.death_active = '1'

              cross join b_site

      where
              t_health_maim.health_maim_active='1'
              and t_health_family.health_family_active='1'
              and b_health_maim.health_maim_active='1'
              AND (case when length(t_health_maim.health_maim_modify_date_time) >= 10
                        then substr(t_health_maim.health_maim_modify_date_time,1,10)
                        else substr(t_health_maim.health_maim_record_date_time,1,10)
                       end between  '?' and '?' )

              and (case when t_death.t_death_id is not null
                          then true
                     when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                          then true
                          else false end)
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
