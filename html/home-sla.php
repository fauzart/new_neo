<?php
$redirect=false;

include "inc.common.php";
include "inc.session.php";
include "inc.db.php";

$conn=connect();

$sla_all=0;
$sla_on=0;
$sla_off=0;
$cnt_host=0;

//sla today
$sql="select round(sum(uptime)/sum(uptime+downtime)*100,2) as sla, count(host) as cnt from core_status";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_all=$row[0]==null?0:$row[0];
	$cnt_host=$row[1];
}
$sql="select round(sum(uptime)/sum(uptime+downtime)*100,2) as sla from core_status where onoff=1";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_on=$row[0]==null?0:$row[0];
}
$sql="select count(host) as sla from core_status where onoff=0";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_off=$row[0];
}

//sla yesterday
$y_all=0;
$y_on=0;
$y_off=0;
$y_cnt=0;

$dt=date('Y-m-d');
$sql="select max(dt) from core_status_sla";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$dt=$row[0]==null?$dt:$row[0];
}

$where="dt = '$dt'";
$sql="select round(sum(uptime)/sum(uptime+downtime)*100,2) as sla, count(distinct host) as cnt from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$y_all=$row[0]==null?0:$row[0];
	$y_cnt=$row[1];
}
$sql="select round(sum(uptime)/sum(uptime+downtime)*100,2) as sla from core_status_sla where onoff=1 and $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$y_on=$row[0]==null?0:$row[0];
}
$sql="select count(host) as sla from core_status_sla where onoff=0 and $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$y_off=$row[0];
}

//best/worst performance
$sla_max=0;
$sla_max_w=0;
$sla_max_m=0;
$sla_max_y=0;

$sla_min=0;
$sla_min_w=0;
$sla_min_m=0;
$sla_min_y=0;

$sla_y_max=0;
$sla_y_min=0;

//now
$sql="select max(round(uptime/(uptime+downtime)*100,2)) as slax,
min(round(uptime/(uptime+downtime)*100,2)) as slai from core_status";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_max=$row[0]==null?0:$row[0];
	$sla_min=$row[1]==null?0:$row[1];
}
//yesterday
$where="dt='$dt'";
$sql="select max(round(uptime/(uptime+downtime)*100,2)) as slax,
min(round(uptime/(uptime+downtime)*100,2)) as slai from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_y_max=$row[0]==null?0:$row[0];
	$sla_y_min=$row[1]==null?0:$row[1];
}
//this week
$where="YEARWEEK(dt) = YEARWEEK(CURRENT_DATE)";
$sql="select max(round(uptime/(uptime+downtime)*100,2)) as slax,
min(round(uptime/(uptime+downtime)*100,2)) as slai from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_max_w=$row[0]==null?0:$row[0];
	$sla_min_w=$row[1]==null?0:$row[1];
}
$sla_max_w=$sla_max_w==0?$sla_max:$sla_max_w;
$sla_min_w=$sla_min_w==0?$sla_min:$sla_min_w;

$where="MONTH(dt) = MONTH(CURRENT_DATE) and YEAR(dt) = YEAR(CURRENT_DATE)";
$sql="select max(round(uptime/(uptime+downtime)*100,2)) as slax,
min(round(uptime/(uptime+downtime)*100,2)) as slai from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_max_m=$row[0]==null?0:$row[0];
	$sla_min_m=$row[1]==null?0:$row[1];
}
$sla_max_m=$sla_max_m==0?$sla_max_w:$sla_max_m;
$sla_min_m=$sla_min_m==0?$sla_min_w:$sla_min_m;

$where="YEAR(dt) = YEAR(CURRENT_DATE)";
$sql="select max(round(uptime/(uptime+downtime)*100,2)) as slax,
min(round(uptime/(uptime+downtime)*100,2)) as slai from core_status_sla where $where";
$rs=exec_qry($conn,$sql);
if($row=fetch_row($rs)){
	$sla_max_y=$row[0]==null?0:$row[0];
	$sla_min_y=$row[1]==null?0:$row[1];
}
$sla_max_y=$sla_max_y==0?$sla_max_m:$sla_max_m;
$sla_min_y=$sla_min_y==0?$sla_min_m:$sla_min_m;

disconnect($conn);

//echo json_encode(($yearweeks));

$sla_all_progress=progress_bar($sla_all,'bg-primary');
$sla_on_progress=progress_bar($sla_on,'bg-success');
$sla_off_progress=progress_bar($sla_off,'bg-danger',$cnt_host);

$sla_all_perc=compare($y_all,$sla_all,"</span> vs yesterday",false);
$sla_on_perc=compare($y_on,$sla_on,"</span> vs yesterday",false);
$sla_off_perc=compare($y_off,$sla_off,"</span> vs yesterday",false);

$sla_all_class=compare_class($y_all,$sla_all,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');
$sla_on_class=compare_class($y_on,$sla_on,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');
$sla_off_class=compare_class($y_off,$sla_off,'<span class="text-success mr-1"> ','<span class="text-danger mr-1"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success mr-1"><i class="fe fe-arrow-down ml-1"></i>');

$sla_max_perc=compare($sla_y_max,$sla_max,"</span>",false);
$sla_min_perc=compare($sla_y_min,$sla_min,"</span>",false);
$sla_max_class=compare_class($sla_y_max,$sla_max,'<span class="text-success"> ','<span class="text-danger"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success"><i class="fe fe-arrow-down ml-1"></i>');
$sla_min_class=compare_class($sla_y_min,$sla_min,'<span class="text-success"> ','<span class="text-danger"><i class="fe fe-arrow-up ml-1"></i>','<span class="text-success"><i class="fe fe-arrow-down ml-1"></i>');

$out=array(
"sla_all"=>$sla_all, 
"sla_on"=>$sla_on, 
"sla_off"=>$sla_off,
"sla_max"=>$sla_max.'%',
"sla_max_m"=>$sla_max_m.'%',
"sla_max_w"=>$sla_max_w.'%',
"sla_max_y"=>$sla_max_y.'%',
"sla_min"=>$sla_min.'%',
"sla_min_y"=>$sla_min_y.'%',
"sla_min_w"=>$sla_min_w.'%',
"sla_min_m"=>$sla_min_m.'%',
"sla_max_perc"=>$sla_max_class.$sla_max_perc,
"sla_min_perc"=>$sla_min_class.$sla_min_perc,
"sla_all_perc"=>$sla_all_class.$sla_all_perc, 
"sla_on_perc"=>$sla_on_class.$sla_on_perc, 
"sla_off_perc"=>$sla_off_class.$sla_off_perc,
"sla_all_progress"=>$sla_all_progress, 
"sla_on_progress"=>$sla_on_progress, 
"sla_off_progress"=>$sla_off_progress);

$msgs = array($out);
echo json_encode(array('code'=>"200",'ttl'=>"OK",'msgs'=>$msgs));
?>