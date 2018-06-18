<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii;

class PersonController extends \yii\web\Controller
{
    public function actionIndex()
    {
          $data = Yii::$app->request->get();
          $date1 = isset($data['date1']) ? $data['date1'] : '';
          $date2 = isset($data['date2']) ? $data['date2'] : '';


          $sql = "

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
