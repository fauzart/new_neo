<?php
$redirect=false;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$all=0;
$on=0;
$off=0;

//today
$sql="select count(host),sum(status) from core_status";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$all=$row[0]==null?0:$row[0];
	$on=$row[1]==null?0:$row[1];
}
$off=$all-$on;

//yesterday
$y_all=0;
$y_on=0;
$y_off=0;

$dt=date('Y-m-d');
$sql="select max(dt) from core_status_sla";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$dt=$row[0]==null?$dt:$row[0];
}

$where="dt = '$dt'";
$sql="select count(host),sum(status) from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$y_all=$row[0]==null?0:$row[0];
	$y_on=$row[1]==null?0:$row[1];
}
$y_off=$y_all-$y_on;

disconnect($conn);

//echo json_encode(($yearweeks));

$all_perc=compare($y_all,$all,")</span>",false);
$on_perc=compare($y_on,$on,")</span>",false);
$off_perc=compare($y_off,$off,")</span>",false);

$all_class=compare_class($y_all,$all,'<span class="text-success fs-13 ml-2">(','<span class="text-success fs-13 ml-2">(+','<span class="text-success fs-13 ml-2">(-');
$on_class=compare_class($y_on,$on,'<span class="text-success fs-13 ml-2">(','<span class="text-success fs-13 ml-2">(+','<span class="text-danger fs-13 ml-2">(-');
$off_class=compare_class($y_off,$off,'<span class="text-success fs-13 ml-2">(','<span class="text-danger fs-13 ml-2">(+','<span class="text-success fs-13 ml-2">(-');

$out=array(
"tdev"=>$all,
"dtot"=>'<b>'.$all.'</b>'.$all_class.$all_perc, 
"don"=>'<b>'.$on.'</b>'.$on_class.$on_perc, 
"doff"=>'<b>'.$off.'</b>'.$off_class.$off_perc
);

$msgs = array($out);
echo json_encode(array('code'=>"200",'ttl'=>"OK",'msgs'=>$msgs));
?>