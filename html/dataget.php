<?php
$redirect=false;
include 'inc.common.php';
include 'inc.session.php';
include 'inc.db.php';

$conn = connect();

$q=post('q',$conn);
$id=post('id',$conn,'0');

$sql="";
$code="200";
$ttl="OK";

switch($q){
	case 'user': $sql="select * from core_user where rowid='$id'"; break;
	case 'sla': $sql="select * from core_sla where rowid='$id'"; break;
	case 'location': $sql="select * from core_location where rowid='$id'"; break;
	case 'ip': $sql="select * from core_ipscan where rowid='$id'"; break;
	case 'severity': $sql="select * from core_severity where rowid='$id'"; break;
	case 'mdevice': $sql="select * from core_node where rowid='$id'"; break;
	case 'mbg': $sql="select *,if(running='1','Running',if(startnow='1','Starting','Stopped')) as status from core_bgjob where rowid='$id'"; break;
	
	case 'profile': $sql="select * from core_user where uid='$id'"; break;
	
	case 'home1': $sql="select count(host) as tdev, sum(status) as tdup, count(host)-sum(status) as tdon from core_status"; break;
	
	case 'map': $tname="core_location l join core_node n on l.locid=n.loc join core_status s on n.host=s.host";
			$grpby="lat,lng,concat(l.name,'\n',l.addr),locid";
		$sql="select lat,lng,concat(l.name,'\n',l.addr) as name,locid,sum(s.status) as onoff from $tname where lat<>'' and lng<>'' group by $grpby"; break;
	
}

//echo $sql;
if($sql==""){
	$code="404";
	$ttl="Error";
	$output="Query not found";
}else{
	$result = exec_qry($conn,$sql);
	if(db_error($conn)==''){
		$output = fetch_alla($result);
	}else{
		$output = db_error($conn);
		if($production){$output="System Error. Please contact admin.";}
		$ttl = "Error";
		$code= "505";
	}
}

disconnect($conn);

echo json_encode(array('code'=>$code,'ttl'=>$ttl,'msgs'=>$output));
?>