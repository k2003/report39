<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class CardController extends \yii\web\Controller
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
                  , r_rp1853_instype.id as INSTYPE_OLD
                  , r_rp1855_instype.id as INSTYPE_NEW
                  , t_patient_payment.patient_payment_card_number as INSID
                  , (case when length(t_patient_payment.patient_payment_card_issue_date) > 9
                      then substr(t_patient_payment.patient_payment_card_issue_date,1,4)::int -543
                      ||replace(substr(t_patient_payment.patient_payment_card_issue_date,5,6),'-','')
                      else ''
                      end) as STARTDATE
                  , (case when length(t_patient_payment.patient_payment_card_expire_date) > 9
                      then substr(t_patient_payment.patient_payment_card_expire_date,1,4)::int -543
                      ||replace(substr(t_patient_payment.patient_payment_card_expire_date,5,6),'-','')
                      else ''
                      end) as EXPIREDATE
                  , case when t_patient_payment.patient_payment_main_hospital <> 'null'
                      and t_patient_payment.patient_payment_main_hospital <> ''
                      and length(t_patient_payment.patient_payment_main_hospital) = 5
                      then t_patient_payment.patient_payment_main_hospital
                      else ''
                      end as MAIN
                  , case when t_patient_payment.patient_payment_sub_hospital <> 'null'
                      and t_patient_payment.patient_payment_sub_hospital <> ''
                      and length(t_patient_payment.patient_payment_sub_hospital) = 5
                      then t_patient_payment.patient_payment_sub_hospital
                      else ''
                      end as SUB
                  , (rpad(substr(t_patient_payment.patient_payment_record_date,1,4)::int -543
                    ||replace(replace(replace(substr(t_patient_payment.patient_payment_record_date,5),'-',''),',',''),':',''),14,'0'))  as D_UPDATE

      						,t_health_family.patient_pid as CID
      from
              (select
                t_patient_payment.*
              from t_patient_payment inner join
                (select
                  t_patient_payment.t_patient_id as t_patient_id
                  ,min(t_patient_payment.b_contact_plans_id) as min_b_contact_plans_id
                  ,max_payment_record_date.patient_payment_record_date as patient_payment_record_date
                  ,max_payment_record_date.checkplan_date as checkplan_date
                  from t_patient_payment inner join
                    (select
                        t_patient_payment.t_patient_id as t_patient_id
                        ,max(t_patient_payment.patient_payment_record_date) as patient_payment_record_date
                        ,max_checkplan_date.checkplan_date as checkplan_date
                        from t_patient_payment inner join
                            (select
                              t_patient_payment.t_patient_id as t_patient_id
                              ,max(t_patient_payment.checkplan_date) as checkplan_date
                              from t_patient_payment
                              where
                              t_patient_payment.patient_payment_priority = '0'
                                group by
                                t_patient_payment.t_patient_id) as max_checkplan_date
                                on t_patient_payment.t_patient_id = max_checkplan_date.t_patient_id
                                and t_patient_payment.checkplan_date = max_checkplan_date.checkplan_date

                                where
                                t_patient_payment.patient_payment_priority = '0'
                                group by
                                t_patient_payment.t_patient_id
                                ,max_checkplan_date.checkplan_date) as max_payment_record_date
                                on t_patient_payment.t_patient_id = max_payment_record_date.t_patient_id
                                and t_patient_payment.patient_payment_record_date = max_payment_record_date.patient_payment_record_date
                                and t_patient_payment.checkplan_date = max_payment_record_date.checkplan_date
                                where
                                t_patient_payment.patient_payment_priority = '0'
                                group by
                                t_patient_payment.t_patient_id
                                ,max_payment_record_date.patient_payment_record_date
                                ,max_payment_record_date.checkplan_date  ) as min_b_contact_plans
                                on
                                t_patient_payment.t_patient_id = min_b_contact_plans.t_patient_id
                                and t_patient_payment.patient_payment_record_date = min_b_contact_plans.patient_payment_record_date
                                and t_patient_payment.checkplan_date = min_b_contact_plans.checkplan_date
                                and t_patient_payment.b_contact_plans_id = min_b_contact_plans.min_b_contact_plans_id) as t_patient_payment

              inner join t_patient on t_patient_payment.t_patient_id = t_patient.t_patient_id
              inner join t_health_family on t_health_family.t_health_family_id = t_patient.t_health_family_id
              left join b_contract_plans on  t_patient_payment.b_contact_plans_id = b_contract_plans.b_contract_plans_id
              left join b_map_rp1853_instype on b_contract_plans.b_contract_plans_id = b_map_rp1853_instype.b_contract_plans_id
              left join r_rp1853_instype on b_map_rp1853_instype.r_rp1853_instype_id =  r_rp1853_instype.id
              left join b_map_rp1855_instype on b_contract_plans.b_contract_plans_id = b_map_rp1855_instype.b_contract_plans_id
              left join r_rp1855_instype on b_map_rp1855_instype.r_rp1855_instype_id = r_rp1855_instype.id

              left join t_death on t_health_family.t_health_family_id = t_death.t_health_family_id
              and t_death.death_active = '1'

              cross join b_site
      where
              t_health_family.health_family_active = '1'
              and t_patient_payment.patient_payment_priority = '0'
              and substr(t_patient_payment.patient_payment_record_date,1,10)  between '?' and '?'

              and (case when t_death.t_death_id is not null
                          then true
                     when t_death.t_death_id is null and t_health_family.f_patient_discharge_status_id <> '1'
                          then true
                          else false end)
       group by
              HOSPCODE
              ,PID
              ,INSTYPE_OLD
              ,INSTYPE_NEW
              ,INSID
              ,STARTDATE
              ,EXPIREDATE
              ,MAIN
              ,SUB
              ,D_UPDATE
      				,CID

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
