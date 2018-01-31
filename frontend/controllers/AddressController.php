<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class AddressController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $data = Yii::$app->request->get();
      $date1 = isset($data['date1']) ? $data['date1'] : '';
      $date2 = isset($data['date2']) ? $data['date2'] : '';


      $sql = "
      select distinct
                  b_site.b_visit_office_id as HOSPCODE
                  , t_health_family.health_family_hn_hcis AS PID
                  , '1' as ADDRESSTYPE
                  , t_health_home.health_home_number as HOUSE_ID
                  , '9' as HOUSETYPE
                  , '' as ROOMNO
                  , '' as CONDO
                  , t_patient.patient_house as HOUSENO
                  , '' as SOISUB
                  , '' as SOIMAIN
                  , t_patient.patient_road as ROAD
                  , '' as VILLANAME
                  , case when t_patient.patient_moo is not null
                                 then lpad(t_patient.patient_moo,2,'0')
                              else '99' end as VILLAGE
                  , case when t_patient.patient_tambon <> ''
                                  then substr(t_patient.patient_tambon,5,2)
                              else '99' end as TAMBON
                  , case when t_patient.patient_amphur <> ''
                                  then substr(t_patient.patient_amphur,3,2)
                              else '99' end as AMPUR
                  , case when t_patient.patient_changwat <> ''
                                  then substr(t_patient.patient_changwat,1,2)
                              else '99' end as CHANGWAT

                  ,substr(t_patient.patient_phone_number,1,15) as TELEPHONE

                  ,substr(t_patient.patient_patient_mobile_phone,1,15)  as MOBILE

                  , case when length(t_health_family.modify_date_time) >= 10
                                  then rpad(substr(t_health_family.modify_date_time,1,4)::int -543
                                                      ||replace(replace(replace(substr(t_health_family.modify_date_time,5),'-',''),',',''),':',''),14,'0')
                                  else rpad(substr(t_health_family.record_date_time,1,4)::int -543
                                                      ||replace(replace(replace(substr(t_health_family.record_date_time,5),'-',''),',',''),':',''),14,'0') end as D_UPDATE
                  , case when t_health_family.patient_pid <> '' and length(t_health_family.patient_pid) =13
                                  then t_health_family.patient_pid
                          when t_health_family.patient_pid = ''
      /*                                 and t_health_family.health_family_foreigner_card_no = ''
                                      and t_health_family.r_rp1853_foreign_id in ('02','03','04','11','12','13','14','21','22','23')
                                then
                                         lpad(t_patient.patient_hn,13,'0')
                          when  t_health_family.health_family_foreigner_card_no <> '' and length(t_health_family.health_family_foreigner_card_no) =13
                                  then  t_health_family.health_family_foreigner_card_no
                          else ''
                          end as CID */
                                      and t_person_foreigner.foreigner_no = ''
                                      and t_person_foreigner.f_person_foreigner_id in ('02','03','04','11','12','13','14','21','22','23')
                                  then
                                      lpad(t_patient.patient_hn,13,'0')
                           when t_person_foreigner.foreigner_no <> '' and length(t_person_foreigner.foreigner_no) = 13
                                  then t_person_foreigner.foreigner_no
                           else ''
                              end as CID
                              ,t_patient.patient_staff_modify as lastmodify
      from
              t_health_family left join t_patient on t_patient.t_health_family_id = t_health_family.t_health_family_id
              left join t_health_home on t_health_family.t_health_home_id = t_health_home.t_health_home_id
       left join t_person_foreigner on t_health_family.t_health_family_id = t_person_foreigner.t_person_id
              left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
                                          and t_death.death_active = '1'

              cross join b_site

      where
               t_health_family.health_family_active = '1'
               and t_health_family.f_patient_area_status_id <> '1'
               and case when length(t_health_family.modify_date_time) >= 10
                                  then substr(t_health_family.modify_date_time,1,10)
                                  else substr(t_health_family.record_date_time,1,10)
                               end between '?' and '?'
                               and (case when t_death.t_death_id is not null
                                           then true
                                      when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                                           then true
                                           else false end)
                       order by
                               PID asc
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
