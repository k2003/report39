<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class DrugallergyController extends \yii\web\Controller
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
                  , substr(t_patient_drug_allergy.record_date_time,1,4)::int -543
                       ||substr(t_patient_drug_allergy.record_date_time,6,2)
                       ||substr(t_patient_drug_allergy.record_date_time,9,2) as DATERECORD
                  , substr(b_nhso_map_drug.f_nhso_drug_id,1,24)as  DRUGALLERGY
                  , b_nhso_drugcode24.itemname as DNAME
                  , case when f_naranjo_interpretation.f_naranjo_interpretation_id = '4'
                                  then '1'
                              when f_naranjo_interpretation.f_naranjo_interpretation_id = '3'
                                                          then '2'
                              when f_naranjo_interpretation.f_naranjo_interpretation_id = '2'
                                                          then '3'
                              when f_naranjo_interpretation.f_naranjo_interpretation_id = '1'
                                                          then '4'
                              when f_naranjo_interpretation.f_naranjo_interpretation_id = '5'
                                                          then '5'
                              else '' end as TYPEDX
                  , t_patient_drug_allergy.f_allergy_level_id as ALEVEL
                  , ''  as SYMPTOM
                  , t_patient_drug_allergy.f_allergy_informant_id  as INFORMANT
                  , case when t_patient_drug_allergy.f_allergy_informant_id = '1'
                                  then ''
                                  else t_patient_drug_allergy.allergy_informant_hospital_id
                                end as INFORMHOSP
                  , substr(t_patient_drug_allergy.modify_date_time,1,4)::int -543
                      ||replace(replace(replace(substr(t_patient_drug_allergy.modify_date_time,5),'-',''),',',''),':','') as D_UPDATE
      								,b_employee.provider as PROVIDER
      								,t_health_family.patient_pid as CID
      								,t_patient_drug_allergy.user_modify as lastmodify
      from
              t_patient_drug_allergy inner join t_patient on t_patient_drug_allergy.t_patient_id = t_patient.t_patient_id
              inner join t_health_family on t_patient.t_health_family_id =  t_health_family.t_health_family_id
              left join b_item_drug_standard_map_item on t_patient_drug_allergy.b_item_drug_standard_id = b_item_drug_standard_map_item.b_item_drug_standard_id
              inner join b_item on b_item_drug_standard_map_item.b_item_id = b_item.b_item_id
              left join b_nhso_map_drug on b_item.b_item_id = b_nhso_map_drug.b_item_id
              left join b_nhso_drugcode24 on b_nhso_map_drug.b_nhso_drugcode24_id = b_nhso_drugcode24.b_nhso_drugcode24_id
              left join f_naranjo_interpretation on t_patient_drug_allergy.f_naranjo_interpretation_id = f_naranjo_interpretation.f_naranjo_interpretation_id
      				left join b_employee on t_patient_drug_allergy.user_record = b_employee.b_employee_id
              left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
                                          and t_death.death_active = '1'

              cross join b_site
      where
              t_patient_drug_allergy.active = '1'
              and t_health_family.health_family_active = '1'
              and substr( t_patient_drug_allergy.modify_date_time,1,10) between '?' and '?' 

              and (case when t_death.t_death_id is not null
                          then true
                     when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                          then true
                          else false end)

      group by
              HOSPCODE
              ,PID
              ,DATERECORD
              ,DRUGALLERGY
              ,DNAME
              ,TYPEDX
              ,ALEVEL
              ,SYMPTOM
              ,INFORMANT
              ,INFORMHOSP
              ,D_UPDATE
      				,PROVIDER
      				,CID
      				,lastmodify

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
