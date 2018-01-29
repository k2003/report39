<?php
echo "$a+$b=$sum";
?>
<hr>
ทดสอบ 1
<?php
echo "<br>" . $sum;
?>
<hr>
array<br>
<?php
$data1 = [1, 2, 3];
print_r($data1);
echo "<hr>";
$data2 = array(1, 2, 3, 4);
print_r($data2);
$data3 = ['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4];
print_r($data3);
?>

<hr>
++++++++++++++++++++++
<br/>
<?php
$sql="
--stat001จำนวนผู้รับบริการ
select  'จำนวนผู้รับบริการผู้ป่วยนอก' as รายการ
            ,count(distinct p1.hn) as คนHN
            ,count(p1.vn) as ครั้งVisit
            ,sum(p1.invoice) as ค่ารักษา
from(
select visit_hn as hn
,visit_vn as vn
,t_billing_invoice.billing_invoice_total AS invoice
from t_visit
inner join t_visit_payment on t_visit.t_visit_id = t_visit_payment.t_visit_id
inner join t_billing ON t_visit.t_visit_id = t_billing.t_visit_id
inner join t_billing_invoice ON t_billing_invoice.t_visit_id = t_visit_payment.t_visit_id and t_billing_invoice.billing_invoice_active ='1'
where  t_visit.f_visit_type_id = '0' --เลือก 1 ผู้ป่วยใน 0 ผู้ป่วยนอก
and t_visit.f_visit_status_id <>'4'
and substring(t_visit.visit_begin_visit_time,1,10) between substring(?,1,10) and substring(?,1,10)
--and (substr(\"public\".t_visit.visit_begin_visit_time, 12, 5) BETWEEN '08:30' AND '16:30')
)as p1

union
select  'จำนวนผู้รับบริการผู้ป่วยใน' as รายการ
            ,count(distinct p1.hn) as คนHN
            ,count(p1.vn) as ครั้งVisit
            ,sum(p1.invoice) as ค่ารักษา
from(
select visit_hn as hn
,visit_vn as vn
,t_billing_invoice.billing_invoice_total AS invoice
from t_visit
inner join t_visit_payment on t_visit.t_visit_id = t_visit_payment.t_visit_id
inner join t_billing ON t_visit.t_visit_id = t_billing.t_visit_id
inner join t_billing_invoice ON t_billing_invoice.t_visit_id = t_visit_payment.t_visit_id and t_billing_invoice.billing_invoice_active ='1'
where  t_visit.f_visit_type_id = '1' --เลือก 1 ผู้ป่วยใน 0 ผู้ป่วยนอก
and t_visit.f_visit_status_id <>'4'
and substring(t_visit.visit_begin_visit_time,1,10) between substring(?,1,10) and substring(?,1,10)
)as p1

";

//echo $ps=strpos($sql,"?");//ค้นหา ? ในตัวแปร $sql
while ($ps=strpos($sql,"?")) {

$ps=strpos($sql,"?");
if($ps!==FALSE){
//echo "<br/>";
$qr = substr_replace($sql, "yyyy-yy-yy", $ps ,1);
//print "substr_replace"."<br>".$qr ;
}
$ps2=strpos($qr,"?");
if($ps2!==FALSE){
//echo "<br/>";
$qr2 = substr_replace($qr, "xxxx-xx-xx", $ps2 ,1);
//print "substr_replace"."<br>".$qr2 ;
}
$sql=$qr2;
}
print $sql;
 ?>

<hr>
++++++++++++++++++++++
<br/>
<hr>
----------------------
<br/>

<?php

    $message = ":) amplysoft ";
    $str_replace = str_replace(":)", "Hello, ", $message);
    echo $str_replace;

?>

<hr>
----------------------
<br/>
<?php

$all = "123,456,789,012";
//แทรกค่า
$w = substr_replace($all, "?", 8 ,0);
//แทนค่า
$v = str_replace("7", "?", $all);

print "substr_replace"."<br>".$w ;

print "str_replace"."<br>".$v ;

?>
<hr>
----------------------
<br/>
<?php

echo strpos("Hello world","wo");

?>
<hr>
----------------------
<br/>
<?php

$mystring = "asdfjkasd";
$findme = "a";
$pos = strpos($mystring,$findme);

if($pos!==FALSE){

echo "พบ $findme ที่ตำแหน่ง<b> $pos </b>";

}else{

echo "ไม่พบ $findme ใน $mystring";

}

?>

<hr>
----------------------
<br/>

<?php

$mystring = "asdfjkasd";
$findme = "a";
$pos = strpos($mystring,$findme,2);

if($pos!==FALSE){

echo "พบ $findme ที่ตำแหน่ง <b>$pos</b>";

}else{

echo "ไม่พบ $findme ใน $mystring";

}

?>
