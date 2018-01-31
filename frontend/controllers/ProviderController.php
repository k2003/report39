<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class ProviderController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $data = Yii::$app->request->get();
      $date1 = isset($data['date1']) ? $data['date1'] : '';
      $date2 = isset($data['date2']) ? $data['date2'] : '';


      $sql = "
      select  distinct
                  b_site.b_visit_office_id as HOSPCODE
                  ,b_employee.provider as PROVIDER
                  ,b_employee.employee_number as REGISTERNO
                  ,case when b_employee.f_provider_council_code_id <> '0'
                                then lpad(b_employee.f_provider_council_code_id,2,'0')
                                else ''
                              end as COUNCIL
                  ,t_person.person_pid as CID
                  ,case when r_rp1853_prefix.id is not null and r_rp1853_prefix.id <> ''
                              then lpad(r_rp1853_prefix.id,3,'0')
                              else ''
                        end  as PRENAME
                  ,t_person.person_firstname as NAME
                  ,t_person.person_lastname as LNAME
                  ,case when t_person.f_sex_id='1'
                  then '1'
                  else '2' end as SEX
                  ,case when t_person.person_birthday <> ''
                  then (to_number(substring(t_person.person_birthday,1,4),'9999') - 543)
                                      || substring(t_person.person_birthday,6,2)
                                      || substring(t_person.person_birthday,9,2)
                  else '' end AS BIRTH
                  ,f_provider_type.code as PROVIDERTYPE
                  ,case when b_employee.start_date <> ''
                  then (to_number(substring(b_employee.start_date,1,4),'9999') - 543)
                                      || substring(b_employee.start_date,6,2)
                                      || substring(b_employee.start_date,9,2)
                  else  '' end as STARTDATE
                  ,case when b_employee.out_date <> ''
                  then (to_number(substring(b_employee.out_date,1,4),'9999') - 543)
                                      || substring(b_employee.out_date,6,2)
                                      || substring(b_employee.out_date,9,2)
                  else '' end as OUTDATE
                  ,b_employee.move_from as MOVEFROM
                  ,b_employee.move_to as MOVETO
                  , case when length(b_employee.update_date_time) >= 10
                                  then cast(substring(b_employee.update_date_time,1,4) as numeric) - 543
                                           || replace(replace(replace(substring(b_employee.update_date_time,5),'-',''),',',''),':','')
                                  when length(b_employee.record_date_time) >= 10
                                  then cast(substring(b_employee.record_date_time,1,4) as numeric) - 543
                                           || replace(replace(replace(substring(b_employee.record_date_time,5),'-',''),',',''),':','')
                                  else ''
                  end as D_UPDATE

      from
              b_employee INNER JOIN t_person ON b_employee.t_person_id = t_person.t_person_id
              LEFT JOIN f_patient_prefix ON t_person.f_prefix_id = f_patient_prefix.f_patient_prefix_id
              left join b_map_rp1853_prefix on  f_patient_prefix.f_patient_prefix_id = b_map_rp1853_prefix.f_patient_prefix_id
              left join r_rp1853_prefix on b_map_rp1853_prefix.r_rp1853_prefix_id = r_rp1853_prefix.id
              LEFT JOIN f_provider_type ON b_employee.f_provider_type_id = f_provider_type.f_provider_type_id
              CROSS JOIN b_site

      where b_employee.employee_active ='1'
                  AND substr(b_employee.update_date_time,1,10) between '?' and '?'   
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
