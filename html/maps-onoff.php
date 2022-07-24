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
$tname="core_location l join core_node n on l.locid=n.loc join core_status s on n.host=s.host";
$cols="loc,count(s.host) as t, sum(s.status) as u";
$grpby="loc";
$sql="select $cols from $tname where loc<>'' group by $grpby";
$rs=exec_qry($conn,$sql);
while($row=fetch_row($rs)){
	$all++;
	$on+=$row[2]==null||$row[2]<1?0:1;
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
$tname="core_node n left join core_status_sla s on n.host=s.host";
$cols="loc,count(s.host) as t, sum(s.status) as u";
$grpby="loc";
$sql="select $cols from $tname where $where group by $grpby";
$rs=exec_qry($conn,$sql);
while($row=fetch_row($rs)){
	$y_all++;
	$y_on+=$row[1]==null||$row[1]<1?0:1;
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
"dtot"=>'<b>'.$all.'</b>'.$all_class.$all_perc, 
"don"=>'<b>'.$on.'</b>'.$on_class.$on_perc, 
"doff"=>'<b>'.$off.'</b>'.$off_class.$off_perc
);

$msgs = array($out);
echo json_encode(array('code'=>"200",'ttl'=>"OK",'msgs'=>$msgs));
?>